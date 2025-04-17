<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

class PG_Prayer_App_Map extends PG_Public_Page {
    public $url_path = 'map';
    public $page_title = 'Pray';
    public $rest_route = 'pray-api';
    private $icons = [];
    private $url_parts;
    private $relay_key = '49ba4c';
    private $relay_id = 2128;
    private $custom_relay = false;

    public function __construct() {
        $url_path = dt_get_url_path( true );
        $this->url_parts = explode( '/', $url_path );
        $this->custom_relay = isset( $this->url_parts[0] ) && $this->url_parts[0] !== $this->relay_key && $this->url_parts[0] !== 'map';

        if ( $url_path !== 'map' && ( !isset( $this->url_parts[1] ) || $this->url_parts[1] !== 'map' ) ) {
            return;
        }
        $this->url_path = $url_path;

        parent::__construct();
        if ( $this->custom_relay ) {
            $this->relay_key = $this->url_parts[0];
            $this->custom_relay = true;
            $this->relay_id = pg_get_relay_id( $this->relay_key );
            $this->page_title = get_the_title( $this->relay_id );
        }
    }

    public function title( $title ){
        if ( !$this->custom_relay ) {
            return __( 'Global Lap', 'prayer-global-porch' );
        } else {
            return __( 'Custom Prayer Lap', 'prayer-global-porch' );
        }
    }

    public function dt_magic_url_base_allowed_js( $allowed_js ) {
        // $allowed_js = [];
        $allowed_js[] = 'jquery';
        $allowed_js[] = 'jquery-touch-punch';
        $allowed_js[] = 'mapbox-gl';
        $allowed_js[] = 'jquery-cookie';
        $allowed_js[] = 'mapbox-cookie';
        $allowed_js[] = 'heatmap-js';
        $allowed_js[] = 'global-functions';
        $allowed_js[] = 'components-js';
        return $allowed_js;
    }

    public function dt_magic_url_base_allowed_css( $allowed_css ) {
        $allowed_css[] = 'mapbox-gl-css';
        $allowed_css[] = 'introjs-css';
        $allowed_css[] = 'heatmap-css';
        $allowed_css[] = 'site-css';
        $allowed_css[] = 'map-css';
        return $allowed_css;
    }

    public function header_javascript(){
        $details = [];
        $url = dt_get_url_path( true, true );
        if ( $url ) {
             $details['url'] = $url;
        }
        $details['title'] = esc_html( sprintf( __( '%s Map', 'prayer-global-porch' ), 'Prayer.Global' ) );
        pg_og_tags( $details );
        DT_Mapbox_API::geocoder_scripts();
    }

