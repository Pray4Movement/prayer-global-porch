<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

class PG_Login extends PG_Public_Page {
    public $url_path = 'login';
    public $page_title = 'Login';
    public $rest_route = 'pg/login';

    public function __construct() {
        $current_page_path_matches = parent::__construct();
        if ( !$current_page_path_matches ) {
            return;
        }
        if ( is_user_logged_in() ){
            wp_redirect( home_url( '/dashboard' ) );
            exit;
        }
        /**
         * Register custom hooks here
         */
    }

    public function register_endpoints() {
        register_rest_route( $this->rest_route, '/wp-login', [
            'methods' => 'POST',
            'callback' => [ $this, 'wp_login_endpoint' ],
        ] );

        register_rest_route( $this->rest_route, '/reset-password', [
            'methods' => 'POST',
            'callback' => [ $this, 'reset_password_endpoint' ],
        ] );
    }

    /**
     * Login the user using WordPress authentication
     * @param WP_REST_Request $request
     * @return WP_REST_Response|WP_Error
     */
    public function wp_login_endpoint( WP_REST_Request $request ) {
        $body = $request->get_body();
        $body = json_decode( $body );

        if ( !isset( $body->email ) || !isset( $body->password ) ) {
            return new WP_Error( 'bad_request', 'Email and password are required', [ 'status' => 400 ] );
        }

        // Find the WordPress user by email
        $user = get_user_by( 'email', $body->email );

        if ( !$user ) {
            return new WP_Error( 'invalid_credentials', 'Invalid email or password', [ 'status' => 401 ] );
        }

        // Check the password
        $check = wp_check_password( $body->password, $user->user_pass, $user->ID );

        if ( !$check ) {
            return new WP_Error( 'invalid_credentials', 'Invalid email or password', [ 'status' => 401 ] );
        }

        // Set the auth cookie for the user
        wp_set_auth_cookie( $user->ID, true );

        return new WP_REST_Response( [
            'status' => 200,
            'message' => 'Login successful',
            'data' => [
                'user_id' => $user->ID,
                'email' => $user->user_email,
                'display_name' => $user->display_name
            ]
        ] );
    }

    /**
     * Handle password reset requests
     * @param WP_REST_Request $request
     * @return WP_REST_Response|WP_Error
     */
    public function reset_password_endpoint( WP_REST_Request $request ){
        $body = $request->get_body();
        $body = json_decode( $body );

        if ( !isset( $body->email ) ){
            return new WP_Error( 'bad_request', 'Email is required', [ 'status' => 400 ] );
        }

        $user_data = get_user_by( 'email', $body->email );

        // If the user exists, generate and send the reset email
        if ( $user_data ){
            // Generate a password reset key
            $key = get_password_reset_key( $user_data );
            if ( is_wp_error( $key ) ){
                // Don't expose the error, just log it
                error_log( 'Error generating password reset key: ' . $key->get_error_message() );
            } else {
                // Send email with reset link
                $reset_url = add_query_arg( [
                    'action' => 'rp',
                    'key' => $key,
                    'login' => rawurlencode( $user_data->user_login )
                ], wp_login_url() );

                $message = __( 'Someone has requested a password reset for the following account:', 'prayer-global-porch' ) . "\r\n\r\n";
                $message .= network_home_url( '/' ) . "\r\n\r\n";
                $message .= sprintf( __( 'Username: %s', 'prayer-global-porch' ), $user_data->user_login ) . "\r\n\r\n";
                $message .= __( 'If this was a mistake, just ignore this email and nothing will happen.', 'prayer-global-porch' ) . "\r\n\r\n";
                $message .= __( 'To reset your password, visit the following address:', 'prayer-global-porch' ) . "\r\n\r\n";
                $message .= $reset_url . "\r\n";

                $title = __( 'Password Reset Request', 'prayer-global-porch' );

                $sent = wp_mail( $user_data->user_email, $title, $message );

                if ( !$sent ){
                    // Don't expose the error, just log it
                    error_log( 'Error sending password reset email to: ' . $user_data->user_email );
                }
            }
        }

        // Always return a success message, regardless of whether the email exists
        // This prevents user enumeration by not revealing if an email exists in the system
        return new WP_REST_Response( [
            'status' => 200,
            'message' => 'If a matching account was found, a password reset email has been sent'
        ] );
    }

    public function wp_enqueue_scripts() {
        wp_enqueue_script( 'user-mobile-login', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'user-mobile-login.js', [], fileatime( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'user-mobile-login.js' ), [ 'strategy' => 'defer' ] );
        wp_enqueue_style( 'pg-login-style', plugin_dir_url( __FILE__ ) . 'login.css', array(), filemtime( plugin_dir_path( __FILE__ ) . 'login.css' ) );
    }

