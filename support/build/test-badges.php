<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

class PG_Test_Badges extends PG_Public_Page {
    public $url_path = 'support/test-badges';
    public $page_title = 'Test Badges';
    public $rest_route = 'pg/test-badges';

    public function __construct() {
        $current_page_path_matches = parent::__construct();
        if ( !$current_page_path_matches ) {
            return;
        }
        if ( !is_user_logged_in() ){
            wp_redirect( home_url( '/login' ) );
            exit;
        }
        // if user is not an admin, redirect to dashboard
        if ( !dt_user_has_role( get_current_user_id(), 'administrator' ) ){
            wp_redirect( home_url( '/dashboard' ) );
            exit;
        }
        /**
         * Register custom hooks here
         */
    }

    public function select_user( WP_REST_Request $request ) {
        $body = $request->get_body();
        $body = json_decode( $body );
        $user_email = isset( $body->user_email ) ? sanitize_text_field( wp_unslash( $body->user_email ) ) : '';
        $user_id = isset( $body->user_id ) ? intval( $body->user_id ) : 0;
        $user = $user_id ? get_user_by( 'id', $user_id ) : get_user_by( 'email', $user_email );
        if ( !$user ) {
            return new WP_REST_Response( [ 'message' => 'User not found' ], 404 );
        }
        $user = $user->to_array();
        $user_language = get_user_meta( $user['ID'], PG_NAMESPACE . 'language', true );
        //$user_language = !empty( $user_language ) ? $user_language : 'en_US';
        pg_set_translation( $user_language );

        // create user stats
        // last prayer date
        // current streak
        // days of inactivity
        // next milestone
        $user_stats = new User_Stats( $user['ID'] );

        $badges_manager = new PG_Badge_Manager( $user['ID'] );

        $all_badges = $badges_manager->get_all_badges_array();

/*         $current_badges = $badges_manager->get_user_current_badges_array();

        $next_badges = $badges_manager->get_next_badge_in_progression_array();
 */
        $new_badges = $badges_manager->get_newly_earned_badges_array();

        if ( !$user ) {
            return new WP_REST_Response( [ 'message' => 'User not found' ], 404 );
        }

        $stats = [
            'last_prayer_date' => $user_stats->last_prayer_date(),
            'current_streak' => $user_stats->current_streak_in_days(),
            'best_streak' => $user_stats->best_streak_in_days(),
            'days_of_inactivity' => $user_stats->days_of_inactivity(),
            'hours_of_inactivity' => $user_stats->hours_of_inactivity(),
            'total_locations_prayed' => $user_stats->total_places_prayed(),
            'total_locations_prayed_in_relays' => $user_stats->total_places_prayed_in_relays(),
            'total_locations_prayed_in_own_relay' => $user_stats->total_locations_prayed_in_own_relay(),
            'num_people_joined_own_relay' => $user_stats->num_people_joined_own_relay(),
            'total_relays_started' => $user_stats->total_relays_started(),
            'total_relays_part_of' => $user_stats->total_relays_part_of(),
            'total_finished_relays_part_of' => $user_stats->total_finished_relays_part_of(),
            'total_finished_relays_started' => $user_stats->total_finished_relays_started(),
            'has_just_returned' => $user_stats->has_just_returned(),
            'days_prayed_this_month' => $user_stats->days_prayed_this_month(),
        ];

        return new WP_REST_Response( [
            'message' => 'User selected',
            'user' => $user,
            'user_stats' => $stats,
            'all_badges' => $all_badges,
            /* 'current_badges' => $current_badges,
            'next_badges' => $next_badges, */
            'new_badges' => $new_badges,
        ] );
    }

    public function create_streak( WP_REST_Request $request ) {
        global $wpdb;
        $body = $request->get_body();
        $body = json_decode( $body );
        $days = isset( $body->days ) ? intval( $body->days ) : 0;
        $user_id = isset( $body->user_id ) ? intval( $body->user_id ) : 0;

        $prayers = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpdb->dt_reports ORDER BY timestamp DESC LIMIT %d", $days ), ARRAY_A );

        $prayers = array_reverse( $prayers );

        $query = "INSERT INTO $wpdb->dt_reports (user_id, post_id, post_type, lap_number, global_lap_number, type, subtype, payload, value, lng, lat, level, label, grid_id, timestamp, hash, timezone_timestamp) VALUES ";
        $values = [];
        $place_holders = [];
        for ( $i = 0; $i < $days; $i++ ) {
            $timestamp = strtotime( "-{$i} days" );
            $place_holders[] = '( %d, %d, %s, %d, %d, %s, %s, %s, %d, %f, %f, %s, %s, %s, %d, %s, %s )';
            $prayer = $prayers[ $i ];
            unset( $prayer['id'] );
            unset( $prayer['parent_id'] );
            unset( $prayer['time_begin'] );
            unset( $prayer['time_end'] );
            $prayer['user_id'] = $user_id;
            $prayer['timestamp'] = $timestamp;
            $prayer['timezone_timestamp'] = gmdate( 'Y-m-d H:i:s', $timestamp );
            $values = array_merge( $values, array_values( $prayer ) );
        }

        $query .= implode( ',', $place_holders );
        //phpcs:ignore
        $wpdb->query( $wpdb->prepare( $query, $values ) );

        return new WP_REST_Response( [ 'message' => 'Streak created' ] );
    }

