<?php

class PG_Relays_Table {

    private mysqli $mysqli;
    private string $relay_table;
    private string $reports_table;
    private string $posts_table;
    private string $postmeta_table;

    public function __construct( mysqli $mysqli, string $db_prefix ) {
        $this->mysqli = $mysqli;
        $this->relay_table = $db_prefix . 'dt_relays';
        $this->reports_table = $db_prefix . 'dt_reports';
        $this->posts_table = $db_prefix . 'posts';
        $this->postmeta_table = $db_prefix . 'postmeta';
    }

    public function log_promise_timestamp( $relay_key, $grid_id ) {
        $response = $this->mysqli->execute_query( "
            UPDATE $this->relay_table
            SET epoch = ?
            WHERE relay_key = ?
            AND grid_id = ?
        ", [ time(), $relay_key, $grid_id ] );

        if ( !$response ) {
            throw new ErrorException( 'Failed to update promise timestamp' );
        }
    }

    /* https://www.sqlines.com/mysql/how-to/select-update-single-statement-race-condition */
    public function update_relay_total( $relay_key, $grid_id ) {
        $response = $this->mysqli->execute_query( "
            UPDATE $this->relay_table
            SET total = LAST_INSERT_ID(total + 1)
            WHERE relay_key = ?
            AND grid_id = ?
        ", [ $relay_key, $grid_id ] );

        if ( !$response ) {
            throw new ErrorException( 'Failed to update relay total' );
        }

        return $this->last_lap_number_updated();
    }

    public function last_lap_number_updated() : int {
        $response = $this->mysqli->execute_query( "
            SELECT LAST_INSERT_ID();
        " );

        if ( $response === false ) {
            throw new Exception( "last insert ID not found for relay update" );
        }

        return $response->fetch_column();
    }

    public function log_prayer( string $grid_id, string $relay_key, array $data ) {
        $post_id = $this->get_relay_id( $relay_key );
        $user_id = $data['user_id'];
        $lap_number = $data['lap_number'];
        $pace = $data['pace'];
        $parts = $data['parts'];
        $user_location = $data['user_location'];

        $args = [
            // lap information
            'post_id' => $post_id,
            'post_type' => $parts['post_type'],
            'lap_number' => $lap_number,

            'type' => $parts['root'],
            'subtype' => $parts['type'],

            // prayer information
            'value' => $pace ?? 1,
            'grid_id' => $grid_id,

            // user information
            'payload' => serialize( [
                'user_location' => $user_location['label'] ?? null,
                'user_language' => 'en' // @todo expand for other languages
            ] ),
            'lng' => $user_location['lng'] ?? null,
            'lat' => $user_location['lat'] ?? null,
            'level' => $user_location['level'] ?? null,
            'label' => $user_location['country'] ?? null,
            'hash' => $user_location['hash'] ?? null,
            'user_id' => $user_id ?? null,
            'timestamp' => time(),
        ];

        if ( empty( $args['hash'] ) ) {
            $args['hash'] = hash( 'sha256', maybe_serialize( $args ) );
        }

        $response = $this->mysqli->execute_query( "
            INSERT INTO $this->reports_table
            (
                user_id,
                post_id,
                post_type,
                lap_number,
                type,
                subtype,
                payload,
                value,
                lng,
                lat,
                level,
                label,
                grid_id,
                timestamp,
                hash
            )
            VALUES
            ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )
        ", [
            $args['user_id'],
            $args['post_id'],
            $args['post_type'],
            $args['lap_number'],
            $args['type'],
            $args['subtype'],
            $args['payload'],
            $args['value'],
            $args['lng'],
            $args['lat'],
            $args['level'],
            $args['label'],
            $args['grid_id'],
            $args['timestamp'],
            $args['hash'],
        ] );

        if ( !$response ) {
            throw new ErrorException( 'Failed to insert report' );
        }
    }

    public function get_next_grid_id( $relay_key ) {
        /* Get locations which haven't been prayed for yet this lap, and haven't been promised in the last minute */
        $next_location = $this->query_needed_locations_not_recently_promised( $relay_key );

        /* IF even that fails, then just give a random location */
        if ( empty( $next_location ) ) {
            require 'pg-query-4770-locations.php';
            $list_4770 = pg_query_4770_locations();
            return $this->get_random_item( $list_4770 );
        }

        return $next_location['grid_id'];
    }

    private function get_relay_id( $relay_key ) {
        $active_lap = $this->mysqli->execute_query( "
            SELECT p.ID FROM $this->posts_table p
                JOIN $this->postmeta_table pm ON pm.post_id = p.ID
                JOIN $this->postmeta_table pm1 ON pm1.post_id = p.ID
                WHERE pm.meta_key = 'prayer_app_relay_key'
                AND pm.meta_value = ?
                AND pm1.meta_key = 'status'
                AND pm1.meta_value = 'active'
        ", [ $relay_key ] );

        if ( false === $active_lap ) {
            throw new ErrorException( 'Failed to get *needed* location not recently promised' );
        }

        $active_lap_id = $active_lap->fetch_column();

        return $active_lap_id;
    }

    /**
     * Get a random location that hasn't been prayed for and hasn't been recently promised
     * @param string $relay_key
     * @return array|object|null
     */
    private function query_needed_locations_not_recently_promised( string $relay_key ) {
        $random_location_which_needs_prayer = $this->mysqli->execute_query( "
            SELECT * FROM $this->relay_table
                WHERE relay_key = ?
                AND epoch < ?
                ORDER BY total, RAND()
                LIMIT 1
        ", [ $relay_key, time() - 60 ] );

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
