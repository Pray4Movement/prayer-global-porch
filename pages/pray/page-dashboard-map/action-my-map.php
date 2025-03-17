<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

class PG_My_Map extends PG_Public_Page {
    public $url_path = 'dashboard/map';
    public $page_title = 'My Map';
    public $rest_route = 'dashboard/map';

    public function __construct() {
        $this->page_title = __( 'My Map', 'prayer-global-porch' );
        $current_page_path_matches = parent::__construct();
        if ( !$current_page_path_matches ) {
            return;
        }
        /**
         * Register custom hooks here
         */
    }

    public function register_endpoints(){
        register_rest_route( $this->rest_route, '/get-grid', [
            'methods' => 'GET',
            'callback' => [ $this, 'get_my_places_prayed_for' ],
            'permission_callback' => '__return_true',
        ] );
    }

    public function body(){

        $lap_stats = [
            'lap_number' => 1,
        ];

        $pray_href = '/prayer_app/custom/';
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
                    <div class="d-flex align-items-center justify-content-between gap-2">

                        <div class="d-flex align-items-center gap-2">
                            <span class="font-weight-bold uppercase"><?php echo esc_html( 'title' ) ?></span>
                            <button class="icon-button share-button two-rem d-flex align-items-center white" data-toggle="modal" data-target="#exampleModal">
                                <i class="icon pg-share"></i>
                            </button>
                        </div>
                        <!-- <a class="btn btn-cta" id="pray-button" href="<?php echo esc_url( $pray_href ) ?>"><?php echo esc_html__( 'Pray', 'prayer-global-porch' ) ?></a> -->

                    </div>

                    <?php require( Prayer_Global_Porch::get_dir_path() . 'pages/pray/map-settings.php' ) ?>

                </div>
                <div class="holding-page flow-small">
                    <span class="six-em center"><?php echo sprintf( esc_html__( 'Starts on %s', 'prayer-global-porch' ), '<span class="starts-on-date"></span>' ) ?></span>
                    <span class="six-em center time-remaining text-secondary"></span>
                    <button class="btn btn-cta btn-lg start-praying-button"><?php echo esc_html__( 'Start Praying', 'prayer-global-porch' ) ?></button>
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

                            <h4 class="uppercase font-weight-bold two-em"><?php echo esc_html( sprintf( __( 'Lap %s', 'prayer-global-porch' ), $lap_stats['lap_number'] ) ) ?></h4>

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
        <div class="offcanvas offcanvas-end" id="offcanvas_menu">
            <button type="button" data-bs-dismiss="offcanvas"><i class="icon pg-chevron-right three-em"></i></button>
            <hr>
            <ul class="navbar-nav two-em">
                <li class="nav-item">
                    <a class="nav-link btn smoothscroll btn-primary" style="text-transform: capitalize;" href="/prayer_app/custom/my">
                        Start Praying
                    </a>
                </li>
            </ul>
            <div class="d-sm-none">
                <hr>
            </div>
        </div>
        <div class="offcanvas offcanvas-end" id="offcanvas_location_details" data-bs-backdrop="false" data-bs-scroll="true">
            <div class="offcanvas__header d-flex align-items-center justify-content-between">
                <button type="button" data-bs-dismiss="offcanvas" style="text-align: start">
                    <i class="icon pg-chevron-right three-em"></i>
                </button>
                <!-- <a class="btn btn-primary py-2" id="pray-for-area-button" href="/prayer_app/custom/location"><?php echo esc_html__( 'Pray for this area', 'prayer-global-porch' ) ?></a> -->
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
                <div class="row justify-content-center">
                    <hr class="mt-3">
                    <div class="col">
                        <p class="two-em mb-0"><?php echo esc_html__( 'Time Elapsed', 'prayer-global-porch' ) ?></p>
                        <p class="stats-figure time_elapsed">0</p>
                    </div>
                    <hr class="mb-3">
                    <div class="col col-12 col-md-4">
                        <p class="stats-title mb-0"><?php echo esc_html__( 'Start Time', 'prayer-global-porch' ) ?></p>
                        <p class="stats-figure start_time">0</p>
                    </div>
                    <div class="col col-12 col-md-4 on-going reveal-me" style="display:none;">
                        <p class="stats-title mb-0"><?php echo esc_html__( 'End Time', 'prayer-global-porch' ) ?></p>
                        <p class="stats-figure end_time">0</p>
                    </div>
                    <div class="col col-12 col-md-4 on-going reveal-me" style="display:none;">
                        <p class="stats-title mb-0"><?php echo esc_html__( 'Locations per Hour', 'prayer-global-porch' ) ?></p>
                        <p class="stats-figure locations_per_hour" style="margin-bottom: 0">0</p>
                        <p class="stats-small">
                            <small><?php sprintf( esc_html__( '%s per day', 'prayer-global-porch' ), '<span class="locations_per_day">0</span>' )?></small>
                        </p>
                    </div>
                    <div class="col col-6 on-going" style="display:none;">
                        <p class="stats-title"><?php echo esc_html__( 'Current Locations per Hour', 'prayer-global-porch' ) ?></p>
                        <p class="stats-figure needed_locations_per_hour" style="margin-bottom: 0">0</p>
                        <p class="stats-small">
                            <small><?php sprintf( esc_html__( '%s per day', 'prayer-global-porch' ), '<span class="locations_per_day">0</span>' )?></small>
                        </p>
                    </div>
                    <div class="col on-going" style="display:none;">
                        <p class="stats-title"><?php echo esc_html__( 'Time Remaining', 'prayer-global-porch' ) ?></p>
                        <p class="stats-figure time_remaining">0</p>
                    </div>
                </div>
                <!-- <div class="row">
                    <a href="/" class="btn btn-small btn-outline-primary w-fit mb-2 d-block m-auto"><?php echo esc_html__( 'Leave this relay', 'prayer-global-porch' ) ?></a>
                </div> -->
            </div>
        </div>

        <?php
    }