    public function dt_magic_url_base_allowed_js( $allowed_js ) {
        return $allowed_js;
    }

    public function dt_magic_url_base_allowed_css( $allowed_css ) {
        $allowed_css[] = 'pg-login-style';
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
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/header.php' );
    }

    /**
     * Print scripts to footer
     */
    public function footer_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/footer.php' );
        ?>
        <script>
            let jsObject = [<?php echo json_encode([
                'rest_url' => esc_url( rest_url( 'dt/v1' ) ),
                'translations' => [
                    'add' => __( 'Add Magic', 'disciple_tools' ),
                    'invalid_credentials' => esc_html__( 'Invalid email or password. Please try again.', 'prayer-global-porch' ),
                    'email_not_found' => esc_html__( 'Email not found. Please register.', 'prayer-global-porch' ),
                    'auth_failed' => esc_html__( 'Authentication failed. Please try again or register for an account.', 'prayer-global-porch' ),
                    'email_required' => esc_html__( 'Email is required', 'prayer-global-porch' ),
                    'no_account_found' => esc_html__( 'No account found with that email address', 'prayer-global-porch' ),
                ],
            ]) ?>][0]
        </script>
        <script type="module" src="<?php echo esc_url( trailingslashit( plugin_dir_url( __FILE__ ) ) . 'login.js' ); ?>"></script>

