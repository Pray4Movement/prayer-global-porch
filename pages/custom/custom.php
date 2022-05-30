<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.


/**
 * Class Prayer_Global_Laps_Custom_Link
 */
class Prayer_Global_Laps_Custom_Link extends DT_Magic_Url_Base {

    public $magic = false;
//    public $parts = false;
    public $page_title = 'Custom Lap';
    public $page_description = 'Prayer Laps';
    public $root = "prayer_app";
    public $type = 'custom';
    public $post_type = 'laps';
    private $meta_key = '';
    public $show_bulk_send = false;
    public $show_app_tile = true;

    private static $_instance = null;
    public $meta = []; // Allows for instance specific data.

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct() {

        $this->meta_key = $this->root . '_' . $this->type . '_magic_key';
        parent::__construct();

        /**
         * post type and module section
         */
        add_filter( 'dt_settings_apps_list', [ $this, 'dt_settings_apps_list' ], 10, 1 );

        if ( dt_is_rest() ) {
            add_action( 'rest_api_init', [ $this, 'add_endpoints' ] );
        }

        /**
         * tests if other URL
         */
        $url = dt_get_url_path();
        if ( strpos( $url, $this->root . '/' . $this->type ) === false ) {
            return;
        }
        /**
         * tests magic link parts are registered and have valid elements
         */
        if ( !$this->check_parts_match() ){
            wp_redirect( site_url() );
            exit;
        }

        $completed = get_post_meta( $this->parts['post_id'],  'end_time', true );
        if ( $completed ) {
            add_action( 'dt_blank_body', [ $this, 'completed_body' ] );
        } else {
            add_action( 'dt_blank_body', [ $this, 'body' ] );
        }

        add_filter( 'dt_magic_url_base_allowed_css', [ $this, 'dt_magic_url_base_allowed_css' ], 10, 1 );
        add_filter( 'dt_magic_url_base_allowed_js', [ $this, 'dt_magic_url_base_allowed_js' ], 10, 1 );
    }

    public function dt_magic_url_base_allowed_js( $allowed_js ) {
        return [];
    }

    public function dt_magic_url_base_allowed_css( $allowed_css ) {
        return [];
    }

    public function dt_settings_apps_list( $apps_list )
    {
        $apps_list[$this->meta_key] = [
            'key' => $this->meta_key,
            'url_base' => $this->root . '/' . $this->type,
            'label' => $this->page_title,
            'description' => $this->page_description,
            'settings_display' => false
        ];

        return $apps_list;
    }

    public function header_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/header.php' );