    public function create_inactivity( WP_REST_Request $request ) {
        global $wpdb;
        $body = $request->get_body();
        $body = json_decode( $body );
        $days = isset( $body->days ) ? intval( $body->days ) : 0;
        $user_id = isset( $body->user_id ) ? intval( $body->user_id ) : 0;

        $wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->dt_reports
            WHERE user_id = %d AND timestamp > %d
            ", $user_id, strtotime( "-{$days} days" ) ) );

        return new WP_REST_Response( [ 'message' => 'Inactivity period created' ] );
    }

    public function create_relay_participants( WP_REST_Request $request ) {
        $body = $request->get_body();
        $body = json_decode( $body );
        $participants = isset( $body->participants ) ? intval( $body->participants ) : 0;
        $relay_key = isset( $body->relay_key ) ? sanitize_text_field( wp_unslash( $body->relay_key ) ) : '';

        if ( $participants === 0 || $relay_key === '' ) {
            return new WP_REST_Response( [ 'message' => 'Invalid participants or relay key' ], 400 );
        }

        $post_id = pg_get_relay_id( $relay_key );

        // We want to insert rows into dt_reports, with $participants amount of unique user id's so as to create new participants on the relay.
        for ( $i = 0; $i < $participants; $i++ ) {
            $user_id = rand( 1, 1000000 );
            $this->log_prayer( 100385029, $relay_key, [
                'user_id' => $user_id,
                'lap_number' => 1,
                'global_lap_number' => 1,
                'pace' => 1,
                'parts' => [
                    'post_type' => 'pg_relays',
                    'root' => 'prayer_app',
                    'type' => 'custom',
                ],
                'user_location' => [
                    'lng' => '-1.886317',
                    'lat' => '52.489988',
                    'level' => 'district',
                    'label' => 'West Midlands, England, United Kingdom',
                    'country' => 'United Kingdom',
                ],
                'user_language' => 'en_US',
            ], $post_id );
        }
        return new WP_REST_Response( [ 'message' => 'Relay participants created' ] );
    }

    public function create_relay_locations( WP_REST_Request $request ) {
        $body = $request->get_body();
        $body = json_decode( $body );
        $locations = isset( $body->locations ) ? intval( $body->locations ) : 0;
        $relay_key = isset( $body->relay_key ) ? sanitize_text_field( wp_unslash( $body->relay_key ) ) : '';

        if ( $locations === 0 || $relay_key === '' ) {
            return new WP_REST_Response( [ 'message' => 'Invalid locations or relay key' ], 400 );
        }

        $post_id = pg_get_relay_id( $relay_key );

        $user_id = rand( 1, 1000000 );
        for ( $i = 0; $i < $locations; $i++ ) {
            $grid_id = rand( 1, 100000000 );
            $this->log_prayer( $grid_id, $relay_key, [
                'user_id' => $user_id,
                'lap_number' => 1,
                'global_lap_number' => 1,
                'pace' => 1,
                'parts' => [
                    'post_type' => 'pg_relays',
                    'root' => 'prayer_app',
                    'type' => 'custom',
                ],
                'user_location' => [
                    'lng' => '-1.886317',
                    'lat' => '52.489988',
                    'level' => 'district',
                    'label' => 'West Midlands, England, United Kingdom',
                    'country' => 'United Kingdom',
                ],
                'user_language' => 'en_US',
            ], $post_id );
        }
        return new WP_REST_Response( [ 'message' => 'Relay locations created' ] );
    }

