<?php

use WP_Queue\Job;

class PG_User_Push_Notification_Job extends Job {
    public int $user_id;
    public string $user_email;
    public PG_Notification $notification;

    public function __construct( WP_User $user, PG_Notification $notification ) {
        $this->user_id = $user->ID;
        $this->user_email = $user->user_email;
        $this->notification = $notification;
    }

    public function handle() {
        // send push notification to user with milestone message
        $data = $this->notification->category === 'badges' ? [] : $this->notification->data;
        $return = PG_Onesignal::send_to_user(
            $this->user_email,
            $this->notification->message,
            $this->notification->title,
            $this->notification->url,
            $data,
        );
        if ( $return === false && defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            error_log( 'PG_User_Push_Notification_Job: Failed to send push notification to user ' . $this->user_email );
        }
        if ( $return === false ) {
            return;
        }
        if ( $this->notification->category === 'badges' ) {
            foreach ( $this->notification->data as $badge ) {
                PG_Notifications_Sent::record( $this->user_id, PG_Notification::from_badge( PG_Badge::from_array( $badge ) ), PG_CHANNEL_IN_APP );
            }
        } else {
            PG_Notifications_Sent::record( $this->user_id, $this->notification, PG_CHANNEL_IN_APP );
        }
    }
}
