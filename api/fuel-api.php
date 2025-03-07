<?php

class Prayer_Global_Fuel_Api {

    public static $namespace = 'prayer-global/fuel';

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
        register_rest_route( self::$namespace, '/(?P<id>\d+)', [
            'methods'  => 'GET',
            'permission_callback' => '__return_true',
            'callback' => [ $this, 'get_fuel_stack' ],
        ] );
    }

    public function get_fuel_stack( WP_REST_Request $request ){
        $params = $request->get_params();
        return PG_Stacker::build_location_stack( $params['id'] );
    }
}
new Prayer_Global_Fuel_Api();