    public function create_days_prayed_this_month( WP_REST_Request $request ) {

        $user_id = $request->get_param( 'user_id' );
        if ( !$user_id ) {
            return new WP_REST_Response( [ 'message' => 'User ID is required' ], 400 );
        }
        $user_id = intval( $user_id );
        $days = $request->get_param( 'days' );
        if ( !$days ) {
            return new WP_REST_Response( [ 'message' => 'Days is required' ], 400 );
        }
        $days = intval( $days );

        $relay_key = '49ba4c';
        $post_id = pg_get_relay_id( $relay_key );

        for ( $i = 0; $i < $days; $i++ ) {
            $grid_id = rand( 1, 100000000 );
            // get the date of the $i-th day from the start of the month
            $timestamp = strtotime( 'first day of this month' ) + $i * DAY_IN_SECONDS;
            $this->log_prayer( $grid_id, $relay_key, [
                'user_id' => $user_id,
                'lap_number' => 1,
                'global_lap_number' => 1,
                'pace' => 1,
                'parts' => [
                    'post_type' => 'pg_relays',
                    'root' => 'prayer_app',
                    'type' => 'custom',
                ],
                'user_location' => [
                    'lng' => '-1.886317',
                    'lat' => '52.489988',
                    'level' => 'district',
                    'label' => 'West Midlands, England, United Kingdom',
                    'country' => 'United Kingdom',
                ],
                'payload' => 'days_prayed_this_month',
                'user_language' => 'en_US',
                'timestamp' => $timestamp,
                'timezone_timestamp' => gmdate( 'Y-m-d H:i:s', $timestamp ),
            ], $post_id );
        }
        return new WP_REST_Response( [ 'message' => 'Days prayed this month created' ] );
    }

