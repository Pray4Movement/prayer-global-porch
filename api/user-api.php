<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class PG_User_API {

    public $root = 'pg-api';

    public $type = 'user';
    public static $allowed_user_meta = [
        'location',
        'location_hash',
        'send_general_emails',
        'tshirt',
        'onesignal_user_id',
        'onesignal_external_id',
        'onesignal_subscription_id',
    ];

    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct() {
        add_filter( 'dt_allow_rest_access', [ $this, 'authorize_url' ], 10, 1 );
        if ( dt_is_rest() ) {
            add_action( 'rest_api_init', [ $this, 'add_endpoints' ] );
        }
    }


    /**
     * Register REST Endpoints
     * @link https://github.com/DiscipleTools/disciple-tools-theme/wiki/Site-to-Site-Link for outside of wordpress authentication
     */
    public function add_endpoints() {
        $namespace = $this->root . '/v1/' . $this->type . '/';
        DT_Route::post( $namespace, 'ip_location', [ $this, 'get_ip_location' ] );
        DT_Route::post( $namespace, 'details', [ $this, 'get_user' ] );
        DT_Route::post( $namespace, 'stats', [ $this, 'get_user_stats' ] );
        DT_Route::post( $namespace, 'locations-prayed-for', [ $this, 'get_user_locations_prayed_for_endpoint' ] );
        DT_Route::post( $namespace, 'onesignal', [ $this, 'update_onesignal_data' ] );
    }

    public function authorize_url( $authorized ){
        if ( isset( $_SERVER['REQUEST_URI'] ) && strpos( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ), $this->root . '/v1/'.$this->type ) !== false ) {
            $authorized = true;
        }
        return $authorized;
    }

    public function get_ip_location() {
        if ( is_user_logged_in() ) {
            $user_id = get_current_user_id();
            $location_meta = get_user_meta( $user_id, PG_NAMESPACE . 'location', true );

            return $location_meta;
        } else {
            $response = DT_Ipstack_API::get_location_grid_meta_from_current_visitor();
            if ( $response ) {
                $response['hash'] = hash( 'sha256', serialize( $response ) . mt_rand( 1000000, 10000000000000000 ) );
                $array = array_reverse( explode( ', ', $response['label'] ) );
                $response['country'] = $array[0] ?? '';
            }
            return $response;
        }
    }

    /**
     * Get the user data and stats for the currently logged in user
     */
    public static function get_user() {
        $user_id = get_current_user_id();
        if ( empty( $user_id ) ) {
            return [];
        }
        $userdata = pg_get_user( $user_id, self::$allowed_user_meta );

        $userdata['stats'] = self::get_user_stats();

        return $userdata;
    }

    public static function get_user_stats() {
        global $wpdb;

        $user_id = get_current_user_id();

        if ( !$user_id ) {
            return new WP_Error( __METHOD__, 'Unauthorised', [ 'status' => 401 ] );
        }

        $user_stats = $wpdb->get_row( $wpdb->prepare( "
            SELECT COUNT(r.id) as total_locations, SUM(r.value) as total_minutes
            FROM $wpdb->dt_reports r
            WHERE r.user_id = %d
            AND r.type = 'prayer_app'
            ORDER BY r.timestamp DESC
            ", $user_id ), ARRAY_A );

        $user_stats['total_locations'] = (int) $user_stats['total_locations'];
        $user_stats['total_minutes'] = (int) $user_stats['total_minutes'];
        return $user_stats;
    }

    public static function get_user_locations_prayed_for_endpoint( WP_REST_Request $request ){
        $params = $request->get_params();
        $params = dt_recursive_sanitize_array( $params );
        if ( !isset( $params['parts']['public_key'] ) ){
            return new WP_Error( __METHOD__, 'Missing parameters', [ 'status' => 400 ] );
        }

        $key = $params['parts']['public_key'];

        $hash = $params['data']['hash'] ?? false;
        if ( empty( $hash ) ) {
            return [];
        }

        return self::get_user_locations_prayed_for( $key, $hash );
    }

    public static function get_user_locations_prayed_for( $key, $hash, $lap_number = null ){
        global $wpdb;

        $lap = Prayer_Stats::get_relay_current_lap( $key );

        if ( empty( $hash ) ) {
            return [];
        }

        if ( empty( $lap_number ) ) {
            $lap_number = $lap['lap_number'];
        }

        $sql = "SELECT lg.longitude, lg.latitude
           FROM $wpdb->dt_reports r
           INNER JOIN $wpdb->dt_location_grid lg ON lg.grid_id = r.grid_id
           WHERE r.post_type = 'pg_relays'
                AND r.type = 'prayer_app'
                AND r.hash = %s
                AND r.label IS NOT NULL
                AND lg.longitude IS NOT NULL
                AND lg.latitude IS NOT NULL
        ";
        $args = [
            $hash,
        ];

        if ( $key === Prayer_Stats::$global_key ) {
            $sql .= 'AND global_lap_number = %d';
            $args[] = $lap_number;
        } else {
            $sql .= 'AND post_id = %s
                    AND lap_number = %d';
            $args[] = $lap['post_id'];
            $args[] = $lap_number;
        }

        //phpcs:ignore
        $user_locations_raw  = $wpdb->get_results( $wpdb->prepare( $sql, $args ), ARRAY_A );

        return $user_locations_raw;
    }


    public static function get_my_places_prayed_for(){
        global $wpdb;

        $user_id = get_current_user_id();

        $results = $wpdb->get_results( $wpdb->prepare( "
            SELECT r.grid_id, count(r.grid_id) as count
            FROM $wpdb->dt_reports r
            WHERE r.user_id = %d
            AND r.type = 'prayer_app'
            AND r.post_type = 'pg_relays'
            GROUP BY r.grid_id
        ", $user_id ) );

        $data = [];
        foreach ( $results as $result ) {
            $data[$result->grid_id] = (int) $result->count;
        }
        return $data;
    }

    public static function get_my_stats(){
        global $wpdb;

        $user_id = get_current_user_id();

        $current_lap_number = 1;

        if ( empty( $lap_number ) ){
            $lap_number = $current_lap_number;
        }
        //phpcs:ignore
        $result = $wpdb->get_row( $wpdb->prepare(
            "SELECT
            MIN( r.timestamp ) as start_time,
            MAX( r.timestamp ) as end_time,
            COUNT( DISTINCT( r.grid_id ) ) as locations_completed,
            SUM( r.value ) as minutes_prayed
            FROM $wpdb->dt_reports r
            WHERE r.post_type = 'pg_relays'
            AND r.user_id = %d
        ", $user_id ), ARRAY_A);

        $data = [
            'lap_number' => (int) $lap_number,
            'start_time' => (int) $result['start_time'],
            'locations_completed' => (int) $result['locations_completed'],
            'minutes_prayed' => (int) $result['minutes_prayed'],
            'on_going' => true,
            'participants' => 1,
            'end_time' => null,
        ];


        if ( $lap_number < $current_lap_number ) {
            /* Past laps should be 100% filled */
            $data['locations_completed'] = 4770;
        }

        return _pg_stats_builder( $data );
    }

    public function update_onesignal_data( WP_REST_Request $request ) {
        $user_id = get_current_user_id();
        if ( !$user_id ) {
            return new WP_Error( __METHOD__, 'Unauthorized', [ 'status' => 401 ] );
        }

        $body = json_decode( $request->get_body() );

        $onesignal_user_id = $body->onesignal_user_id ?? null;
        $onesignal_external_id = $body->onesignal_external_id ?? null;
        $onesignal_subscription_id = $body->onesignal_subscription_id ?? null;

        update_user_meta( $user_id, PG_NAMESPACE . 'onesignal_user_id', sanitize_text_field( $onesignal_user_id ) );
        update_user_meta( $user_id, PG_NAMESPACE . 'onesignal_external_id', sanitize_text_field( $onesignal_external_id ) );
        update_user_meta( $user_id, PG_NAMESPACE . 'onesignal_subscription_id', sanitize_text_field( $onesignal_subscription_id ) );

        return new WP_REST_Response([
            'status' => 200,
            'message' => 'OneSignal data updated successfully'
        ]);
    }
}
PG_User_API::instance();
