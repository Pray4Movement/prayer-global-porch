<?php
if ( !defined( 'ABSPATH' ) ){
    exit;
} // Exit if accessed directly.

class Prayer_Global_Porch_Contact_Us extends DT_Magic_Url_Base{
    public $magic = false;
    public $parts = false;
    public $page_title = 'Global Prayer - Contact Us';
    public $root = 'prayer_app';
    public $type = 'contact_us';
    public $type_name = 'Global Prayer - Contact Us';
    public static $token = 'prayer_app';
    public $post_type = 'groups';

    private static $_instance = null;

    public static function instance(){
        if ( is_null( self::$_instance ) ){
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct(){
        parent::__construct();

        $url = dt_get_url_path();
        if ( ( $this->root . '/' . $this->type ) === $url ){

            $this->magic = new DT_Magic_URL( $this->root );
            $this->parts = $this->magic->parse_url_parts();


            // page content
            add_action( 'dt_blank_body', [ $this, 'body' ] ); // body for no post key

            add_filter( 'dt_magic_url_base_allowed_css', [ $this, 'dt_magic_url_base_allowed_css' ], 10, 1 );
            add_filter( 'dt_magic_url_base_allowed_js', [ $this, 'dt_magic_url_base_allowed_js' ], 10, 1 );
            add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

        }
        add_action( 'rest_api_init', [ $this, 'add_api_routes' ] );

    }

    public function add_api_routes(){
        register_rest_route( $this->root . '/v1/' . $this->type, '/contact_us', [
            'methods' => 'POST',
            'callback' => [ $this, 'contact_us' ],
            'permission_callback' => function (){
                return true;
            },
        ] );
    }

    public function contact_us( WP_REST_Request $request ){
        $params = $request->get_params();

        $name = sanitize_text_field( $params['name'] );
        $email = sanitize_email( $params['email'] );
        $message = sanitize_textarea_field( $params['message'] );
        $news = $params['news'] ? true : false;
        $cf_token = sanitize_text_field( $params['cf_token'] ?? '' );

        $cf_secret = get_option( 'dt_cloudflare_secret_key', '' );
        $cf_site_key = get_option( 'dt_cloudflare_site_key', '' );

        if ( !isset( $params['message'], $params['email'], $params['name'] ) ){
            return new WP_Error( __METHOD__, 'Missing required fields', [ 'status' => 400 ] );
        }

        if ( !empty( $cf_secret ) && !empty( $cf_site_key ) ){
            $cf_token = $params['cf_token'] ?? '';
            if ( empty( $cf_token ) ){
                return new WP_Error( __METHOD__, 'Missing Cloudflare Verification', [ 'status' => 400 ] );
            }

            $ip = sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ?? '' ) );
            $url = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';
            $response = wp_remote_post( $url, [
                'body' => [
                    'secret' => $cf_secret,
                    'response' => $cf_token,
                    'remoteip' => $ip,
                ],
            ] );

            if ( is_wp_error( $response ) ){
                return new WP_Error( 'cf_token', 'Invalid token', [ 'status' => 400 ] );
            }
            $response_body = json_decode( wp_remote_retrieve_body( $response ), true );
            if ( empty( $response_body['success'] ) ){
                return new WP_Error( 'cf_token', 'Invalid token', [ 'status' => 400 ] );
            }
        }

        $key = Site_Link_System::get_site_key_by_dev_key( 'crm_connection' );
        if ( empty( $key ) ){
            return new WP_Error( __METHOD__, 'Internal Server Error', [ 'status' => 500 ] );
        }
        $site_key = md5( $key['token'] . $key['site1'] . $key['site2'] );
        $transfer_token = Site_Link_System::create_transfer_token_for_site( $site_key );

        $url = 'https://' . $key['site2'] . '/wp-json/dt-posts/v2/contacts';

        $body = [
            'title' => $name,
            'contact_email' => [ [ 'value' => $email ] ],
            'email' => $email,
            'message' => $message,
            'sources' => [ 'values' => [ [ 'value' => 'prayer_global' ] ] ],
            'projects' => [ 'values' => [ [ 'value' => 'prayer_global' ] ] ],
        ];

        if ( $news ){
            $body['steps_taken'] = [ 'values' => [ [ 'value' => 'P.G Newsletter' ] ] ];
            $body['tags'] = [ 'values' => [ [ 'value' => 'add_to_mailing_list_39' ] ] ]; //P.G Newsletter
        }

        $request = wp_remote_post( $url, [
            'body' => $body,
            'headers' => [
                'Authorization' => 'Bearer ' . $transfer_token,
            ],
        ] );

        if ( is_wp_error( $request ) ){
            return new WP_Error( __METHOD__, 'Internal Server Error', [ 'status' => 500 ] );
        }
        return true;
    }

    public function dt_magic_url_base_allowed_js( $allowed_js ){
        return [ 'cloudflare-turnstile' ];
    }

    public function dt_magic_url_base_allowed_css( $allowed_css ){
        return [];
    }

