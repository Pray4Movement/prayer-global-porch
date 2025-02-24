<?php

/**
 * Send an API response
 * @param  mixed       $response The API response
 * @param  integer $code     The response code
 */
function send_response( mixed $response, $code = 200, $location = null ) {
    header( 'Content-Type: application/json; charset=utf-8' );
    if ( $location ){
        header( 'next_location: ' . $location );
    }
    http_response_code( $code );
    die( json_encode( $response ) );
}

function cors() {

    $allowed_origins = [
        'https://prayer.global',
        'https://staging.prayer.global',
        'http://localhost:8000', // TODO: DELETE this for production
        'http://prayerglobal.lwp',
        'https://prayerglobal.lwp',
    ];

    $origin = sanitize_text_field( stripslashes_deep( $_SERVER['HTTP_ORIGIN'] ?? '' ) );

    // If no origin, try to extract it from referer
    if ( empty( $origin ) && !empty( $_SERVER['HTTP_REFERER'] ) ) {
        $referer_parts = parse_url( sanitize_text_field( stripslashes_deep( $_SERVER['HTTP_REFERER'] ) ) );
        if ( $referer_parts && isset( $referer_parts['scheme'] ) && isset( $referer_parts['host'] ) ) {
            $origin = $referer_parts['scheme'] . '://' . $referer_parts['host'];
            if ( isset( $referer_parts['port'] ) ) {
                $origin .= ':' . $referer_parts['port'];
            }
        }
    }

    if ( empty( $origin ) ) {
        return false;
    }
    if ( in_array( $origin, $allowed_origins ) ) {
        header( "Access-Control-Allow-Origin: $origin " );
        header( 'Access-Control-Allow-Credentials: true' );
        header( 'Access-Control-Max-Age: 86400' );    // cache for 1 day
    } else {
        return false;
    }

    // Access-Control headers are received during OPTIONS requests
    if ( isset( $_SERVER['REQUEST_METHOD'] ) && $_SERVER['REQUEST_METHOD'] === 'OPTIONS' ) {

        if ( isset( $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] ) ) {
            // may also be using PUT, PATCH, HEAD etc
            header( 'Access-Control-Allow-Methods: GET, POST, OPTIONS' );
        }

        if ( isset( $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'] ) ) {
            header( 'Access-Control-Allow-Headers: ' . sanitize_text_field( stripslashes_deep( $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'] ) ) );
        }

        exit( 0 );
    }

    return true;
}
