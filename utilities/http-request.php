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
