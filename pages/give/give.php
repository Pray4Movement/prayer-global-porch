<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.


class Prayer_Global_Give extends DT_Magic_Url_Base {
    public $magic = false;
    public $parts = false;
    public $page_title = 'Global Prayer - Give';
    public $root = 'give';
    public $type = '';
    public $type_name = 'Global Prayer - Give';
    public static $token = 'content_app_give';
    public $post_type = 'laps';

    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct() {
        parent::__construct();

        $url = dt_get_url_path();
        if ( ( $this->root ) === $url ) {

            $this->magic = new DT_Magic_URL( $this->root );
            $this->parts = $this->magic->parse_url_parts();


            // register url and access
            add_action( 'template_redirect', [ $this, 'theme_redirect' ] );
            add_filter( 'dt_blank_access', function (){ return true;
            }, 100, 1 );
            add_filter( 'dt_allow_non_login_access', function (){ return true;
            }, 100, 1 );
            add_filter( 'dt_override_header_meta', function (){ return true;
            }, 100, 1 );

            // header content
            add_filter( 'dt_blank_title', [ $this, 'page_tab_title' ] ); // adds basic title to browser tab
            add_action( 'wp_print_scripts', [ $this, 'print_scripts' ], 1500 ); // authorizes scripts
            add_action( 'wp_print_styles', [ $this, 'print_styles' ], 1500 ); // authorizes styles


            // page content
            add_action( 'dt_blank_head', [ $this, '_header' ] );
            add_action( 'dt_blank_footer', [ $this, '_footer' ] );
            add_action( 'dt_blank_body', [ $this, 'body' ] ); // body for no post key

            add_filter( 'dt_magic_url_base_allowed_css', [ $this, 'dt_magic_url_base_allowed_css' ], 10, 1 );
            add_filter( 'dt_magic_url_base_allowed_js', [ $this, 'dt_magic_url_base_allowed_js' ], 10, 1 );

            add_filter( 'dt_allow_rest_access', [ $this, 'authorize_url' ], 10, 1 );
        }
    }

    public function authorize_url( $authorized ){

        $url = 'go-stripe/v1/pay';
        if ( isset( $_SERVER['REQUEST_URI'] ) &&
            strpos( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ), $url ) !== false ) {
            $authorized = true;
        }

        return $authorized;
    }



    public function dt_magic_url_base_allowed_js( $allowed_js ) {
        return array_merge( $allowed_js, [
            'stripe',
            'fetch',
            'jquery',
            'client-stripe-js',
        ] );
    }

    public function dt_magic_url_base_allowed_css( $allowed_css ) {
        return [];
    }

    public function header_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/header.php' );
    }

    public function footer_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/footer.php' );
    }

    public function body(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . '/assets/nav.php' ) ?>

        <section class="page" data-section="give" id="section-give">
            <div class="container flow">
                <div class="row justify-content-md-center text-center mb-5 flow-small">
                    <div class="col col-md-8">
                        <h2 class=""><?php echo esc_html( __( 'Give', 'prayer-global-porch' ) ) ?></h2>
                        <i class="icon pg-give icon-large brand-light"></i>
                        <h4><?php echo esc_html( __( 'To Prayer.Global', 'prayer-global-porch' ) ) ?></h4>
                        <p>
                            <?php echo sprintf( esc_html__( 'Thank you for wanting to be part of seeing the Kingdom grow through prayer and movements. Your gift ensures that we can continue to freely give away all of the tools and resources we develop. Your tax deductible donation will go to the development and maintenance of %1$s which is part of the %2$s network.', 'prayer-global-porch' ), "<a href='https://pray4movement.org' target='_blank'>Pray4Movement</a>", 'Prayer.Global' ) ?>
                        </p>
                    </div>
                </div>

                <div class="row justify-content-md-center text-center flow-small brand-bg white py-4">
                    <div class="col col-md-8">
                    <h4><?php echo esc_html( __( 'Give Online', 'prayer-global-porch' ) ) ?></h4>

                        <!--spinner-->
                        <div id="give-loading-spinner" class="text-center" style="padding-top: 50px">
                            <div class="spinner-border text-light" role="status"></div>
                        </div>

                        <iframe height="650"
                                src="https://axiainternational.net/embed/giving/231-0312MYK" width="100%" id="givingWidget231-0312MYK"
                                style="border: none" scrolling="no"
                                onload="document.querySelector('#give-loading-spinner').remove()"
                        ></iframe>
                        <script>window.addEventListener("message", function (event) {if (event.origin ==='https://axiainternational.net' && (typeof event.data == "number" || typeof event.data == "string")) {
                          document.getElementById("givingWidget231-0312MYK").height = event.data;
                        }});</script>

                    </div>
                </div>

                <div class="row justify-content-md-center text-center">
                    <div class="col col-md-8">
                        <h4><?php echo esc_html( __( 'Give by Check', 'prayer-global-porch' ) ) ?></h4>
                        <p>
                            <strong><?php echo esc_html( __( 'Note:', 'prayer-global-porch' ) ) ?></strong> <?php echo esc_html( __( "If you'd like to avoid the 3% fee that credit card companies charge everyone, you can send tax deductible donations via check to:", 'prayer-global-porch' ) ) ?>
                        </p>
                        <p class="font-weight-bold">
                            Prayer.Global <br>
                            c/o Gospel Ambition <br>
                            PO Box 325 <br>
                            Mooreland OK 73852
                        </p>
                    </div>
                </div>

                <div class="row justify-content-md-center text-center flow-small brand-light-bg white">
                    <div class="col col-md-8">
                        <p class="m-5">
                            <strong><?php echo esc_html( __( 'Note:', 'prayer-global-porch' ) ) ?></strong> <?php echo sprintf( esc_html__( '%1$s and by extension %2$s is part of %3$s. You may see %4$s on your invoice or receipt.', 'prayer-global-porch' ), 'Prayer.Global', 'Pray4Movement.org', '<a class="link-light" href="https://gospelambition.org" target="_blank" rel="noopener">Gospel Ambition</a>', 'Gospel Ambition' ) ?>
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <?php require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . '/assets/working-footer.php' ) ?>
        <?php
    }
}
Prayer_Global_Give::instance();
