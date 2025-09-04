<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

class Prayer_Global_Porch_Home2 extends DT_Magic_Url_Base
{
    public $magic = false;
    public $parts = false;
    public $page_title = 'Prayer.Global';
    public $root = 'prayer_global';
    public $type = 'porch';
    public static $token = 'prayer_global_porch';

    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'wp_enqueue_scripts' ], 100 );
        parent::__construct();

        $url = dt_get_url_path( true );
        if ( $url === 'new-home' && ! dt_is_rest() ) {

            /* If the user is logged in, and the url doesn't contain the internal=true query param then redirect to the dashboard */
/*             $url = new DT_URL( site_url( dt_get_url_path( false, true ) ) );
            if ( is_user_logged_in() && ! $url->query_params->has( 'internal' ) ) {
                wp_redirect( home_url( '/dashboard' ) );
                exit;
            } */

            add_filter( 'dt_override_header_meta', function (){ return true;
            }, 100, 1 );

            // register url and access
            add_action( 'template_redirect', [ $this, 'theme_redirect' ] );
            add_filter( 'dt_blank_access', function (){ return true;
            }, 100, 1 ); // allows non-logged in visit
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
            add_action( 'dt_blank_body', [ $this, 'body' ] );
            add_filter( 'dt_templates_for_urls', [ $this, 'register_url' ], 199, 1 ); // registers url as valid once tests are passed

            add_filter( 'dt_magic_url_base_allowed_css', [ $this, 'dt_magic_url_base_allowed_css' ], 10, 1 );
            add_filter( 'dt_magic_url_base_allowed_js', [ $this, 'dt_magic_url_base_allowed_js' ], 10, 1 );

        }
        else if ( dt_is_rest() ) {
            add_action( 'rest_api_init', [ $this, 'add_endpoints' ] );
        }
    }

    public function wp_enqueue_scripts() {}

    public function register_url( $template_for_url ){
        $url = dt_get_url_path( true );
        $url_parts = explode( '/', $url );
        $template_for_url[join( '/', $url_parts )] = 'template-blank.php';
        return $template_for_url;
    }

    public function dt_magic_url_base_allowed_js( $allowed_js ) {
        return $allowed_js;
    }

    public function dt_magic_url_base_allowed_css( $allowed_css ) {
        return $allowed_css;
    }

    public function header_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/header.php' );
    }

    public function footer_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/footer.php' );
        ?>

        <script>
        let jsObject = [<?php echo json_encode([
            'parts' => [
                'type' => $this->type,
                'root' => $this->root,
            ],
            'image_folder' => plugin_dir_url( __DIR__ ) . 'assets/images/',
        ]) ?>][0]

          window.addEventListener('load', function() {

            window.api_post = ( action, data ) => {
              return jQuery.ajax({
                type: "POST",
                data: JSON.stringify({ action: action, parts: jsObject.parts, data: data }),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                url: window.pg_global.root + jsObject.parts.root + '/v1/' + jsObject.parts.type,
              })
              .fail(function(e) {
                console.log(e)
              })
            }

            window.api_post( 'get_stats', {} )
            .done(function(stats) {
              jQuery('#global-lap-percentage').html(Math.round(Number(stats.current_completed.replace(',', '')) / 4770 * 100) + '%')
              jQuery('#global-intercessors').html(stats.global_participants )
              jQuery('#global-laps-completed').html( Number(stats.global_lap_number) )
            })

          })
        </script>
        <?php
    }

    public function body(){
        require_once( 'body2.php' );
    }

    public function add_endpoints() {
        $namespace = $this->root . '/v1';
        register_rest_route(
            $namespace,
            '/'.$this->type,
            [
                [
                    'methods'  => WP_REST_Server::CREATABLE,
                    'callback' => [ $this, 'endpoint' ],
                    'permission_callback' => '__return_true'
                ],
            ]
        );
    }

    public function endpoint( WP_REST_Request $request ) {
        $params = $request->get_params();

        if ( ! isset( $params['parts'], $params['action'], $params['data'] ) ) {
            return new WP_Error( __METHOD__, 'Missing parameters', [ 'status' => 400 ] );
        }

        $data = get_transient( 'pg_home_stats' );
        if ( !empty( $data ) ) {
            return $data;
        }

        $current_global_stats = Prayer_Stats::get_relay_current_lap_stats( '49ba4c' );
        $relay_id = pg_get_relay_id( '49ba4c' );
        $global_race = Prayer_Stats::stats_since_start_of_relay( $relay_id );

        $data = [
            'current_time_elapsed' => $current_global_stats['time_elapsed'],
            'current_time_elapsed_data' => $current_global_stats['time_elapsed_data'],
            'current_participants' => $current_global_stats['participants'],
            'current_completed' => $current_global_stats['completed'],
            'current_remaining' => $current_global_stats['remaining'],
            'global_time_elapsed' => $global_race['time_elapsed'],
            'global_time_elapsed_data' => $global_race['time_elapsed_data'],
            'global_participants' => $global_race['participants'],
            'global_minutes_prayed' => $global_race['minutes_prayed'],
            'global_lap_number' => (int) $global_race['lap_number'] - 1,
            'race' => $global_race
        ];
        set_transient( 'pg_home_stats', $data, 5 * MINUTE_IN_SECONDS );
        return $data;
    }
}
Prayer_Global_Porch_Home2::instance();
