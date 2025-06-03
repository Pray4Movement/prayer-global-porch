<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

class PG_Test_Push extends PG_Public_Page {
    public $url_path = 'support/test-push';
    public $page_title = 'Test Push';
    public $rest_route = 'pg/test-push';

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

    public function set_queue_processing_method( $send_with_cron ) {
        add_filter( 'wp_queue_default_connection', function( $connection ) use ( $send_with_cron ) {
            if ( $send_with_cron ) {
                return $connection;
            }
            return 'sync';
        } );
    }

    public function test_push( WP_REST_Request $request ) {
        $body = $request->get_body();
        $body = json_decode( $body );

        $send_with_cron = isset( $body->send_with_cron ) && $body->send_with_cron === '1';
        $this->set_queue_processing_method( $send_with_cron );

        $user = isset( $body->user_email )
            ? get_user_by( 'email', sanitize_text_field( wp_unslash( $body->user_email ) ) )
            : get_user_by( 'email', 'nathinabob+1234@gmail.com' );
        $milestone_title = isset( $body->milestone_title ) && !empty( $body->milestone_title )
            ? sanitize_text_field( wp_unslash( $body->milestone_title ) )
            : 'Test title';
        $milestone_text = isset( $body->milestone_text ) && !empty( $body->milestone_text )
            ? sanitize_text_field( wp_unslash( $body->milestone_text ) )
            : 'Test text';
        $milestone_url = isset( $body->milestone_url ) && !empty( $body->milestone_url )
            ? sanitize_text_field( wp_unslash( $body->milestone_url ) )
            : site_url( 'dashboard' );
        $milestone = new PG_Milestone(
            $milestone_title,
            $milestone_text,
            'streak',
            1,
            [ PG_CHANNEL_PUSH ],
            $milestone_url,
        );
        wp_queue()->push( new PG_User_Push_Notification_Job( $user, $milestone ) );
        return new WP_REST_Response( [ 'message' => 'Push job test sent' ] );
    }

    public function test_push_handler( WP_REST_Request $request ) {
        $body = $request->get_body();
        $body = json_decode( $body );
        $send_with_cron = isset( $body->send_with_cron ) && $body->send_with_cron === '1';
        $this->set_queue_processing_method( $send_with_cron );

        wp_queue()->push( new PG_Notification_Handler_Job() );
        return new WP_REST_Response( [ 'message' => 'Push handler test sent' ] );
    }

    public function process_jobs( WP_REST_Request $request ) {

        $logs = [];
        add_filter( 'wp_queue_cron_memory_exceeded', function( $return ) use ( &$logs ) {
            $logs[] = 'Memory exceeded: ' . esc_html( $return );
            return false;
        } );

        add_filter( 'wp_queue_cron_time_exceeded', function( $return ) use ( &$logs ) {
            $logs[] = 'Time exceeded: ' . esc_html( $return );
        } );

        wp_queue()->cron()->cron_worker();
        $number_of_jobs = wp_queue_count_jobs();
        return new WP_REST_Response( [ 'message' => 'Jobs processed', 'number_of_jobs' => $number_of_jobs, 'logs' => $logs ] );
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

        // create user stats
        // last prayer date
        // current streak
        // days of inactivity
        // next milestone
        $user_stats = new User_Stats( $user['ID'] );
        $milestones_manager = new PG_Milestones( $user['ID'] );
        $next_milestones = $milestones_manager->get_next_milestones();
        $stats = [
            'last_prayer_date' => $user_stats->last_prayer_date(),
            'current_streak' => $user_stats->current_streak_in_days(),
            'days_of_inactivity' => $user_stats->days_of_inactivity(),
            'hours_of_inactivity' => $user_stats->hours_of_inactivity(),
        ];

        $next_milestones = array_map( function( $milestone ) use ( $user_stats ) {

            if ( $milestone->get_category() === 'streak' ) {
                $days_left = $milestone->get_value() - $user_stats->current_streak_in_days();
                $date = gmdate( 'Y-m-d', strtotime( "+{$days_left} days" ) );
            }
            if ( $milestone->get_category() === 'inactivity' ) {
                $days_left = $milestone->get_value() - $user_stats->days_of_inactivity();
                $date = gmdate( 'Y-m-d', strtotime( "+{$days_left} days" ) );
            }

            return [
                'title' => $milestone->get_title(),
                'message' => $milestone->get_message(),
                'value' => $milestone->get_value(),
                'date' => $date,
            ];
        }, $next_milestones );

        if ( !$user ) {
            return new WP_REST_Response( [ 'message' => 'User not found' ], 404 );
        }
        return new WP_REST_Response( [
            'message' => 'User selected',
            'user' => $user,
            'user_stats' => $stats,
            'next_milestones' => $next_milestones,
        ] );
    }
    public function register_endpoints() {
        register_rest_route( $this->rest_route, '/push-job-test', [
            'methods' => 'POST',
            'callback' => [ $this, 'test_push' ],
            'permission_callback' => [ $this, 'permission_callback' ],
        ] );
        register_rest_route( $this->rest_route, '/push-handler-test', [
            'methods' => 'POST',
            'callback' => [ $this, 'test_push_handler' ],
            'permission_callback' => [ $this, 'permission_callback' ],
        ] );
        register_rest_route( $this->rest_route, '/process-jobs', [
            'methods' => 'POST',
            'callback' => [ $this, 'process_jobs' ],
            'permission_callback' => [ $this, 'permission_callback' ],
        ] );
        register_rest_route( $this->rest_route, '/select-user', [
            'methods' => 'POST',
            'callback' => [ $this, 'select_user' ],
            'permission_callback' => [ $this, 'permission_callback' ],
        ] );
    }

