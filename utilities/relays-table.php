<?php

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
    ", [ $relay_id, $relay_id ] );

    if ( false === $random_location_which_needs_prayer ) {
        throw new ErrorException( 'Failed to get *needed* location not recently promised' );
    }

    $locations = $random_location_which_needs_prayer->fetch_all( MYSQLI_ASSOC );
    return get_random_item( $locations );
}

function query_locations_not_recently_promised( mysqli $mysqli, string $table_name, string $relay_id ) {
    $random_location_which_needs_prayer = $mysqli->execute_query( "
        SELECT * FROM $table_name
            WHERE relay_id = ?
            AND timestamp < TIMESTAMPADD( MINUTE, -1, NOW() )
    ", [ $relay_id ] );

    if ( false === $random_location_which_needs_prayer ) {
        throw new ErrorException( 'Failed to get location not recently promised' );
    }

    $locations = $random_location_which_needs_prayer->fetch_all( MYSQLI_ASSOC );

    return get_random_item( $locations );
}

function log_promise_timestamp( mysqli $mysqli, string $table_name, $relay_id, $grid_id ) {
    $response = $mysqli->execute_query( "
        UPDATE $table_name
        SET timestamp = ?
        WHERE relay_id = ?
        AND grid_id = ?
    ", [ gmdate( 'Y-m-d H:i:s' ), $relay_id, $grid_id ] );

    if ( !$response ) {
        throw new ErrorException( 'Failed to update promise timestamp' );
    }
}

function update_relay_total( mysqli $mysqli, string $table_name, $relay_id, $grid_id ) {
    $response = $mysqli->execute_query( "
        UPDATE $table_name
        SET total = total + 1
        WHERE relay_id = ?
        AND grid_id = ?
    ", [ $relay_id, $grid_id ] );

    if ( !$response ) {
        throw new ErrorException( 'Failed to update relay total' );
    }
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
        require 'pg-query-4770-locations.php';
        $list_4770 = pg_query_4770_locations();
        return get_random_item( $list_4770 );
    }

    //phpcs:ignore
    echo print_r( $next_location, true );

    return $next_location['grid_id'];
}

function get_random_item( array $items ) {
    if ( !is_array( $items ) ) {
        return null;
    }

    $length = count( $items );

    if ( $length === 0 ) {
        return null;
    }

    $random_index = rand( 0, $length );
    return $items[$random_index];
}