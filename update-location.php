<?php

/*
    This is a POST request, and so is expecting the data to be in the body of the request
    This is accessed by reading the php://input file stream
*/

/* TODO: add cors and file protections */

//this stops wp-settings from load everything
define( 'SHORTINIT', true );

error_log( 'short-init complete' );
require '../../../wp-config.php';
require 'utilities/relays-table.php';
require 'utilities/http-request.php';

function dt_recursive_sanitize_array( array $array ) : array {
    foreach ( $array as $key => &$value ) {
        if ( is_array( $value ) ) {
            $value = dt_recursive_sanitize_array( $value );
        }
        else {
            $value = sanitize_text_field( stripslashes_deep( $value ) );
        }
    }
    return $array;
}

//phpcs:ignore
mysqli_report( MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT );
//phpcs:ignore
$conn = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );

if ($conn->connect_error) {
    send_response( array(
        'status' => 'error',
        'error' => 'Unable to make connection with DB',
    ) );
}

$db_prefix = defined( 'DB_PREFIX' ) ? DB_PREFIX : 'wp_';

$content = trim( file_get_contents( "php://input" ) );
$decoded = json_decode( $content, true );

if ( !is_array( $decoded ) ) {
    send_response( [
        'status' => 'error',
        'error' => 'JSON is improperly formatted',
    ] );
}

if ( !isset( $decoded['data'] ) ) {
    send_response( [
        'status' => 'error',
        'error' => 'No args provided',
    ], 400 );
}

$relay_id = isset( $decoded['relay_id'] ) ? sanitize_text_field( stripslashes_deep( $decoded['relay_id'] ) ) : '49ba4c';
$data = dt_recursive_sanitize_array( $decoded['data'] );

$relays_table = new PG_Relays_Table( $conn, $db_prefix );

try {
    $relays_table->update_relay_total( $relay_id, $data );
} catch (\Throwable $th) {
    send_response( array(
        'status' => 'error',
        'error' => $th->getMessage(),
        'trace' => $th->getTrace(),
    ), 400 );
}

send_response( array(
    'status' => 'ok',
) );