    public function permission_callback( $request ) {
        return current_user_can( 'manage_dt' );
    }

    public function wp_enqueue_scripts() {
        wp_enqueue_style( 'pg-login-style', plugin_dir_url( __FILE__ ) . 'login.css', array(), filemtime( plugin_dir_path( __FILE__ ) . 'login.css' ) );

        wp_localize_script( 'global-functions', 'jsObject', [
            'rest_url' => esc_url( rest_url( 'pg/test-push' ) ),
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

                <?php
                if ( defined( 'PG_ONESIGNAL_STOP' ) ) {
                    echo 'PG_ONESIGNAL_STOP is defined as ' . esc_html( PG_ONESIGNAL_STOP ) . '<br>';
                } else {
                    echo 'PG_ONESIGNAL_STOP is not defined <br>';
                }

                $number_of_jobs = wp_queue_count_jobs();

                echo 'Number of jobs: ' . esc_html( $number_of_jobs ) . '<br>';

                ?>

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
                            <td>Days of Inactivity:</td>
                            <td id="days-of-inactivity"></td>
                        </tr>
                    </table>
                    <h3>Next Milestones</h3>
                    <table>
                        <thead>
                            <tr>
                                <td>Title</td>
                                <td>Text</td>
                                <td>Value</td>
                                <td>Date</td>
                            </tr>
                        </thead>
                        <tbody id="next-milestones-table-body"></tbody>
                    </table>
                </div>


                <div>
                    <h3>Push Job Test</h3>
                    <form class="" id="push-job-test-form">
                        <input type="text" name="user_email" placeholder="User Email" required>
                        <input type="text" name="milestone_title" placeholder="Milestone Title">
                        <input type="text" name="milestone_text" placeholder="Milestone Text">
                        <input type="text" name="milestone_url" placeholder="Milestone URL">
                        <label><input type="checkbox" name="send_with_cron" value="1"> Send with cron</label>
                        <input class="btn btn-primary" type="submit" value="Send">
                    </form>
                </div>

                <div>
                    <h3>Push Handler Test</h3>
                    <form class="" id="push-handler-test-form">
                        <label><input type="checkbox" name="send_with_cron" value="1"> Send with cron</label>
                        <input class="btn btn-primary" type="submit" value="Send">
                    </form>
                </div>

                <div>
                    <h3>Process Jobs</h3>
                    <form class="" id="process-jobs-form">
                        <input type="hidden" name="send_with_cron" value="1">
                        <input class="btn btn-primary" type="submit" value="Process">
                    </form>
                </div>

            </div>

        </section>

        <script>
            document.querySelector('#push-job-test-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const data = Object.fromEntries(formData);
                fetch(jsObject.rest_url + '/push-job-test', {
                    method: 'POST',
                    body: JSON.stringify(data),
                    headers: {
                        'Content-Type': 'application/json',
                        'X-WP-Nonce': jsObject.nonce,
                    },
                }).then(response => response.json()).then(data => {
                    console.log(data);
                });
            });

            document.querySelector('#push-handler-test-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const data = Object.fromEntries(formData);
                fetch(jsObject.rest_url + '/push-handler-test', {
                    method: 'POST',
                    body: JSON.stringify(data),
                    headers: {
                        'Content-Type': 'application/json',
                        'X-WP-Nonce': jsObject.nonce,
                    },
                }).then(response => response.json()).then(data => {
                    console.log(data);
                });
            });

            document.querySelector('#process-jobs-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const data = Object.fromEntries(formData);
                fetch(jsObject.rest_url + '/process-jobs', {
                    method: 'POST',
                    body: JSON.stringify(data),
                    headers: {
                        'Content-Type': 'application/json',
                        'X-WP-Nonce': jsObject.nonce,
                    },
                }).then(response => response.json()).then(data => {
                    console.log(data);
                });
            });

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
                        document.querySelector('#last-prayer-date').innerHTML = data.user_stats.last_prayer_date;
                        document.querySelector('#current-streak').innerHTML = data.user_stats.current_streak;
                        document.querySelector('#days-of-inactivity').innerHTML = data.user_stats.days_of_inactivity;
                    }
                    if ( data.next_milestones ) {
                        document.querySelector('#next-milestones-table-body').innerHTML = data.next_milestones.map(milestone =>
                            `<tr>
                                <td>${milestone.title}</td>
                                <td>${milestone.message}</td>
                                <td>${milestone.value}</td>
                                <td>${milestone.date}</td>
                            </tr>`
                        ).join('');
                    }
                });
            }

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

new PG_Test_Push();