    public function complete_relay( WP_REST_Request $request ) {
        $body = $request->get_body();
        $body = json_decode( $body );
        $relay_key = isset( $body->relay_key ) ? sanitize_text_field( wp_unslash( $body->relay_key ) ) : '';
        $post_id = pg_get_relay_id( $relay_key );

        $lap_number = intval( get_post_meta( $post_id, 'lap_number', true ) );

        global $wpdb;
        $wpdb->query( $wpdb->prepare(
            "INSERT INTO $wpdb->dt_reports
            (post_id, post_type, type, subtype, value, timestamp)
            VALUES (%d, %s, %s, %s, %d, %d)
        ", $post_id, 'pg_relays', 'lap_completed', '', $lap_number, time() ) );
        update_post_meta( $post_id, 'lap_number', $lap_number + 1 );

        return new WP_REST_Response( [ 'message' => 'Relay completed' ] );
    }

    public function clear_todays_prayers( WP_REST_Request $request ) {
        global $wpdb;
        // get the time of midnight this morning
        $response = $wpdb->query( $wpdb->prepare(
            "DELETE FROM $wpdb->dt_reports
                WHERE timestamp > %d
            ", strtotime( 'today' )
        ) );
        return new WP_REST_Response( [
            'message' => 'Todays prayers cleared',
            'response' => $response,
        ] );
    }

    public function clear_this_month_prayers( WP_REST_Request $request ) {
        $user_id = $request->get_param( 'user_id' );
        if ( !$user_id ) {
            return new WP_REST_Response( [ 'message' => 'User ID is required' ], 400 );
        }
        $user_id = intval( $user_id );
        global $wpdb;
        $wpdb->query( $wpdb->prepare( "
            DELETE FROM $wpdb->dt_reports
            WHERE timestamp > %d
        ", $user_id, strtotime( 'first day of this month' ) ) );
        return new WP_REST_Response( [ 'message' => "This month's prayers cleared" ] );
    }

    public function log_prayer( string $grid_id, string $relay_key, array $data, int $relay_id ) {
        $user_id = $data['user_id'];
        $lap_number = $data['lap_number'];
        $pace = $data['pace'];
        $parts = $data['parts'];
        $user_location = $data['user_location'];
        $user_language = $data['user_language'];

        $timezone = new DateTimeZone( $user_location['time_zone'] ?? 'UTC' );
        $datetime = isset( $data['timestamp'] ) ? new DateTime( '@' . $data['timestamp'], $timezone ) : new DateTime( 'now', $timezone );
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

            'lng' => $user_location['lng'] ?? null,
            'lat' => $user_location['lat'] ?? null,
            'level' => $user_location['level'] ?? null,
            'label' => $user_location['country'] ?? null,
            'hash' => $user_location['hash'] ?? null,
            'user_id' => $user_id ?? null,
            'timestamp' => $data['timestamp'] ?? time(),
            'timezone_timestamp' => $timezone_timestamp,
        ];

        if ( isset( $data['payload'] ) ) {
            $args['payload'] = $data['payload'];
        }
        else {
            $args['payload'] = serialize( [
                'user_location' => $user_location['label'] ?? null,
                'user_language' => $user_language ?? 'en_US',
            ] );
        }

        if ( empty( $args['hash'] ) ) {
            $args['hash'] = hash( 'sha256', serialize( $args ) );
        }

        global $wpdb;
        $response = $wpdb->query( $wpdb->prepare( "
            INSERT INTO $wpdb->dt_reports
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
            ( %d, %d, %s, %d, %d, %s, %s, %s, %d, %f, %f, %s, %s, %d, %d, %s, %s )
        ",
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
        ) );

        return $response;
    }

    public function add_missing_badges( WP_REST_Request $request ) {
        $user_id = $request->get_param( 'user_id' );
        if ( !$user_id ) {
            return new WP_REST_Response( [ 'message' => 'User ID is required' ], 400 );
        }
        $user_id = intval( $user_id );
        $badge_manager = new PG_Badge_Manager( $user_id );
        $new_badges = $badge_manager->get_new_badges();
        $badge_manager->save_badges( $new_badges );
        return new WP_REST_Response( [ 'message' => 'Missing badges added' ] );
    }

    public function clear_badges( WP_REST_Request $request ) {
        $user_id = $request->get_param( 'user_id' );
        if ( !$user_id ) {
            return new WP_REST_Response( [ 'message' => 'User ID is required' ], 400 );
        }
        $user_id = intval( $user_id );
        $badge_manager = new PG_Badge_Manager( $user_id );
        $badge_manager->clear_badges();
        return new WP_REST_Response( [ 'message' => 'Badges cleared' ] );
    }

    public function earn_badge( WP_REST_Request $request ) {
        $user_id = $request->get_param( 'user_id' );
        $badge_id = $request->get_param( 'badge_id' );
        $badge_manager = new PG_Badge_Manager( $user_id );
        $badge_manager->earn_badge( $badge_id );
        return new WP_REST_Response( [ 'message' => 'Badge earned' ] );
    }

    public function register_endpoints() {
        register_rest_route( $this->rest_route, '/select-user', [
            'methods' => 'POST',
            'callback' => [ $this, 'select_user' ],
            'permission_callback' => [ $this, 'permission_callback' ],
        ] );
        register_rest_route( $this->rest_route, '/create-streak', [
            'methods' => 'POST',
            'callback' => [ $this, 'create_streak' ],
            'permission_callback' => [ $this, 'permission_callback' ],
        ] );
        register_rest_route( $this->rest_route, '/create-inactivity', [
            'methods' => 'POST',
            'callback' => [ $this, 'create_inactivity' ],
            'permission_callback' => [ $this, 'permission_callback' ],
        ] );
        register_rest_route( $this->rest_route, '/create-relay-participants', [
            'methods' => 'POST',
            'callback' => [ $this, 'create_relay_participants' ],
            'permission_callback' => [ $this, 'permission_callback' ],
        ] );
        register_rest_route( $this->rest_route, '/create-relay-locations', [
            'methods' => 'POST',
            'callback' => [ $this, 'create_relay_locations' ],
            'permission_callback' => [ $this, 'permission_callback' ],
        ] );
        register_rest_route( $this->rest_route, '/create-days-prayed-this-month', [
            'methods' => 'POST',
            'callback' => [ $this, 'create_days_prayed_this_month' ],
            'permission_callback' => [ $this, 'permission_callback' ],
        ] );
        register_rest_route( $this->rest_route, '/complete-relay', [
            'methods' => 'POST',
            'callback' => [ $this, 'complete_relay' ],
            'permission_callback' => [ $this, 'permission_callback' ],
        ] );
        register_rest_route( $this->rest_route, '/clear-todays-prayers', [
            'methods' => 'POST',
            'callback' => [ $this, 'clear_todays_prayers' ],
            'permission_callback' => [ $this, 'permission_callback' ],
        ] );
        register_rest_route( $this->rest_route, '/clear-this-month-prayers', [
            'methods' => 'POST',
            'callback' => [ $this, 'clear_this_month_prayers' ],
            'permission_callback' => [ $this, 'permission_callback' ],
        ] );
        register_rest_route( $this->rest_route, '/add-missing-badges', [
            'methods' => 'POST',
            'callback' => [ $this, 'add_missing_badges' ],
            'permission_callback' => [ $this, 'permission_callback' ],
        ] );
        register_rest_route( $this->rest_route, '/clear-badges', [
            'methods' => 'POST',
            'callback' => [ $this, 'clear_badges' ],
            'permission_callback' => [ $this, 'permission_callback' ],
        ] );
        register_rest_route( $this->rest_route, '/earn-badge', [
            'methods' => 'POST',
            'callback' => [ $this, 'earn_badge' ],
            'permission_callback' => [ $this, 'permission_callback' ],
        ] );
    }

    public function permission_callback( $request ) {
        return current_user_can( 'manage_dt' );
    }

    public function wp_enqueue_scripts() {
        wp_enqueue_style( 'pg-login-style', plugin_dir_url( __FILE__ ) . 'login.css', array(), filemtime( plugin_dir_path( __FILE__ ) . 'login.css' ) );

        wp_localize_script( 'global-functions', 'jsObject', [
            'rest_url' => esc_url( rest_url( 'pg/test-badges' ) ),
            'nonce' => wp_create_nonce( 'wp_rest' ),
            'translations' => [
                'invalid_credentials' => esc_html__( 'Invalid email or password. Please try again.', 'prayer-global-porch' ),
                'email_not_found' => esc_html__( 'Email not found. Please register.', 'prayer-global-porch' ),
                'auth_failed' => esc_html__( 'Authentication failed. Please try again or register for an account.', 'prayer-global-porch' ),
                'email_required' => esc_html__( 'Email is required', 'prayer-global-porch' ),
                'no_account_found' => esc_html__( 'No account found with that email address', 'prayer-global-porch' ),
            ],
        ] );
    }

    public function dt_magic_url_base_allowed_js( $allowed_js ) {
        return $allowed_js;
    }

    public function dt_magic_url_base_allowed_css( $allowed_css ) {
        return $allowed_css;
    }

    /**
     * Print scripts to header
     */
    public function header_javascript(){}

    /**
     * Print styles to header
     */
    public function header_style(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . '../pages/assets/header.php' );
        ?>
        <style>
            tr > td + td {
                padding-left: 20px;
            }
        </style>
        <?php
    }

    /**
     * Print scripts to footer
     */
    public function footer_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . '../pages/assets/footer.php' );
        ?>

        <?php
    }
    /**
     * Print body
     */
    public function body(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . '../pages/assets/nav.php' );
        ?>

