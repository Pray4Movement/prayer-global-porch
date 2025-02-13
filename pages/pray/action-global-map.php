<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

class PG_Global_Prayer_App_Map extends PG_Global_Prayer_App {

    private static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

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

        // must be specific action
        if ( 'map' !== $this->parts['action'] ) {
            return;
        }

        // load if valid url
        add_action( 'dt_blank_body', [ $this, 'body' ] );

        add_filter( 'dt_magic_url_base_allowed_css', [ $this, 'dt_magic_url_base_allowed_css' ], 10, 1 );
        add_filter( 'dt_magic_url_base_allowed_js', [ $this, 'dt_magic_url_base_allowed_js' ], 10, 1 );

        add_action( 'wp_enqueue_scripts', [ $this, '_wp_enqueue_scripts' ], 100 );
    }

    public function dt_magic_url_base_allowed_js( $allowed_js ) {
        $allowed_js = [];
        $allowed_js[] = 'jquery-touch-punch';
        $allowed_js[] = 'mapbox-gl';
        $allowed_js[] = 'jquery-cookie';
        $allowed_js[] = 'mapbox-cookie';
        $allowed_js[] = 'heatmap-js';
        return $allowed_js;
    }

    public function dt_magic_url_base_allowed_css( $allowed_css ) {
        $allowed_css[] = 'mapbox-gl-css';
        $allowed_css[] = 'introjs-css';
        $allowed_css[] = 'heatmap-css';
        $allowed_css[] = 'site-css';
        return $allowed_css;
    }

    public function _header() {
        $this->header_style();
        $this->header_javascript();
    }
    public function _footer(){
        $this->footer_javascript();
    }

    public function header_javascript(){
        $details = [];
        $url = dt_get_url_path( true, true );
        if ( $url ) {
             $details['url'] = $url;
        }
        $details['title'] = esc_html( sprintf( __( '%s Map', 'prayer-global-porch' ), 'Prayer.Global' ) );
        pg_og_tags( $details );

        $url = new DT_URL( dt_get_url_path( false, true ) );
        $lap_number = $url->query_params->has( 'lap' ) ? $url->query_params->get( 'lap' ) : null;

        ?>
        <script>
            let jsObject = [<?php echo json_encode([
                'parts' => $this->parts,
                'grid_data' => [],
                'participants' => [],
                'user_locations' => [],
                'stats' => Prayer_Stats::get_relay_current_lap_stats( $this->parts['public_key'], $this->parts['post_id'], $lap_number ),
                'image_folder' => plugin_dir_url( __DIR__ ) . 'assets/images/',
                'map_type' => 'binary',
                'is_cta_feature_on' => true,
            ]) ?>][0]
        </script>
        <link href="https://fonts.googleapis.com/css?family=Crimson+Text:400,400i,600|Montserrat:200,300,400" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>assets/css/bootstrap/bootstrap5.2.2.css">
        <link rel="stylesheet" href="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>assets/fonts/ionicons/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>assets/fonts/prayer-global/style.css?ver=<?php echo esc_attr( fileatime( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/fonts/prayer-global/style.css' ) ) ?>">
        <link rel="stylesheet" href="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>assets/css/basic.css?ver=<?php echo esc_attr( fileatime( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/css/basic.css' ) ) ?>" type="text/css" media="all">
        <link rel="stylesheet" href="<?php echo esc_url( trailingslashit( plugin_dir_url( __FILE__ ) ) ) ?>heatmap.css?ver=<?php echo esc_attr( fileatime( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'heatmap.css' ) ) ?>" type="text/css" media="all">
        <?php
    }

    public function footer_javascript() {
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/share-modal.php' );
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/cta-modal.php' );
    }

    public function body(){
        $parts = $this->parts;

        $url = new DT_URL( dt_get_url_path( false, true ) );
        $lap_number = $url->query_params->has( 'lap' ) ? $url->query_params->get( 'lap' ) : null;

        $lap_stats = Prayer_Stats::get_relay_current_lap_stats( $this->parts['public_key'], $this->parts['post_id'], $lap_number );
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
                <div id="head_block" class="brand-bg white">

                    <?php require( __DIR__ . '/nav-global-map.php' ) ?>

                    <?php require( __DIR__ . '/map-settings.php' ) ?>

                </div>
                <span class="loading-spinner active"></span>
                <div id='map'></div>
                <div id="foot_block">
                    <div class="map-overlay" id="map-legend"></div>
                    <div class="row g-0 justify-content-center">
                        <div class="col col-12 center">
                            <button type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_stats">
                                <i class="icon pg-chevron-up three-em blue"></i>
                            </button>
                            <div class="one-em uppercase font-weight-bold"><?php echo sprintf( esc_html__( 'Lap %s Stats', 'prayer-global-porch' ), esc_html( $lap_stats['lap_number'] ) ) ?></div>
                        </div>
                        <div class="col col-sm-6 col-lg-2 center">
                            <div class="blue-bg white blue-border rounded-start d-flex align-items-center justify-content-around py-1">
                                <i class="icon pg-world-light three-em"></i>
                                <div class="two-em white stats-figure remaining"></div>
                            </div>
                            <span class="uppercase small"><?php echo esc_html__( 'Places Remaining', 'prayer-global-porch' ) ?></span><br>
                        </div>
                        <div class="col col-sm-6 col-lg-2 center">
                            <div class="white-bg blue blue-border rounded-end d-flex align-items-center justify-content-around py-1">
                                <i class="icon pg-world-light three-em"></i>
                                <div class="two-em stats-figure completed"></div>
                            </div>
                            <span class="uppercase small"><?php echo esc_html__( 'Places Covered', 'prayer-global-porch' ) ?></span><br>
                        </div>
                        <div class="col col-lg-1 d-none d-lg-block"></div>
                        <div class="col col-sm-6 col-lg-2 center d-none d-lg-block">
                            <div class="secondary-bg white secondary-border rounded-start d-flex align-items-center justify-content-around py-1">
                                <i class="icon pg-prayer three-em"></i>
                                <div class="two-em stats-figure warriors"></div>
                            </div>
                            <span class="uppercase small"><?php echo esc_html__( 'Intercessors', 'prayer-global-porch' ) ?></span><br>
                        </div>
                        <div class="col col-sm-6 col-lg-2 center d-none d-lg-block">
                            <div class="blue-bg white blue-border rounded-end d-flex align-items-center justify-content-around py-1">
                                <i class="icon pg-world-arrow three-em"></i>
                                <div class="two-em stats-figure"><span class="completed_percent">0</span>%</div>
                            </div>
                            <span class="uppercase small"><?php echo esc_html__( 'World Coverage', 'prayer-global-porch' ) ?></span><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       <div class="offcanvas offcanvas-end" id="offcanvas_location_details" data-bs-backdrop="false" data-bs-scroll="true">
            <div class="offcanvas__header d-flex align-items-center justify-content-between">
                <button type="button" data-bs-dismiss="offcanvas" style="text-align: start">
                    <i class="icon pg-chevron-right three-em"></i>
                </button>
                <a class="btn btn-primary py-2" id="pray-for-area-button" href="#"><?php echo esc_html__( 'Pray for this area', 'prayer-global-porch' ) ?></a>
            </div>
            <div class="row offcanvas__content" id="grid_details_content"></div>
        </div>
        <div class="modal fade" id="pray-for-area-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <iframe src="" frameborder="0" id="pray-for-area-iframe"></iframe>
                </div>
            </div>
        </div>
        <!-- report modal -->
        <div class="reveal " id="correction_modal" data-v-offset="10px;" data-reveal>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo esc_html__( 'Thank you! Leave us a correction below.', 'prayer-global-porch' ) ?></h5>
                    <hr>
                </div>
                <div class="modal-body">
                    <p><span id="correction_title" class="correction_field"></span></p>
                    <p>
                        <?php echo esc_html__( 'Section:', 'prayer-global-porch' ) ?><br>
                        <select class="form-control form-select correction_field" id="correction_select"></select>
                    </p>
                    <p>
                        <?php echo esc_html__( 'Correction Requested:', 'prayer-global-porch' ) ?><br>
                        <textarea class="form-control correction_field" id="correction_response" rows="3"></textarea>
                    </p>
                    <p>
                    <button type="button" class="button button-secondary" id="correction_submit_button"><?php echo esc_html__( 'Submit', 'prayer-global-porch' ) ?></button> <span class="loading-spinner correction_modal_spinner"></span>
                    </p>
                    <p id="correction_error" class="correction_field"></p>
                </div>
            </div>
            <button class="close-button" data-close aria-label="Close modal" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="offcanvas offcanvas-bottom" id="offcanvas_stats">
            <div class="center offcanvas__header d-flex justify-content-center align-items-center">
                <button type="button" data-bs-dismiss="offcanvas">
                    <i class="icon pg-chevron-down blue three-em"></i>
                </button>
            </div>
            <div class="container center uppercase pt-3">
                <div class="row g-0 justify-content-center">
                    <div class="col col-12">
                        <div class="two-em font-weight-bold"><?php echo sprintf( esc_html__( 'Lap %s Stats', 'prayer-global-porch' ), esc_html( $lap_stats['lap_number'] ) ) ?></div>
                    </div>
                    <div class="col col-6 col-sm-5 col-md-4 col-xl-3">
                        <div class="blue-bg white blue-border rounded-start d-flex align-items-center justify-content-between px-3">
                            <i class="icon pg-world-light three-em"></i>
                            <div class="two-em white stats-figure remaining"></div>
                        </div>
                        <span class="small"><?php echo esc_html__( 'Places Remaining', 'prayer-global-porch' ) ?></span><br>
                    </div>
                    <div class="col col-6 col-sm-5 col-md-4 col-xl-3">
                        <div class="white-bg blue blue-border rounded-end d-flex align-items-center justify-content-between px-3">
                            <i class="icon pg-world-light three-em"></i>
                            <div class="two-em stats-figure completed"></div>
                        </div>
                        <span class="small"><?php echo esc_html__( 'Places Covered', 'prayer-global-porch' ) ?></span><br>
                    </div>
                </div>
                <div class="row g-0 justify-content-center mt-4">
                    <div class="col col-6 col-sm-5 col-md-4 col-xl-3 center">
                        <div class="secondary-bg white secondary-border rounded-start d-flex align-items-center justify-content-between px-3">
                            <i class="icon pg-prayer three-em"></i>
                            <div class="two-em stats-figure warriors"></div>
                        </div>
                        <span class="uppercase small"><?php echo esc_html__( 'Intercessors', 'prayer-global-porch' ) ?></span><br>
                    </div>
                    <div class="col col-6 col-sm-5 col-md-4 col-xl-3 center">
                        <div class="blue-bg white blue-border rounded-end d-flex align-items-center justify-content-between px-3">
                            <i class="icon pg-world-arrow three-em"></i>
                            <div class="two-em stats-figure"><span class="completed_percent">0</span>%</div>
                        </div>
                        <span class="uppercase small"><?php echo esc_html__( 'World Coverage', 'prayer-global-porch' ) ?></span><br>
                    </div>
                </div>
                <div class="row">
                    <hr class="mt-3">
                    <div class="col">
                        <p class="two-em mb-0"><?php echo esc_html__( 'Time Elapsed', 'prayer-global-porch' ) ?></p>
                        <p class="stats-figure time_elapsed">0</p>
                    </div>
                    <hr class="mt-3">

                    <div class="col col-6 col-sm-3" style="display:none">
                        <p class="stats-title"><?php echo esc_html__( 'Start Time', 'prayer-global-porch' ) ?></p>
                        <p class="stats-figure start_time">0</p>
                    </div>
                    <div class="col col-6 col-sm-3 on-going" style="display:none;">
                        <p class="stats-title"><?php echo esc_html__( 'End Time', 'prayer-global-porch' ) ?></p>
                        <p class="stats-figure end_time">0</p>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    public function _wp_enqueue_scripts(){
        pg_heatmap_scripts( $this );
    }

    public function endpoint( WP_REST_Request $request ) {
        $params = $request->get_params();

        if ( ! isset( $params['parts'], $params['action'] ) ) {
            return new WP_Error( __METHOD__, 'Missing parameters', [ 'status' => 400 ] );
        }

        $params = dt_recursive_sanitize_array( $params );

        switch ( $params['action'] ) {
            case 'get_stats':
                return Prayer_Stats::get_relay_current_lap_stats( $params['parts']['public_key'], $params['parts']['post_id'], $params['data']['lap_number'] ?? null );
            case 'get_grid':
                return [
                    'grid_data' => $this->get_grid( $params['data']['lap_number'] ?? null ),
                    'participants' => $this->get_participants( $params['parts'], $params['data']['lap_number'] ?? null ),
                ];
            case 'get_grid_details':
                if ( isset( $params['data']['grid_id'] ) ) {
                    return PG_Stacker::build_location_stack( $params['data']['grid_id'] );
                }
                return false;
            case 'get_participants':
                return $this->get_participants( $params['parts'], $params['data']['lap_number'] ?? null );
            case 'get_user_locations':
                return $this->get_user_locations( $params['parts'], $params['data'] );
            default:
                return new WP_Error( __METHOD__, 'missing action parameter' );
        }
    }

    public function get_grid( $lap_number = null ) {
        $data = $this->get_global_relay_map_stats( $lap_number );
        return [
            'data' => $data,
        ];
    }


    /* The global lap has to look at the dt_reports table in order to find out what custom laps have
    contributed to the completion of the map and stats */
    public function get_global_relay_map_stats( $lap_number = null ) {
        global $wpdb;

        if ( $lap_number === null ) {
            $lap_number = Prayer_Stats::get_relay_lap_number();
        }

        $locations = $wpdb->get_col( $wpdb->prepare(
            "SELECT grid_id
            FROM $wpdb->dt_reports
            WHERE global_lap_number = %d
            AND post_type = 'pg_relays'
        ", $lap_number ) );
        $data = pg_query_4770_locations();

        foreach ( $data as $key ) {
            if ( in_array( $key, $locations ) ) {
                $data[$key] = 1;
            } else {
                $data[$key] = 0;
            }
        }
        return $data;
    }
    public function get_participants( $parts, $lap_number = null ){
        return Prayer_Stats::get_relay_lap_map_participants( $parts['post_id'], $parts['public_key'], $lap_number );
    }

    public function get_user_locations( $parts, $data ){
        return PG_User_API::get_user_locations_prayed_for( $parts['public_key'], $data['hash'], $data['lap_number'] ?? null );
    }
}
PG_Global_Prayer_App_Map::instance();
