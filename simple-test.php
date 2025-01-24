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
$and_update = isset( $_GET['and_update'] ) ? true : false;

//phpcs:ignore
$get_what = isset( $_GET['get'] ) ? $_GET['get'] : 'one';

$relays_table = $db_prefix . 'dt_relays';

//phpcs:ignore
try {
    switch ( $get_what ) {
        case 'one':
            $results = $mysqli->execute_query( "
                SELECT * FROM $relays_table
                    WHERE relay_id = ?
                    AND grid_id = ?
            ", [ $relay_id, $grid_id ] );
            break;
        case 'all':
            $results = $mysqli->execute_query( "
                SELECT * FROM $relays_table
                    WHERE relay_id = ?
            ", [ $relay_id ] );
            break;
        default:
            # code...
            break;
    }

    if ( $and_update ) {
        $mysqli->execute_query( "
            UPDATE $relays_table
            SET timestamp = ?
                WHERE relay_id = ?
                AND grid_id = ?
        ", [ gmdate( 'Y-m-d H:i:s' ), $relay_id, $grid_id ] );
    }
    if ( false === $results ) {
        throw new ErrorException( 'Failed to get location not recently promised' );
    }

    $locations = $results->fetch_all( MYSQLI_ASSOC );
    $location = !empty( $locations ) ? $locations[0] : '';
} catch (\Throwable $th) {
    send_response( [
        'status' => 'error',
        'error' => $th->getMessage(),
        'trace' => $th->getTrace(),
    ], 400 );
}

send_response([
    'status' => 'ok',
    'location' => $location,
]);

?>