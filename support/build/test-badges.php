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
        $current_badges = $badges_manager->get_user_current_badges();
        $next_badges = $badges_manager->get_next_badge_in_progressions();

        if ( !$user ) {
            return new WP_REST_Response( [ 'message' => 'User not found' ], 404 );
        }

        $stats = [
            'last_prayer_date' => $user_stats->last_prayer_date(),
            'current_streak' => $user_stats->current_streak_in_days(),
            'best_streak' => $user_stats->best_streak_in_days(),
            'days_of_inactivity' => $user_stats->days_of_inactivity(),
            'hours_of_inactivity' => $user_stats->hours_of_inactivity(),
        ];

        return new WP_REST_Response( [
            'message' => 'User selected',
            'user' => $user,
            'user_stats' => $stats,
            'current_badges' => $current_badges,
            'next_badges' => $next_badges,
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
        register_rest_route( $this->rest_route, '/add-missing-badges', [
            'methods' => 'POST',
            'callback' => [ $this, 'add_missing_badges' ],
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
                    </table>
                    <h3>Current Badges</h3>
                    <table>
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Title</td>
                                <td>Description</td>
                                <td>Category</td>
                                <td></td>Value</td>
                                <td>Date</td>
                            </tr>
                        </thead>
                        <tbody id="current-badges-table-body"></tbody>
                    </table>
                    <h3>Next Badges</h3>
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
                        <tbody id="next-badges-table-body"></tbody>
                    </table>
                </div>

                <div class="flow-small">
                    <h3>Manipulate DB</h3>
                    <button class="btn btn-primary" id="add-missing-badges">Add missing badges</button>
                    <form class="" id="create-streak-form">
                        <input type="number" name="days" placeholder="Days">
                        <input class="btn btn-primary" type="submit" value="Create streak">
                    </form>
                    <form class="" id="create-inactivity-form">
                        <input type="number" name="days" placeholder="Days">
                        <input class="btn btn-primary" type="submit" value="Create inactive period">
                    </form>
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
                    }
                    if ( data.next_badges ) {
                        document.querySelector('#next-badges-table-body').innerHTML = data.next_badges.map(badge =>
                            `<tr>
                                <td>${badge.id}</td>
                                <td>${badge.title}</td>
                                <td>${badge.description}</td>
                                <td>${badge.category}</td>
                                <td>${badge.value}</td>
                                <td>${new Date(badge.date * 1000).toLocaleDateString()}</td>
                            </tr>`
                        ).join('');
                    }
                    if ( data.current_badges ) {
                        document.querySelector('#current-badges-table-body').innerHTML = data.current_badges.map(badge =>
                            `<tr>
                                <td>${badge.id}</td>
                                <td>${badge.title}</td>
                                <td>${badge.description}</td>
                                <td>${badge.category}</td>
                                <td>${badge.value}</td>
                                <td>${new Date(badge.date * 1000).toLocaleDateString()}</td>
                            </tr>`
                        ).join('');
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
