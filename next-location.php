<?php
//this stops wp-settings from load everything
define( 'SHORTINIT', true );

error_log( 'short-init complete' );
require '../../../wp-config.php';

//phpcs:ignore
$conn = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );

if ($conn->connect_error) {
    //phpcs:ignore
    die( "Connection failed: " . $conn->connect_error );
}

echo "Connected successfully";
$db_prefix = defined( 'DB_PREFIX' ) ? DB_PREFIX : 'wp_';
//phpcs:ignore
$relay_id = isset( $_GET['relay_id'] ) ? $_GET['relay_id'] : '49ba4c';

$relays_table = $db_prefix . 'dt_relays';

/**
 * Get a random location that hasn't been prayed for and hasn't been recently promised
 * @param mysqli $mysqli
 * @param string $relay_table
 * @param string $relay_id
 * @return array|object|null
 */
function query_needed_locations_not_recently_promised( mysqli $mysqli, string $relay_table, string $relay_id ) {
    $random_location_which_needs_prayer = $mysqli->execute_query( "
        SELECT * FROM $relay_table
            WHERE relay_id = ?
            AND total = ( SELECT MIN(total) FROM $relay_table WHERE relay_id = ? )
            AND timestamp < TIMESTAMPADD( MINUTE, -1, NOW() )
            ORDER BY RAND()
            LIMIT 1
    ", [ $relay_id, $relay_id ] );

    return $random_location_which_needs_prayer->fetch_all( MYSQLI_ASSOC );
}

function query_locations_not_recently_promised( mysqli $mysqli, string $table_name, string $relay_id ) {
    $random_location_which_needs_prayer = $mysqli->execute_query( "
        SELECT * FROM $table_name
            WHERE relay_id = ?
            AND timestamp < TIMESTAMPADD( MINUTE, -1, NOW() )
            ORDER BY RAND()
            LIMIT 1
    ", [ $relay_id ] );

    return $random_location_which_needs_prayer->fetch_all( MYSQLI_ASSOC );
}

function log_promise_timestamp( mysqli $mysqli, string $table_name, $relay_id, $grid_id ) {
    $mysqli->execute_query( "
        UPDATE $table_name
        SET timestamp = ?
        WHERE relay_id = ?
        AND grid_id = ?
    ", [ gmdate( 'Y-m-d H:i:s' ), $relay_id, $grid_id ] );
}

function update_relay_total( mysqli $mysqli, string $table_name, $relay_id, $grid_id ) {
    $mysqli->execute_query( "
        UPDATE $table_name
        SET total = total + 1
        WHERE relay_id = ?
        AND grid_id = ?
    ", [ $relay_id, $grid_id ] );
}

function get_next_grid_id_from_relays_table( mysqli $mysqli, string $relay_table, $relay_id ) {
    /* Get locations which haven't been prayed for yet this lap, and haven't been promised in the last minute */

    $next_location = query_needed_locations_not_recently_promised( $mysqli, $relay_table, $relay_id );

    /* IF all the locations that need praying for have been promised in the last minute */
    /* THEN get a location for the next lap that hasn't been promised in the last minute */
    if ( empty( $next_location ) ) {
        $next_location = query_locations_not_recently_promised( $mysqli, $relay_table, $relay_id );
    }

    /* IF even that fails, then just give a random location */
    if ( empty( $next_location ) ) {
        $list_4770 = pg_query_4770_locations();
        shuffle( $list_4770 );
        return $list_4770[0];
    }

    return $next_location[0]['grid_id'];
}

$next_location = get_next_grid_id_from_relays_table( $conn, $relays_table, $relay_id );
log_promise_timestamp( $conn, $relays_table, $relay_id, $next_location );
update_relay_total( $conn, $relays_table, $relay_id, $next_location );

echo $next_location;
?>