        <section class="pg-container page" id="section-test-push">
            <div class="flow">

                <div>
                    <h3>Select User</h3>
                    <form class="" id="select-user-form">
                        <input type="text" name="user_email" placeholder="User Email">
                        <input type="number" name="user_id" placeholder="User ID">
                        <input class="btn btn-primary" type="submit" value="Select">
                    </form>
                </div>

                <div>
                    <h3>User Stats</h3>
                    <table>
                        <tr>
                            <td>User ID:</td>
                            <td id="user-id"></td>
                        </tr>
                        <tr>
                            <td>User Email:</td>
                            <td id="user-email"></td>
                        </tr>
                        <tr>
                            <td>Last Prayer Date:</td>
                            <td id="last-prayer-date"></td>
                        </tr>
                        <tr>
                            <td>Current Streak:</td>
                            <td id="current-streak"></td>
                        </tr>
                        <tr>
                            <td>Best Streak:</td>
                            <td id="best-streak"></td>
                        </tr>
                        <tr>
                            <td>Days of Inactivity:</td>
                            <td id="days-of-inactivity"></td>
                        </tr>
                        <tr>
                            <td>Hours of Inactivity:</td>
                            <td id="hours-of-inactivity"></td>
                        </tr>
                        <tr>
                            <td>Total Locations Prayed:</td>
                            <td id="total-locations-prayed"></td>
                        </tr>
                        <tr>
                            <td>Total Locations Prayed in Relays:</td>
                            <td id="total-locations-prayed-in-relays"></td>
                        </tr>
                        <tr>
                            <td>Total Locations Prayed in Own Relay:</td>
                            <td id="total-locations-prayed-in-own-relay"></td>
                        </tr>
                        <tr>
                            <td>Num People Joined Own Relay:</td>
                            <td id="num-people-joined-own-relay"></td>
                        </tr>
                        <tr>
                            <td>Total Relays Started:</td>
                            <td id="total-relays-started"></td>
                        </tr>
                        <tr></tr>
                            <td>Total Relays Part Of:</td>
                            <td id="total-relays-part-of"></td>
                        </tr>
                        <tr>
                            <td>Total Finished Relays Part Of:</td>
                            <td id="total-finished-relays-part-of"></td>
                        </tr>
                        <tr>
                            <td>Total Finished Relays Started:</td>
                            <td id="total-finished-relays-started"></td>
                        </tr>
                        <tr>
                            <td>Has Just Returned:</td>
                            <td id="has-just-returned"></td>
                        </tr>
                        <tr>
                            <td>Days Prayed This Month:</td>
                            <td id="days-prayed-this-month"></td>
                        </tr>
                    </table>

