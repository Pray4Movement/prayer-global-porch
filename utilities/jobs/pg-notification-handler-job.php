<?php

use WP_Queue\Job;

class PG_Notification_Handler_Job extends Job {
    public function __construct() {}

    public function handle() {
        // Loop through all users with push notifications enabled
        $users = get_users(array(
            'meta_key' => PG_NAMESPACE . 'notifications_permission',
            'meta_value' => '1'
        ));

        // check if the user has any notifications to send
        foreach ( $users as $user ) {
            // get the user milestones
            $milestones_manager = new PG_Milestones( $user->ID );
            $milestones = $milestones_manager->get_milestones();

            foreach ( $milestones as $milestone ) {
                // check if the user has reached the milestone
                if ( $milestone->get_category() === 'streak' && !PG_Notifications_Sent::is_recent( $user->ID, $milestone ) ) {
                    wp_queue()->push( new PG_User_Push_Notification_Job( $user, $milestone ) );
                }
            }
        }
    }
}
