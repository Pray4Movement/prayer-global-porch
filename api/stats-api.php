<?php

class Prayer_Global_Stats_Api {

    public static $namespace = 'prayer-global/stats';

    public function __construct(){
        add_action( 'rest_api_init', [ $this, 'add_endpoints' ] );
        add_filter( 'dt_allow_rest_access', [ $this, 'authorize_url' ], 10, 1 );
    }

    public function authorize_url( $authorized ){
        if ( isset( $_SERVER['REQUEST_URI'] ) && str_contains( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ), self::$namespace ) ) {
            $authorized = true;
        }
        return $authorized;
    }

    public function add_endpoints(){
        register_rest_route( self::$namespace, '/map/locations', [
            'methods'  => 'POST',
            'permission_callback' => '__return_true',
            'callback' => [ $this, 'get_map_covered_locations' ],
        ] );
        register_rest_route( self::$namespace, '/lap', [
            'methods'  => 'POST',
            'permission_callback' => '__return_true',
            'callback' => [ $this, 'get_relay_stats' ],
        ] );
        register_rest_route( self::$namespace, '/map/location', [
            'methods'  => 'POST',
            'permission_callback' => '__return_true',
            'callback' => [ $this, 'get_grid_stats' ],
        ] );
    }

    public function get_map_covered_locations( WP_REST_Request $request ){
        $params = $request->get_params();
        $params = dt_recursive_sanitize_array( $params );
        if ( !isset( $params['public_key'] ) ){
            return new WP_Error( __METHOD__, 'Missing parameters', [ 'status' => 400 ] );
        }

        $key = $params['public_key'];
        $lap_number = $params['lap_number'];
        $map_data = Prayer_Stats::get_relay_current_lap_map_stats( $key, $lap_number );
        $participants = Prayer_Stats::get_relay_lap_map_participants( $params['relay_id'], $key );

        return [
            'grid_data' => [ 'data' => $map_data ],
            'participants' => $participants,
        ];
    }

    public function get_relay_stats( WP_REST_Request $request ){
        $params = $request->get_params();
        $params = dt_recursive_sanitize_array( $params );
        if ( !isset( $params['public_key'] ) ){
            return new WP_Error( __METHOD__, 'Missing parameters', [ 'status' => 400 ] );
        }

        $key = $params['public_key'];
        $data = Prayer_Stats::get_relay_current_lap_stats( $key );

        return $data;
    }

    public function get_grid_stats( WP_REST_Request $request ){
        $params = $request->get_params();
        $params = dt_recursive_sanitize_array( $params );
        if ( !isset( $params['grid_id'] ) ){
            return new WP_Error( __METHOD__, 'Missing parameters', [ 'status' => 400 ] );
        }

        return PG_Stacker::build_location_stats( $params['grid_id'] );
    }
}
new Prayer_Global_Stats_Api();
