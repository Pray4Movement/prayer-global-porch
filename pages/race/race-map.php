<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.


class Prayer_Global_Porch_Stats_Race_Map extends PG_Public_Page
{
    public $url_path = 'race-map';
    public $page_title = 'Global Prayer Map';
    public $map_type = 'heatmap';
    public $details_type = 'community_stats';
    public $relay_key = '49ba4c';
    public $relay_id = 2128;
    public $url_parts;
    public $custom_relay = false;

    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct() {
        $url_path = dt_get_url_path( true );
        $this->url_parts = explode( '/', $url_path );
        $this->custom_relay = isset( $this->url_parts[0] ) && $this->url_parts[0] !== $this->relay_key && $this->url_parts[0] !== 'race-map';

        if ( $url_path !== 'race-map' && ( !isset( $this->url_parts[1] ) || $this->url_parts[1] !== 'race-map' ) ) {
            return;
        }
        $this->url_path = $url_path;

        parent::__construct();
    }

    public function dt_magic_url_base_allowed_js( $allowed_js ) {
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
                // 'parts' => [],
                'relay_key' => $this->relay_key,
                'relay_id' => $this->relay_id,
                'grid_data' => [],
                'participants' => [],
                'stats' => Prayer_Stats::get_relay_current_lap_stats( $this->relay_key, $this->relay_id ),
                'image_folder' => plugin_dir_url( __DIR__ ) . 'assets/images/',
                'translations' => [],
                'map_type' => $this->map_type,
                'details_type' => $this->details_type,
            ]) ?>][0]
        </script>
        <link rel="stylesheet" href="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>pray/heatmap.css?ver=<?php echo esc_attr( fileatime( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'pray/heatmap.css' ) ) ?>" type="text/css" media="all">
        <?php
    }

    public function footer_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/footer.php' );
    }

    public function body(){
        $lap_stats = Prayer_Stats::get_relay_current_lap_stats( $this->relay_key, $this->relay_id );
        $finished_laps = number_format( (int) $lap_stats['lap_number'] - 1 );
        DT_Mapbox_API::geocoder_scripts();
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
                <div class="brand-bg white" id="head_block">
                    <?php require( __DIR__ . '/../pray/nav-global-map.php' ) ?>
                    <?php require( __DIR__ . '/../pray/map-settings.php' ) ?>
                </div>
                <span class="loading-spinner active"></span>
                <div id='map'></div>
                <div id="foot_block">
                    <div class="map-overlay" id="map-legend" data-map-type="<?php echo esc_attr( $this->map_type ) ?>"></div>
                    <div class="row g-0 justify-content-center">
                        <div class="col col-12 text-center">
                            <button type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_stats">
                                <i class="icon pg-chevron-up three-em blue"></i>
                            </button>
                            <div class="one-em uppercase font-weight-bold"><?php echo esc_html__( 'Race Map Stats', 'prayer-global-porch' ) ?></div>
                        </div>
                        <div class="col col-6 col-md-3 text-center ">
                            <div class="blue-bg white blue-border rounded-start d-flex align-items-center justify-content-around py-1">
                                <i class="icon pg-prayer three-em"></i>
                                <div class="two-em stats-figure">
                                    <?php echo esc_html( $lap_stats['participants'] ) ?>
                                </div>
                            </div>
                            <span class="uppercase small"><?php echo esc_html__( 'Intercessors', 'prayer-global-porch' ) ?></span><br>
                        </div>
                        <div class="col col-6 col-md-3 text-center ">
                            <div class="white-bg blue blue-border rounded-end d-flex align-items-center justify-content-around py-1">
                                <i class="icon pg-world-arrow three-em"></i>
                                <div class="two-em stats-figure">
                                    <?php echo sprintf( esc_html__( '%s times', 'prayer-global-porch' ), esc_html( $finished_laps ) ) ?>
                                </div>
                            </div>
                            <span class="uppercase small"><?php echo esc_html__( 'World Prayer Coverage', 'prayer-global-porch' ) ?></span><br>
                        </div>
                        <div class="col d-none d-md-block col-md-1"></div>
                        <div class="col d-none d-md-block col-md-3 text-center ">
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
            <div class="text-center offcanvas__header"><button type="button" data-bs-toggle="offcanvas"><i class="icon pg-chevron-down three-em"></i></button></div>
            <div class="row text-center uppercase offcanvas__content">
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

    public function wp_enqueue_scripts(){
        pg_heatmap_scripts( null );
    }
}
Prayer_Global_Porch_Stats_Race_Map::instance();
