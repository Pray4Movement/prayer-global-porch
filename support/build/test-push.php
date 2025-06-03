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
                    <h3>Push Job Test</h3>
                    <form class="flow-small" id="push-job-test-form">
                        <input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'push_test' ) ); ?>">
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
                    <form class="flow-small" id="push-handler-test-form">
                        <input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'push_test' ) ); ?>">
                        <label><input type="checkbox" name="send_with_cron" value="1"> Send with cron</label>
                        <input class="btn btn-primary" type="submit" value="Send">
                    </form>
                </div>

                <div>
                    <h3>Process Jobs</h3>
                    <form class="flow-small" id="process-jobs-form">
                        <input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'push_test' ) ); ?>">
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
        </script>

        <?php
    }
}

new PG_Test_Push();