        $completed = get_post_meta( $this->parts['post_id'],  'end_time', true );
        if ( ! $completed ) {
            ?>
            <script src="<?php echo esc_url( trailingslashit( plugin_dir_url( __FILE__ ) ) ) ?>prayer.js?ver=<?php echo fileatime( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'prayer.js' ) ?>"></script>
            <script>
                let jsObject = [<?php echo json_encode([
                    'map_key' => DT_Mapbox_API::get_key(),
                    'mirror_url' => dt_get_location_grid_mirror( true ),
                    'ipstack' => DT_Ipstack_API::get_key(),
                    'root' => esc_url_raw( rest_url() ),
                    'nonce' => wp_create_nonce( 'wp_rest' ),
                    'parts' => $this->parts,
                    'current_lap' => pg_current_global_lap(),
                    'translations' => [
                        'add' => __( 'Add Magic', 'prayer-global' ),
                    ],
                    'start_content' => $this->get_new_location( $this->parts ),
                    'next_content' => $this->get_new_location( $this->parts ),
                ]) ?>][0]
            </script>
            <script type="text/javascript" src="<?php echo DT_Mapbox_API::$mapbox_gl_js ?>"></script>
            <link rel="stylesheet" href="<?php echo DT_Mapbox_API::$mapbox_gl_css ?>" type="text/css" media="all">
            <?php
        }

    }

    public function footer_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/footer.php' );
    }

    public function body(){
        DT_Mapbox_API::geocoder_scripts();
        require_once( 'body.php' );
    }

    public function completed_body(){
        require_once( 'custom-completed-body.php' );
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
            return new WP_Error( __METHOD__, "Missing parameters", [ 'status' => 400 ] );
        }

        $params = dt_recursive_sanitize_array( $params );

        switch( $params['action'] ) {
            case 'log':
                $result = $this->save_log( $params['parts'], $params['data'] );
                return $result;
            case 'refresh':
                return $this->get_new_location( $params['parts']['post_id'] );
            default:
                return new WP_Error( __METHOD__, "Incorrect action", [ 'status' => 400 ] );
        }
    }

    public function save_log( $parts, $data ) {

        if ( !isset( $parts['post_id'], $parts['root'], $parts['type'], $data['grid_id'] ) ) {
            return new WP_Error( __METHOD__, "Missing parameters", [ 'status' => 400 ] );
        }

        $args = [
            'post_id' => $parts['post_id'],
            'post_type' => 'laps',
            'type' => $parts['root'],
            'subtype' => $parts['type'],
            'payload' => null,
            'value' => $data['pace'] ?? 1,
            'grid_id' => $data['grid_id'],
        ];
        if ( is_user_logged_in() ) {
            $args['user_id'] = get_current_user_id();
        }
        $id = dt_report_insert( $args, false );

        return $this->get_new_location( $parts );
    }

    /**
     * Custom query
     * @param $post_id
     * @return array|false|void
     */
    public function get_new_location( $parts ) {
        $post_id = $parts['post_id'];
        $public_key = $parts['public_key'];

        // get 4770 list
        $list_4770 = pg_query_4770_locations();

        // subtract prayed places
        $list_prayed = $this->_query_prayed_list( $post_id );
        if ( ! empty( $list_prayed ) ) {
            foreach( $list_prayed as $grid_id ) {
                if ( isset( $list_4770[$grid_id] ) ) {
                    unset( $list_4770[$grid_id] );
                }
            }
        }

        if ( empty( $list_4770 ) ) {
            $time = time();
            $date = date( 'Y-m-d H:m:s', time() );
            DT_Posts::update_post('laps', $post_id, [ 'status' => 'complete', 'end_date' => $date, 'end_time' => $time ], false, false );
            if ( dt_is_rest() ) { // signal new lap to rest request
                return false;
            } else { // if first load on finished lap, redirect to new lap
                wp_redirect( '/prayer_app/custom/'.$public_key );
                exit;
            }
        }

        if ( count( $list_4770 ) > 20 ) { // turn off shuffle for the last few records
            shuffle( $list_4770 );
        } else {
            sort( $list_4770 );
        }
        $grid_id = $list_4770[0];

        // checks global list and finds an id that has not been prayer for by either custom or global.
        // else it goes with the custom selected grid_id above

        $global_list_prayed = Prayer_Global_Prayer_App::instance()->_query_prayed_list(); // positive list of global locations prayed for
        if ( ! empty( $global_list_prayed ) && in_array( $grid_id, $global_list_prayed ) /* in_array means the global list has already prayed for this location */ ) {
            foreach( $list_4770 as $index => $custom_grid_id ) {
                if ( ! isset( $global_list_prayed[$custom_grid_id] ) ) {
                    $grid_id = $list_4770[$index];
                }
            }
        }

        $content = PG_Stacker::build_location_stack( $grid_id );
        return $content;
    }

    public function _query_prayed_list( $post_id ) {

        global $wpdb;
        $raw_list = $wpdb->get_col( $wpdb->prepare(
            "SELECT DISTINCT grid_id
                    FROM $wpdb->dt_reports
                    WHERE post_id = %d
                      AND type = 'prayer_app'
                      AND subtype = 'custom';"
            , $post_id ) );

        $list = [];
        if ( ! empty( $raw_list) ) {
            foreach( $raw_list as $item ) {
                $list[$item] = $item;
            }
        }

        return $list;
    }
}
Prayer_Global_Laps_Custom_Link::instance();