<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

require_once( 'trait-lap.php' );
/**
 * Class Prayer_Global_Prayer_App
 */
class PG_Global_Prayer_App_Lap extends PG_Global_Prayer_App {

    use PG_Lap_Trait;

    public $lap_title;

    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct() {
        parent::__construct();

        // must be valid url
        $url = dt_get_url_path();
        if ( strpos( $url, $this->root . '/' . $this->type ) === false ) {
            return;
        }

        // must be valid parts
        if ( !$this->check_parts_match() ){
            return;
        }

        // has empty action, of stop
        if ( !empty( $this->parts['action'] ) ) {
            return;
        }

        add_action( 'dt_blank_body', [ $this, 'body' ] );

        $this->lap_title = 'Global';

        add_filter( 'dt_magic_url_base_allowed_css', [ $this, 'dt_magic_url_base_allowed_css' ], 10, 1 );
        add_filter( 'dt_magic_url_base_allowed_js', [ $this, 'dt_magic_url_base_allowed_js' ], 200, 1 );
        add_action( 'wp_enqueue_scripts', [ $this, 'wp_enqueue_scripts' ], 100 );
    }
    public function _header() {
        $this->header_style();
        $this->header_javascript();
    }
    public function _footer(){
        $this->footer_javascript();
    }

    /**
     * Register REST Endpoints
     * @link https://github.com/DiscipleTools/disciple-tools-theme/wiki/Site-to-Site-Link for outside of wordpress authentication
     */
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
        $params = pg_get_body_params( $request );

        if ( ! isset( $params['parts'], $params['action'], $params['data'] ) ) {
            return new WP_Error( __METHOD__, 'Missing parameters', [ 'status' => 400 ] );
        }

        $params = dt_recursive_sanitize_array( $params );

        switch ( $params['action'] ) {
            case 'increment_prayer_time':
                return $this->increment_prayer_time( $params['parts'], $params['data'] );
            case 'correction':
                return $this->save_correction( $params['parts'], $params['data'] );
            case 'ip_location':
                return $this->get_ip_location();
            default:
                return new WP_Error( __METHOD__, 'Incorrect action', [ 'status' => 400 ] );
        }
    }
}
PG_Global_Prayer_App_Lap::instance();