    public function wp_enqueue_scripts() {
        pg_heatmap_scripts( $this );

        $stats = PG_User_API::get_my_stats();

        $js_object = [
            'public_endpoint_url' => rest_url() . $this->rest_route,
            'grid_data' => $this->get_my_places_prayed_for(),
            'stats' => $stats,
            'image_folder' => Prayer_Global_Porch::get_url_path() . 'pages/assets/images/',
            'map_type' => 'binary',
        ];

        wp_localize_script( 'heatmap-js', 'jsObject', $js_object );

        pg_enqueue_script( 'my-map-heatmap', 'pages/pray/page-dashboard-map/heatmap.js', [ 'heatmap-js' ] );

        wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Crimson+Text:400,400i,600|Montserrat:200,300,400', [], '1' );
        wp_enqueue_style( 'google-fonts-2', 'https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@300&display=swap', [], '1' );
        wp_enqueue_style( 'heatmap-css', Prayer_Global_Porch::get_url_path() . 'pages/pray/heatmap.css', [], fileatime( Prayer_Global_Porch::get_dir_path() . 'pages/pray/heatmap.css' ) );


        // function add_google_fonts_preconnect( $urls, $relation_type ) {
        //     if ( 'preconnect' === $relation_type ) {
        //         $urls[] = [
        //             'href' => 'https://fonts.googleapis.com',
        //         ];
        //         $urls[] = [
        //             'href' => 'https://fonts.gstatic.com',
        //             'crossorigin' => 'anonymous', // or just 'crossorigin' => true
        //         ];
        //     }
        //     return $urls;
        // }
        // add_filter( 'wp_resource_hints', 'add_google_fonts_preconnect', 10, 2 );
    }

    /**
     * Adds printed styles to header
     */
    public function header_style(){}

    /**
     * Adds printed scripts to header
     */
    public function header_javascript(){
        $details['title'] = 'Prayer.Global ' . $this->page_title;
        pg_og_tags( $details );

        ?>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <?php
    }

    /**
     * Adds printed scripts to footer
     */
    public function footer_javascript(){}

    public function dt_magic_url_base_allowed_js( $allowed_js ) {
        $allowed_js = [];
        $allowed_js[] = 'jquery';
        $allowed_js[] = 'bootstrap';
        $allowed_js[] = 'global-functions';
        $allowed_js[] = 'components-js';
        $allowed_js[] = 'mapbox-gl';
        $allowed_js[] = 'mapbox-cookie';
        $allowed_js[] = 'heatmap-js';
        $allowed_js[] = 'my-map-heatmap';
        $allowed_js[] = 'umami';

        return $allowed_js;
    }

    public function dt_magic_url_base_allowed_css( $allowed_css ) {
        $allowed_css[] = 'mapbox-gl-css';
        $allowed_css[] = 'heatmap-css';
        $allowed_css[] = 'google-fonts';
        $allowed_css[] = 'google-fonts-2';
        return $allowed_css;
    }


    public function get_my_places_prayed_for(){
        $results = PG_User_API::get_my_places_prayed_for();
        return [
            'grid_data' => [ 'data' =>$results ],
            'participants' => []
        ];
    }
}

new PG_My_Map();
