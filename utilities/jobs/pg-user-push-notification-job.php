<?php

use WP_Queue\Job;

class PG_User_Push_Notification_Job extends Job {
    public int $user_id;
    public string $user_email;
    public PG_Milestone $milestone;

    public function __construct( WP_User $user, PG_Milestone $milestone ) {
        $this->user_id = $user->ID;
        $this->user_email = $user->user_email;
        $this->milestone = $milestone;
    }

    public function handle() {
        // send push notification to user with milestone message
        $return = PG_Onesignal::send_to_user( $this->user_email, $this->milestone->get_message(), $this->milestone->get_title(), $this->milestone->get_url() );
        if ( $return === false ) {
            error_log( 'PG_User_Push_Notification_Job: Failed to send push notification to user ' . $this->user_email );
        }
        PG_Notifications_Sent::record( $this->user_id, $this->milestone, PG_CHANNEL_PUSH );
    }
}
