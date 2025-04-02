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
        $this->send_push_notification( $this->user_email, $this->milestone->get_message() );
        PG_Notifications_Sent::record( $this->user_id, $this->milestone );
    }

    public function send_push_notification( string $user_email, string $message ) {

        $onesignal_app_id = get_option( 'pg_onesignal_app_id' );
        $onesignal_api_key = get_option( 'pg_onesignal_api_key' );

        // send push notification to user with milestone message
        $curl = curl_init();

        curl_setopt_array( $curl, [
            CURLOPT_URL => 'https://api.onesignal.com/notifications?c=push',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                'app_id' => $onesignal_app_id,
                'contents' => [
                    'en' => $message,
                ],
                'include_aliases' => [
                    'external_id' => [
                        $user_email,
                    ]
                ]
            ]),
            CURLOPT_HTTPHEADER => [
                'Authorization: Key ' . $onesignal_api_key,
                'accept: application/json',
                'content-type: application/json'
            ],
        ]);

        $response = curl_exec( $curl );
        $err = curl_error( $curl );

        curl_close( $curl );

        if ( $err ) {
            return new WP_Error( 'pg_push_notification_error', $err );
        } else {
            return $response;
        }
    }
}
