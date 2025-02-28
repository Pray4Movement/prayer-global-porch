<?php
/* Useful sql queries to check and reset the database */
// SELECT total, COUNT(total) FROM 9VJS6H_dt_relays WHERE relay_key = '49ba4c' GROUP BY total ORDER BY total;
// UPDATE 9VJS6H_dt_relays SET epoch = epoch - 60, total = 0 WHERE relay_key = '49ba4c';

//this stops wp-settings from load everything
define( 'SHORTINIT', true );

require '../../../wp-config.php';
require 'utilities/relays-table.php';
require 'utilities/http-request.php';
require 'utilities/pg-nonce.php';

if ( !defined( 'WP_DEBUG' ) || !WP_DEBUG ) {
    $cors_passed = cors();

    if ( !$cors_passed ) {
        send_response( [
            'error' => "incorrect origin $origin",
        ], 400 );
    }
    $nonce = isset( $_GET['nonce'] ) ? sanitize_text_field( stripslashes_deep( $_GET['nonce'] ) ) : '';

    if ( !PG_Nonce::verify( $nonce, 'direct-api' ) ) {
        send_response( [
            'status' => 'error',
            'error' => 'Unauthorized',
        ], 400 );
    }
}

//phpcs:ignore
mysqli_report( MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT );
//phpcs:ignore
$conn = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );

if ( $conn->connect_error ) {
    send_response( array(
        'status' => 'error',
        'error' => 'Unable to make connection with DB',
    ), 500 );
}

$db_prefix = defined( 'DB_PREFIX' ) ? DB_PREFIX : 'wp_';

//phpcs:ignore
$relay_key = isset( $_GET['relay_key'] ) ? sanitize_text_field( stripslashes_deep( $_GET['relay_key'] ) ) : '49ba4c';

$relays_table = new PG_Relays_Table( $conn, $db_prefix );

try {
    $next_location = (int) $relays_table->get_next_grid_id( $relay_key );
    $relays_table->log_promise_timestamp( $relay_key, $next_location );
} catch ( \Throwable $th ) {
    send_response( array(
        'status' => 'error',
        'error' => $th->getMessage(),
        'trace' => $th->getTrace(),
    ), 400 );
}

send_response(
    array(
    'status' => 'ok',
    'next_location' => $next_location,
    ),
    200,
    $next_location
);
$conn->close();