        <?php
    }
    /**
     * Print body
     */
    public function body(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . '/assets/nav.php' );

        $url = new DT_URL( dt_get_url_path() );

        $redirect_to = $url->query_params->has( 'redirect_to' ) ? urlencode( $url->query_params->get( 'redirect_to' ) ) : '';

        $register_url = '/register';
        $register_url = !empty( $redirect_to ) ? $register_url . "&redirect_to=$redirect_to" : $register_url;

        $svg_manager = new SVG_Spritesheet_Manager();
        $icons = [
            'pg-streak',
            'pg-relay',
            'pg-prayer',
            'pg-go-logo',
        ];
        $svgs_url = $svg_manager->get_cached_spritesheet_url( $icons );
        ?>

        <div class="login-modal" id="modal-news-signup">
            <div class="login-modal-content">
                <h3 class="d-flex align-items-center gap-2">
                    <?php echo esc_html__( 'Stay Updated', 'prayer-global-porch' ) ?>
                    <svg class="icon-md"><use href="<?php echo esc_html( $svgs_url ); ?>#pg-go-logo"></use></svg>
                </h3>
                <p>

                    <?php echo esc_html__( 'Sign up for Prayer.Global news and opportunities, and occasional communication from Prayer.Tools and GospelAmbition.org', 'prayer-global-porch' ) ?>?
                </p>
                <div style="display: flex; justify-content: space-between; margin-top: 20px; gap: 1rem;">
                    <button id="modal-no" class="btn btn-outline-primary btn-small"><?php echo esc_html__( 'No Thanks', 'prayer-global-porch' ) ?></button>
                    <button id="modal-yes" class="btn btn-primary btn-small"><?php echo esc_html__( 'Yes, Sign Me Up', 'prayer-global-porch' ) ?></button>
                </div>
            </div>
        </div>

        <section class="login-section pt-4" data-section="login" id="section-login">
            <div class="container center">
                <div class="login-register-links">
                    <a class="link-active" href="#"><?php esc_html_e( 'Login', 'prayer-global-porch' ); ?></a>
                    <a href="<?php echo esc_html( $register_url ); ?>"><?php esc_html_e( 'Register', 'prayer-global-porch' ); ?></a>
                </div>
                <div class="card">
                    <div id="card-content">
                        <h2 class=""><?php echo esc_html__( 'Login', 'prayer-global-porch' ) ?></h2>
                        <hr>
                        <ul class="reasons-list w-fit text-align-left mx-auto">
                            <li>
                                <svg class="icon-sm"><use href="<?php echo esc_html( $svgs_url ); ?>#pg-relay"></use></svg>
                                <?php echo esc_html__( 'Join and create custom prayer relays', 'prayer-global-porch' ) ?>
                            </li>
                            <li>
                                <svg class="icon-sm"><use href="<?php echo esc_html( $svgs_url ); ?>#pg-prayer"></use></svg>
                                <?php echo esc_html__( 'View your interactive prayer history', 'prayer-global-porch' ) ?>
                            </li>
                            <li>
                                <svg class="icon-sm"><use href="<?php echo esc_html( $svgs_url ); ?>#pg-streak"></use></svg>
                                <?php echo esc_html__( 'Prayer streaks, badges and more', 'prayer-global-porch' ) ?>
                            </li>
                        </ul>
                        <hr>
                        <div id="login-ui-loader">
                            <span class="loading-spinner"></span>
                        </div>
                        <div id="login-buttons" class="login-buttons">
                            <div>
                                <button id="signin-google" class="google-button" data-provider-id="google.com">
                                    <span style="margin-right: 10px">
                                        <img alt="sign in with google"
                                             src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg">
                                    </span>
                                    <span><?php echo esc_html__( 'Sign in with Google', 'prayer-global-porch' ); ?></span>
                                </button>
                            </div>
                            <div class="separator"><?php echo esc_html__( 'OR', 'prayer-global-porch' ); ?></div>
                            <div>
                                <button id="register-password" class="email-button" data-provider-id="password">
                                    <span><?php echo esc_html__( 'Continue with Email', 'prayer-global-porch' ); ?></span>
                                </button>
                            </div>
                        </div>
                        <div id="login-email-password-form" style="display: none">
                            <button class="button btn btn-primary" id="login-email-password-form-back">
                                <?php esc_html_e( 'Back', 'prayer-global-porch' ); ?>
                            </button>
                            <div class="wp_register_form">
                                <div>
                                    <form id="loginform" class="loginform" action="" method="POST" data-abide>
                                        <div>
                                            <label for="email">
                                                <?php esc_html_e( 'Email', 'prayer-global-porch' ) ?>
                                                <input class="input login-username" type="email" name="email" id="email" value="" aria-errormessage="email-error" required>
                                            </label>
                                            <span class="form-error
                                                    <?php echo ( $url->query_params->has( 'email_error' ) ? 'is-invalid-label' : '' ) ?>"
                                                  id="email-error">
                                                    <?php esc_html_e( 'Badly formatted email address', 'prayer-global-porch' ) ?>
                                            </span>
                                        </div>
                                        <div>
                                            <label for="password"><?php esc_html_e( 'Password', 'prayer-global-porch' ) ?>
                                                <input class="input login-password" type="password" id="password" name="password" aria-errormessage="password-error" required >

                                            </label>
                                            <span class="form-error
                                                    <?php echo ( $url->query_params->has( 'password_error' ) ? 'is-invalid-label' : '' ) ?>"
                                                  id="password-error">
                                                <?php esc_html_e( 'Password is required', 'prayer-global-porch' ) ?>
                                            </span>
                                        </div>
                                        <div data-abide-error class="form-error" id="login-error" style="display: none;">
                                            <p><i class="fi-alert"></i><?php esc_html_e( 'There are some errors in your form.', 'prayer-global-porch' ) ?></p>
                                        </div>
                                        <?php wp_nonce_field( 'login_form', 'login_form_nonce' ) ?>

                                        <div>
                                            <button class="btn w-100 btn-secondary" id="login-submit">
                                                <?php esc_html_e( 'Login', 'prayer-global-porch' ) ?>
                                                <span class="loading-spinner"></span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Password Reset Form -->
                        <div id="reset-password-form">
                            <button class="button btn btn-primary" id="reset-password-back">
                                <?php esc_html_e( 'Back to Login', 'prayer-global-porch' ); ?>
                            </button>
                            <h4><?php esc_html_e( 'Reset Password', 'prayer-global-porch' ); ?></h4>
                            <p><?php esc_html_e( 'Enter your email address and we\'ll send you a link to reset your password.', 'prayer-global-porch' ); ?></p>
                            <form id="reset-password-form-element" class="loginform" action="" method="POST" data-abide>
                                <div>
                                    <label for="reset-email">
                                        <?php esc_html_e( 'Email', 'prayer-global-porch' ) ?>
                                        <input class="input" type="email" name="reset-email" id="reset-email" value="" aria-errormessage="reset-email-error" required>
                                    </label>
                                    <span class="form-error" id="reset-email-error">
                                        <?php esc_html_e( 'Please enter a valid email address', 'prayer-global-porch' ) ?>
                                    </span>
                                </div>
                                <div>
                                    <button class="btn w-100 btn-secondary" id="reset-password-submit">
                                        <?php esc_html_e( 'Send Reset Link', 'prayer-global-porch' ) ?>
                                        <span class="loading-spinner"></span>
                                    </button>
                                </div>
                            </form>
                            <div class="reset-success-message" id="reset-success-message">
                                <?php esc_html_e( 'Password reset link has been sent to your email address.', 'prayer-global-porch' ) ?>
                            </div>
                        </div>

                        <div class="login-links">
                            <p>
                                <?php echo esc_html__( 'Don\'t have an account?', 'prayer-global-porch' ) ?>
                                <a href="<?php echo esc_url( $register_url ) ?>"><?php echo esc_html__( 'Register', 'prayer-global-porch' ) ?></a>
                            </p>
                            <p>
                                <a href="#" id="forgot-password-link"><?php echo esc_html__( 'Forgot Password?', 'prayer-global-porch' ) ?></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}

new PG_Login();