    public function header_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/header.php' );
    }

    public function footer_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/footer.php' );
    }

    public function body(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . '/assets/nav.php' );

        $cloudflare_site_key = get_option( 'dt_cloudflare_site_key', '' );

        ?>

        <section class="page-section mt-5 pb-0" data-section="about" id="section-about">
            <div class="container">
                <div class="row justify-content-md-center text-center mb-5">
                    <div class="col-lg-7">
                        <h2 class="mt-0 pb-3 font-weight-normal"><?php echo esc_html( __( 'Contact Us', 'prayer-global-porch' ) ) ?></h2>
                        <p>
                            <?php echo esc_html( __( 'First, thank you for reaching out.', 'prayer-global-porch' ) ) ?>
                        </p>
                        <p>
                            <?php echo esc_html( __( "Second, we're a group of volunteers striving to see the Great Commission fulfilled in this generation ... and we also have other jobs ... so be patient as we get back to you!", 'prayer-global-porch' ) ) ?>
                        </p>
                    </div>
                </div>
                <div class="row justify-content-md-center">
                    <div class="col-lg-7">
                        <form onSubmit="event.preventDefault();submit_contact_us_form();return false;" id="form-content"
                              style="max-width: 600px; margin: auto">
                            <p>
                                <label style="width: 100%">
                                    <?php esc_html_e( 'Name', 'prayer-global-porch' ); ?>
                                    <br>
                                    <input type="text" id="contact-name" required style="width: 100%">
                                </label>
                            </p>
                            <p>
                                <label style="width: 100%">
                                    <?php esc_html_e( 'Email', 'prayer-global-porch' ); ?>
                                    <br>
                                    <input type="email" id="email" style="display: none">
                                    <input type="email" id="email-2" required style="width: 100%">
                                </label>
                            </p>
                            <p>
                                <label style="width: 100%">
                                    <?php esc_html_e( 'Question or Comment', 'prayer-global-porch' ); ?>
                                    <br>
                                    <textarea id="contact-message" required rows="4" type="text"
                                              style="width: 100%"></textarea>
                                </label>
                            </p>
                            <p>
                                <label>
                                    <input type="checkbox" name="news" id="news">
                                    <?php esc_html_e( 'Sign up for Prayer.Global news and opportunities, and occasional communication from Prayer.Tools and GospelAmbition.org', 'prayer-global-porch' ); ?>
                                </label>
                            </p>
                            <?php if ( !empty( $cloudflare_site_key ) ) : ?>
                                <div
                                    class="cf-turnstile"
                                    data-sitekey="<?php echo esc_html( $cloudflare_site_key ); ?>"
                                    data-theme="light"
                                    style="margin-top:1em;"
                                ></div>
                            <?php endif; ?>
                            <p id="form-error-section" style="color: red"></p>
                            <p>
                                <button id="contact-submit-button" class="btn btn-primary-light white uppercase">
                                    <?php esc_html_e( 'Submit', 'prayer-global-porch' ); ?>
                                    <img id="contact-submit-spinner" style="display: none; margin-left: 10px"
                                         src="<?php echo esc_url( trailingslashit( get_stylesheet_directory_uri() ) ) ?>spinner.svg"
                                         width="22px;" alt="spinner "/>
                                </button>
                            </p>
                        </form>
                        <div id="form-confirm" class="section-header" style="display: none">
                            <h3 class="section-subtitle"><?php esc_html_e( 'Thank you', 'prayer-global-porch' ); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script>
          const parts = <?php echo json_encode( $this->parts ) ?>;

          let submit_contact_us_form = function () {

            $('#contact-submit-spinner').show()
            let honey = $('#email').val();
            if (honey) {
              return;
            }
            $('#form-error-section').text('');

            //cloudflare turnstile token
            const cf_token = $('input[name="cf-turnstile-response"]').val();

            const name = $('#contact-name').val();
            const email = $('#email-2').val();
            const message = $('#contact-message').val()
            const news = $('#news').is(':checked');

            let payload = {
              'parts': parts,
              name,
              email,
              message,
              news,
              cf_token,
            };

            let link = window.pg_global.root + parts.root + '/v1/' + parts.type + '/contact_us';

            jQuery.ajax({
              type: 'POST',
              data: JSON.stringify(payload),
              contentType: 'application/json; charset=utf-8',
              dataType: 'json',
              url: link,
            }).done(function (data) {
              $('#contact-submit-spinner').hide()
              $('#form-content').hide()
              $('#form-confirm').show()
            })
            .fail(function (e) {
              const message = e.responseJSON?.message || 'There was an error submitting your form. Please try again.';
              $('#form-error-section').text(message);
              $('#contact-submit-spinner').hide()
            })
          }
        </script>
        <!-- END section -->
        <?php require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . '/assets/working-footer.php' ) ?>
        <?php
    }

    public function enqueue_scripts(){
        $cloudflare_site_key = get_option( 'dt_cloudflare_site_key', '' );
        if ( !empty( $cloudflare_site_key ) ){
            wp_enqueue_script( 'cloudflare-turnstile', 'https://challenges.cloudflare.com/turnstile/v0/api.js', [], null, [ 'strategy' => 'defer' ] );
        }
    }
}

Prayer_Global_Porch_Contact_Us::instance();
