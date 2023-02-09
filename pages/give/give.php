<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

class Prayer_Global_Give extends DT_Magic_Url_Base
{
    public $magic = false;
    public $parts = false;
    public $page_title = 'Global Prayer - Give';
    public $root = 'content_app';
    public $type = 'give_page';
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
        ?>
        <link href="https://fonts.googleapis.com/css?family=Crimson+Text:400,400i,600|Montserrat:200,300,400" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>assets/fonts/ionicons/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>assets/css/basic.css?ver=<?php echo esc_attr( fileatime( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/css/basic.css' ) ) ?>" type="text/css" media="all">
        <?php
    }

    public function footer_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/footer.php' );
    }

    public function body(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . '/assets/nav.php' ) ?>

        <section class="page-section mt-5" data-section="give" id="section-give">
            <div class="container flow">
                <div class="row justify-content-md-center text-center mb-5 flow-small">
                    <h2 class="header-border-top">Giving to Prayer.Global</h2>

                    <p>
                        Thank you for wanting to be part of seeing the Kingdom grow through prayer and movements.
                        Your gift ensures that we can continue to freely give away all of the tools and resources we develop.
                        Your tax deductible donation will go to the development and maintenance of Prayer.Global which is part of the <a href="https://pray4movement.org" target="_blank">Pray4Movement</a> network.
                    </p>
                </div>
                <div class="row justify-content-md-center text-center flow-small">
                    <h3>Check</h3>

                    <p class="bg-warning p-2" style="--bs-bg-opacity: 0.3"><strong>Note:</strong> If you’d like to avoid the 3% fee that credit card companies charge everyone, you can send tax deductible donations via check to:</p>

                    <p>
                        Pray4Movement <br>
                        c/o Gospel Ambition <br>
                        PO Box 325 <br>
                        Mooreland OK 73852
                    </p>
                </div>

                <div class="row justify-content-md-center text-center flow-small">
                    <h3>Credit/Debit Card</h3>

                    <?php echo do_shortcode( '[stripe]' ) ?>

                    <p class="bg-warning p-2" style="--bs-bg-opacity: 0.3">
                        <strong>Note:</strong> Prayer.Global and by extension Pray4Movement.org is part of <a href="https://gospelambition.org" target="_blank" rel="noopener">Gospel Ambition</a>. You may see Gospel Ambition on your invoice or receipt.
                    </p>

                </div>

            </div>
        </section>

        <?php require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . '/assets/working-footer.php' ) ?>
        <?php
    }

}
Prayer_Global_Give::instance();

