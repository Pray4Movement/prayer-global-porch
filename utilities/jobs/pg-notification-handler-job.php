<?php

use WP_Queue\Job;

class PG_Notification_Handler_Job extends Job {
    public function __construct() {}

    public function handle() {
        // Loop through all users with push notifications enabled
        $users = get_users( array(
            'meta_key' => [
                PG_NAMESPACE . 'notifications_permission',
                PG_NAMESPACE . 'emails_permission',
            ],
        ));

        $processed_users = [];
        // check if the user has any notifications to send
        foreach ( $users as $user ) {
            if (
                ( defined( 'PG_ONESIGNAL_STOP' ) && PG_ONESIGNAL_STOP ) &&
                !in_array( $user->user_email, PG_Onesignal::$allowed_users )
            ) {
                continue;
            }

            if ( in_array( $user->ID, $processed_users ) ) {
                continue;
            }

            $processed_users[] = $user->ID;

            $user_notifications_permission = get_user_meta( $user->ID, PG_NAMESPACE . 'notifications_permission', true );
            $can_send_push = $user_notifications_permission === '1';
            if ( !$can_send_push ) {
                continue;
            }

            /* Change locale to user locale for notification translation */
            $user_language = get_user_meta( $user->ID, PG_NAMESPACE . 'language', true );
            $user_language = !empty( $user_language ) ? $user_language : 'en_US';

            pg_switch_notifications_locale( $user_language );

            if ( !pg_is_user_in_ab_test( $user->ID ) ) {
                // get the users new badges that haven't been awarded yet
                $badges_manager = new PG_Badge_Manager( $user->ID );
                $new_badges = $badges_manager->get_newly_earned_badges();

                foreach ( $new_badges as $badge ) {
                    $badges_manager->earn_badge( $badge->get_id() );
                }

                if ( $can_send_push && count( $new_badges ) === 1 &&
                    !PG_Notifications_Sent::is_recent( $user->ID, PG_Notification::from_badge( $new_badges[0] ) )
                ) {
                    wp_queue()->push( new PG_User_Push_Notification_Job( $user, PG_Notification::from_badge( $new_badges[0] ) ), 15 * MINUTE_IN_SECONDS );
                }

                if ( $can_send_push && count( $new_badges ) > 1 &&
                    !PG_Notifications_Sent::is_recent( $user->ID, PG_Notification::from_badges( $new_badges ) )
                ) {
                    wp_queue()->push( new PG_User_Push_Notification_Job( $user, PG_Notification::from_badges( $new_badges ) ), 15 * MINUTE_IN_SECONDS );
                }
            }

            // get the user milestones
            $milestones_manager = new PG_Milestones( $user->ID );
            $milestones = $milestones_manager->get_milestones();

            foreach ( $milestones as $milestone ) {
                if (
                    $milestone->get_category() === 'inactivity' &&
                    !PG_Notifications_Sent::is_recent( $user->ID, PG_Notification::from_milestone( $milestone ) )
                ) {
                    if ( $can_send_push && $milestone->push() ) {
                        wp_queue()->push( new PG_User_Push_Notification_Job( $user, PG_Notification::from_milestone( $milestone ) ) );
                    }
                }
            }
        }
    }
}
