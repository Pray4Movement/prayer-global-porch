<?php

class Prayer_Stats {

    public static function get_relay_lap_number( $relay_key = '49ba4c' ){
        global $wpdb;
        return (int) $wpdb->get_var( $wpdb->prepare(
            "SELECT MIN(total) as lap_number
            FROM $wpdb->dt_relays
            WHERE relay_id = %s", $relay_key ) );
    }

    public static function get_relay_current_lap( $relay_key = '49ba4c' ){
        /**
         * Example:
         *  [lap_number] => 5
         *  [post_id] => 19
         *  [key] => d7dcd4
         *  [start_time] => 1651269768
         */
        global $wpdb;
        $data = $wpdb->get_row( $wpdb->prepare(
            "SELECT MIN(total) as lap_number, MIN( epoch ) as start_time,
            ( SELECT pm.post_id 
                FROM $wpdb->postmeta pm
                WHERE pm.meta_key = 'prayer_app_relay_key'
                AND pm.meta_value = %s
             ) as post_id
            FROM $wpdb->dt_relays
            WHERE relay_id = %s", $relay_key, $relay_key ), ARRAY_A );
        return [
            'lap_number' => (int) $data['lap_number'],
            'post_id' => (int) $data['post_id'],
            'key' => $relay_key,
            'start_time' => (int) $data['start_time'],
        ];
    }

    public static function get_lap_stats( int $relay_id, int $lap_number ){
        $relay = DT_Posts::get_post( 'relays', $relay_id, true, false );
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
            AND lap_number = %d
            AND r.post_id = %d
        ", $lap_number, $relay_id ), ARRAY_A);

        $data = [
            'tile' => $relay['title'],
            'lap_number' => (int) $lap_number,
            'post_id' => (int) $relay_id,
            'key' => $relay['prayer_app_relay_key'],
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
        $relay = DT_Posts::get_post( 'relays', $relay_id, true, false );
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


    public static function get_relay_current_lap_map_stats( $relay_key ){
        return [];
    }
}
