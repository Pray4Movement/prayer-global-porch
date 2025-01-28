<?php

class PG_Relays_Table {

    private mysqli $mysqli;
    private string $table_name = 'dt_relays';
    private string $relay_table;

    public function __construct( mysqli $mysqli, string $db_prefix ) {
        $this->mysqli = $mysqli;
        $this->relay_table = $db_prefix . $this->table_name;
    }

    public function log_promise_timestamp( $relay_id, $grid_id ) {
        $response = $this->mysqli->execute_query( "
            UPDATE $this->relay_table
            SET epoch = ?
            WHERE relay_id = ?
            AND grid_id = ?
        ", [ time(), $relay_id, $grid_id ] );

        if ( !$response ) {
            throw new ErrorException( 'Failed to update promise timestamp' );
        }
    }

    public function update_relay_total( $relay_id, $grid_id ) {
        $response = $this->mysqli->execute_query( "
            UPDATE $this->relay_table
            SET total = total + 1
            WHERE relay_id = ?
            AND grid_id = ?
        ", [ $relay_id, $grid_id ] );

        if ( !$response ) {
            throw new ErrorException( 'Failed to update relay total' );
        }
    }

    public function get_next_grid_id( $relay_id ) {
        /* Get locations which haven't been prayed for yet this lap, and haven't been promised in the last minute */
        $next_location = $this->query_needed_locations_not_recently_promised( $relay_id );

        /* IF even that fails, then just give a random location */
        if ( empty( $next_location ) ) {
            require 'pg-query-4770-locations.php';
            $list_4770 = pg_query_4770_locations();
            return $this->get_random_item( $list_4770 );
        }

        return $next_location['grid_id'];
    }

    /**
     * Get a random location that hasn't been prayed for and hasn't been recently promised
     * @param mysqli $mysqli
     * @param string $relay_table
     * @param string $relay_id
     * @return array|object|null
     */
    private function query_needed_locations_not_recently_promised( string $relay_id ) {
        $random_location_which_needs_prayer = $this->mysqli->execute_query( "
            SELECT * FROM $this->relay_table
                WHERE relay_id = ?
                AND epoch < ?
                ORDER BY total, RAND()
                LIMIT 1
        ", [ $relay_id, time() - 60 ] );

        if ( false === $random_location_which_needs_prayer ) {
            throw new ErrorException( 'Failed to get *needed* location not recently promised' );
        }

        $locations = $random_location_which_needs_prayer->fetch_all( MYSQLI_ASSOC );
        $location = !empty( $locations ) ? $locations[0] : [];
        return $location;
    }

    private function get_random_item( array $items ) {
        if ( !is_array( $items ) ) {
            return null;
        }

        $length = count( $items );

        if ( $length === 0 ) {
            return null;
        }

        $random_index = mt_rand( 0, $length );
        return $items[$random_index];
    }
}