<?php

use WP_Queue\Job;

class PG_User_Email_Notification_Job extends Job {
    public int $user_id;
    public string $user_email;
    public string $user_language;
    public PG_Notification $notification;

    public function __construct( WP_User $user, PG_Notification $notification, string $user_language = 'en_US' ) {
        $this->user_id = $user->ID;
        $this->user_email = $user->user_email;
        $this->user_language = $user_language;
        $this->notification = $notification;
    }

    public function handle() {
        pg_switch_notifications_locale( $this->user_language );

        $subject = $this->notification->title;
        $body = $this->build_body();
        $headers = [ 'Content-Type: text/html; charset=UTF-8' ];

        $sent = wp_mail( $this->user_email, $subject, $body, $headers );

        if ( $sent === false ) {
            if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
                error_log( 'PG_User_Email_Notification_Job: failed to send email to user ' . $this->user_email );
            }
            return;
        }

        if ( $this->notification->category === 'badges' ) {
            foreach ( $this->notification->data as $badge ) {
                PG_Notifications_Sent::record( $this->user_id, PG_Notification::from_badge( PG_Badge::from_array( $badge ) ), PG_CHANNEL_EMAIL );
            }
        } else {
            PG_Notifications_Sent::record( $this->user_id, $this->notification, PG_CHANNEL_EMAIL );
        }
    }

    private function build_body(): string {
        $title = esc_html( $this->notification->title );
        $message = esc_html( $this->notification->message );
        $url = esc_url( $this->notification->url );
        $cta = esc_html__( 'View your badges', 'prayer-global-porch' );

        return "<!DOCTYPE html><html><body style=\"font-family: sans-serif; max-width: 600px; margin: 0 auto; padding: 1.5rem; color: #333;\">
            <h1 style=\"margin-top: 0;\">{$title}</h1>
            <p style=\"font-size: 1.05rem; line-height: 1.5;\">{$message}</p>
            <p><a href=\"{$url}\" style=\"display: inline-block; padding: 0.75rem 1.5rem; background: #2563eb; color: #fff; text-decoration: none; border-radius: 4px;\">{$cta}</a></p>
        </body></html>";
    }
}
