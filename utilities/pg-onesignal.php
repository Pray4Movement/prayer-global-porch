<?php

class PG_Onesignal {
    public static array $allowed_users = [
        'nathinabob+1234@gmail.com',
        'nathinabob@gmail.com',
    ];
    public static function send_to_user( string $user_email, string $message, string $title = '', string $url = '', array $data = [] ) {
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
            $payload['url'] = $url;
        }

        if ( !empty( $data ) ) {
            $payload['data'] = $data;
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
            throw new Exception( 'pg_push_notification_error: ' . $err );
        }

        if ( self::response_indicates_undeliverable( $response ) ) {
            return 'undeliverable';
        }

        if ( isset( $response['errors'] ) && is_array( $response['errors'] ) && count( $response['errors'] ) > 0 ) {
            throw new Exception( 'pg_push_notification_error: ' . array_reduce( $response['errors'], function( $carry, $item ) {
                return $carry . $item['message'] . ' **&&** ';
            }, '' ) );
        }

        $decoded_error = self::extract_response_error_message( $response );
        if ( $decoded_error !== null ) {
            throw new Exception( 'pg_push_notification_error: ' . $decoded_error );
        }

        return $response;
    }

    private static function extract_response_error_message( $response ) {
        $data = is_string( $response ) ? json_decode( $response, true ) : null;
        if ( !is_array( $data ) || empty( $data['errors'] ) ) {
            return null;
        }
        $errors = $data['errors'];
        $parts = [];
        if ( is_array( $errors ) ) {
            foreach ( $errors as $key => $value ) {
                if ( is_string( $value ) ) {
                    $parts[] = $value;
                } elseif ( is_array( $value ) ) {
                    $parts[] = ( is_string( $key ) ? $key . ': ' : '' ) . implode( ', ', array_map( 'strval', $value ) );
                }
            }
        } elseif ( is_string( $errors ) ) {
            $parts[] = $errors;
        }
        return empty( $parts ) ? null : implode( ' **&&** ', $parts );
    }

    private static function response_indicates_undeliverable( $response ) {
        $data = is_string( $response ) ? json_decode( $response, true ) : null;
        if ( !is_array( $data ) || !isset( $data['errors'] ) ) {
            return false;
        }
        $errors = $data['errors'];
        if ( isset( $errors['invalid_external_user_ids'] ) || isset( $errors['invalid_aliases'] ) ) {
            return true;
        }
        if ( is_array( $errors ) ) {
            foreach ( $errors as $msg ) {
                if ( is_string( $msg ) && stripos( $msg, 'not subscribed' ) !== false ) {
                    return true;
                }
            }
        }
        return false;
    }
}
