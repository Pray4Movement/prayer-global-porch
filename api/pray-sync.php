<?php

if ( !defined( 'ABSPATH' ) ){
    exit; // Exit if accessed directly
}

class PG_Prayer_API{

    public string $last_saved_id_prefix = 'pg_sync_last_saved_id_';
    public string $api_url = PG_API_ENDPOINT;
    public int $lap_size = PG_TOTAL_STATES;

    public function __construct(){
        if ( dt_is_rest() ){
            add_action( 'rest_api_init', [ $this, 'add_endpoints' ] );

            //Setting WP HTTP API Timeout
            add_action( 'http_api_curl', [ $this, 'my_http_api_curl' ], 100, 1 );
        }
    }

    public function my_http_api_curl( $handle ) {
        curl_setopt( $handle, CURLOPT_CONNECTTIMEOUT, 0 );
        curl_setopt( $handle, CURLOPT_TIMEOUT, 30 );
    }

    public function add_endpoints(){
        $namespace = 'dt-public/pg-api/v1/';
        DT_Route::get( $namespace, 'trigger', [ $this, 'trigger' ] );
        DT_Route::post( $namespace, 'reset', [ $this, 'reset' ] );
        //DT_Route::get( $namespace, 'generate_lap', [ $this, 'generate_new_lap' ] );
    }

    public function trigger( WP_REST_Request $request ){
        $params = $request->get_params();
        $relay_id = $params['relay'] ?? null;
        if ( empty( $relay_id ) ){
            return new WP_Error( 'missing_relay', 'Missing relay parameter', [ 'status' => 400 ] );
        }
        $url = $this->api_url . 'logs?relay=' . $relay_id;

        //get the id of the last saved location, get logs since then
        $last_saved_id = get_option( $this->last_saved_id_prefix . $relay_id, 0 );
        $url .= '&last_id=' . $last_saved_id;

        $start_time = microtime( true );

        $response = wp_remote_get( $url );

        $end_time = microtime( true );

        $response_time = floor( ( $end_time - $start_time ) * 1000 ) / 1000;
        if ( is_wp_error( $response ) ) {
            return [
                'error' => $response->get_error_message(),
            ];
        }
        $body = wp_remote_retrieve_body( $response );
        $data = json_decode( $body, true );
        if ( !empty( $data['total'] ) ){
            $logs = $data['rows'];
            $this->save_logs( $data, $relay_id );

            /* If we are doing these syncs, successively then we want don't want any skipped */
            update_option( 'pg_sync_last_saved_id_' . $relay_id, $logs[ count( $logs ) -1 ]['id'] );
        }
        return [
            'total' => $data['total'],
            'first_id' => !empty( $data['rows'] ) ? $data['rows'][0]['id'] : null,
            'last_id' => !empty( $data['rows'] ) ? $data['rows'][ count( $data['rows'] ) - 1 ]['id'] : null,
            'last_saved_id' => $last_saved_id,
            'curl_time' => $response_time,
        ];
    }

    public function reset( WP_REST_Request $request ) {
        if ( ! $request->has_param( 'relay' ) ) {
            return new WP_Error( 'missing_relay', 'missing relay parameter', 400 );
        }

        $relay_id = $request->get_param( 'relay' );

        $url = $this->api_url . 'reset?relay=' . $relay_id;

        $response = wp_remote_get( $url );
        if ( is_wp_error( $response ) ) {
            return [
                'error' => $response->get_error_message(),
            ];
        }

        update_option( $this->last_saved_id_prefix . $relay_id, 0 );

        return [
            'message' => 'reset relay ' . $relay_id,
        ];
    }

    private function save_logs( $logs, $relay_id ){
        global $wpdb;
        $time = time(); //@todo record time on log

        $current_lap_post = $wpdb->get_row( $wpdb->prepare( "
            SELECT *
            FROM $wpdb->posts p
            INNER JOIN $wpdb->postmeta pm ON (
                pm.post_id = p.ID AND
                pm.meta_key = 'prayer_app_custom_magic_key' AND
                pm.meta_value = %s
            )
            WHERE p.post_type = 'laps'
        ", $relay_id ), ARRAY_A );
        if ( empty( $current_lap_post ) ){
            return;
        }

        $current_lap = pg_current_custom_lap( $current_lap_post['ID'] );
        if ( empty( $current_lap ) ){
            return;
        }

        //split logs into groups of 500 to avoid max query length
        $chunked_arrays = array_chunk( $logs['rows'], 500 );
        foreach ( $chunked_arrays as $chunked_array ){
            $sql = "INSERT INTO $wpdb->dt_reports (post_id, post_type, type, subtype, value, grid_id, timestamp) VALUES ";
            foreach ( $chunked_array as $log ){
                //check and generate a new lap if needed
                $number_of_laps_of_logs = ceil( $log['logId'] / $this->lap_size );
                if ( $number_of_laps_of_logs > (int) $current_lap['lap_number'] ){
                    pg_generate_new_custom_prayer_lap( $current_lap['post_id'] );
                    $current_lap = pg_current_custom_lap( $current_lap['post_id'] );
                }
                $lap_id = $current_lap['post_id'];
                $location = $log['location'];
                $sql .= "( $lap_id, 'laps', 'prayer_app', 'event', 1, $location, $time ),";
            }
            $sql = rtrim( $sql, ',' );
            //phpcs:ignore
            $wpdb->query( $sql );
            //update_option( 'pg_sync_last_saved_id_' . $relay_id, $chunked_array[count( $chunked_array ) - 1]['id'] );
        }
    }

    public function generate_new_lap( WP_REST_Request $request ) {
        global $wpdb;

        if ( ! $request->has_param( 'relay' ) ) {
            return new WP_Error( 'missing_relay', 'missing relay parameter', 400 );
        }

        $relay_id = $request->get_param( 'relay' );

        $current_lap_post = $wpdb->get_row( $wpdb->prepare( "
            SELECT *
            FROM $wpdb->posts p
            INNER JOIN $wpdb->postmeta pm ON (
                pm.post_id = p.ID AND
                pm.meta_key = 'prayer_app_custom_magic_key' AND
                pm.meta_value = %s
            )
            WHERE p.post_type = 'laps'
        ", $relay_id ), ARRAY_A );
        if ( empty( $current_lap_post ) ){
            return;
        }

        $current_lap = pg_current_custom_lap( $current_lap_post['ID'] );
        if ( empty( $current_lap ) ){
            return;
        }

        pg_generate_new_custom_prayer_lap( $current_lap['post_id'] );
        $new_lap = pg_current_custom_lap( $current_lap['post_id'] );

        return [
            'old_lap' => [
                'post_id' => $current_lap_post['ID'],
                'relay_id' => $relay_id,
            ],
            'new_lap' => [
                'post_id' => $new_lap['post_id'],
                'relay_id' => $new_lap['key'],
            ],
        ];
    }
}

new PG_Prayer_API();
