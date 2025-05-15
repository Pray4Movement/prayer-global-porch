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
        'language',
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
        DT_Route::post( $namespace, 'save_details', [ $this, 'save_details' ] );
        DT_Route::post( $namespace, 'stats', [ $this, 'get_user_stats' ] );
        DT_Route::post( $namespace, 'milestones', [ $this, 'get_user_milestones' ] );
        DT_Route::post( $namespace, 'locations-prayed-for', [ $this, 'get_user_locations_prayed_for_endpoint' ] );
        DT_Route::post( $namespace, 'onesignal', [ $this, 'update_onesignal_data' ] );
        DT_Route::post( $namespace, 'requested-notifications', [ $this, 'requested_notifications' ] );
        DT_Route::post( $namespace, 'notifications-permission', [ $this, 'notifications_permission' ] );
        DT_Route::post( $namespace, 'has-used-app', [ $this, 'has_used_app' ] );
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

    public static function save_details( WP_REST_Request $request ) {

        $user_id = get_current_user_id();

        if ( !$user_id ) {
            return new WP_Error( __METHOD__, 'Unauthorised', [ 'status' => 401 ] );
        }

        $params = $request->get_params();

        $params = dt_recursive_sanitize_array( $params );

        $result = [];

        if ( isset( $params['display_name'] ) ) {
            $display_name = $params['display_name'];

            $success = wp_update_user( [
                'ID' => $user_id,
                'display_name' => $display_name,
            ] );

            if ( is_wp_error( $success ) ) {
                $display_name = '';
            }

            $result['display_name'] = $display_name;
        }

        $user_updates = [];

        if ( isset( $params['location'] ) ) {
            $location = $params['location'];
            if ( !isset( $location['lat'], $location['lng'], $location['label'] ) ) {
                return new WP_Error( __METHOD__, 'Missing lat, lng or label', [ 'status' => 400 ] );
            }

            /* Get the grid_id for this lat lng */
            $geocoder = new Location_Grid_Geocoder();

            $lat = (float) $location['lat'];
            $lng = (float) $location['lng'];
            $label = sanitize_text_field( wp_unslash( $location['label'] ) );

            $grid_row = $geocoder->get_grid_id_by_lnglat( $lng, $lat );

            $old_location = get_user_meta( get_current_user_id(), PG_NAMESPACE . 'location', true );

            $timezone = self::_get_timezone_from_grid_id( 2, $grid_row['admin2_grid_id'] );

            $location['grid_id'] = $grid_row ? $grid_row['grid_id'] : false;
            $location['lat'] = strval( $lat );
            $location['lng'] = strval( $lng );
            $location['country'] = self::_extract_country_from_label( $label );
            $location['hash'] = $old_location ? $old_location['hash'] : '';
            $location['timezone'] = $timezone ?? '';

            $result['location'] = $location;
            $user_updates['location'] = $location;
        }

        if ( isset( $params['language'] ) ) {
            $result['language'] = $params['language'];
            $user_updates['language'] = $params['language'];
        }

        self::update_user_meta( $user_updates );

        return $result;
    }

    /**
     * Private utility function to get the timezone from the admin0 level of the grid_id
     */
    private static function _get_timezone_from_grid_id( $level, $grid_id ) {
        global $wpdb;

        if ( $level === 0 ) {
            $where = 'admin0_grid_id = %s';
        } else if ( $level === 1 ) {
            $where = 'admin1_grid_id = %s';
        } else if ( $level === 2 ) {
            $where = 'admin2_grid_id = %s';
        }

        //phpcs:ignore
        $grid_row = $wpdb->get_row( $wpdb->prepare( "SELECT timezone FROM $wpdb->location_grid_cities WHERE $where", $grid_id ), ARRAY_A );
        return $grid_row['timezone'];
    }

    /**
     * Extract_country_from_label
     * @param string $label
     * @return array|bool|string
     */
    private static function _extract_country_from_label( string $label ) {
        if ( $label === '' ) {
            return '';
        }
        return array_reverse( explode( ', ', $label ) )[0];
    }

    /**
     * Update the user's data
     *
     * @param array $data
     * @return bool|WP_Error
     */
    public static function update_user_meta( $data ) {
        $user_id = get_current_user_id();

        if ( !$user_id ) {
            return new WP_Error( __METHOD__, 'Unauthorised', [ 'status' => 401 ] );
        }

        foreach ( $data as $meta_key => $meta_value ) {
            if ( !in_array( $meta_key, self::$allowed_user_meta, true ) ) {
                continue;
            }

            $meta_key = PG_NAMESPACE . $meta_key;

            $meta_key = sanitize_text_field( wp_unslash( $meta_key ) );

            if ( is_array( $meta_value ) ) {
                $meta_value = dt_sanitize_array( $meta_value );
            }

            $response = update_user_meta( $user_id, $meta_key, $meta_value );

            if ( is_wp_error( $response ) ) {
                return $response;
            }
        }

        return true;
    }

    public static function get_user_stats() {
        $user_id = get_current_user_id();

        if ( !$user_id ) {
            return new WP_Error( __METHOD__, 'Unauthorised', [ 'status' => 401 ] );
        }

        $user_stats = new User_Stats( $user_id );

        $result = [];
        $result['total_locations'] = $user_stats->total_places_prayed();
        $result['total_minutes'] = $user_stats->total_minutes_prayed();
        $result['current_streak'] = $user_stats->current_streak_in_days();
        $result['best_streak'] = $user_stats->best_streak_in_days();

        return $result;
    }

    public static function get_user_milestones() {
        $user_id = get_current_user_id();

        if ( !$user_id ) {
            return new WP_Error( __METHOD__, 'Unauthorised', [ 'status' => 401 ] );
        }


        $milestones_manager = new PG_Milestones( $user_id );
        $milestones = $milestones_manager->get_in_app_milestones();

        $result = [];
        foreach ( $milestones as $milestone ) {
            if ( !PG_Notifications_Sent::is_recent( $user_id, $milestone ) ) {
                PG_Notifications_Sent::record( $user_id, $milestone, PG_CHANNEL_IN_APP );
                $result[] = $milestone->to_array();
            }
        }

        return $result;
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

    public function requested_notifications() {
        $user_id = get_current_user_id();
        if ( !$user_id ) {
            return new WP_Error( __METHOD__, 'Unauthorized', [ 'status' => 401 ] );
        }

        update_user_meta( $user_id, PG_NAMESPACE . 'requested_notifications', true );

        return new WP_REST_Response([
            'status' => 200,
            'message' => 'Notifications marked as requested'
        ]);
    }

    public function notifications_permission( WP_REST_Request $request ) {
        $user_id = get_current_user_id();
        if ( !$user_id ) {
            return new WP_Error( __METHOD__, 'Unauthorized', [ 'status' => 401 ] );
        }

        $body = json_decode( $request->get_body() );
        $notifications_permission = $body->notifications_permission ?? null;

        update_user_meta( $user_id, PG_NAMESPACE . 'notifications_permission', $notifications_permission );

        return new WP_REST_Response([
            'status' => 200,
            'message' => 'Notifications permission updated successfully'
        ]);
    }

    public function has_used_app() {
        $user_id = get_current_user_id();
        if ( !$user_id ) {
            return new WP_Error( __METHOD__, 'Unauthorized', [ 'status' => 401 ] );
        }

        update_user_meta( $user_id, PG_NAMESPACE . 'has_used_app', true );

        return new WP_REST_Response([
            'status' => 200,
            'message' => 'App usage marked as used'
        ]);
    }
}
PG_User_API::instance();
