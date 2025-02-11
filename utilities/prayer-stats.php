<?php

class Prayer_Stats {

    public static function get_relay_lap_number( $relay_key = '49ba4c' ){
        global $wpdb;
        return (int) $wpdb->get_var( $wpdb->prepare(
            "SELECT MIN(total) + 1 as lap_number
            FROM $wpdb->dt_relays
            WHERE relay_key = %s", $relay_key ) );
    }

    public static function get_relay_current_lap( $relay_key = '49ba4c', $relay_id = null ){
        /**
         * Example:
         *  [lap_number] => 5
         *  [post_id] => 19
         *  [key] => d7dcd4
         *  [start_time] => 1651269768
         */
        if ( empty( $relay_id ) ){
            $relay_id = pg_get_relay_id( $relay_key );
        }
        global $wpdb;
        $data = $wpdb->get_row( $wpdb->prepare(
            "SELECT 
            MIN(total) + 1 as lap_number,
            MIN(epoch) as start_time
            FROM $wpdb->dt_relays
            WHERE relay_key = %s", $relay_key ), ARRAY_A );
        $relay = DT_Posts::get_post( 'pg_relays', $relay_id, true, false );
        return [
            'title' => $relay['title'],
            'lap_number' => (int) $data['lap_number'],
            'post_id' => (int) $relay_id,
            'key' => $relay_key,
            'start_time' => (int) $data['start_time'],
            'ctas_off' => isset( $relay['ctas_off'] ) ? $relay['ctas_off'] : false,
            'event_lap' => isset( $relay['event_lap'] ) ? $relay['event_lap'] : false,
            'single_lap' => isset( $relay['single_lap'] ) ? $relay['single_lap'] : false,
            'visibility' => isset( $relay['visibility']['key'] ) ? $relay['visibility']['key'] : 'public',
            'challenge_type' => isset( $relay['challenge_type']['key'] ) ? $relay['challenge_type']['key'] : 'ongoing',
        ];
    }

    public static function get_lap_stats( int $relay_id, $relay_key = null, int $lap_number = null ){
        $post_title = get_the_title( $relay_id );

        if ( empty( $relay_key ) ){
            $relay_key = get_post_meta( $relay_id, 'prayer_app_relay_key', true );
        }
        $current_lap_number = self::get_relay_lap_number( $relay_key );

        if ( empty( $lap_number ) ){
            $lap_number = $current_lap_number;
        }

        global $wpdb;
        $result = $wpdb->get_row( $wpdb->prepare("
            SELECT
            MIN( r.timestamp ) as start_time,
            MAX( r.timestamp ) as end_time,
            COUNT( DISTINCT( r.grid_id ) ) as locations_completed,
            SUM( r.value ) as minutes_prayed,
            COUNT( DISTINCT( r.hash ) ) as participants,
            COUNT( DISTINCT( r.label ) ) as participant_country_count
            FROM $wpdb->dt_reports r
            WHERE r.post_type = 'pg_relays'
            AND lap_number = %d
            AND r.post_id = %d
        ", $lap_number, $relay_id ), ARRAY_A);

        $data = [
            'title' => $post_title,
            'lap_number' => (int) $lap_number,
            'post_id' => (int) $relay_id,
            'key' => $relay_key,
            'start_time' => (int) $result['start_time'],
            'end_time' => (int) $result['end_time'],
            'on_going' => $lap_number === $current_lap_number,
            'locations_completed' => (int) $result['locations_completed'],
            'minutes_prayed' => (int) $result['minutes_prayed'],
            'participants' => (int) $result['participants'],
            'participant_country_count' => (int) $result['participant_country_count'],
        ];
        return _pg_stats_builder( $data );
    }

    public static function stats_since_start_of_relay( $relay_id ) {
        $relay = DT_Posts::get_post( 'pg_relays', $relay_id, true, false );
        $current_lap_number = self::get_relay_lap_number( $relay['prayer_app_relay_key'] );

        global $wpdb;
        $result = $wpdb->get_row( $wpdb->prepare("
            SELECT
            MIN( r.timestamp ) as start_time,
            MAX( r.timestamp ) as end_time,
            COUNT( DISTINCT( r.grid_id ) ) as locations_completed,
            SUM( r.value ) as minutes_prayed,
            COUNT( DISTINCT( r.hash ) ) as participants,
            COUNT( DISTINCT( r.label ) ) as participant_country_count
            FROM $wpdb->dt_reports r
            WHERE r.post_type = 'pg_relays'
            AND r.post_id = %d
        ", $relay_id ), ARRAY_A);

        $data = [
            'tile' => $relay['title'],
            'lap_number' => (int) $current_lap_number,
            'post_id' => (int) $relay_id,
            'key' => $relay['prayer_app_relay_key'],
            'start_time' => (int) $result['start_time'],
            'end_time' => (int) $result['end_time'],
            'on_going' => $relay['status'] === 'active',
            'locations_completed' => (int) $result['locations_completed'],
            'minutes_prayed' => (int) $result['minutes_prayed'],
            'participants' => (int) $result['participants'],
            'participant_country_count' => (int) $result['participant_country_count'],

        ];
        return _pg_stats_builder( $data );
    }

    public static function get_relay_current_lap_stats( $relay_key, $relay_id = null ){
        if ( empty( $relay_id ) ){
            $relay_id = pg_get_relay_id( $relay_key );
        }
        return self::get_lap_stats( $relay_id, $relay_key );
    }

    public static function get_relay_current_lap_map_stats( $relay_key ){
        global $wpdb;
        $lap_number = self::get_relay_lap_number( $relay_key );
        $locations = $wpdb->get_results( $wpdb->prepare(
            "SELECT grid_id,
            IF ( total = %d, 1, 0 ) as completed
            FROM $wpdb->dt_relays
            WHERE relay_key = %s
        ", $lap_number, $relay_key ), ARRAY_A );

        $data = [];
        foreach ( $locations as $location ){
            $data[$location['grid_id']] = (int) $location['completed'];
        }
        return $data;
    }

    public static function get_relay_all_map_stats( $relay_key = '49ba4c' ){
        global $wpdb;
        $locations = $wpdb->get_results( $wpdb->prepare(
            "SELECT grid_id,
            total as completed
            FROM $wpdb->dt_relays
            WHERE relay_key = %s
        ", $relay_key ), ARRAY_A );

        $data = [];
        foreach ( $locations as $location ){
            $data[$location['grid_id']] = (int) $location['completed'];
        }
        return $data;
    }

    public static function get_relay_current_lap_map_participants( $relay_id, $relay_key ){
        global $wpdb;
        $lap_number = self::get_relay_lap_number( $relay_key );
        $locations = $wpdb->get_results( $wpdb->prepare(
            "SELECT r.lng as longitude, r.lat as latitude, r.hash
            FROM $wpdb->dt_reports r
            WHERE post_id = %s
            AND lap_number = %d
            AND r.lng IS NOT NULL
            GROUP BY r.hash
        ", $relay_id, $lap_number ), ARRAY_A );

        $data = [];
        foreach ( $locations as $location ){
            $data[] = [ 'longitude' => (float) $location['longitude'], 'latitude' => (float) $location['latitude'] ];
        }
        return $data;
    }

    public static function get_all_relay_participants( $relay_key = '49ba4c' ){
        global $wpdb;
        $relay_id = pg_get_relay_id( $relay_key );
        $locations = $wpdb->get_results( $wpdb->prepare(
            "SELECT r.lng as longitude, r.lat as latitude, r.hash
            FROM $wpdb->dt_reports r
            WHERE post_id = %s
            AND r.lng IS NOT NULL
            GROUP BY r.hash
        ", $relay_id ), ARRAY_A );

        $data = [];
        foreach ( $locations as $location ){
            $data[] = [ 'longitude' => (float) $location['longitude'], 'latitude' => (float) $location['latitude'] ];
        }
        return $data;
    }
}
