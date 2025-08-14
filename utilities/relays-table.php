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

    public function get_lap_number( $key ) {
        $response = $this->mysqli->execute_query( "
            SELECT MIN(total) + 1 as lap_number
            FROM $this->relay_table
            WHERE relay_key = ?
        ", [ $key ] );

        $lap_number = $response->fetch_column();

        return $lap_number ?? 0;
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
    public function update_relay_total( $relay_key, $grid_id, $relay_id ) {
        if ( $relay_key !== '49ba4c' ) {
            $global_lap_number = $this->get_lap_number( '49ba4c' );

            //only update global lap number if it counts towards the current global lap
            $response = $this->mysqli->execute_query( "
                UPDATE $this->relay_table
                SET total = total + 1
                WHERE relay_key = '49ba4c'
                AND grid_id = ?
                AND total = ?
            ", [ $grid_id, $global_lap_number - 1 ] );

            if ( !$response ) {
                throw new ErrorException( 'Failed to update relay total' );
            }
        }

        //get the current lap number
        $lap_number_before_update = $this->get_lap_number( $relay_key );

        //update the location's total
        $response = $this->mysqli->execute_query( "
            UPDATE $this->relay_table
            SET total = LAST_INSERT_ID(total + 1)
            WHERE relay_key = ?
            AND grid_id = ?
        ", [ $relay_key, $grid_id ] );

        if ( !$response ) {
            throw new ErrorException( 'Failed to update relay total' );
        }
        $lap_number = $this->last_lap_number_updated();

        $lap_number_after_update = $this->get_lap_number( $relay_key );

        //we have a new lap!
        if ( $lap_number_before_update !== $lap_number_after_update ){
            $this->new_lap_action( $relay_id, $lap_number_before_update );
        }

        return [
            'lap_number' => $lap_number,
            'global_lap_number' => $global_lap_number ?? $lap_number,
        ];
    }

    public function last_lap_number_updated() : int {
        $response = $this->mysqli->execute_query( '
            SELECT LAST_INSERT_ID();
        ' );

        if ( $response === false ) {
            throw new Exception( 'last insert ID not found for relay update' );
        }

        return $response->fetch_column();
    }

    public function log_prayer( string $grid_id, string $relay_key, array $data, int $relay_id ) {
        $user_id = $data['user_id'];
        $lap_number = $data['lap_number'];
        $pace = $data['pace'];
        $parts = $data['parts'];
        $user_location = $data['user_location'];
        $user_language = $data['user_language'];

        $timezone = new DateTimeZone( $user_location['time_zone'] ?? 'UTC' );
        $datetime = new DateTime( 'now', $timezone );
        $timezone_timestamp = $datetime->format( 'Y-m-d H:i:s' );

        $args = [
            // lap information
            'post_id' => $relay_id,
            'post_type' => $parts['post_type'],
            'lap_number' => $lap_number,
            'global_lap_number' => $data['global_lap_number'] ?? $lap_number,

            'type' => $parts['root'],
            'subtype' => $parts['type'],

            // prayer information
            'value' => $pace ?? 1,
            'grid_id' => $grid_id,

            // user information
            'payload' => serialize( [
                'user_location' => $user_location['label'] ?? null,
                'user_language' => $user_language ?? 'en_US',
            ] ),
            'lng' => $user_location['lng'] ?? null,
            'lat' => $user_location['lat'] ?? null,
            'level' => $user_location['level'] ?? null,
            'label' => $user_location['country'] ?? null,
            'hash' => $user_location['hash'] ?? null,
            'user_id' => $user_id ?? null,
            'timestamp' => time(),
            'timezone_timestamp' => $timezone_timestamp,
        ];

        if ( empty( $args['hash'] ) ) {
            $args['hash'] = hash( 'sha256', serialize( $args ) );
        }

        $response = $this->mysqli->execute_query( "
            INSERT INTO $this->reports_table
            (
                user_id,
                post_id,
                post_type,
                lap_number,
                global_lap_number,
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
                timezone_timestamp,
                hash
            )
            VALUES
            ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )
        ", [
            $args['user_id'],
            $args['post_id'],
            $args['post_type'],
            $args['lap_number'],
            $args['global_lap_number'],
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
            $args['timezone_timestamp'],
            $args['hash'],
        ] );

        if ( !$response ) {
            throw new ErrorException( 'Failed to insert report' );
        }

        return $this->mysqli->insert_id;
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

    public function get_relay_id( $relay_key ) {
        $active_lap = $this->mysqli->execute_query( "
            SELECT post_id
            FROM $this->postmeta_table pm
            WHERE pm.meta_key = 'prayer_app_relay_key'
            AND pm.meta_value = ?
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
        if ( $relay_key === '49ba4c' ) {
            /**
             * Prioritize locations that haven't been prayed for yet this lap
             * and that have not been promised out recently
             * then prioritize locations given out the longest ago
             */
            $locations = $this->mysqli->execute_query( "
                SELECT grid_id
                FROM $this->relay_table
                WHERE relay_key = '49ba4c'
                AND epoch < UNIX_TIMESTAMP() - 5
                AND total = ( SELECT MIN(total) FROM $this->relay_table where relay_key = '49ba4c' )
                ORDER BY epoch
                LIMIT 500
            " );
            if ( false === $locations ) {
                throw new ErrorException( 'Failed to get *needed* location not recently promised' );
            }
            $locations = $locations->fetch_all( MYSQLI_ASSOC );
            if ( empty( $locations ) ) {
                return [];
            }
            $locations = array_column( $locations, 'grid_id' );
            //return random
            $grid_id = $this->get_random_item( $locations );

            return [ 'grid_id' => $grid_id ];

        } else {
            //get location and prioritize ones from relay 49ba4c
            $locations = $this->mysqli->execute_query("
                SELECT r1.grid_id
                FROM $this->relay_table r1
                JOIN $this->relay_table r2 ON ( r2.relay_key = '49ba4c' AND r1.grid_id = r2.grid_id )
                WHERE r1.relay_key = ?
                AND r1.epoch < UNIX_TIMESTAMP() - 5
                AND r1.total = ( SELECT MIN(total) FROM $this->relay_table WHERE relay_key = ? )
                AND r2.epoch < UNIX_TIMESTAMP() - 60
                AND r2.total = ( SELECT MIN(total) FROM $this->relay_table WHERE relay_key = '49ba4c' )
                ORDER BY
                r1.epoch
                LIMIT 500;
            ", [ $relay_key, $relay_key ] );

            if ( false === $locations ) {
                throw new ErrorException( 'Failed to get *needed* location not recently promised' );
            }
            $locations = $locations->fetch_all( MYSQLI_ASSOC );
            if ( empty( $locations ) ) {
                $locations = $this->mysqli->execute_query("
                    SELECT grid_id
                    FROM $this->relay_table
                    WHERE relay_key = ?
                    AND epoch < UNIX_TIMESTAMP() - 5
                    AND total = (SELECT MIN(total) FROM $this->relay_table WHERE relay_key = ?)
                    ORDER BY
                    epoch
                    LIMIT 500;
                ", [ $relay_key, $relay_key ] );
                $locations = $locations->fetch_all( MYSQLI_ASSOC );
            }
            if ( empty( $locations ) ){
                return [];
            }
            $locations = array_column( $locations, 'grid_id' );
            //return random
            $grid_id = $this->get_random_item( $locations );
            return [ 'grid_id' => $grid_id ];
        }
    }

    private function get_random_item( array $items ) {
        if ( !is_array( $items ) ) {
            return null;
        }

        $length = count( $items );

        if ( $length === 0 ) {
            return null;
        }

        $random_index = mt_rand( 0, $length - 1 );
        return $items[$random_index];
    }


    /**
     * What happens when a new lap is started
     * @param $relay_id
     * @return void
     */
    public function new_lap_action( $relay_id, $completed_lap_number ) {
        //check if this is a single lap relay
        $relay_type_query = $this->mysqli->execute_query( "
            SELECT meta_value
            FROM $this->postmeta_table
            WHERE post_id = ?
            AND meta_key = 'single_lap'
            ", [ $relay_id ] );
        $relay_type = $relay_type_query->fetch_column();

        //if it is a single lap relay, update the status to complete
        if ( $relay_type === '1' ){
            $this->mysqli->execute_query( "
                UPDATE $this->postmeta_table
                SET meta_value = 'complete'
                WHERE post_id = ?
                AND meta_key = 'status'
            ", [ $relay_id ] );
        }

        //update lap number
        if ( (int) $completed_lap_number === 1 ){
            //instert new row
            $this->mysqli->execute_query( "
                INSERT INTO $this->postmeta_table
                ( post_id, meta_key, meta_value )
                VALUES ( ?, ?, ? )
                ", [ $relay_id, 'number_of_completed_laps', $completed_lap_number ]
            );
        } else {
            //update existing row
            $this->mysqli->execute_query( "
                UPDATE $this->postmeta_table
                SET meta_value = ?
                WHERE post_id = ?
                AND meta_key = 'number_of_completed_laps'
            ", [ $completed_lap_number, $relay_id ] );
        }

        //create a report for complete laps
        $this->mysqli->execute_query( "
            INSERT INTO $this->reports_table
            (
                post_id,
                post_type,
                type,
                subtype,
                value,
                timestamp
            )
            VALUES
            ( ?, ?, ?, ?, ?, ? )
            ", [ $relay_id, 'pg_relays', 'lap_completed', '', $completed_lap_number, time() ]
        );
    }
}
