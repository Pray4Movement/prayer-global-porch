<?php

class Prayer_Global_Prayer_Api {

    public static $namespace = 'prayer-global/prayer';

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
        register_rest_route( self::$namespace, '/increment-prayer-time', [
            'methods'  => 'POST',
            'permission_callback' => '__return_true',
            'callback' => [ $this, 'increment_prayer_time_endpoint' ],
        ] );

        register_rest_route( self::$namespace, '/correction', [
            'methods'  => 'POST',
            'permission_callback' => '__return_true',
            'callback' => [ $this, 'correction_endpoint' ],
        ] );
    }

    public function increment_prayer_time_endpoint( WP_REST_Request $request ){
        $params = $request->get_params();
        $data = dt_recursive_sanitize_array( $params['data'] );
        $report_id = $data['report_id'];
        //verify nonce from X-WP-Nonce header
        if ( !wp_verify_nonce( $request->get_header( 'X-WP-Nonce' ), 'wp_rest' ) ) {
            return new WP_Error( __METHOD__, 'Invalid nonce', [ 'status' => 403 ] );
        }


        return $this->increment_prayer_time( $report_id );
    }

    public function increment_prayer_time( $report_id ) {
        /* Check that the report exists */
        $report = Disciple_Tools_Reports::get( $report_id, 'id' );

        if ( !$report || empty( $report ) || is_wp_error( $report ) ) {
            return new WP_Error( __METHOD__, 'Report doesn\'t exist', [ 'status' => 400 ] );
        }

        $new_value = (int) $report['value'] + 1;
        if ( $new_value <= 60 ){
            /* update the report */
            global $wpdb;
            $wpdb->query( $wpdb->prepare( "
                UPDATE $wpdb->dt_reports
                SET value = value + 1
                WHERE id = %d
            ", $report_id ) );
        }

        return $new_value;
    }

    public function correction_endpoint( WP_REST_Request $request ){
        //verify nonce from X-WP-Nonce header
        if ( !wp_verify_nonce( $request->get_header( 'X-WP-Nonce' ), 'wp_rest' ) ) {
            return new WP_Error( __METHOD__, 'Invalid nonce', [ 'status' => 403 ] );
        }
        $params = $request->get_params();
        if ( empty( $params['data'] ) ) {
            return new WP_Error( __METHOD__, 'No data', [ 'status' => 400 ] );
        }
        $data = dt_recursive_sanitize_array( $params['data'] );

        return $this->save_correction( $data );
    }

    /**
     * @param $parts
     * @param $data
     * @return array|false|int|WP_Error
     */
    public function save_correction( $data ) {
        if ( empty( $data['section_label'] ) ) {
            $title = $data['current_content']['location']['full_name'];
        } else {
            $title = $data['current_content']['location']['full_name'] . ' (' . $data['section_label'] . ')';
        }

        $current_location_list = 'SECTIONS AVAILABLE DURING REPORT' . PHP_EOL . PHP_EOL;
        foreach ( $data['current_content']['list'] as $list ) {
            $current_location_list .= strtoupper( $list['type'] ) . PHP_EOL;
            foreach ( $list['data'] as $k => $v ){
                if ( is_array( $v ) ) {
                    $v = serialize( $v );
                }
                $current_location_list .= $k . ': ' . $v . PHP_EOL;
            }
            $current_location_list .= PHP_EOL;
        }

        $user_location = 'USER LOCATION' . PHP_EOL . PHP_EOL;
        foreach ( $data['user'] as $uk => $uv ) {
            $user_location .= $uk . ': ' . $uv . PHP_EOL;
        }
        $user_location .= PHP_EOL . 'https://maps.google.com/maps?q='.$data['user']['lat'].','.$data['user']['lng'] .'&ll='.$data['user']['lat'].','.$data['user']['lng'] .'&z=7' .  PHP_EOL;

        $fields = [
            // lap information
            'title' => $title,
            'type' => 'location',
            'status' => 'new',
            'payload' => maybe_serialize( $data ),
            'response' => $data['response'],
            'location_grid_meta' => [
                'values' => [
                    [
                        'grid_id' => $data['grid_id']
                    ]
                ]
            ],
            'user_hash' => $data['user']['hash'],
            'notes' => [
                'Review Link' => get_site_url() . '/show_app/all_content/?grid_id='.$data['grid_id'],
                'Current_Location' => $current_location_list,
                'User_Location' => $user_location,
            ]
        ];

        if ( is_user_logged_in() ) {
            $contact_id = Disciple_Tools_users::get_contact_for_user( get_current_user_id() );
            if ( ! empty( $contact_id ) && ! is_wp_error( $contact_id ) ) {
                $fields['contacts'] = [
                    'values' => [
                        [ 'value' => $contact_id ],
                    ]
                ];
            }
        }

        $result = DT_Posts::create_post( 'feedback', $fields, true, false );
        if ( is_wp_error( $result ) ) {
            return new WP_Error( __METHOD__, 'Error creating feedback', [ 'status' => 400 ] );
        }

        return true;
    }
}
new Prayer_Global_Prayer_Api();
