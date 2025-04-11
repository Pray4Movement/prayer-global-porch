<?php

class PG_Onesignal {
    public static array $allowed_users = [
        'nathinabob+1234@gmail.com',
        'nathinabob@gmail.com',
    ];
    public static function send_to_user( string $user_email, string $message, string $title = '', string $url = '' ) {
        if (
            ( defined( 'PG_ONESIGNAL_STOP' ) && PG_ONESIGNAL_STOP ) &&
            !in_array( $user_email, self::$allowed_users )
        ) {
            return false;
        }

        $onesignal_app_id = get_option( 'pg_onesignal_app_id' );
        $onesignal_api_key = get_option( 'pg_onesignal_api_key' );

        // Decode HTML entities in message and title
        $message = html_entity_decode( $message, ENT_QUOTES );
        $title = $title ? html_entity_decode( $title, ENT_QUOTES ) : '';

        $payload = [
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
        ];

        if ( $title ) {
            $payload['headings'] = [
                'en' => $title,
            ];
        }

        if ( $url ) {
            $payload['app_url'] = $url;
        }

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
            CURLOPT_POSTFIELDS => json_encode( $payload ),
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
            throw new Exception( 'pg_push_notification_error', $err );
        } else if ( isset( $response['errors'] ) && is_array( $response['errors'] ) && count( $response['errors'] ) > 0 ) {
            throw new Exception( 'pg_push_notification_error', array_reduce( $response['errors'], function( $carry, $item ) {
                return $carry . $item['message'] . ' **&&** ';
            }, '' ) );
        } else {
            return $response;
        }
    }
}
