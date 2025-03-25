<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

require_once plugin_dir_path( __DIR__ ) . '../vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class PG_Register extends PG_Public_Page {
    public $url_path = 'register';
    public $page_title = 'Register';
    public $rest_route = 'pg/register';

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

    public function register_endpoints(){
        register_rest_route( $this->rest_route, '/password', [
            'methods' => 'POST',
            'callback' => [ $this, 'register_with_password' ],
        ] );
    }

    public function register_with_password( $request ){
        $body = $request->get_body();
        $body = json_decode( $body );

        //cloudflare turnstile verification if enabled
        $cf_secret = get_option( 'dt_cloudflare_secret_key', '' );
        $cf_site_key = get_option( 'dt_cloudflare_site_key', '' );
        if ( !empty( $cf_secret ) && !empty( $cf_site_key ) ){
            if ( !isset( $body->extra_data->turnstile_token ) ) {
                return new WP_Error( 'turnstile_error', 'Turnstile token not found', [ 'status' => 401 ] );
            }

            $ip = sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ?? '' ) );
            $url = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';
            $response = wp_remote_post( $url, [
                'body' => [
                    'secret' => $cf_secret,
                    'response' => $body->extra_data->turnstile_token,
                    'remoteip' => $ip,
                ],
            ] );

            if ( is_wp_error( $response ) ) {
                return new WP_Error( 'turnstile_error', 'Failed to verify Turnstile token', [ 'status' => 500 ] );
            }
            $response_body = json_decode( wp_remote_retrieve_body( $response ), true );
            if ( empty( $response_body['success'] ) ){
                return new WP_Error( 'turnstile_error', 'Failed to verify Turnstile token', [ 'status' => 500 ] );
            }
        }

        try {
            // Check if user already exists
            if ( email_exists( $body->email ) ) {
                return new WP_Error( 'user_exists', 'A user with this email already exists', [ 'status' => 400 ] );
            }

            // Create WordPress user
            $user_id = wp_create_user(
                sanitize_user( $body->email ),
                $body->password,
                sanitize_email( $body->email )
            );

            if ( is_wp_error( $user_id ) ) {
                return new WP_Error( 'registration_failed', $user_id->get_error_message(), [ 'status' => 400 ] );
            }

            // Set user display name and role
            wp_update_user( [
                'ID' => $user_id,
                'display_name' => $body->name ?? $body->email,
                'first_name' => $body->name ?? '',
                'role' => 'prayer_warrior'
            ] );

            // Log user in
            wp_set_auth_cookie( $user_id, true );

            // Process marketing preference from extra_data
            if ( isset( $body->extra_data ) ) {
                do_action( 'dt_sso_login_extra_fields', (array) $body->extra_data, (array) $body );
            }

            // Send verification email (optional)
            // TODO: Implement email verification if needed

            return new WP_REST_Response([
                'status' => 200,
                'message' => 'Registration successful.',
                'data' => [
                    'user_id' => $user_id,
                    'email' => $body->email
                ]
            ]);

        } catch ( \Exception $e ) {
            return new WP_Error( 'registration_failed', $e->getMessage(), [ 'status' => 400 ] );
        }
    }

    public function wp_enqueue_scripts() {
        wp_enqueue_script( 'pass-strength', 'https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.2.0/zxcvbn.js', [], '4.2.0', true );
        wp_enqueue_script( 'cloudflare-turnstile', 'https://challenges.cloudflare.com/turnstile/v0/api.js', [], 'v0', [ 'strategy' => 'defer' ] );
        wp_enqueue_style( 'pg-register-style', plugin_dir_url( __FILE__ ) . 'login.css', array(), filemtime( plugin_dir_path( __FILE__ ) . 'login.css' ) );
    }

    public function dt_magic_url_base_allowed_js( $allowed_js ) {
        $allowed_js[] = 'cloudflare-turnstile';
        $allowed_js[] = 'pass-strength';
        return $allowed_js;
    }

    public function dt_magic_url_base_allowed_css( $allowed_css ) {
        $allowed_css[] = 'pg-register-style';
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
          //check and redirect if the user is already logged in
          window.addEventListener('load', function() {
            if (pg_global.is_logged_in) {
              const url = new URL(location.href)
              const redirectTo = url.searchParams.get('redirect_to') || encodeURIComponent('/dashboard')

              location.href = decodeURIComponent(redirectTo)
            }
          })
        </script>
        <script>
            let jsObject = [<?php echo json_encode([
                'rest_url' => esc_url( rest_url( 'dt/v1' ) ),
                'translations' => [
                   'turnstile_error' => esc_html__( 'Please complete the security check.', 'prayer-global-porch' ),
                ],
            ]) ?>][0]
        </script>
        <script type="module" src="<?php echo esc_url( trailingslashit( plugin_dir_url( __FILE__ ) ) . 'register.js' ); ?>"></script>
        <script type="module" src="<?php echo esc_url( trailingslashit( plugin_dir_url( __FILE__ ) ) . 'user-mobile-login.js' ); ?>"></script>

        <?php
    }
    /**
     * Print body
     */
    public function body(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . '/assets/nav.php' );

        $url = new DT_URL( dt_get_url_path() );

        $redirect_to = $url->query_params->has( 'redirect_to' ) ? urlencode( $url->query_params->get( 'redirect_to' ) ) : '';

        $login_url = '/login';
        $login_url = !empty( $redirect_to ) ? $login_url . "?redirect_to=$redirect_to" : $login_url;

        $svg_manager = new SVG_Spritesheet_Manager();
        $icons = [
            'pg-streak',
            'pg-relay',
            'pg-prayer',
            'pg-go-logo',
        ];
        $svgs_url = $svg_manager->get_cached_spritesheet_url( $icons );
        ?>

        <section class="login-section pt-4" data-section="register" id="section-register">
            <div class="container center text-center">
                <div class="login-register-links">
                    <a href="<?php echo esc_html( $login_url ); ?>"><?php esc_html_e( 'Login', 'prayer-global-porch' ); ?></a>
                    <a class="link-active" href="#"><?php esc_html_e( 'Register', 'prayer-global-porch' ); ?></a>
                </div>
                <div class="card">
                    <div id="card-content">
                        <h2 class="pt-4 m-0"><?php echo esc_html__( 'Register', 'prayer-global-porch' ) ?></h2>
                        <hr>
                        <p class="text-center" style="font-size: larger"><?php echo esc_html__( 'Create your own free login', 'prayer-global-porch' ) ?></p>
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
                        <div class="flow-medium">
                            <svg class="icon-lg"><use href="<?php echo esc_html( $svgs_url ); ?>#pg-go-logo"></use></svg>
                            <div class="marketing-options" style="text-align: start; max-width:20rem;">
                                <div class="form-check small">
                                    <label class="form-check-label" for="extra_register_input_marketing">
                                        <input type="checkbox" id="extra_register_input_marketing" checked>
                                        <?php echo esc_html( __( 'Sign up for Prayer.Global news and opportunities, and occasional communication from Prayer.Tools and GospelAmbition.org', 'prayer-global-porch' ) ) ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div id="login-buttons" class="login-buttons">
                            <div>
                                <button id="signin-google" data-type="register" class="google-button" data-provider-id="google.com">
                                            <span style="margin-right: 10px">
                                                <img alt="sign in with google"
                                                     src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg">
                                            </span>
                                    <span><?php echo esc_html__( 'Register with Google', 'prayer-global-porch' ); ?></span>
                                </button>
                            </div>
                            <div class="separator"><?php echo esc_html__( 'OR', 'prayer-global-porch' ); ?></div>
                            <div>
                                <button id="register-password" class="email-button" data-provider-id="password">
                                    <!--<span style="margin-right: 10px">-->
                                    <!--    <img alt="sign in with google"-->
                                    <!--         src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/mail.svg">-->
                                    <!--</span>-->
                                    <span><?php echo esc_html__( 'Register with Email', 'prayer-global-porch' ); ?></span>
                                </button>
                            </div>
                        </div>
                        <div id="register-email-password-form" style="display: none">
                            <button class="button btn btn-primary" id="register-email-password-form-back">
                                <?php esc_html_e( 'Back', 'prayer-global-porch' ); ?>
                            </button>
                            <div class="wp_register_form">
                                <div>
                                    <form id="loginform" class="loginform" action="" method="POST" data-abide>
                                        <!--name-->
                                        <div>
                                            <label for="name">
                                                <?php esc_html_e( 'Name', 'prayer-global-porch' ) ?>
                                            </label>
                                            <input class="input" type="text" name="name" id="name" value="" required>
                                        </div>
                                        <div>
                                            <label for="email">
                                                <?php esc_html_e( 'Email', 'prayer-global-porch' ) ?>
                                            </label>
                                            <input class="input" type="email" name="email" id="email" value="" aria-errormessage="email-error" required>
                                            <span class="form-error" id="email-error">
                                                        <?php esc_html_e( 'Badly formatted email address', 'prayer-global-porch' ) ?>
                                                    </span>
                                        </div>
                                        <div>
                                            <label for="password"><?php esc_html_e( 'Password', 'prayer-global-porch' ) ?></label>
                                            <input class="input" type="password" id="password" name="password" aria-errormessage="password-error-too-weak" required >
                                            <span class="form-error" id="password-error-too-weak">
                                                        <?php esc_html_e( 'Password is not strong enough', 'prayer-global-porch' ) ?>
                                                    </span>
                                        </div>
                                        <meter max="4" id="password-strength-meter" value="0"></meter>
                                        <div>
                                            <label class="show-for-sr"><?php esc_html_e( 'Re-enter Password', 'prayer-global-porch' ) ?></label>
                                            <input class="input" id="password2" name="password2" type="password" aria-errormessage="password-error-2" data-equalto="password" required>
                                            <span class="form-error" id="password-error-2">
                                                    <?php esc_html_e( 'Passwords do not match. Please, try again.', 'prayer-global-porch' ) ?>
                                                </span>
                                        </div>
                                        <div class="cf-turnstile" data-sitekey="<?php echo esc_attr( get_option( 'dt_cloudflare_site_key' ) ); ?>" data-theme="light"></div>
                                        <?php wp_nonce_field( 'login_form', 'login_form_nonce' ) ?>
                                        <div>
                                            <button class="btn w-100 btn-secondary" id="register-submit">
                                                <?php esc_html_e( 'Register', 'prayer-global-porch' ) ?>
                                                <span class="loading-spinner"></span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div id="login-ui-loader">
                            <span class="loading-spinner"></span>
                        </div>
                        <div class="error-message">
                                    <span class="form-error" id="login-error">
                                        <?php echo esc_html__( 'There was a problem with your login. Please try again.', 'prayer-global-porch' ) ?>
                                    </span>
                        </div>
                        <div class="flow-medium">
                            <div class="login-links">
                                <p>
                                    <?php echo esc_html__( 'Already got an account?', 'prayer-global-porch' ) ?>
                                    <a href="<?php echo esc_url( $login_url ) ?>"><?php echo esc_html__( 'Login', 'prayer-global-porch' ) ?></a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}

new PG_Register();
