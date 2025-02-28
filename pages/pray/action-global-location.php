<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

require_once( 'trait-lap.php' );
/**
 * Class Prayer_Global_Prayer_App
 */
class PG_Global_Prayer_App_Location extends PG_Global_Prayer_App {

    use PG_Lap_Trait;

    public $grid_id;
    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct() {
        parent::__construct();

        $grid_id = isset( $_GET['grid_id'] ) ? sanitize_text_field( wp_unslash( $_GET['grid_id'] ) ) : null;
        $this->grid_id = $grid_id;

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
        if ( !$this->validate_action( $this->parts['action'] ) ) {
            return;
        }

        /**
         * post type and module section
         */
        $this->if_rest_add_actions();

        add_action( 'dt_blank_body', [ $this, 'body' ] );
        add_filter( 'dt_magic_url_base_allowed_css', [ $this, 'dt_magic_url_base_allowed_css' ], 10, 1 );
        add_filter( 'dt_magic_url_base_allowed_js', [ $this, 'dt_magic_url_base_allowed_js' ], 200, 1 );
        add_action( 'wp_enqueue_scripts', [ $this, 'wp_enqueue_scripts' ], 100 );

        add_action( 'disciple_tools_loaded', [ $this, 'disciple_tools_loaded' ] );
    }

    public function disciple_tools_loaded(){
        // redirect to completed if not current global lap
        $status = get_post_meta( $this->parts['post_id'], 'status', true );
        if ( $status === 'complete' ) {
            wp_redirect( trailingslashit( site_url() ) . $this->root . '/' . $this->type . '/' . $this->parts['public_key'] . '/completed' );
            exit;
        }
    }


    public function _header() {
        $this->header_style();
        $this->header_javascript();
    }
    public function _footer(){
        $this->footer_javascript();
    }

    public function if_rest_add_actions() {
        if ( dt_is_rest() ) {
            add_action( 'rest_api_init', [ $this, 'add_endpoints' ] );
        }
    }

//    public function wp_enqueue_scripts(){
//        pg_enqueue_script( 'report-js', 'pages/pray/report.js', [ 'jquery', 'global-functions' ], true );
//        pg_enqueue_script( 'lap-js', 'pages/pray/lap.js', [ 'jquery', 'global-functions', 'report-js' ], true );
//    }

    public function validate_action( $action ) {
        if ( 'location' === $action && $this->is_valid_grid_id( $this->grid_id ) ) {
            return true;
        }
        add_filter( 'dt_blank_access', function() { return false;
        } );
        return false;
    }

    public function is_valid_grid_id( $grid_id ) {
        global $wpdb;

        $grid_id = intval( $grid_id );

        if ( !$grid_id ) {
            return false;
        }

        $location = $wpdb->get_row( $wpdb->prepare( "
            SELECT * FROM $wpdb->dt_location_grid
            WHERE grid_id = %d
        ", $grid_id ) );

        if ( !$location ) {
            return false;
        }

        return true;
    }

    public function question_buttons() {
        ?>

        <button type="button" class="btn btn-primary question" id="question__yes_done"><?php echo esc_html__( 'Done', 'prayer-global-porch' ) ?></button>

        <?php
    }

    public function decision_buttons() {
        ?>

        <button type="button" class="btn btn-primary decision" id="decision__leave"><?php echo esc_html__( 'Leave', 'prayer-global-porch' ) ?></button>

        <?php
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
        $params = $request->get_params();

        if ( ! isset( $params['parts'], $params['action'], $params['data'] ) ) {
            return new WP_Error( __METHOD__, 'Missing parameters', [ 'status' => 400 ] );
        }

        $params = dt_recursive_sanitize_array( $params );

        switch ( $params['action'] ) {
            case 'increment_prayer_time':
                return $this->increment_prayer_time( $params['parts'], $params['data'] );
            case 'correction':
                return $this->save_correction( $params['parts'], $params['data'] );
            default:
                return new WP_Error( __METHOD__, 'Incorrect action', [ 'status' => 400 ] );
        }
    }
}
PG_Global_Prayer_App_Location::instance();
