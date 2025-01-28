<?php
/* Useful sql queries to check and reset the database */
// SELECT total, COUNT(total) FROM 9VJS6H_dt_relays WHERE relay_id = '49ba4c' GROUP BY total ORDER BY total;
// UPDATE 9VJS6H_dt_relays SET epoch = epoch - 60, total = 0 WHERE relay_id = '49ba4c';

//this stops wp-settings from load everything
define( 'SHORTINIT', true );

error_log( 'short-init complete' );
require '../../../wp-config.php';
require 'utilities/relays-table.php';
require 'utilities/http-request.php';

//phpcs:ignore
mysqli_report( MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT );
//phpcs:ignore
$conn = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );

if ($conn->connect_error) {
    //phpcs:ignore
    die( "Connection failed: " . $conn->connect_error );
}

$db_prefix = defined( 'DB_PREFIX' ) ? DB_PREFIX : 'wp_';
//phpcs:ignore
$relay_id = isset( $_GET['relay_id'] ) && 1 === preg_match( '/[[:^alnum]]/', $_GET['relay_id'] ) ? $_GET['relay_id'] : '49ba4c';

$relays_table = $db_prefix . 'dt_relays';

//phpcs:ignore
try {
    $next_location = get_next_grid_id_from_relays_table( $conn, $relays_table, $relay_id );
    log_promise_timestamp( $conn, $relays_table, $relay_id, $next_location );
    update_relay_total( $conn, $relays_table, $relay_id, $next_location );
} catch (\Throwable $th) {
    send_response( [
        'status' => 'error',
        'error' => $th->getMessage(),
        'trace' => $th->getTrace(),
    ], 400 );
}

send_response([
    'status' => 'ok',
    'next_location' => $next_location,
]);

?>