    public function body(){
        $url = new DT_URL( dt_get_url_path( false, true ) );
        $lap_number = $url->query_params->has( 'lap' ) ? $url->query_params->get( 'lap' ) : null;
        $lap_stats = Prayer_Stats::get_relay_current_lap_stats( $this->relay_key, $this->relay_id, $lap_number );

        $title = $this->custom_relay ? $lap_stats['title'] : __( 'Global Lap', 'prayer-global-porch' );

        ?>
        <style id="custom-style"></style>
        <div id="map-content">
            <div id="initialize-screen">
                <div id="initialize-spinner-wrapper" class="text-center">
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

                <nav class="navbar navbar-dark bg-none p-0 d-block" id="pg-navbar">
                    <div class="d-flex align-items-center justify-content-between mx-0 px-0 mw-100 flex-nowrap">
                    <div class="cluster overflow-x-hidden">
                            <span class="font-weight-bold uppercase text-ellipsis"><?php echo esc_html( $lap_stats['title'] ) ?></span>
                            <div class="space-out">
                                <button class="icon-button share-button two-rem d-flex align-items-center white" data-toggle="modal" data-target="#exampleModal">
                                    <i class="icon pg-share"></i>
                                </button>
                                <?php pg_streak_icon(); ?>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end align-items-center">
                            <div><a class="btn btn-cta mx-2" href="/newest/lap/"><?php echo esc_html__( 'Pray', 'prayer-global-porch' ) ?></a></div>
                            <a href="/dashboard" class="icon-button mx-2 two-rem d-flex align-items-center white" title="<?php echo esc_attr__( 'Profile', 'prayer-global-porch' ) ?>" id="user-profile-link">

                                <?php if ( is_user_logged_in() ) : ?>

                                    <?php //phpcs:ignore ?>
                                    <?php echo pg_profile_icon(); ?>

                                <?php else : ?>

                                    <span class="one-rem"><?php echo esc_html__( 'Login', 'prayer-global-porch' ); ?></span>

                                <?php endif; ?>

                            </a>
                            <button class="navbar-toggler mx-2 two-rem d-flex align-items-center white" type="button" data-bs-toggle="offcanvas" data-bs-target="#probootstrap-navbar" aria-controls="probootstrap-navbar" aria-expanded="false" aria-label="<?php echo esc_attr__( 'Toggle navigation', 'prayer-global-porch' ) ?>">
                                <i class="icon pg-menu"></i>
                            </button>
                        </div>
                    </div>

                    <?php pg_menu(); ?>

                </nav>


                    <?php require( __DIR__ . '/map-settings.php' ) ?>

                </div>
                <span class="loading-spinner active"></span>
                <div id='map'></div>
                <div id="foot_block">
                    <div class="map-overlay" id="map-legend"></div>
                    <div class="row g-0 justify-content-center">
                        <div class="col col-12 text-center">
                            <button type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_stats">
                                <i class="icon pg-chevron-up three-em blue"></i>
                            </button>
                            <div class="one-em uppercase font-weight-bold"><?php echo sprintf( esc_html__( 'Lap %s Stats', 'prayer-global-porch' ), esc_html( $lap_stats['lap_number'] ) ) ?></div>
                        </div>
                        <div class="col col-sm-6 col-lg-2 text-center">
                            <div class="blue-bg white blue-border rounded-start d-flex align-items-center justify-content-around py-1">
                                <i class="icon pg-world-light three-em"></i>
                                <div class="two-em white stats-figure remaining"></div>
                            </div>
                            <span class="uppercase small"><?php echo esc_html__( 'Places Remaining', 'prayer-global-porch' ) ?></span><br>
                        </div>
                        <div class="col col-sm-6 col-lg-2 text-center">
                            <div class="white-bg blue blue-border rounded-end d-flex align-items-center justify-content-around py-1">
                                <i class="icon pg-world-light three-em"></i>
                                <div class="two-em stats-figure completed"></div>
                            </div>
                            <span class="uppercase small"><?php echo esc_html__( 'Places Covered', 'prayer-global-porch' ) ?></span><br>
                        </div>
                        <div class="col col-lg-1 d-none d-lg-block"></div>
                        <div class="col col-sm-6 col-lg-2 text-center d-none d-lg-block">
                            <div class="secondary-bg white secondary-border rounded-start d-flex align-items-center justify-content-around py-1">
                                <i class="icon pg-prayer three-em"></i>
                                <div class="two-em stats-figure warriors"></div>
                            </div>
                            <span class="uppercase small"><?php echo esc_html__( 'Intercessors', 'prayer-global-porch' ) ?></span><br>
                        </div>
                        <div class="col col-sm-6 col-lg-2 text-center d-none d-lg-block">
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
            <div class="text-center offcanvas__header d-flex justify-content-center align-items-center">
                <button type="button" data-bs-dismiss="offcanvas">
                    <i class="icon pg-chevron-down blue three-em"></i>
                </button>
            </div>
            <div class="container text-center uppercase pt-3">
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
                    <div class="col col-6 col-sm-5 col-md-4 col-xl-3 text-center">
                        <div class="secondary-bg white secondary-border rounded-start d-flex align-items-center justify-content-between px-3">
                            <i class="icon pg-prayer three-em"></i>
                            <div class="two-em stats-figure warriors"></div>
                        </div>
                        <span class="uppercase small"><?php echo esc_html__( 'Intercessors', 'prayer-global-porch' ) ?></span><br>
                    </div>
                    <div class="col col-6 col-sm-5 col-md-4 col-xl-3 text-center">
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
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/share-modal.php' );
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/cta-modal.php' );
    }

    public function wp_enqueue_scripts(){
        pg_heatmap_scripts( $this );
        pg_enqueue_script( 'components-js', 'pages/assets/js/components.js', [ 'jquery', 'global-functions' ], [ 'strategy' => 'defer' ] );

        $url = new DT_URL( dt_get_url_path( false, true ) );
        $lap_number = $url->query_params->has( 'lap' ) ? $url->query_params->get( 'lap' ) : null;

        wp_localize_script( 'heatmap-js', 'jsObject', [
            // 'parts' => $this->parts,
            'relay_key' => $this->relay_key,
            'relay_id' => $this->relay_id,
            'grid_data' => [],
            'participants' => [],
            'user_locations' => [],
            'stats' => Prayer_Stats::get_relay_current_lap_stats( $this->relay_key, $this->relay_id, $lap_number ),
            'image_folder' => plugin_dir_url( __DIR__ ) . 'assets/images/',
            'map_type' => 'binary',
            'is_cta_feature_on' => true,
        ]);

        pg_enqueue_style( 'map-css', 'pages/pray/heatmap.css' );
    }
}
new PG_Prayer_App_Map();
