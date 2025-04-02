<?php

class PG_Onesignal {
    public static function send_to_user( string $user_email, string $message ) {

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
                'target_channel' => 'push',
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
