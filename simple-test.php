<?php
// select total, count(total) from 9VJS6H_dt_relays where relay_id = '49ba4c' group by total order by total;

/* TODO: prevent direct access */


//this stops wp-settings from load everything
define( 'SHORTINIT', true );

error_log( 'short-init complete' );
require '../../../wp-config.php';
require 'utilities/http-request.php';

//phpcs:ignore
mysqli_report( MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT );
//phpcs:ignore
$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );

if ($mysqli->connect_error) {
    //phpcs:ignore
    die( "Connection failed: " . $mysqli->connect_error );
}

$db_prefix = defined( 'DB_PREFIX' ) ? DB_PREFIX : 'wp_';
//phpcs:ignore
$relay_id = isset( $_GET['relay_id'] ) && 1 === preg_match( '/[[:^alnum]]/', $_GET['relay_id'] ) ? $_GET['relay_id'] : '49ba4c';
//phpcs:ignore
$grid_id = isset( $_GET['grid_id'] ) && 1 === preg_match( '/[[:^alnum]]/', $_GET['grid_id'] ) ? $_GET['grid_id'] : '100219981';

$relays_table = $db_prefix . 'dt_relays';

//phpcs:ignore
try {
    $results = $mysqli->execute_query( "
        SELECT * FROM $relays_table
            WHERE relay_id = ?
            AND grid_id = ?
    ", [ $relay_id, $grid_id ] );

    if ( false === $results ) {
        throw new ErrorException( 'Failed to get location not recently promised' );
    }

    $locations = $results->fetch_all( MYSQLI_ASSOC );
} catch (\Throwable $th) {
    send_response( [
        'status' => 'error',
        'error' => $th->getMessage(),
        'trace' => $th->getTrace(),
    ], 400 );
}

send_response([
    'status' => 'ok',
    'locations' => $locations,
]);

?>