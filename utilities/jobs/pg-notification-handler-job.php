<?php

use WP_Queue\Job;

class PG_Notification_Handler_Job extends Job {
    public function __construct() {}

    public function handle() {
        global $wpdb;

        // Pull every opted-in user with the settings we need in a single query,
        // instead of loading full WP_User objects and querying meta per user.
        // phpcs:disable
        $users = $wpdb->get_results(
            "SELECT u.ID AS user_id, u.user_email,
                MAX( CASE WHEN um.meta_key = 'pg_notifications_permission' THEN um.meta_value END ) AS notifications_permission,
                MAX( CASE WHEN um.meta_key = 'pg_emails_permission'        THEN um.meta_value END ) AS emails_permission,
                MAX( CASE WHEN um.meta_key = 'pg_push_undeliverable_at'    THEN um.meta_value END ) AS push_undeliverable_at,
                MAX( CASE WHEN um.meta_key = 'pg_language'                 THEN um.meta_value END ) AS language,
                MAX( CASE WHEN um.meta_key = 'pg_location'                 THEN um.meta_value END ) AS location,
                MAX( CASE WHEN um.meta_key = 'pg_ab_test'                  THEN um.meta_value END ) AS ab_test
            FROM $wpdb->users u
            JOIN $wpdb->usermeta um ON um.user_id = u.ID
            WHERE um.meta_key IN ( 'pg_notifications_permission', 'pg_emails_permission', 'pg_push_undeliverable_at', 'pg_language', 'pg_location', 'pg_ab_test' )
            GROUP BY u.ID, u.user_email
            HAVING notifications_permission = '1' OR emails_permission = '1'"
        );

        // Last prayer activity per user, in one grouped scan (uses the
        // post_type_user_id index). Keyed by user_id for lookup in the loop.
        $activity_rows = $wpdb->get_results(
            "SELECT user_id, MAX( timestamp ) AS last_prayer, MAX( timezone_timestamp ) AS last_tz
            FROM $wpdb->dt_reports
            WHERE post_type = 'pg_relays'
            GROUP BY user_id"
        );
        // phpcs:enable
        $activity = [];
        foreach ( $activity_rows as $row ) {
            $activity[ (int) $row->user_id ] = $row;
        }

        $now = time();
        foreach ( $users as $user ) {
            try {
                $user_id = (int) $user->user_id;

                if (
                    ( defined( 'PG_ONESIGNAL_STOP' ) && PG_ONESIGNAL_STOP ) &&
                    !in_array( $user->user_email, PG_Onesignal::$allowed_users )
                ) {
                    continue;
                }

                $can_send_push = $user->notifications_permission === '1';
                $can_send_email = $user->emails_permission === '1';
                $push_deliverable = empty( $user->push_undeliverable_at );
                $user_language = !empty( $user->language ) ? $user->language : 'en_US';
                $in_ab_test = $user->ab_test === 'group_b';

                $location = maybe_unserialize( $user->location ) ?: [];
                $timezone = $location['time_zone'] ?? 'UTC';

                $last_activity = $activity[ $user_id ] ?? null;
                $last_prayer = $last_activity ? (int) $last_activity->last_prayer : 0;
                $is_recently_active = $last_prayer && $last_prayer > ( $now - HOUR_IN_SECONDS );
                $days_inactive = $this->compute_days_of_inactivity( $last_activity->last_tz ?? null, $timezone );

                // Skip the heavy badge sweep for users with no recent activity.
                // Badges are activity-driven, so a quiet user's badge state cannot have
                // changed since the last sweep. Inactivity milestones still run below.
                // One-hour window (vs the 15-min schedule) gives slack so a user is not
                // skipped just because the previous run missed.
                //
                // Persist newly-earned badges before the push-eligibility gates below;
                // a badge records activity the user did and must not depend on delivery channel.
                $new_badges = [];
                if ( $is_recently_active && !$in_ab_test ) {
                    $badges_manager = new PG_Badge_Manager( $user_id );
                    $new_badges = $badges_manager->get_newly_earned_badges();

                    foreach ( $new_badges as $badge ) {
                        $badges_manager->earn_badge( $badge->get_id() );
                    }
                }

                if ( !$can_send_push || !$push_deliverable ) {
                    // Push is not available for this user — try email fallback for badge notifications.
                    if ( !empty( $new_badges ) && $can_send_email ) {
                        pg_switch_notifications_locale( $user_language );

                        $notification = count( $new_badges ) === 1
                            ? PG_Notification::from_badge( $new_badges[0] )
                            : PG_Notification::from_badges( $new_badges );

                        if ( !PG_Notifications_Sent::is_recent( $user_id, $notification ) ) {
                            wp_queue()->push( new PG_User_Email_Notification_Job( $user_id, $user->user_email, $notification, $user_language ), 15 * MINUTE_IN_SECONDS );
                        }
                    }
                    continue;
                }

                /* Change locale to user locale for notification translation */
                pg_switch_notifications_locale( $user_language );

                if ( !$in_ab_test ) {
                    if ( count( $new_badges ) === 1 &&
                        !PG_Notifications_Sent::is_recent( $user_id, PG_Notification::from_badge( $new_badges[0] ) )
                    ) {
                        wp_queue()->push( new PG_User_Push_Notification_Job( $user_id, $user->user_email, PG_Notification::from_badge( $new_badges[0] ) ), 15 * MINUTE_IN_SECONDS );
                    }

                    if ( count( $new_badges ) > 1 &&
                        !PG_Notifications_Sent::is_recent( $user_id, PG_Notification::from_badges( $new_badges ) )
                    ) {
                        wp_queue()->push( new PG_User_Push_Notification_Job( $user_id, $user->user_email, PG_Notification::from_badges( $new_badges ) ), 15 * MINUTE_IN_SECONDS );
                    }
                }

                // Inactivity milestones, matched from the precomputed days of inactivity.
                // Using the static matcher avoids constructing PG_Milestones / User_Stats,
                // which would each trigger a per-user meta query.
                $milestones = PG_Milestones::match_inactivity_milestones( $days_inactive );

                foreach ( $milestones as $milestone ) {
                    if (
                        $milestone->get_category() === 'inactivity' &&
                        !PG_Notifications_Sent::is_recent( $user_id, PG_Notification::from_milestone( $milestone ) )
                    ) {
                        if ( $milestone->push() ) {
                            wp_queue()->push( new PG_User_Push_Notification_Job( $user_id, $user->user_email, PG_Notification::from_milestone( $milestone ) ) );
                        }
                    }
                }
            } catch ( \Throwable $e ) {
                // Isolate per-user failures so one bad user does not abort the whole sweep
                // and trigger a full-job retry by WP_Queue.
                dt_write_log( 'PG_Notification_Handler_Job: error processing user ' . ( $user->user_id ?? '?' ) . ': ' . $e->getMessage() );
            }
        }
    }

    /**
     * Replicates User_Stats::days_of_inactivity() in PHP from the batched last
     * activity timestamp, so we avoid a per-user query. Matches MySQL DATEDIFF:
     * the calendar-day difference between today and the last prayer date, both
     * evaluated in the user's timezone.
     *
     * @param string|null $last_tz  MAX( timezone_timestamp ) for the user, or null.
     * @param string      $timezone The user's timezone, e.g. 'America/New_York'.
     */
    private function compute_days_of_inactivity( ?string $last_tz, string $timezone ): int {
        if ( empty( $last_tz ) ) {
            return 0;
        }
        try {
            $tz = new DateTimeZone( $timezone );
        } catch ( \Exception $e ) {
            $tz = new DateTimeZone( 'UTC' );
        }
        $today_midnight = new DateTime( 'today', $tz );
        $last_midnight = new DateTime( ( new DateTime( $last_tz, $tz ) )->format( 'Y-m-d' ), $tz );
        return (int) $last_midnight->diff( $today_midnight )->format( '%r%a' );
    }
}
