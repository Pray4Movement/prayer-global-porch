<?php

/**
 * Send an API response
 * @param  mixed       $response The API response
 * @param  integer $code     The response code
 */
function send_response( mixed $response, $code = 200 ) {
    header( 'Content-Type: application/json; charset=utf-8' );
    http_response_code( $code );
    die( json_encode( $response ) );
}

function cors() {

    header( 'Access-Control-Allow-Origin: https://staging.prayer.global' );
    header( 'Access-Control-Allow-Credentials: true' );
    header( 'Access-Control-Max-Age: 86400' );    // cache for 1 day

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
}
