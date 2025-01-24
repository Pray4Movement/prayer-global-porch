<?php

function query_next_location_with_php( mysqli $mysqli, string $relay_table, string $relay_id ) {
    $query = $mysqli->execute_query( "
        SELECT relay_id, grid_id, total, UNIX_TIMESTAMP( timestamp ) as unix_timestamp FROM $relay_table
            WHERE relay_id = ?
    ", [ $relay_id ] );

    if ( false === $query ) {
        throw new ErrorException( 'Failed to get *needed* location not recently promised' );
    }

    $locations = $query->fetch_all( MYSQLI_ASSOC );

    /* The query we're trying to replicate in mysql first gets things that match the min */
    /* We need the complete minimum, and we need to store all the locations not recently prayed for, and the minimum of those */

    $locations_sorted_by_total = [];
    $locations_not_recently_promised = [];
    $min_total = PHP_INT_MAX;
    $timelimit_for_recent = 60;
    foreach ( $locations as $location ) {
        $total = $location['total'];

        /* Store the smallest total of all locations */
        if ( $total < $min_total ) {
            $min_total = $total;
        }

        $timestamp = $location['unix_timestamp'];

        /* If the location was recently promised then don't include it */
        if ( time() - $timestamp < $timelimit_for_recent ) {
            continue;
        }

        if ( !isset( $locations_sorted_by_total[$total] ) ) {
            $locations_sorted_by_total[$total] = [];
        }
        $locations_sorted_by_total[$total][] = $location;
        $locations_not_recently_promised[] = $location;
    }

    if ( !isset( $locations_sorted_by_total[$min_total] ) ) {
        /* We don't have any locations not recently promised that match the min total */
        /* So we return any of the not recently promised locations */
        return get_random_item( $locations_not_recently_promised );
    }

    /* Otherwise return a location not recently promised that helps complete the current lap */
    return get_random_item( $locations_sorted_by_total[$min_total] );
}

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

    if ( false === $random_location_which_needs_prayer ) {
        throw new ErrorException( 'Failed to get *needed* location not recently promised' );
    }

    $locations = $random_location_which_needs_prayer->fetch_all( MYSQLI_ASSOC );
    $location = !empty( $locations ) ? $locations[0] : [];
    return $location;
}

function query_locations_not_recently_promised( mysqli $mysqli, string $table_name, string $relay_id ) {
    $random_location_which_needs_prayer = $mysqli->execute_query( "
        SELECT * FROM $table_name
            WHERE relay_id = ?
            AND timestamp < TIMESTAMPADD( MINUTE, -1, NOW() )
            ORDER BY RAND()
            LIMIT 1
    ", [ $relay_id ] );

    if ( false === $random_location_which_needs_prayer ) {
        throw new ErrorException( 'Failed to get location not recently promised' );
    }

    $locations = $random_location_which_needs_prayer->fetch_all( MYSQLI_ASSOC );
    $location = !empty( $locations ) ? $locations[0] : [];
    return $location;
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

function get_next_grid_id_from_relays_table( mysqli $mysqli, string $relay_table, $relay_id, $prefer_php_algorithm = false ) {
    /* Get locations which haven't been prayed for yet this lap, and haven't been promised in the last minute */

    if ( $prefer_php_algorithm ) {
        $next_location = query_next_location_with_php( $mysqli, $relay_table, $relay_id );
    } else {
        $next_location = query_needed_locations_not_recently_promised( $mysqli, $relay_table, $relay_id );

        /* IF all the locations that need praying for have been promised in the last minute */
        /* THEN get a location for the next lap that hasn't been promised in the last minute */
        if ( empty( $next_location ) ) {
            $next_location = query_locations_not_recently_promised( $mysqli, $relay_table, $relay_id );
        }
    }


    /* IF even that fails, then just give a random location */
    if ( empty( $next_location ) ) {
        require 'pg-query-4770-locations.php';
        $list_4770 = pg_query_4770_locations();
        return get_random_item( $list_4770 );
    }

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