<?php

use WP_Queue\Job;

class PG_User_Push_Notification_Job extends Job {
    private int $user_id;
    private string $user_email;
    private PG_Milestone $milestone;

    public function __construct( int $user_id, string $user_email, PG_Milestone $milestone ) {
        $this->user_id = $user_id;
        $this->user_email = $user_email;
        $this->milestone = $milestone;
    }

    public function handle() {
        // send push notification to user with milestone message
        PG_Onesignal::send_to_user( $this->user_email, $this->milestone->get_message() );
        PG_Notifications_Sent::record( $this->user_id, $this->milestone );
    }
}
