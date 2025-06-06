<?php
/*
    This is a POST request, and so is expecting the data to be in the body of the request
    This is accessed by reading the php://input file stream
*/

require '../../../pg-wp-config.php';
require 'utilities/security.php';
require 'utilities/http-request.php';
require 'utilities/relays-table.php';

if ( !defined( 'PG_DEBUG' ) || !PG_DEBUG ){
    $cors_passed = cors();

    if ( !$cors_passed ) {
        send_response( [
            'error' => 'incorrect origin',
        ], 400 );
    }
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

if ( !defined( 'PG_DEBUG' ) || !PG_DEBUG ){
    $nonce = isset( $decoded['nonce'] ) ? pg_sanitize_text_field_custom( $decoded['nonce'] ) : '';

    if ( !PG_Nonce::verify( $nonce, 'direct-api' ) ){
        send_response( [
            'status' => 'error',
            'error' => 'Unauthorized',
        ], 400 );
    }
}

$relay_key = isset( $decoded['relay_key'] ) ? pg_sanitize_text_field_custom( $decoded['relay_key'] ) : null;
$relay_id = isset( $decoded['relay_id'] ) ? pg_sanitize_text_field_custom( $decoded['relay_id'] ) : null;
$grid_id = isset( $decoded['grid_id'] ) ? pg_sanitize_text_field_custom( $decoded['grid_id'] ) : null;
$user_id = isset( $decoded['user_id'] ) ? pg_sanitize_text_field_custom( $decoded['user_id'] ) : null;
$pace = 1;
$user_location = pg_sanitize_text_field_custom( $decoded['user_location'] ?? [] );
$user_language = pg_sanitize_text_field_custom( $decoded['language'] ?? 'en_US' );
$parts = pg_sanitize_text_field_custom( $decoded['parts'] ?? [] );

//phpcs:ignore
//mysqli_report( MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT );
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
            'user_location' => $user_location,
            'user_language' => $user_language,
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
