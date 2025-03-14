<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

class Prayer_Global_Porch_Challenge_List extends DT_Magic_Url_Base
{
    public $magic = false;
    public $parts = false;
    public $page_title = 'Active Relays';
    public $root = 'challenges';
    public $type = 'active';
    public $type_name = 'Active Relays';
    public static $token = 'custom_app_lists';
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

        $url = dt_get_url_path( true );
        if ( ( $this->root . '/' . $this->type ) === $url ) {

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

            // page content
            add_action( 'dt_blank_head', [ $this, '_header' ] );
            add_action( 'dt_blank_body', [ $this, 'body' ] ); // body for no post key

            add_filter( 'dt_magic_url_base_allowed_js', [ $this, 'dt_magic_url_base_allowed_js' ], 10, 1 );
            add_filter( 'dt_magic_url_base_allowed_css', [ $this, 'dt_magic_url_base_allowed_css' ], 10, 1 );

            add_action( 'wp_enqueue_scripts', [ $this, 'wp_enqueue_scripts' ], 100 );

            add_filter( 'dt_override_header_meta', function (){ return true;
            }, 100, 1 );
        }

        if ( dt_is_rest() ) {
            add_action( 'rest_api_init', [ $this, 'add_endpoints' ] );
            add_filter( 'dt_allow_rest_access', [ $this, 'authorize_url' ], 10, 1 );
        }
    }

    public function dt_magic_url_base_allowed_js( $allowed_js ) {
        $allowed_js = [];
        $allowed_js[] = 'active-list-js';
        $allowed_js[] = 'datatables';
        return $allowed_js;
    }

    public function dt_magic_url_base_allowed_css( $allowed_css ) {
        return [];
    }

    public function wp_enqueue_scripts(){
        $lang = pg_get_current_lang();
        $enabled_langs = pg_enabled_translations();


        pg_enqueue_script( 'active-list-js', 'pages/challenges/active-list.js', [ 'jquery', 'global-functions' ], true );
        wp_localize_script( 'active-list-js', 'pg_active_list', [
            'translations' => [
                'pray' => esc_html( __( 'Pray', 'prayer-global-porch' ) ),
                'map' => esc_html( __( 'Map', 'prayer-global-porch' ) ),
                'sharing' => esc_html( __( 'Sharing', 'prayer-global-porch' ) ),
                'display' => esc_html( __( 'Display', 'prayer-global-porch' ) ),
                'name' => esc_html( __( 'Name', 'prayer-global-porch' ) ),
                'intercessors' => esc_html( __( 'Intercessors', 'prayer-global-porch' ) ),
                'time_elapsed' => esc_html( __( 'Time Elapsed', 'prayer-global-porch' ) ),
                'links' => esc_html( __( 'Links', 'prayer-global-porch' ) ),
                'lap' => esc_html( __( '- Lap %d', 'prayer-global-porch' ) ),
            ],
            'is_rolling_laps_feature_on' => true,
            'api_url' => PG_API_ENDPOINT,
            'parts' => $this->parts,
            'nope' => plugin_dir_url( __DIR__ ) . 'assets/images/nope.jpg',
            'images_url' => pg_grid_image_url(),
            'image_folder' => plugin_dir_url( __DIR__ ) . 'assets/images/',
            'datatable_translations' => $enabled_langs[$lang]['datatables_url'] ?? ''
        ] );
        wp_enqueue_script( 'datatables', 'https://cdn.datatables.net/v/dt/dt-1.12.1/r-2.3.0/datatables.min.js', [ 'active-list-js' ], '4.0.1', true );
    }


    public function header_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/header.php' );
        ?>
        <link rel="stylesheet" href="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>assets/css/basic.css?ver=<?php echo esc_attr( fileatime( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/css/basic.css' ) ) ?>" type="text/css" media="all">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.12.1/r-2.3.0/datatables.min.css"/>
        <?php
    }

    public function footer_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/footer.php' );
    }

    public function body(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . '/assets/nav.php' );
        ?>
        <!-- content section -->
        <style>
            .challenge-cell {
                cursor:pointer;
            }
            .challenge-row:hover{
                background-color: #f9f9f9;
            }
            .dataTables_wrapper {
                margin: 2em 0;
            }
        </style>
        <section class="brand-light text-center page flow-medium">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class=""><?php echo esc_html( __( 'Prayer Relays', 'prayer-global-porch' ) ) ?></h2>
                        <i class="icon pg-relay icon-large"></i>
                    </div>
                    <div class="col-md-3"></div>
                    <div class="col-md-6 mt-4">
                    <p><?php echo esc_html( __( 'Prayer Relays are communities of prayer intercessors who have picked up the challenge of praying for the entire world as a group. All prayers prayed in the prayer relays contribute to the global laps.', 'prayer-global-porch' ) ) ?></p>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md text-center brand-bg white py-4">
                        <h4><?php echo esc_html__( 'Want to create your own Prayer Relay?', 'prayer-global-porch' ) ?></h4>
                        <a class="btn btn-cta two-rem has-icon cta-blue px-5 mt-4" href="/login">
                            <?php echo esc_html( is_user_logged_in() ? __( 'Profile', 'prayer-global-porch' ) : __( 'Login', 'prayer-global-porch' ) ) ?>
                            <i class="icon pg-chevron-right icon-end two-rem end-0 me-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            <section class="flow-small contain bg-top" style="background-image: url(<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>assets/images/map-lightblue-transparent.png);">
                <i class="icon pg-relay icon-medium d-block"></i>
                <h4 class="uppercase font-base"><?php echo esc_html( __( 'Active Relays', 'prayer-global-porch' ) ) ?></h4>
                <div class="container data-table uppercase" id="active_content"><span class="loading-spinner active"></span></div>
            </section>
            <section class="brand-lighter flow-small contain bg-top" style="background-image: url(<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>assets/images/map-lightblue-transparent.png);">
                <i class="icon pg-crown icon-medium d-block"></i>
                <h4 class="uppercase font-base"><?php echo esc_html( __( 'Completed Relays', 'prayer-global-porch' ) ) ?></h4>
                <div class="container data-table uppercase" id="complete_content"><span class="loading-spinner active"></span></div>
            </section>
        </section>

        <?php require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . '/assets/working-footer.php' ) ?>
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
                ],
            ]
        );
    }

    public function endpoint( WP_REST_Request $request ) {
        $params = $request->get_params();

        if ( ! isset( $params['parts'], $params['action'] ) ) {
            return new WP_Error( __METHOD__, 'Missing parameters', [ 'status' => 400 ] );
        }

        switch ( $params['action'] ) {
            case 'get_global_list':
                return $this->get_active_list();
        }

        return false;
    }

    public function get_active_list(){
        global $wpdb;

        $data = [];

        $results = $wpdb->get_results(
            "   SELECT
                    p.post_title,
                    pm.post_id,
                    pm2.meta_value as status,
                    pm3.meta_value as lap_key,
                    pm4.meta_value as start_time,
                    pm6.meta_value as lap_number,
                    pm7.meta_value as single_lap,
                    pm8.meta_value as event_lap
                FROM $wpdb->posts p
                JOIN $wpdb->postmeta pm ON pm.post_id=p.ID AND pm.meta_key = 'type' AND pm.meta_value = 'custom'
                LEFT JOIN $wpdb->postmeta pm2 ON pm2.post_id=p.ID AND pm2.meta_key = 'status'
                LEFT JOIN $wpdb->postmeta pm3 ON pm3.post_id=p.ID AND pm3.meta_key = 'prayer_app_custom_magic_key'
                LEFT JOIN $wpdb->postmeta pm4 ON pm4.post_id=p.ID AND pm4.meta_key = 'start_time'
                LEFT JOIN $wpdb->postmeta pm5 ON pm5.post_id=p.ID AND pm5.meta_key = 'visibility'
                LEFT JOIN $wpdb->postmeta pm6 ON pm6.post_id=p.ID AND pm6.meta_key = 'global_lap_number'
                LEFT JOIN $wpdb->postmeta pm7 ON pm7.post_id=p.ID AND pm7.meta_key = 'single_lap'
                LEFT JOIN $wpdb->postmeta pm8 ON pm8.post_id=p.ID AND pm8.meta_key = 'event_lap'
                WHERE p.post_type = 'pg_relays'
                AND ( pm5.meta_value = 'public' OR pm5.meta_value IS NULL OR pm5.meta_value = 'none' )
                ORDER BY p.post_title
             ", ARRAY_A );

        foreach ( $results as $row ){
            $row['stats'] = Prayer_Stats::get_lap_stats( $row['post_id'] );
            $data[] = $row;
        }

        return $data;
    }
}
Prayer_Global_Porch_Challenge_List::instance();
