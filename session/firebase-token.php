<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class FirebaseToken {

    private string $token;

    public function __construct( string $token ) {
        $this->token = $token;
    }

    /**
     * Verifies the token according to the firebase project id
     * @param string $project_id
     * @throws Error
     * @return array
     */
    public function verify( string $project_id ) : array {
        $keys = $this->getPublicKeys();

        $payload = JWT::decode( $this->token, $keys );

        $isValid = $this->validatePayload( $payload, $project_id );

        if ( !$isValid ) {
            throw new Error( 'firebase token payload is invalid' );
        }

        return (array) $payload;
    }

    /**
     * Returns googles current public keys. Caches them until they need refetching.
     * @return array
     */
    private function getPublicKeys() : array {

        $public_key_url = 'https://www.googleapis.com/robot/v1/metadata/x509/securetoken@system.gserviceaccount.com';

        $response = wp_remote_get( $public_key_url );

        $body = wp_remote_retrieve_body( $response );

        $keys = json_decode( $body, true );

        foreach ($keys as $kid => $cert) {
            $keys[$kid] = new Key( $cert, 'RS256' );
        }

        return $keys;
    }

    /**
     * Validates the token payload according to the rules at https://firebase.google.com/docs/auth/admin/verify-id-tokens
     * @param object $payload
     * @param string $project_id
     * @return bool
     */
    private function validatePayload( object $payload, string $project_id ) : bool {

        /* Expiry must be in the future */
        if ( $payload->exp < time() ) {
            return false;
        }
        /* Issued at time must be in the past */
        if ( $payload->iat > time() ) {
            return false;
        }
        /* Audience must be the project id */
        if ( $payload->aud !== $project_id ) {
            return false;
        }
        if ( $payload->iss !== "https://securetoken.google.com/$project_id" ) {
            return false;
        }
        /* Subject must be non empty string and contains the uid of the user */
        if ( empty( $payload->sub ) ) {
            return false;
        }
        /* Authentication time must be in the past */
        if ( $payload->auth_time > time() ) {
            return false;
        }

        return true;
    }

}