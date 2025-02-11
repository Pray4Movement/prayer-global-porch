<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.


class Prayer_Global_Porch_Stats_Race_Map extends DT_Magic_Url_Base
{
    public $magic = false;
    public $parts = false;
    public $page_title = 'Global Prayer Map';
    public $root = 'race_app';
    public $type = 'race_map';
    public $type_name = 'Global Prayer Stats';
    public static $token = 'race_app_race_map';
    public $post_type = 'laps';
    public $map_type = 'heatmap';
    public $details_type = 'community_stats';

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
            add_action( 'dt_blank_body', [ $this, 'body' ] ); // body for no post key

            add_filter( 'dt_magic_url_base_allowed_css', [ $this, 'dt_magic_url_base_allowed_css' ], 10, 1 );
            add_filter( 'dt_magic_url_base_allowed_js', [ $this, 'dt_magic_url_base_allowed_js' ], 10, 1 );

            add_action( 'wp_enqueue_scripts', [ $this, '_wp_enqueue_scripts' ], 100 );

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
        $allowed_js[] = 'jquery-touch-punch';
        $allowed_js[] = 'mapbox-gl';
        $allowed_js[] = 'jquery-cookie';
        $allowed_js[] = 'mapbox-cookie';
        $allowed_js[] = 'heatmap-js';
        $allowed_js[] = 'components-js';
        return $allowed_js;
    }

    public function dt_magic_url_base_allowed_css( $allowed_css ) {
        $allowed_css[] = 'mapbox-gl-css';
        $allowed_css[] = 'introjs-css';
        $allowed_css[] = 'foundation-css';
        $allowed_css[] = 'heatmap-css';
        $allowed_css[] = 'site-css';
        return $allowed_css;
    }

    public function header_javascript(){
        $details = [];
        $url = dt_get_url_path( false, true );
        if ( $url ) {
            $details['url'] = $url;
        }
        $details['title'] = esc_html( sprintf( __( '%s Race Map', 'prayer-global-porch' ), 'Prayer.Global' ) );
        pg_og_tags( $details );

        ?>
        <script>
            let jsObject = [<?php echo json_encode([
                'parts' => $this->parts,
                'grid_data' => [],
                'participants' => [],
                'stats' => Prayer_Stats::stats_since_start_of_relay( pg_get_relay_id( '49ba4c' ) ),
                'image_folder' => plugin_dir_url( __DIR__ ) . 'assets/images/',
                'translations' => [],
                'map_type' => $this->map_type,
                'details_type' => $this->details_type,
            ]) ?>][0]
        </script>
        <link href="https://fonts.googleapis.com/css?family=Crimson+Text:400,400i,600|Montserrat:200,300,400" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>assets/css/bootstrap/bootstrap5.2.2.css">
        <link rel="stylesheet" href="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>assets/fonts/ionicons/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>assets/fonts/prayer-global/style.css?ver=<?php echo esc_attr( fileatime( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/fonts/prayer-global/style.css' ) ) ?>">
        <link rel="stylesheet" href="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>assets/css/basic.css?ver=<?php echo esc_attr( fileatime( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/css/basic.css' ) ) ?>" type="text/css" media="all">
        <link rel="stylesheet" href="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>pray/heatmap.css?ver=<?php echo esc_attr( fileatime( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'pray/heatmap.css' ) ) ?>" type="text/css" media="all">
        <?php
    }

    public function footer_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/footer.php' );
    }

    public function body(){
        $lap_stats = Prayer_Stats::stats_since_start_of_relay( pg_get_relay_id( '49ba4c' ) );
        $finished_laps = number_format( (int) $lap_stats['lap_number'] - 1 );
        DT_Mapbox_API::geocoder_scripts();
        ?>
        <style id="custom-style"></style>
        <div id="map-content">
            <div id="initialize-screen">
                <div id="initialize-spinner-wrapper" class="center">
                    <progress class="success initialize-progress" max="46" value="0"></progress><br>
                    <?php echo esc_html__( 'Loading the planet ...', 'prayer-global-porch' ) ?><br>
                    <span id="initialize-people" style="display:none;"><?php echo esc_html__( 'Locating world population...', 'prayer-global-porch' ) ?></span><br>
                    <span id="initialize-activity" style="display:none;"><?php echo esc_html__( 'Calculating movement activity...', 'prayer-global-porch' ) ?></span><br>
                    <span id="initialize-coffee" style="display:none;"><?php echo esc_html__( 'Shamelessly brewing coffee...', 'prayer-global-porch' ) ?></span><br>
                    <span id="initialize-dothis" style="display:none;"><?php echo esc_html__( "Let's do this...", 'prayer-global-porch' ) ?></span><br>
                </div>
            </div>
            <div id="map-wrapper">
                <div class="brand-bg white" id="head_block">
                    <?php require( __DIR__ . '/../pray/nav-global-map.php' ) ?>
                    <?php require( __DIR__ . '/../pray/map-settings.php' ) ?>
                </div>
                <span class="loading-spinner active"></span>
                <div id='map'></div>
                <div id="foot_block">
                    <div class="map-overlay" id="map-legend" data-map-type="<?php echo esc_attr( $this->map_type ) ?>"></div>
                    <div class="row g-0 justify-content-center">
                        <div class="col col-12 center">
                            <button type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_stats">
                                <i class="icon pg-chevron-up three-em blue"></i>
                            </button>
                            <div class="one-em uppercase font-weight-bold"><?php echo esc_html__( 'Race Map Stats', 'prayer-global-porch' ) ?></div>
                        </div>
                        <div class="col col-6 col-md-3 center ">
                            <div class="blue-bg white blue-border rounded-start d-flex align-items-center justify-content-around py-1">
                                <i class="icon pg-prayer three-em"></i>
                                <div class="two-em stats-figure">
                                    <?php echo esc_html( $lap_stats['participants'] ) ?>
                                </div>
                            </div>
                            <span class="uppercase small"><?php echo esc_html__( 'Intercessors', 'prayer-global-porch' ) ?></span><br>
                        </div>
                        <div class="col col-6 col-md-3 center ">
                            <div class="white-bg blue blue-border rounded-end d-flex align-items-center justify-content-around py-1">
                                <i class="icon pg-world-arrow three-em"></i>
                                <div class="two-em stats-figure">
                                    <?php echo sprintf( esc_html__( '%s times', 'prayer-global-porch' ), esc_html( $finished_laps ) ) ?>
                                </div>
                            </div>
                            <span class="uppercase small"><?php echo esc_html__( 'World Prayer Coverage', 'prayer-global-porch' ) ?></span><br>
                        </div>
                        <div class="col d-none d-md-block col-md-1"></div>
                        <div class="col d-none d-md-block col-md-3 center ">
                            <div class="white-bg blue d-flex align-items-center justify-content-around">
                                <div class="two-em stats-figure time_elapsed">
                                    0
                                </div>
                            </div>
                            <span class="uppercase small"><?php echo esc_html__( 'Time Elapsed', 'prayer-global-porch' ) ?></span><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       <div class="offcanvas offcanvas-end" id="offcanvas_location_details" data-bs-backdrop="false" data-bs-scroll="true">
            <div class="offcanvas__header"><button type="button" data-bs-toggle="offcanvas" style="text-align: start;"><i class="icon pg-chevron-right three-em"></i></button></div>
            <div class="row offcanvas__content" id="grid_details_content"></div>
        </div>
        <div class="offcanvas offcanvas-bottom" id="offcanvas_stats">
            <div class="center offcanvas__header"><button type="button" data-bs-toggle="offcanvas"><i class="icon pg-chevron-down three-em"></i></button></div>
            <div class="row center uppercase offcanvas__content">
                <div class="col col-12">
                    <div class="two-em font-weight-bold"><?php echo esc_html__( 'Race Map Stats', 'prayer-global-porch' ) ?></div>
                </div>
                <div class="align-items-center d-flex flex-dir-column mt-3">
                    <i class="icon pg-world-arrow blue four-em"></i>
                    <span class="stats-title"><?php echo esc_html__( 'World Coverage', 'prayer-global-porch' ) ?></span>
                    <div class="blue-bg rounded stats-figure-lg px-3 white"><?php echo esc_html( sprintf( __( '%s times', 'prayer-global-porch' ), $finished_laps ) ) ?></div>
                </div>
                <div class="align-items-center d-flex flex-dir-column mt-3">
                    <i class="icon pg-prayer blue four-em"></i>
                    <span class="stats-title"><?php echo esc_html__( 'Intercessors', 'prayer-global-porch' ) ?></span>
                    <div class="orange-bg rounded stats-figure-lg px-3 warriors white"><?php echo esc_html( $lap_stats['participants'] ) ?></div>
                </div>
                <hr class="mt-3">
                <div class="">
                    <p class="two-em mb-0"><?php echo esc_html__( 'Time Elapsed', 'prayer-global-porch' ) ?></p>
                    <p class="stats-figure time_elapsed">0</p>
                </div>
                <hr class="mt-3">
            </div>
        </div>
        <?php
    }

    public function _wp_enqueue_scripts(){
        pg_heatmap_scripts( null );
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
            case 'get_stats':
                return Prayer_Stats::stats_since_start_of_relay( pg_get_relay_id( '49ba4c' ) );
            case 'get_grid':
                return [
                    'grid_data' => $this->get_grid( $params['parts'] ),
                    'participants' => $this->get_participants( $params['parts'] ),
                ];
            case 'get_grid_stats':
                if ( isset( $params['data']['grid_id'] ) ) {
                    return PG_Stacker::build_location_stats( $params['data']['grid_id'] );
                }
                return false;

            case 'get_grid_details':
                if ( isset( $params['data']['grid_id'] ) ) {
                    return PG_Stacker::build_location_stack( $params['data']['grid_id'] );
                }
                return false;

            case 'get_participants':
                return $this->get_participants( $params['parts'] );
            case 'get_user_locations':
                return $this->get_user_locations( $params['parts'], $params['data'] );
            default:
                return new WP_Error( __METHOD__, 'missing action parameter' );
        }
    }

    public function get_grid( $parts ) {
        $data = Prayer_Stats::get_relay_all_map_stats();

        return [
            'data' => $data,
        ];
    }

    public function get_participants( $parts ){
        return Prayer_Stats::get_all_relay_participants();
    }

    public function get_user_locations( $parts, $data ){
        global $wpdb;
        // Query based on hash
        $hash = $data['hash'];
        if ( empty( $hash ) ) {
            return [];
        }
        $post_id = pg_get_relay_id( '49ba4c' );

        $user_locations_raw  = $wpdb->get_results( $wpdb->prepare( "
           SELECT lg.longitude, lg.latitude
           FROM $wpdb->dt_reports r
           INNER JOIN $wpdb->dt_location_grid lg ON lg.grid_id = r.grid_id
           WHERE r.post_type = 'pg_relays'
                AND r.type = 'prayer_app'
                AND r.hash = %s
                AND r.post_id = %d
                AND r.label IS NOT NULL
                AND lg.longitude IS NOT NULL
                AND lg.latitude IS NOT NULL
        ", $hash, $post_id  ), ARRAY_A );

        return $user_locations_raw;
    }
}
Prayer_Global_Porch_Stats_Race_Map::instance();