                    <div class="flow-small">
                        <h3>Manipulate DB</h3>
                        <button class="btn btn-primary" id="add-missing-badges">Add missing badges</button>
                        <button class="btn btn-primary" id="clear-badges">Clear badges</button>
                        <button class="btn btn-primary" id="clear-todays-prayers">Clear today's prayers</button>
                        <button class="btn btn-primary" id="clear-this-month-prayers">Clear days prayed this month</button>
                        <form class="" id="create-streak-form">
                            <input type="number" name="days" placeholder="Days">
                            <input class="btn btn-primary" type="submit" value="Create streak">
                        </form>
                        <form class="" id="create-inactivity-form">
                            <input type="number" name="days" placeholder="Days">
                            <input class="btn btn-primary" type="submit" value="Create inactive period">
                        </form>
                        <form class="" id="create-relay-participants-form">
                            <input type="number" name="participants" placeholder="Participants">
                            <input type="text" name="relay_key" placeholder="Relay Key">
                            <input class="btn btn-primary" type="submit" value="Create Relay Participants">
                        </form>
                        <form class="" id="create-relay-locations-form">
                            <input type="number" name="locations" placeholder="Locations">
                            <input type="text" name="relay_key" placeholder="Relay Key">
                            <input class="btn btn-primary" type="submit" value="Create Relay Locations">
                        </form>
                        <form class="" id="create-days-prayed-this-month-form">
                            <input type="number" name="days" placeholder="Days">
                            <input class="btn btn-primary" type="submit" value="Create Days Prayed This Month">
                        </form>
                        <form class="" id="complete-relay-form">
                            <input type="text" name="relay_key" placeholder="Relay Key">
                            <input class="btn btn-primary" type="submit" value="Complete Relay">
                        </form>
                    </div>

                    <h3>New Badges</h3>
                    <table>
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Title</td>
                                <td>Description</td>
                                <td>Category</td>
                                <td>Value</td>
                                <td>Date</td>
                            </tr>
                        </thead>
                        <tbody id="new-badges-table-body"></tbody>
                    </table>

                    <h3>All Badges</h3>
                    <table>
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Title</td>
                                <td>Category</td>
                                <td>Value</td>
                                <td>Date</td>
                                <td>Has Earned Badge</td>
                                <td>Num Times Earned</td>
                                <td>Earn Badge</td>
                            </tr>
                        </thead>
                        <tbody id="all-badges-table-body"></tbody>
                    </table>

                    <h3>Current Badges</h3>
                    <table>
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Title</td>
                                <td>Description</td>
                                <td>Category</td>
                                <td>Value</td>
                                <td>Date</td>
                            </tr>
                        </thead>
                        <tbody id="current-badges-table-body"></tbody>
                    </table>
                </div>

            </div>

        </section>

        <script>

            const user_id = getCookie('user_id_diagnostic');
            if ( user_id ) {
                getUser({ user_id: user_id });
            }

