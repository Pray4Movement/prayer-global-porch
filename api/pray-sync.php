<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class PG_Prayer_API {

    public function __construct() {
        if ( dt_is_rest() ) {
            add_action( 'rest_api_init', [ $this, 'add_endpoints' ] );
        }
        if ( !wp_next_scheduled( 'pg_api_sync' ) ){
            wp_schedule_event( time(), '5min', 'trigger' );
        }
    }

    public function add_endpoints() {
        $namespace = 'dt-public/pg-api/v1/';
        DT_Route::get( $namespace, 'trigger', [ $this, 'trigger' ] );
    }

    public function trigger() {
        $url = 'http://api.prayer.global/logs';
        $last_saved_id = get_option( 'pg_sync_last_saved_id', 0 );
        $url .= '?last_id=' . $last_saved_id;
        $response = wp_remote_get( $url );
        $body = wp_remote_retrieve_body( $response );
        $data = json_decode( $body, true );
        if ( !empty( $data['total'] ) ){
            $this->save_logs( $data );
        }
        return $data['total'];
    }

    private function save_logs( $logs ){
        global $wpdb;
        $time = time(); //@todo record time on log

        $current_lap = pg_current_custom_lap( 1051 );

        $chunked_arrays = array_chunk( $logs['rows'], 500 );
        foreach ( $chunked_arrays as $chunked_array ){
            $sql = "INSERT INTO $wpdb->dt_reports (post_id, post_type, type, subtype, value, grid_id, timestamp) VALUES ";
            foreach ( $chunked_array as $log ){
                if ( floor( $log['id'] / 4700 ) > $current_lap['lap_number'] ){
                    pg_generate_new_custom_prayer_lap( $current_lap['post_id'] );
                    $current_lap = pg_current_custom_lap( 1051 );
                }
                $lap_id = $current_lap['post_id'];
                $location = $log['location'];
                $sql .= "( $lap_id, 'laps', 'prayer_app', 'custom', 1, $location, $time ),";
            }
            $sql = rtrim( $sql, ',' );
            $wpdb->query( $sql );
            update_option( 'pg_sync_last_saved_id' , $chunked_array[ count( $chunked_array ) - 1 ]['id'] );
        }
    }
}
new PG_Prayer_API();