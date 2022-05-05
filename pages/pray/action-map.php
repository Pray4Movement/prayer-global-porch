<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

class Prayer_Global_Prayer_App_Map extends Prayer_Global_Prayer_App {

    private static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct()
    {
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
        add_action( 'dt_blank_head', [ $this, '_header' ] );
        add_action( 'dt_blank_body', [ $this, 'body' ] );

        add_filter( 'dt_magic_url_base_allowed_css', [ $this, 'dt_magic_url_base_allowed_css' ], 10, 1 );
        add_filter( 'dt_magic_url_base_allowed_js', [ $this, 'dt_magic_url_base_allowed_js' ], 10, 1 );

        add_action( 'wp_enqueue_scripts', [ $this, '_wp_enqueue_scripts' ], 100 );
    }

    public function dt_magic_url_base_allowed_js( $allowed_js ) {
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

    public function header_javascript(){
        ?>
        <script>
            let jsObject = [<?php echo json_encode([
                'map_key' => DT_Mapbox_API::get_key(),
                'ipstack' => DT_Ipstack_API::get_key(),
                'mirror_url' => dt_get_location_grid_mirror( true ),
                'root' => esc_url_raw( rest_url() ),
                'nonce' => wp_create_nonce( 'wp_rest' ),
                'parts' => $this->parts,
                'grid_data' => $this->get_grid($this->parts),
                'participants' => $this->get_participants($this->parts),
                'stats' => pg_lap_stats_by_key($this->parts['public_key']),
                'image_folder' => plugin_dir_url(__DIR__) . 'assets/images/',
                'translations' => [
                    'add' => __( 'Add Magic', 'prayer-global' ),
                ],
            ]) ?>][0]
        </script>
        <style>
            body {
                background: white !important;
            }
            #initialize-screen {
                width: 100%;
                height: 2000px;
                z-index: 10;
                background-color: white;
                position: absolute;
            }
            #initialize-spinner-wrapper{
                position:relative;
                top:45%;
            }
            progress {
                top: 50%;
                margin: 0 auto;
                height:50px;
                width:300px;
            }
            .pb_navbar .navbar-toggler {
                color: black;
                border-color: black;
                cursor: pointer;
                padding-right: 0;
            }
            #head_block, #foot_block {
                position: absolute;
                width:100%;
                z-index: 5;
                background: white;
                padding: 1em;
                opacity: .9;
                display:none;
            }
            #head_block {
                margin: 0 auto 1em;
            }
            #foot_block {
                bottom: 0;
                margin: 1em auto 0;
            }
            #offcanvas_menu {
                background: white;
                z-index: 15;
                padding: 1em;
            }
            #offcanvas_location_details {
                background: white;
                z-index: 15;
                padding: 1em;
            }
            #offcanvas_stats {
                background: white;
                z-index: 15;
                padding: 1em;
                height: 80%;
            }
            .nav-item {
                list-style-type: none;
            }
            #title {
                font-weight: bold;
            }
            .mapboxgl-ctrl-group {
                margin-top:120px !important;
            }
            .one-em {
                font-size: 1.5rem;
            }
            .two-em {
                font-size: 2rem;
            }
            .three-em {
                font-size: 3rem;
            }
            .bold {
                font-weight: bold;
            }
            .stats-title {
                font-size: 1.5rem;
            }
            .stats-figure {
                font-size: 2rem;
            }
            @media (max-width: 768px) {
                .mapboxgl-ctrl-group {
                    margin-top:100px !important;
                }
                .one-em {
                    font-size: 1rem;
                }
                .two-em {
                    font-size: 1.8rem;
                }
                .three-em {
                    font-size: 2rem;
                }
                .stats-title {
                    font-size: 1rem;
                    padding-bottom: 0;
                }
                .stats-figure {
                    font-size: 1.8rem;
                    font-weight: bold;
                    padding-top: 0;
                }
            }
        </style>
        <link rel="stylesheet" href="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>assets/fonts/ionicons/css/ionicons.min.css">
        <?php
    }

    public function body(){
        $parts = $this->parts;
        $lap_stats = pg_lap_stats_by_key($parts['public_key']);
        DT_Mapbox_API::geocoder_scripts();
        ?>
        <style id="custom-style"></style>
        <div id="map-content">
            <div id="initialize-screen">
                <div id="initialize-spinner-wrapper" class="center">
                    <progress class="success initialize-progress" max="46" value="0"></progress><br>
                    Loading the planet ...<br>
                    <span id="initialize-people" style="display:none;">Locating world population...</span><br>
                    <span id="initialize-activity" style="display:none;">Calculating movement activity...</span><br>
                    <span id="initialize-coffee" style="display:none;">Shamelessly brewing coffee...</span><br>
                    <span id="initialize-dothis" style="display:none;">Let's do this...</span><br>
                </div>
            </div>
            <div id="map-wrapper">
                <div id="head_block">
                    <div class="grid-x grid-padding-x">
                        <div class="cell medium-4 hide-for-small-only">
                            <a href="/"><i class="fi-home two-em" style="color:black;"></i></a>
                        </div>
                        <div class="cell small-9 medium-4 center hide-for-small-only">
                            <span class="two-em">Lap <?php echo $lap_stats['lap_number'] ?></span>
                        </div>
                        <div class="cell small-9 medium-4 show-for-small-only">
                            <span class="two-em"><strong>Lap <?php echo $lap_stats['lap_number'] ?></strong></span>
                        </div>
                        <div class="cell small-3 medium-4" style="text-align:right;">
                            <button type="button" data-toggle="offcanvas_menu"><i class="fi-list two-em"></i></button>
                        </div>
                    </div>
                </div>
                <span class="loading-spinner active"></span>
                <div id='map'></div>
                <div id="foot_block">
                    <div class="grid-x grid-padding-x">
                        <div class="cell center"><button type="button" data-toggle="offcanvas_stats"><i class="ion-chevron-up two-em"></i></button></div>
                        <div class="cell small-6 medium-2 center"><strong>Warriors</strong> <i class="fi-marker" style="color:blue;"></i><br><span class="one-em" id="warriors"></span></div>
                        <div class="cell small-6 medium-2 center"><strong>World Coverage</strong><br><span class="one-em" id="completed_percent"></span><span class="one-em">%</span></div>
                        <div class="cell small-6 medium-2 center hide-for-small-only"><strong>Places Remaining</strong><br><span class="one-em" id="remaining"></span></div>
                        <div class="cell small-6 medium-3 center hide-for-small-only"><strong>Length of Time</strong><br><span class="one-em" id="time_elapsed"></span></div>
                        <div class="cell small-6 medium-3 center hide-for-small-only"><strong>Quantity of Time</strong><br><span class="one-em" id="minutes_prayed_formatted"></span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="off-canvas position-right reveal-for-large" id="offcanvas_menu" data-close-on-click="true" data-off-canvas>
            <button type="button" data-toggle="offcanvas_menu"><i class="ion-chevron-right three-em"></i></button>
            <hr>
            <ul class="navbar-nav two-em">
                <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="/#section-lap">Current Lap</a></li>
                <li class="nav-item"><a class="nav-link" href="/#section-about">About</a></li>
                <li class="nav-item"><a class="nav-link btn smoothscroll pb_outline-dark" style="text-transform: capitalize;" href="/newest/lap/">Start Praying</a></li>
            </ul>
            <div class="show-for-small-only">
                <hr>
                <i class="fi-marker" style="color:blue;"></i> = prayer warriors
            </div>
        </div>
        <div class="off-canvas position-right reveal-for-large" id="offcanvas_location_details" data-close-on-click="true" data-off-canvas>
            <button type="button" data-toggle="offcanvas_location_details"><i class="ion-chevron-right three-em"></i></button>
            <hr>
            <div class="grid-x grid-padding-x" id="grid_details_content"></div>
        </div>
        <div class="off-canvas position-bottom reveal-for-large" id="offcanvas_stats" data-close-on-click="true" data-off-canvas>
            <div class="center"><button type="button" data-toggle="offcanvas_stats"><i class="ion-chevron-down three-em"></i></button></div>
            <hr>
            <div class="grid-x grid-padding-x center">
                <div class="cell small-6 medium-3">
                    <p class="stats-title">Warriors</p>
                    <p class="stats-figure">0</p>
                </div>
                <div class="cell small-6 medium-3">
                    <p class="stats-title">Warriors Countries</p>
                    <p class="stats-figure">0</p>
                </div>
                <div class="cell small-6 medium-3">
                    <p class="stats-title">Percent Complete</p>
                    <p class="stats-figure">0</p>
                </div>
                <div class="cell small-6 medium-3">
                    <p class="stats-title">Completed Locations</p>
                    <p class="stats-figure">0</p>
                </div>
                <div class="cell small-6 medium-3">
                    <p class="stats-title">Percent Remaining</p>
                    <p class="stats-figure">0</p>
                </div>
                <div class="cell small-6 medium-3">
                    <p class="stats-title">Remaining Locations</p>
                    <p class="stats-figure">0</p>
                </div>
            </div>
        </div>
        <?php
    }

    public static function _wp_enqueue_scripts(){
        DT_Mapbox_API::load_mapbox_header_scripts();

        wp_enqueue_script( 'heatmap-js', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'heatmap.js', [
            'jquery',
            'mapbox-gl'
        ], filemtime( plugin_dir_path( __FILE__ ) .'heatmap.js' ), true );
    }

    public function endpoint( WP_REST_Request $request ) {
        $params = $request->get_params();

        if ( ! isset( $params['parts'], $params['action'] ) ) {
            return new WP_Error( __METHOD__, "Missing parameters", [ 'status' => 400 ] );
        }

        switch( $params['action'] ) {
            case 'get_stats':
                return pg_lap_stats_by_key($params['parts']['public_key']);
            case 'get_grid':
                return $this->get_grid( $params['parts'] );
            case 'get_participants':
                return $this->get_participants( $params['parts'] );
            default:
                return new WP_Error(__METHOD__, 'missing action parameter' );
        }

    }

    public function get_grid( $parts ) {
        global $wpdb;
        $lap_stats = pg_lap_stats_by_key($parts['public_key']);

        // map grid
        $data_raw = $wpdb->get_results( $wpdb->prepare( "
            SELECT
                lg1.grid_id, r1.value
            FROM $wpdb->dt_location_grid lg1
			LEFT JOIN $wpdb->dt_reports r1 ON r1.grid_id=lg1.grid_id AND r1.type = 'prayer_app' AND r1.timestamp >= %d AND r1.timestamp <= %d
            WHERE lg1.level = 0
              AND lg1.grid_id NOT IN ( SELECT lg11.admin0_grid_id FROM $wpdb->dt_location_grid lg11 WHERE lg11.level = 1 AND lg11.admin0_grid_id = lg1.grid_id )
              AND lg1.admin0_grid_id NOT IN (100050711,100219347,100089589,100074576,100259978,100018514)
            UNION ALL
            SELECT
                lg2.grid_id, r2.value
            FROM $wpdb->dt_location_grid lg2
			LEFT JOIN $wpdb->dt_reports r2 ON r2.grid_id=lg2.grid_id AND r2.type = 'prayer_app' AND r2.timestamp >= %d AND r2.timestamp <= %d
            WHERE lg2.level = 1
              AND lg2.admin0_grid_id NOT IN (100050711,100219347,100089589,100074576,100259978,100018514)
            UNION ALL
            SELECT
                lg3.grid_id, r3.value
            FROM $wpdb->dt_location_grid lg3
			LEFT JOIN $wpdb->dt_reports r3 ON r3.grid_id=lg3.grid_id AND r3.type = 'prayer_app' AND r3.timestamp >= %d AND r3.timestamp <= %d
            WHERE lg3.level = 2
              AND lg3.admin0_grid_id IN (100050711,100219347,100089589,100074576,100259978,100018514)
        ", $lap_stats['start_time'], $lap_stats['end_time'], $lap_stats['start_time'], $lap_stats['end_time'], $lap_stats['start_time'], $lap_stats['end_time'] ), ARRAY_A );

        $data = [];
        foreach ( $data_raw as $row ) {
            if ( ! isset( $data[$row['grid_id']] ) ) {
                $data[$row['grid_id']] = (int) $row['value'] ?? 0;
            }
        }

        return [
            'data' => $data,
        ];
    }

    public function get_participants( $parts ){
        global $wpdb;
        $lap_stats = pg_lap_stats_by_key($parts['public_key']);

        $participants_raw = $wpdb->get_results( $wpdb->prepare( "
           SELECT r.lng as longitude, r.lat as latitude
           FROM $wpdb->dt_reports r
           LEFT JOIN $wpdb->dt_location_grid lg ON lg.grid_id=r.grid_id
            WHERE r.post_type = 'laps'
                AND r.type = 'prayer_app'
           AND r.timestamp >= %d AND r.timestamp <= %d AND r.hash IS NOT NULL
        ", $lap_stats['start_time'], $lap_stats['end_time'] ), ARRAY_A );
        $participants = [];
        if ( ! empty( $participants_raw ) ) {
            foreach( $participants_raw as $p ) {
                if ( ! empty( $p['longitude'] ) ) {
                    $participants[] = [
                        'longitude' => (float) $p['longitude'],
                        'latitude' => (float) $p['latitude']
                    ];
                }
            }
        }

        return $participants;
    }

}
Prayer_Global_Prayer_App_Map::instance();