            document.querySelector('#select-user-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const data = Object.fromEntries(formData);
                getUser(data);
            });

            function getUser(data) {
                return fetch(jsObject.rest_url + '/select-user', {
                    method: 'POST',
                    body: JSON.stringify(data),
                    headers: {
                        'Content-Type': 'application/json',
                        'X-WP-Nonce': jsObject.nonce,
                    },
                }).then(response => response.json()).then(data => {
                    if ( data.user ) {
                        document.querySelector('#user-email').innerHTML = data.user.user_email;
                        document.querySelector('#user-id').innerHTML = data.user.ID;
                        jsObject.user = data.user;
                        document.cookie = `user_id_diagnostic=${data.user.ID}; path=/`;
                    }
                    if ( data.user_stats ) {
                        document.querySelector('#last-prayer-date').innerHTML = new Date(data.user_stats.last_prayer_date * 1000).toLocaleDateString();
                        document.querySelector('#current-streak').innerHTML = data.user_stats.current_streak;
                        document.querySelector('#best-streak').innerHTML = data.user_stats.best_streak;
                        document.querySelector('#days-of-inactivity').innerHTML = data.user_stats.days_of_inactivity;
                        document.querySelector('#hours-of-inactivity').innerHTML = data.user_stats.hours_of_inactivity;
                        document.querySelector('#total-locations-prayed').innerHTML = data.user_stats.total_locations_prayed;
                        document.querySelector('#total-locations-prayed-in-relays').innerHTML = data.user_stats.total_locations_prayed_in_relays;
                        document.querySelector('#total-locations-prayed-in-own-relay').innerHTML = data.user_stats.total_locations_prayed_in_own_relay;
                        document.querySelector('#num-people-joined-own-relay').innerHTML = data.user_stats.num_people_joined_own_relay;
                        document.querySelector('#total-relays-started').innerHTML = data.user_stats.total_relays_started;
                        document.querySelector('#total-relays-part-of').innerHTML = data.user_stats.total_relays_part_of;
                        document.querySelector('#total-finished-relays-part-of').innerHTML = data.user_stats.total_finished_relays_part_of;
                        document.querySelector('#total-finished-relays-started').innerHTML = data.user_stats.total_finished_relays_started;
                        document.querySelector('#has-just-returned').innerHTML = data.user_stats.has_just_returned;
                        document.querySelector('#days-prayed-this-month').innerHTML = data.user_stats.days_prayed_this_month;
                    }
                    const sort_by = ( $field ) => function( $a, $b ) {
                        if ( $a[$field] === $b[$field] ) {
                            return 0;
                        }
                        return $a[$field] > $b[$field] ? 1 : -1;
                    };
                    if ( data.next_badges ) {
                        data.next_badges.sort( sort_by( 'id' ) );
                        data.next_badges.sort( sort_by( 'category' ) );
                        document.querySelector('#next-badges-table-body').innerHTML = data.next_badges.map(badge =>
                            `<tr>
                                <td>${badge.id}</td>
                                <td>${badge.title}</td>
                                <td>${badge.description_unearned}</td>
                                <td>${badge.category}</td>
                                <td>${badge.value}</td>
                                <td>${new Date(badge.date * 1000).toLocaleDateString()}</td>
                            </tr>`
                        ).join('');
                    }
                    if ( data.current_badges ) {
                        data.current_badges.sort( sort_by( 'id' ) );
                        data.current_badges.sort( sort_by( 'category' ) );
                        document.querySelector('#current-badges-table-body').innerHTML = data.current_badges.map(badge =>
                            `<tr>
                                <td>${badge.id}</td>
                                <td>${badge.title}</td>
                                <td>${badge.description_earned}</td>
                                <td>${badge.category}</td>
                                <td>${badge.value}</td>
                                <td>${new Date(badge.date * 1000).toLocaleDateString()}</td>
                            </tr>`
                        ).join('');
                    }
                    if ( data.new_badges ) {
                        data.new_badges.sort( sort_by( 'id' ) );
                        data.new_badges.sort( sort_by( 'category' ) );
                        document.querySelector('#new-badges-table-body').innerHTML = data.new_badges.map(badge =>
                            `<tr>
                                <td>${badge.id}</td>
                                <td>${badge.title}</td>
                                <td>${badge.description_earned}</td>
                                <td>${badge.category}</td>
                                <td>${badge.value}</td>
                                <td>${new Date(badge.date * 1000).toLocaleDateString()}</td>
                            </tr>`
                        ).join('');
                    }
                    if ( data.all_badges ) {
                        console.log(data.all_badges);
                        document.querySelector('#all-badges-table-body').innerHTML = Object.values(data.all_badges).map(badge =>
                            `<tr>
                                <td>${badge.id}</td>
                                <td>${badge.title}</td>
                                <td>${badge.category}</td>
                                <td>${badge.value}</td>
                                <td>${new Date(badge.timestamp * 1000).toLocaleDateString()}</td>
                                <td>${badge.has_earned_badge}</td>
                                <td>${badge.num_times_earned}</td>
                                <td><button class="btn btn-primary earn-badge" id="${badge.id}">Earn Badge</button></td>
                            </tr>`
                        ).join('');
                        document.querySelectorAll('.earn-badge').forEach(button => {
                            const badgeId = button.id;
                            const currentBadge = Object.values(data.all_badges).find(badge => badge.id === badgeId);
                            let badgeToEarn = badgeId;
                            if ( currentBadge.type === 'progression' && currentBadge.has_earned_badge ) {
                                const progressionBadges = Object.values(currentBadge.progression_badges);
                                const currentBadgeIndex = progressionBadges.findIndex(badge => badge.id === badgeId);
                                if ( currentBadgeIndex < progressionBadges.length - 1 ) {
                                    badgeToEarn = progressionBadges[currentBadgeIndex + 1].id;
                                }
                            } else if ( currentBadge.type === 'achievement' && currentBadge.has_earned_badge ) {
                                return;
                            }
                            button.addEventListener('click', function(e) {
                                e.preventDefault();
                                fetch(jsObject.rest_url + '/earn-badge', {
                                    method: 'POST',
                                    body: JSON.stringify({ user_id: jsObject.user.ID, badge_id: badgeToEarn }),
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-WP-Nonce': jsObject.nonce,
                                    },
                                }).then(response => response.json()).then(data => {
                                    console.log(data);
                                    getUser({ user_id: jsObject.user.ID });
                                });
                            });
                        });
                    }
                });
            }

            document.querySelector('#add-missing-badges').addEventListener('click', function(e) {
                e.preventDefault();
                fetch(jsObject.rest_url + '/add-missing-badges', {
                    method: 'POST',
                    body: JSON.stringify({ user_id: jsObject.user.ID }),
                    headers: {
                        'Content-Type': 'application/json',
                        'X-WP-Nonce': jsObject.nonce,
                    },
                }).then(response => response.json()).then(data => {
                    console.log(data);
                    getUser({ user_id: jsObject.user.ID });
                });
            });

            document.querySelector('#clear-badges').addEventListener('click', function(e) {
                e.preventDefault();
                fetch(jsObject.rest_url + '/clear-badges', {
                    method: 'POST',
                    body: JSON.stringify({ user_id: jsObject.user.ID }),
                    headers: {
                        'Content-Type': 'application/json',
                        'X-WP-Nonce': jsObject.nonce,
                    },
                }).then(response => response.json()).then(data => {
                    console.log(data);
                    getUser({ user_id: jsObject.user.ID });
                });
            });

            document.querySelector('#create-streak-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const data = Object.fromEntries(formData);
                data.user_id = jsObject.user.ID;
                fetch(jsObject.rest_url + '/create-streak', {
                    method: 'POST',
                    body: JSON.stringify(data),
                    headers: {
                        'Content-Type': 'application/json',
                        'X-WP-Nonce': jsObject.nonce,
                    },
                }).then(response => response.json()).then(data => {
                    console.log(data);
                    getUser({ user_id: jsObject.user.ID });
                });
            });

            document.querySelector('#create-inactivity-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const data = Object.fromEntries(formData);
                data.user_id = jsObject.user.ID;
                fetch(jsObject.rest_url + '/create-inactivity', {
                    method: 'POST',
                    body: JSON.stringify(data),
                    headers: {
                        'Content-Type': 'application/json',
                        'X-WP-Nonce': jsObject.nonce,
                    },
                }).then(response => response.json()).then(data => {
                    getUser({ user_id: jsObject.user.ID });
                    console.log(data);
                });
            });

            document.querySelector('#create-relay-participants-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const data = Object.fromEntries(formData);
                console.log(data)
                fetch(jsObject.rest_url + '/create-relay-participants', {
                    method: 'POST',
                    body: JSON.stringify(data),
                    headers: {
                        'Content-Type': 'application/json',
                        'X-WP-Nonce': jsObject.nonce,
                    },
                }).then(response => response.json()).then(data => {
                    getUser({ user_id: jsObject.user.ID });
                    console.log(data);
                });
            });

            document.querySelector('#create-relay-locations-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const data = Object.fromEntries(formData);
                console.log(data)
                fetch(jsObject.rest_url + '/create-relay-locations', {
                    method: 'POST',
                    body: JSON.stringify(data),
                    headers: {
                        'Content-Type': 'application/json',
                        'X-WP-Nonce': jsObject.nonce,
                    },
                }).then(response => response.json()).then(data => {
                    getUser({ user_id: jsObject.user.ID });
                    console.log(data);
                });
            });

            document.querySelector('#create-days-prayed-this-month-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const data = Object.fromEntries(formData);
                data.user_id = jsObject.user.ID;
                fetch(jsObject.rest_url + '/create-days-prayed-this-month', {
                    method: 'POST',
                    body: JSON.stringify(data),
                    headers: {
                        'Content-Type': 'application/json',
                        'X-WP-Nonce': jsObject.nonce,
                    },
                }).then(response => response.json()).then(data => {
                    getUser({ user_id: jsObject.user.ID });
                    console.log(data);
                });
            });

            document.querySelector('#complete-relay-form').addEventListener('submit', function(e) {

                const formData = new FormData(this);
                const data = Object.fromEntries(formData);
                data.user_id = jsObject.user.ID;
                fetch(jsObject.rest_url + '/complete-relay', {
                    method: 'POST',
                    body: JSON.stringify(data),
                    headers: {
                        'Content-Type': 'application/json',
                        'X-WP-Nonce': jsObject.nonce,
                    },
                }).then(response => response.json()).then(data => {
                    getUser({ user_id: jsObject.user.ID });
                    console.log(data);
                });
            });

            document.querySelector('#clear-todays-prayers').addEventListener('click', function(e) {
                e.preventDefault();
                fetch(jsObject.rest_url + '/clear-todays-prayers', {
                    method: 'POST',
                    body: JSON.stringify({ user_id: jsObject.user.ID }),
                    headers: {
                        'Content-Type': 'application/json',
                        'X-WP-Nonce': jsObject.nonce,
                    },
                }).then(response => response.json()).then(data => {
                    getUser({ user_id: jsObject.user.ID });
                    console.log(data);
                });
            });

            document.querySelector('#clear-this-month-prayers').addEventListener('click', function(e) {
                e.preventDefault();
                fetch(jsObject.rest_url + '/clear-this-month-prayers', {
                    method: 'POST',
                    body: JSON.stringify({ user_id: jsObject.user.ID }),
                    headers: {
                        'Content-Type': 'application/json',
                        'X-WP-Nonce': jsObject.nonce,
                    },
                }).then(response => response.json()).then(data => {
                    getUser({ user_id: jsObject.user.ID });
                    console.log(data);
                });
            });

            function getCookie(name) {
                const cookieValue = document.cookie
                    .split("; ")
                    .find((row) => row.startsWith(name + "="))
                    ?.split("=")[1];
                return cookieValue;
            }
        </script>

        <?php
    }
}

new PG_Test_Badges();
