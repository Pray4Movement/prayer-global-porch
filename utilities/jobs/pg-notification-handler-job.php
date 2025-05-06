<?php

use WP_Queue\Job;

class PG_Notification_Handler_Job extends Job {
    public function __construct() {}

    public function handle() {
        dt_write_log( 'PG_Notification_Handler_Job' );
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
            if ( in_array( $user->ID, $processed_users ) ) {
                continue;
            }
            $processed_users[] = $user->ID;

            dt_write_log( 'PG_Notification_Handler_Job: ' . $user->ID );
            $user_notifications_permission = get_user_meta( $user->ID, PG_NAMESPACE . 'notifications_permission', true );
            $can_send_push = $user_notifications_permission === '1';
            if ( !$can_send_push ) {
                continue;
            }

            /* Change locale to user locale for notification translation */
            $user_language = get_user_meta( $user->ID, PG_NAMESPACE . 'language', true );

            if ( !empty( $user_language ) ) {
                pg_set_translation( $user_language );
            }

            // get the user milestones
            $milestones_manager = new PG_Milestones( $user->ID );
            $milestones = $milestones_manager->get_milestones();

            foreach ( $milestones as $milestone ) {
                dt_write_log( 'PG_Notification_Handler_Job: ' . $milestone->get_category() );
                if (
                        $milestone->get_category() === 'streak' &&
                        !PG_Notifications_Sent::is_recent( $user->ID, $milestone )
                ) {
                    if ( $can_send_push && $milestone->push() ) {
                        wp_queue()->push( new PG_User_Push_Notification_Job( $user, $milestone ), 15 * MINUTE_IN_SECONDS );
                    }
                }
                if (
                    $milestone->get_category() === 'inactivity' &&
                    !PG_Notifications_Sent::is_recent( $user->ID, $milestone, 24 )
                ) {
                    if ( $can_send_push && $milestone->push() ) {
                        wp_queue()->push( new PG_User_Push_Notification_Job( $user, $milestone ) );
                    }
                }
            }
        }
    }
}
