<?php
/*
    This is a POST request, and so is expecting the data to be in the body of the request
    This is accessed by reading the php://input file stream
*/

/* TODO: add cors and file protections */

//this stops wp-settings from load everything
define( 'SHORTINIT', true );

require '../../../wp-config.php';
require 'utilities/relays-table.php';
require 'utilities/http-request.php';
require 'utilities/pg-nonce.php';

//$cors_passed = cors();
//
//if ( !$cors_passed ) {
//    send_response( [
//        'error' => 'incorrect origin',
//    ], 400 );
//}

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

$content = trim( file_get_contents( 'php://input' ) );
$decoded = json_decode( $content, true );

if ( !is_array( $decoded ) ) {
    send_response( [
        'status' => 'error',
        'error' => 'JSON is improperly formatted',
    ] );
}

if ( !isset( $decoded['relay_key'] ) || !isset( $decoded['grid_id'] ) || !isset( $decoded['parts'] ) ) {
    send_response( [
        'status' => 'error',
        'error' => 'Incomplete args provided',
    ], 400 );
}

if ( !defined( 'WP_DEBUG' ) || !WP_DEBUG ){
    $nonce = isset( $decoded['nonce'] ) ? sanitize_text_field( stripslashes_deep( $decoded['nonce'] ) ) : '';

    if ( !PG_Nonce::verify( $nonce, 'direct-api' ) ){
        send_response( [
            'status' => 'error',
            'error' => 'Unauthorized',
        ], 400 );
    }
}

$relay_key = isset( $decoded['relay_key'] ) ? sanitize_text_field( stripslashes_deep( $decoded['relay_key'] ) ) : null;
$relay_id = isset( $decoded['relay_id'] ) ? sanitize_text_field( stripslashes_deep( $decoded['relay_id'] ) ) : null;
$grid_id = isset( $decoded['grid_id'] ) ? sanitize_text_field( stripslashes_deep( $decoded['grid_id'] ) ) : null;
$user_id = isset( $decoded['user_id'] ) ? sanitize_text_field( stripslashes_deep( $decoded['user_id'] ) ) : null;
$pace = isset( $decoded['pace'] ) ? sanitize_text_field( stripslashes_deep( $decoded['pace'] ) ) : 1;
$user_location = dt_recursive_sanitize_array( $decoded['user_location'] ?? [] );
$parts = dt_recursive_sanitize_array( $decoded['parts'] ?? [] );

//phpcs:ignore
mysqli_report( MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT );
//phpcs:ignore
$conn = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );

if ( $conn->connect_error ) {
    send_response( array(
        'status' => 'error',
        'error' => 'Unable to make connection with DB',
    ) );
}

$db_prefix = defined( 'DB_PREFIX' ) ? DB_PREFIX : 'wp_';

$relays_table = new PG_Relays_Table( $conn, $db_prefix );

try {
    if ( empty( $relay_id ) ) {
        $relay_id = $relays_table->get_relay_id( $relay_key );
    }
    $updated_laps = $relays_table->update_relay_total( $relay_key, $grid_id, $relay_id );
    $report_id = $relays_table->log_prayer( $grid_id, $relay_key, [
            'user_id' => $user_id,
            'lap_number' => $updated_laps['lap_number'],
            'global_lap_number' => $updated_laps['global_lap_number'],
            'pace' => $pace,
            'parts' => $parts,
            'user_location' => $user_location
        ],
        $relay_id
    );
} catch ( \Throwable $th ) {
    send_response( array(
        'status' => 'error',
        'error' => $th->getMessage(),
        'trace' => $th->getTrace(),
    ), 400 );
}

send_response( array(
    'status' => 'ok',
    'report_id' => $report_id,
) );
