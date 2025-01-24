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
$options_table = $db_prefix . 'options';

//phpcs:ignore
try {
    switch ( $get_what ) {
        case 'one':
            $results = $mysqli->execute_query( "
                SELECT * FROM $relays_table
                    WHERE relay_id = ?
                    AND grid_id = ?
            ", [ $relay_id, $grid_id ] );
            $locations = $results->fetch_all( MYSQLI_ASSOC );
            break;
        case 'all':
            $results = $mysqli->execute_query( "
                SELECT * FROM $relays_table
                    WHERE relay_id = ?
            ", [ $relay_id ] );
            $locations = $results->fetch_all( MYSQLI_ASSOC );
            $location = $locations[0];
            break;
        case 'all-ids':
            $results = $mysqli->execute_query( "
                SELECT grid_id FROM $relays_table
                    WHERE relay_id = ?
            ", [ $relay_id ] );
            $locations = $results->fetch_all( MYSQLI_ASSOC );
            $location = $locations[0];
            break;
        case 'rand-php':
            $results = $mysqli->execute_query( "
                SELECT * FROM $relays_table
                    WHERE relay_id = ?
            ", [ $relay_id ] );
            $locations = $results->fetch_all( MYSQLI_ASSOC );
            $location = !empty( $locations ) ? $locations[rand( 0, count( $locations ) - 1 )] : '';
            break;
        case 'rand-mysql':
            $results = $mysqli->execute_query( "
                SELECT * FROM $relays_table
                    WHERE relay_id = ?
                ORDER BY RAND()
                LIMIT 1
            ", [ $relay_id ] );
            $locations = $results->fetch_all( MYSQLI_ASSOC );
            $location = !empty( $locations ) ? $locations[0] : '';
            break;
        case 'min-total':
            $results = $mysqli->execute_query( "
                SELECT * FROM $relays_table
                    WHERE relay_id = ?
                    AND total = ( SELECT MIN(total) FROM $relays_table WHERE relay_id = ? )
                ORDER BY RAND()
                LIMIT 1
            ", [ $relay_id, $relay_id ] );
            $locations = $results->fetch_all( MYSQLI_ASSOC );
            $location = !empty( $locations ) ? $locations[0] : '';
            break;
        case 'min-total-precalc':
            $min_results = $mysqli->execute_query( "
                SELECT MIN(total) FROM $relays_table WHERE relay_id = ?
            ", [ $relay_id ] );
            $min_total = $min_results->fetch_column();
            $results = $mysqli->execute_query( "
                SELECT * FROM $relays_table
                    WHERE relay_id = ?
                    AND total = ?
                ORDER BY RAND()
                LIMIT 1
            ", [ $relay_id, $min_total ] );
            $locations = $results->fetch_all( MYSQLI_ASSOC );
            $location = !empty( $locations ) ? $locations[0] : '';
            break;
        case 'min-total-cached':

            $min_total = get_cache( $mysqli, $options_table, 'relays_min_total' );
            if ( $min_total === false ) {
                $min_results = $mysqli->execute_query( "
                    SELECT MIN(total) FROM $relays_table WHERE relay_id = ?
                ", [ $relay_id ] );
                $min_total = $min_results->fetch_column();

                set_cache( $mysqli, $options_table, 'relays_min_total', $min_total );
            }

            $results = $mysqli->execute_query( "
                SELECT * FROM $relays_table
                    WHERE relay_id = ?
                    AND total = ?
                ORDER BY RAND()
                LIMIT 1
            ", [ $relay_id, $min_total ] );
            $locations = $results->fetch_all( MYSQLI_ASSOC );
            $location = !empty( $locations ) ? $locations[0] : '';
            break;
        default:
            $location = '';
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

function set_cache( $mysqli, $options_table, $key, $value ) {
    $mysqli->execute_query( "
        INSERT INTO $options_table ( option_name, option_value )
        VALUES ( ?, ? )
    ", [ $key, $value ] );
}

function get_cache( mysqli $mysqli, $options_table, $key ) {
    $results = $mysqli->execute_query( "
        SELECT option_value FROM $options_table
        WHERE option_name = ?
    ", [ $key ] );
    $value = $results->fetch_column();

    return $value;
}

?>