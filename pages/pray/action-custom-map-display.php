<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

class PG_Custom_Prayer_App_Map_Display extends PG_Custom_Prayer_App {

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
        if ( 'display' !== $this->parts['action'] ) {
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
        ?>
        <script>
            let jsObject = [<?php echo json_encode([
                'parts' => $this->parts,
                'grid_data' => [],
                'stats' => Prayer_Stats::get_relay_current_lap_stats( $this->parts['public_key'], $this->parts['post_id'] ),
                'image_folder' => plugin_dir_url( __DIR__ ) . 'assets/images/',
                'translations' => [
                    'lap' => __( 'Lap %d', 'prayer-global-porch' ),
                ],
                'map_type' => 'binary',
            ]) ?>][0]
        </script>
        <link rel="stylesheet" href="<?php echo esc_url( trailingslashit( plugin_dir_url( __FILE__ ) ) ) ?>heatmap.css?ver=<?php echo esc_attr( fileatime( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'heatmap.css' ) ) ?>" type="text/css" media="all">
        <?php
    }

    public function body(){
        $lap_stats = Prayer_Stats::get_relay_current_lap_stats( $this->parts['public_key'], $this->parts['post_id'] );
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
                <div id="head_block_wrapper">
                    <div id="head_block_display" class="text-center brand-bg white relative">
                        <h2 class="uppercase"><?php echo esc_html( sprintf( __( '%s Prayer Relay', 'prayer-global-porch' ), $lap_stats['title'] ) ) ?></h2>
                        <h4 class="uppercase"><?php echo esc_html__( 'Cover The World In Prayer', 'prayer-global-porch' ) ?></h4>
                        <h4 class="uppercase lap-number"><?php echo esc_html__( 'Lap:', 'prayer-global-porch' ) ?> <span><?php echo esc_html( $lap_stats['lap_number'] ) ?></span></h4>
                    </div>
                </div>
                <span class="loading-spinner active"></span>
                <div id='map'></div>
                <div id="foot_block">
                    <div class="row d-flex justify-content-between text-center gap-5 flex-nowrap">
                        <div class="col col-sm-3" id="qr-cell"></div>
                        <div class="w-auto flex-1">
                            <div class="blue-bg white blue-border rounded d-flex align-items-center justify-content-around font-weight-bold">
                                <i class="icon pg-world-light three-em"></i>
                                <div class="three-em white remaining"></div>
                            </div>
                            <span class="uppercase one-rem"><?php echo esc_html__( 'Places Remaining', 'prayer-global-porch' ) ?></span>
                        </div>
                        <div class="w-auto flex-1">
                            <div class="white-bg blue blue-border rounded d-flex align-items-center justify-content-around font-weight-bold">
                                <i class="icon pg-world-light three-em"></i>
                                <div class="three-em completed"></div>
                            </div>
                            <span class="uppercase one-rem"><?php echo esc_html__( 'Places Covered', 'prayer-global-porch' ) ?></span>
                        </div>
                        <div class="w-auto flex-1">
                            <div class="brand-bg white blue-border rounded d-flex align-items-center justify-content-around font-weight-bold">
                                <i class="icon pg-world-arrow three-em"></i>
                                <div><span class="three-em  completed_percent"></span><span class="three-em">%</span></div>
                            </div>
                            <span class="uppercase one-rem"><?php echo esc_html__( 'World Coverage', 'prayer-global-porch' ) ?></span>
                        </div>
                        <div class="w-auto flex-1 d-none">
                            <div class="secondary-bg white secondary-border rounded d-flex align-items-center justify-content-around font-weight-bold">
                                <i class="icon pg-prayer three-em"></i>
                                <div class="three-em prayer_warriors"></div>
                            </div>
                            <span class="uppercase one-rem"><?php echo esc_html__( 'Intercessors', 'prayer-global-porch' ) ?></span>
                        <div class=""></div>
                    </div>
                    <div id="qr-code-block">
                        <div class="two-em text-center uppercase"><?php echo esc_html__( 'Pray with us', 'prayer-global-porch' ) ?></div>
                        <?php if ( !empty( $lap_stats['event_lap'] ) ) : ?>
                            <!--Event relay-->
                            <img class="qr-code-image" src="https://api.qrserver.com/v1/create-qr-code/?size=500x500&amp;data=https://api.prayer.global/?relay=<?php echo esc_html( $lap_stats['key'] ) ?>">
                        <?php else : ?>
                            <img class="qr-code-image" src="https://api.qrserver.com/v1/create-qr-code/?size=500x500&amp;data=<?php echo esc_url( get_site_url() ) ?>/prayer_app/custom/<?php echo esc_html( $lap_stats['key'] ) ?>">
                        <?php endif; ?>
                        <div class="text-center uppercase"><?php echo esc_html__( 'Turn the map from dark to light', 'prayer-global-porch' ) ?></div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    public function footer_javascript(){
        ?>
        <script>
            window.addEventListener('load', function(){
                setTimeout(function() {
                    let qr_width = jQuery('#qr-cell').width()
                    let qr_height = ( qr_width * .15 ) + qr_width
                    let div = jQuery('#qr-code-block')
                    if ( 0 < qr_width || 0 < qr_height ) {
                        div.css('width', qr_width+'px' ).css('height', qr_height + 'px')
                    }
                    div.show()
                }, 1000);
            })
        </script>
        <?php
    }

    public static function _wp_enqueue_scripts(){
        DT_Mapbox_API::load_mapbox_header_scripts();
        wp_enqueue_script( 'heatmap-js', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'heatmap-display.js', [
            'jquery',
            'mapbox-gl'
        ], filemtime( plugin_dir_path( __FILE__ ) .'heatmap-display.js' ), true );
    }

    public function endpoint( WP_REST_Request $request ) {
        $params = $request->get_params();

        if ( ! isset( $params['parts'], $params['action'] ) ) {
            return new WP_Error( __METHOD__, 'Missing parameters', [ 'status' => 400 ] );
        }

        switch ( $params['action'] ) {
            case 'get_stats':
                return Prayer_Stats::get_relay_current_lap_stats( $params['parts']['public_key'] );
            case 'get_grid':
                return [
                    'grid_data' => $this->get_grid( $params['parts'] ),
                    'participants' => [],
                    'stats' => Prayer_Stats::get_relay_current_lap_stats( $params['parts']['public_key'] )
                ];
            default:
                return new WP_Error( __METHOD__, 'missing action parameter' );
        }
    }

    public function get_grid( $parts ) {
        $data = Prayer_Stats::get_relay_current_lap_map_stats( $parts['public_key'] );
        return [
            'data' => $data,
        ];
    }
}
PG_Custom_Prayer_App_Map_Display::instance();
