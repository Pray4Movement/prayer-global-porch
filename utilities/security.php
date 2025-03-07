<?php

function pg_sanitize_text_field_custom( $str ){
    if ( is_array( $str ) ){
        return array_map( 'pg_sanitize_text_field_custom', $str );
    }

    $str = preg_replace( '/[^a-zA-Z0-9_\-., ]/', '', $str );

    return $str;
}

/**
 * Create and verify time based nonces
 */
class PG_Nonce {
    /**
     * Create a nonce based on an action
     * @param string $action
     * @return string
     */
    public static function create( string $action ) {
        /* TODO: implement me */
        $session_token = self::get_session_token();
        $timestamp = time();
        return self::hash( "$timestamp | $action | $session_token" ) . '.' . $timestamp;
    }

    /**
     * Verify that the nonce is valid in the last time period
     * @param string $nonce
     * @param string $action
     * @return bool
     */
    public static function verify( string $nonce, string $action ) {
        $nonce_parts = explode( '.', $nonce );

        if ( count( $nonce_parts ) !== 2 ) {
            return false;
        }

        $hash = $nonce_parts[0];
        $timestamp = $nonce_parts[1];
        $session_token = self::get_session_token();

        $expected_hash = self::hash( "$timestamp | $action | $session_token" );

        if ( $hash !== $expected_hash ) {
            return false;
        }

        if ( $timestamp < time() - 86400 ) {
            return false;
        }

        return true;
    }

    private static function hash( $data ) {
        return substr( hash_hmac( 'md5', $data, NONCE_SALT ), -12, 10 );
    }

    private static function get_session_token() {
        $result = '';
        foreach ( array_keys( $_COOKIE ) as $key ) {
            if ( str_contains( 'wordpress_', $key ) && !str_contains( 'wordpress_logged_in', $key ) ) {
                $result = !empty( $_COOKIE[$key] ) ? pg_sanitize_text_field_custom( $_COOKIE[$key] ) : ''; //phpcs:ignore
            }
        }
        return $result;
    }
}
