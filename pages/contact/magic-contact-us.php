<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

class Prayer_Global_Porch_Contact_Us extends DT_Magic_Url_Base
{
    public $magic = false;
    public $parts = false;
    public $page_title = 'Global Prayer - Contact Us';
    public $root = 'prayer_app';
    public $type = 'contact_us';
    public $type_name = 'Global Prayer - Contact Us';
    public static $token = 'prayer_app';
    public $post_type = 'groups';

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
        if ( ( $this->root . '/' . $this->type ) === $url ) {

            $this->magic = new DT_Magic_URL( $this->root );
            $this->parts = $this->magic->parse_url_parts();


            // register url and access
            add_action( "template_redirect", [ $this, 'theme_redirect' ] );
            add_filter( 'dt_blank_access', function (){ return true;
            }, 100, 1 );
            add_filter( 'dt_allow_non_login_access', function (){ return true;
            }, 100, 1 );
            add_filter( 'dt_override_header_meta', function (){ return true;
            }, 100, 1 );

            // header content
            add_filter( "dt_blank_title", [ $this, "page_tab_title" ] ); // adds basic title to browser tab
            add_action( 'wp_print_scripts', [ $this, 'print_scripts' ], 1500 ); // authorizes scripts
            add_action( 'wp_print_styles', [ $this, 'print_styles' ], 1500 ); // authorizes styles


            // page content
            add_action( 'dt_blank_head', [ $this, '_header' ] );
            add_action( 'dt_blank_footer', [ $this, '_footer' ] );
            add_action( 'dt_blank_body', [ $this, 'body' ] ); // body for no post key

            add_filter( 'dt_magic_url_base_allowed_css', [ $this, 'dt_magic_url_base_allowed_css' ], 10, 1 );
            add_filter( 'dt_magic_url_base_allowed_js', [ $this, 'dt_magic_url_base_allowed_js' ], 10, 1 );
        }

    }

    public function dt_magic_url_base_allowed_js( $allowed_js ) {
        return [];
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

        <section class="page-section mt-5" data-section="about" id="section-about">
            <div class="container">
                <div class="row justify-content-md-center text-center mb-5">
                    <div class="col-lg-7">
                        <h2 class="mt-0 pb-3 header-border-top font-weight-normal"><?php echo esc_html__( 'Contact Us', 'prayer-global-porch' ) ?></h2>
                        <p>
                            <?php echo esc_html( __( 'First, thank you for reaching out.', 'prayer-global-porch' ) ) ?>
                        </p>
                        <p>
                            <?php echo esc_html( __( "Second, we're a group of volunteers striving to see the Great Commission fulfilled in this generation ... and we also have other jobs ... so be patient as we get back to you!", 'prayer-global-porch' ) ) ?>
                        </p>
                    </div>
                </div>
                <div class="row justify-content-md-center text-center mb-5">
                    <div class="col-lg-7">
                        <p>
                            <iframe src="https://pray4movement.org/wp-content/plugins/disciple-tools-webform/public/form.php?token=d21730a05ffbbc372eb9e58f58e56ee7" style="width:100%;height:800px;" frameborder="0"></iframe>
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <!-- END section -->
        <?php require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . '/assets/working-footer.php' ) ?>
        <?php
    }
}
Prayer_Global_Porch_Contact_Us::instance();
