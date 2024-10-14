<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

/**
 * Class Prayer_Global_Prayer_App
 */
class PG_Global_Prayer_App_Location_Map extends PG_Global_Prayer_App {

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

        // redirect to completed if not current global lap
        $current_lap = pg_current_global_lap();
        if ( (int) $current_lap['post_id'] === (int) $this->parts['post_id'] ) {
            add_action( 'dt_blank_body', [ $this, 'body' ] );
        } else {
            wp_redirect( trailingslashit( site_url() ) . $this->root . '/' . $this->type . '/' . $this->parts['public_key'] . '/completed' );
            exit;
        }

        add_filter( 'dt_magic_url_base_allowed_css', [ $this, 'dt_magic_url_base_allowed_css' ], 10, 1 );
        add_filter( 'dt_magic_url_base_allowed_js', [ $this, 'dt_magic_url_base_allowed_js' ], 10, 1 );
        add_action( 'wp_enqueue_scripts', [ $this, 'wp_enqueue_scripts' ], 100 );

    }

    public function _header() {
        $this->header_style();
        $this->header_javascript();
    }

    public function new_header_javascript(){

        $current_url = trailingslashit( site_url() ) . $this->parts['root'] . '/' . $this->parts['type'] . '/' . $this->parts['public_key'] . '/';
        ?>
        <script>
            let jsObject = [<?php echo json_encode([
                'parts' => $this->parts,
                'current_lap' => pg_current_global_lap(),
                'nope' => plugin_dir_url( __DIR__ ) . 'assets/images/anon.jpeg',
                'images_url' => pg_grid_image_url(),
                'image_folder' => plugin_dir_url( __DIR__ ) . 'assets/images/',
                'current_url' => $current_url,
                'stats_url' => $current_url . 'stats',
                'map_url' => $current_url . 'map',
                'map_key' => DT_Mapbox_API::get_key(),
                'mirror_url' => dt_get_location_grid_mirror( true ),
                'is_custom' => ( 'custom' === $this->parts['type'] ),
                'is_cta_feature_on' => true,
                'location' => [
                    "grid_id" => "100000002",
                    "name" => "Badakhshan",
                    "admin0_name" => "Afghanistan",
                    "full_name" => "Badakhshan, Afghanistan",
                    "population" => "1,054,100",
                    "latitude" => 37.0329,
                    "longitude" => 71.459,
                    "country_code" => "AF",
                    "admin0_code" => "AFG",
                    "parent_id" => "100000001",
                    "parent_name" => "Afghanistan",
                    "admin0_grid_id" => "100000001",
                    "admin1_grid_id" => "100000002",
                    "admin1_name" => "Badakhshan",
                    "admin2_grid_id" => null,
                    "admin2_name" => null,
                    "admin3_grid_id" => null,
                    "admin3_name" => null,
                    "admin4_grid_id" => null,
                    "admin4_name" => null,
                    "admin5_grid_id" => null,
                    "admin5_name" => null,
                    "level" => 1,
                    "level_name" => "admin1",
                    "north_latitude" => 38.4909,
                    "south_latitude" => 35.4464,
                    "east_longitude" => 74.8941,
                    "west_longitude" => 69.9615,
                    "p_longitude" => 66.0296,
                    "p_latitude" => 33.8284,
                    "p_north_latitude" => 38.4909,
                    "p_south_latitude" => 29.3616,
                    "p_east_longitude" => 74.8941,
                    "p_west_longitude" => 60.5049,
                    "c_longitude" => 66.0296,
                    "c_latitude" => 33.8284,
                    "c_north_latitude" => 38.4909,
                    "c_south_latitude" => 29.3616,
                    "c_east_longitude" => 74.8941,
                    "c_west_longitude" => 60.5049,
                    "peer_locations" => "34",
                    "birth_rate" => 37.5,
                    "death_rate" => 6.5,
                    "growth_rate" => 1.31,
                    "believers" => "168",
                    "christian_adherents" => "33",
                    "non_christians" => "1,053,900",
                    "primary_language" => "Pashto, Southern",
                    "primary_religion" => "Islam",
                    "percent_believers" => 0.02,
                    "percent_christian_adherents" => 0,
                    "percent_non_christians" => 99.98,
                    "admin_level_name" => "state",
                    "admin_level_title" => "the state",
                    "admin_level_name_cap" => "State",
                    "admin_level_name_plural" => "states",
                    "population_int" => 1054100,
                    "believers_int" => 168,
                    "christian_adherents_int" => 33,
                    "non_christians_int" => 1053900,
                    "percent_believers_full" => 0.0158908,
                    "percent_christian_adherents_full" => 0.00312661,
                    "percent_non_christians_full" => 99.981,
                    "all_lost_int" => 1053933,
                    "all_lost" => "1,053,933",
                    "lost_per_believer_int" => 6274,
                    "lost_per_believer" => "6,274",
                    "population_growth_status" => "Fastest Growing in the World",
                    "deaths_non_christians_next_hour" => "0",
                    "deaths_non_christians_next_100" => "78",
                    "deaths_non_christians_next_week" => "131",
                    "deaths_non_christians_next_month" => "563",
                    "deaths_non_christians_next_year" => "6,850",
                    "births_non_christians_last_hour" => "4",
                    "births_non_christians_last_100" => "451",
                    "births_non_christians_last_week" => "757",
                    "births_non_christians_last_month" => "3,248",
                    "births_non_christians_last_year" => "39,522",
                    "deaths_christian_adherents_next_hour" => "0",
                    "deaths_christian_adherents_next_100" => "0",
                    "deaths_christian_adherents_next_week" => "0",
                    "deaths_christian_adherents_next_month" => "0",
                    "deaths_christian_adherents_next_year" => "0",
                    "births_christian_adherents_last_hour" => "0",
                    "births_christian_adherents_last_100" => "0",
                    "births_christian_adherents_last_week" => "0",
                    "births_christian_adherents_last_month" => "0",
                    "births_christian_adherents_last_year" => "1",
                    "deaths_among_lost" => "0",
                    "new_churches_needed" => "210",
                    "favor" => "non_christians",
                    "icon_color" => "brand-lighter",
                    "people_groups_list" => "Nuristani, Prasuni, Garwi, Kohistani, Ishkashimi, Arora (Hindu traditions), Parachi",
                    "people_groups_list_w_pop" => "Nuristani, Prasuni (9,700), Garwi, Kohistani (1,900), Ishkashimi (3,100), Arora (Hindu traditions) (1,500), Parachi (8,100)",
                    "cities_list" => "Fayzabad, Jurm, Darāyim, Chākarān, Bahārak",
                    "cities_list_w_pop" => "Fayzabad (44,421), Jurm (12,106), Darāyim, Chākarān, Bahārak"
                ],
            ]) ?>][0]
        </script>
        <script type="text/javascript" src="<?php echo esc_url( DT_Mapbox_API::$mapbox_gl_js ) ?>"></script>

        <?php
    }
    public function _footer(){
        $this->footer_javascript();

        ?>


        <?php
    }

    public function new_dt_magic_url_base_allowed_js( $allowed_js ) {
        $allowed_js = [];
        return $allowed_js;
    }

    public function new_wp_enqueue_scripts(){
        wp_enqueue_style_async( 'mapbox-gl-css', DT_Mapbox_API::$mapbox_gl_css, [], '1.1.0', 'all' );
        wp_enqueue_style( 'lap-css', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'lap.css', [ 'basic-css' ], fileatime( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'lap.css' ), 'all' );
    }

    public function new_dt_magic_url_base_allowed_css( $allowed_css ) {
        return [
            'lap-css',
            'mapbox-gl-css',
        ];
    }

    public function validate_action( $action ) {
        if ( 'location-map' === $action && $this->is_valid_grid_id( $this->grid_id ) ) {
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

    public function new_body(){
        DT_Mapbox_API::geocoder_scripts();
        ?>

        <section>
            <div class="container" id="map">
                <div class="row">
                    <div class="col">
                        <div class="text-md-center" id="location-map"><span class="loading-spinner active"></span></div>
                    </div>
                </div>
            </div>
        </section>


        <script>

          jQuery(document).ready(() => {
            mapbox_border_map()
          })

          /**
           * Maps
           */
          function mapbox_border_map() {
            let content = jQuery('#location-map')
            let grid_row = jsObject.location

            content.empty().html(`
                <div id="map-wrapper">
                  <div id='mapbox-map'></div>
                </div>
                `
              )

            window.load_map_with_style = ( ) => {
              if ( typeof mapboxgl === 'undefined' ){
                return;
              }
              let center = [grid_row.p_longitude, grid_row.p_latitude]
              mapboxgl.accessToken = jsObject.map_key;

              let map = new mapboxgl.Map({
                container: 'mapbox-map',
                style: 'mapbox://styles/discipletools/clgnj6vkv00e801pj9xnw49i6',
                center: center,
                minZoom: 0,
                zoom: 1
              });
              map.dragRotate.disable();
              map.touchZoomRotate.disableRotation();
              map.addControl(new mapboxgl.NavigationControl());

              map.on('load', function() {

                jQuery.ajax({
                  url: jsObject.mirror_url + 'collection/'+grid_row.parent_id+'.geojson',
                  dataType: 'json',
                  data: null,
                  cache: true,
                  beforeSend: function (xhr) {
                    if (xhr.overrideMimeType) {
                      xhr.overrideMimeType("application/json");
                    }
                  }
                })
                  .done(function (geojson) {
                    /* Make sure that grid_id properties are strings to enable correct filtering for red fill */
                    /* TODO: fix any geojson files that have integers as their grid_id properties and convert them to strings */
                    if (geojson.features.length > 0 && typeof geojson.features[0].properties.grid_id === 'number') {
                      geojson.features.forEach((feature, i) => {
                        geojson.features[i].properties.grid_id = `${feature.properties.grid_id}`
                      });
                    }

                    map.addSource('parent_collection', {
                      'type': 'geojson',
                      'data': geojson
                    });
                    map.addLayer({
                      'id': 'parent_collection_lines',
                      'type': 'line',
                      'source': 'parent_collection',
                      'paint': {
                        'line-color': '#6e6f70',
                        'line-width': 2
                      }
                    });
                    map.addLayer({
                      'id': 'parent_collection_fill',
                      'type': 'fill',
                      'source': 'parent_collection',
                      'filter': [ '==', ['get', 'grid_id'], grid_row.grid_id ],
                      'paint': {
                        'fill-color': '#fff',
                        'fill-opacity': 1
                      }
                    });
                    map.addLayer({
                      'id': 'parent_collection_fill_click',
                      'type': 'fill',
                      'source': 'parent_collection',
                      'paint': {
                        'fill-color': 'white',
                        'fill-opacity': 0
                      }
                    });


                    let point_geojson = {
                      'type': 'FeatureCollection',
                      'features': [
                        {
                          'type': 'Feature',
                          'properties': {
                            'full_name': grid_row.full_name
                          },
                          'geometry': {
                            'type': 'Point',
                            'coordinates': [ grid_row.longitude, grid_row.latitude ]
                          }
                        }]
                    }
                    map.addSource('point_geojson', {
                      'type': 'geojson',
                      'data': point_geojson
                    });
                    map.addLayer({
                      'id': 'poi-labels',
                      'type': 'symbol',
                      'source': 'point_geojson',
                      'layout': {
                        'text-field': ['get', 'full_name'],
                        'text-variable-anchor': ['top', 'bottom', 'left', 'right'],
                        'text-radial-offset': 0.5,
                        'text-justify': 'auto',
                        'text-allow-overlap': false,
                        'text-size': 26
                      },
                      "paint": {
                        "text-color": "#202",
                        "text-halo-color": "#dbe9f4",
                        "text-halo-width": 3
                      },
                    });

                    map.on('click', 'parent_collection_fill_click', function (e) {
                      new mapboxgl.Popup()
                        .setLngLat(e.lngLat)
                        .setHTML(e.features[0].properties.full_name)
                        .addTo(map);
                    });
                    map.on('mouseenter', 'parent_collection_fill_click', function () {
                      map.getCanvas().style.cursor = 'pointer';
                    });

                    map.on('mouseleave', 'parent_collection_fill_click', function () {
                      map.getCanvas().style.cursor = '';
                    });

                    map.fitBounds([
                      [parseFloat( grid_row.p_west_longitude), parseFloat(grid_row.p_south_latitude)], // southwestern corner of the bounds
                      [parseFloat(grid_row.p_east_longitude), parseFloat(grid_row.p_north_latitude)] // northeastern corner of the bounds
                    ], {padding: 25, duration: 5000});

                  })

                if ( grid_row.level >= 2 ) {
                  jQuery.ajax({
                    url: jsObject.mirror_url + 'low/'+grid_row.admin0_grid_id+'.geojson',
                    dataType: 'json',
                    data: null,
                    cache: true,
                    beforeSend: function (xhr) {
                      if (xhr.overrideMimeType) {
                        xhr.overrideMimeType("application/json");
                      }
                    }
                  })
                    .done(function (geojson) {
                      map.addSource('country_outline', {
                        'type': 'geojson',
                        'data': geojson
                      });
                      map.addLayer({
                        'id': 'country_outline_lines',
                        'type': 'line',
                        'source': 'country_outline',
                        'paint': {
                          'line-color': '#6e6f70',
                          'line-width': 4
                        }
                      });
                    })
                }

              }) // map load
            }
            window.load_map_with_style() // initialize map
          }
        </script>
        <?php
    }


     public function dt_magic_url_base_allowed_js( $allowed_js ) {
        $allowed_js = [];
        $allowed_js[] = 'lap-js';
        $allowed_js[] = 'report-js';
        return $allowed_js;
    }

    public function dt_magic_url_base_allowed_css( $allowed_css ) {
        return [
            'lap-css',
            'mapbox-gl-css',
        ];
    }

    public function wp_enqueue_scripts(){
        pg_enqueue_script( 'report-js', 'pages/pray/report.js', [ 'jquery', 'global-functions' ], true );
        pg_enqueue_script( 'lap-js', 'pages/pray/lap.js', [ 'jquery', 'global-functions', 'report-js' ], true );

        wp_enqueue_style_async( 'mapbox-gl-css', DT_Mapbox_API::$mapbox_gl_css, [], fileatime( trailingslashit( plugin_dir_path( __FILE__ ) ) . DT_Mapbox_API::$mapbox_gl_css ), 'all' );
        wp_enqueue_style( 'lap-css', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'lap.css', [ 'basic-css' ], fileatime( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'lap.css' ), 'all' );
    }

    public function header_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/header.php' );

        $current_lap = pg_current_global_lap();
        $current_url = trailingslashit( site_url() ) . $this->parts['root'] . '/' . $this->parts['type'] . '/' . $this->parts['public_key'] . '/';
        if ( (int) $current_lap['post_id'] === (int) $this->parts['post_id'] ) {
            ?>
            <!-- Resources -->
            <script src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js?ver=3" defer></script>
            <script>
                let jsObject = [<?php echo json_encode([
                    'parts' => $this->parts,
                    'current_lap' => pg_current_global_lap(),
                    'translations' => [
                        'state_of_location' => _x( '%1$s of %2$s', 'state of California', 'prayer-global-porch' ),
                        'Keep Praying...' => __( 'Keep Praying...', 'prayer-global-porch' ),
                        "Don't Know Jesus" => __( "Don't Know Jesus", 'prayer-global-porch' ),
                        'Know About Jesus' => __( 'Know About Jesus', 'prayer-global-porch' ),
                        'Know Jesus' => __( 'Know Jesus', 'prayer-global-porch' ),
                        'Praying Paused' => __( 'Praying Paused', 'prayer-global-porch' ),
                        'Great Job!' => __( 'Great Job!', 'prayer-global-porch' ),
                        'Prayer Added!' => __( 'Prayer Added!', 'prayer-global-porch' ),
                    ],
                    'nope' => plugin_dir_url( __DIR__ ) . 'assets/images/anon.jpeg',
                    'images_url' => pg_grid_image_url(),
                    'image_folder' => plugin_dir_url( __DIR__ ) . 'assets/images/',
                    'current_url' => $current_url,
                    'stats_url' => $current_url . 'stats',
                    'map_url' => $current_url . 'map',
                    'is_custom' => ( 'custom' === $this->parts['type'] ),
                    'is_cta_feature_on' => true,
                ]) ?>][0]
            </script>
            <script type="text/javascript" src="<?php echo esc_url( DT_Mapbox_API::$mapbox_gl_js ) ?>" defer></script>
            <link rel="prefetch" href="<?php echo esc_url( plugin_dir_url( __DIR__ ) . 'assets/images/celebrate1.gif' ) ?>" >
            <link rel="prefetch" href="<?php echo esc_url( plugin_dir_url( __DIR__ ) . 'assets/images/celebrate2.gif' ) ?>" >
            <link rel="prefetch" href="<?php echo esc_url( plugin_dir_url( __DIR__ ) . 'assets/images/celebrate3.gif' ) ?>" >
            <?php
        }
    }

    public function footer_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/footer.php' );
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/share-modal.php' );
    }

    public function body(){
        DT_Mapbox_API::geocoder_scripts();
        ?>

        <!-- navigation & widget -->
        <nav class="navbar prayer_navbar fixed-top" id="pb-pray-navbar">
            <div class="container" id="praying-panel">
                <div class="d-flex w-100 gap-2 praying_button_group" role="group" aria-label="<?php echo esc_attr__( 'Praying Button', 'prayer-global-porch' ) ?>">
                    <div class="align-items-center brand-lighter-bg btn-praying d-flex gap-2 prayer-odometer px-2">
                        <i class="icon pg-prayer"></i><span class="two-rem location-count">0</span>
                    </div>
                    <button type="button" class="btn p-2" id="praying_button" data-percent="0" data-seconds="0">
                        <div class="praying__progress"></div>
                        <span class="praying__text uppercase font-weight-normal"></span>
                    </button>
                    <button type="button" class="btn btn-primary-dark btn-praying" id="praying__pause_button">
                        <i class="icon pg-pause"></i>
                    </button>
                    <button type="button" class="btn btn-primary-dark btn-praying" id="praying__continue_button">
                        <i class="icon pg-start"></i>
                    </button>
                    <button type="button" class="btn btn-primary-dark btn-praying" id="praying__open_options" data-bs-toggle="modal" data-bs-target="#option_filter">
                        <i class="icon pg-settings"></i>
                    </button>
                </div>
            </div>

            <div class="container question" id="question-panel">
                <div class="d-flex w-100 gap-2 question_button_group" role="group" aria-label="<?php echo esc_attr__( 'Praying Button', 'prayer-global-porch' ) ?>">

                    <?php $this->question_buttons() ?>

                </div>
            </div>
            <div class="w-100" ></div>
            <div class="container decision" id="decision-panel">
                <div class="d-flex w-100 gap-2 decision_button_group" role="group" aria-label="<?php echo esc_attr__( 'Decision Button', 'prayer-global-porch' ) ?>">

                    <?php $this->decision_buttons() ?>

                </div>
            </div>
            <div class="container celebrate text-center" id="celebrate-panel"></div>
            <div class="w-100" ></div>
            <div class="container flex-column justify-content-center">
                <p class="my-0 font-weight-normal text-center tutorial uppercase one-em lh-1" id="tutorial-location"><?php echo esc_html__( 'Pray for', 'prayer-global-porch' ) ?></p>
                <h5 class="my-0 font-weight-bold text-center w-75" id="location-name"></h5>
            </div>
        </nav>

        <!-- Modal -->
        <div class="modal fade" id="option_filter" tabindex="-1" role="dialog" aria-labelledby="option_filter_label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><?php echo esc_html__( 'Set Your Prayer Experience', 'prayer-global-porch' ) ?></h5>
                        <button type="button" class="d-flex brand-light" data-bs-dismiss="modal" aria-label="<?php echo esc_attr__( 'Close', 'prayer-global-porch' ) ?>">
                            <i class="icon pg-close two-em"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <p><?php echo esc_html__( 'Prayer pace per place', 'prayer-global-porch' ) ?></p>
                        </div>
                        <div class="btn-group-vertical pace-wrapper">
                            <button type="button" class="btn btn-secondary pace" id="pace__1" value="1"><?php echo esc_html( sprintf( __( '%d Minute', 'prayer-global-porch' ), 1 ) ) ?></button>
                            <button type="button" class="btn btn-outline-secondary pace" id="pace__2" value="2"><?php echo esc_html( sprintf( __( '%d Minutes', 'prayer-global-porch' ), 2 ) ) ?></button>
                            <button type="button" class="btn btn-outline-secondary pace" id="pace__3" value="3"><?php echo esc_html( sprintf( __( '%d Minutes', 'prayer-global-porch' ), 3 ) ) ?></button>
                            <button type="button" class="btn btn-outline-secondary pace" id="pace__5" value="5"><?php echo esc_html( sprintf( __( '%d Minutes', 'prayer-global-porch' ), 5 ) ) ?></button>
                            <button type="button" class="btn btn-outline-secondary pace" id="pace__10" value="10"><?php echo esc_html( sprintf( __( '%d Minutes', 'prayer-global-porch' ), 10 ) ) ?></button>
                            <button type="button" class="btn btn-outline-secondary pace" id="pace__15" value="15"><?php echo esc_html( sprintf( __( '%d Minutes', 'prayer-global-porch' ), 15 ) ) ?></button>
                        </div>
                    </div>
                    <div class="modal-footer center">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal"><?php echo esc_html__( "Let's Go!", 'prayer-global-porch' ) ?></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="decision_leave_modal" tabindex="-1" role="dialog" aria-labelledby="option_filter_label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><?php echo esc_html__( 'Are you sure you want to leave?', 'prayer-global-porch' ) ?></h5>
                        <button type="button" class="d-flex brand-light" data-bs-dismiss="modal" aria-label="<?php esc_attr( __( 'Close', 'prayer-global-porch' ) ) ?>">
                            <i class="icon pg-close two-em"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>
                            <?php echo esc_html__( "If you leave now, this place won't count as having been prayed for and will remain available for the next person to pray over." ) ?>
                        </p>
                    </div>
                    <div class="modal-footer center">
                        <button type="button" class="btn btn-outline-primary uppercase" id="decision__keep_praying" data-bs-dismiss="modal"><?php echo esc_html__( "Keep Praying", 'prayer-global-porch' ) ?></button>
                        <button type="button" class="btn btn-primary" id="decision__leave" data-bs-dismiss="modal"><?php echo esc_html__( "Leave", 'prayer-global-porch' ) ?></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="welcome_screen" tabindex="-1" role="dialog" aria-labelledby="welcome_screen_label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body pb-0">
                        <p class="center"><?php echo esc_html( sprintf( __( 'How %s works', 'prayer-global-porch' ), 'Prayer.Global' ) ) ?></p>
                        <h4 class="center"><?php echo esc_html( __( 'Step 1', 'prayer-global-porch' ) ) ?></h4>
                        <p>
                            <?php echo esc_html( __( 'Pray over the location provided using the maps, photos, prayers, people group info, and facts.', 'prayer-global-porch' ) ) ?>
                        </p>

                        <h4 class="center"><?php echo esc_html( __( 'Step 2', 'prayer-global-porch' ) ) ?></h4>
                        <p>
                            <?php echo esc_html( __( 'Pray for one minute (or longer) as the Spirit leads.', 'prayer-global-porch' ) ) ?>
                        </p>
                        <p>
                            <img src="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>assets/images/welcome-keep.png" style="opacity:0.5;" class="img-fluid" />
                        </p>
                        <h4 class="center"><?php echo esc_html( __( 'Step 3', 'prayer-global-porch' ) ) ?></h4>
                        <p>
                            <?php echo sprintf( esc_html( __( 'Click Done to see your impact on the map or %sclick Next to pray for another location', 'prayer-global-porch' ) ), '<br>' ) ?>
                        </p>
                        <p>
                            <img src="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>assets/images/welcome-next.png" style="opacity:0.5;" class="img-fluid" />
                        </p>
                    </div>
                    <div class="modal-footer justify-content-center pt-0">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal"><?php echo esc_html( __( "Let's Go!", 'prayer-global-porch' ) ) ?></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="correction_modal"  role="dialog" aria-labelledby="correction_modal_label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title"><?php echo esc_html__( 'Thank you! Leave us a correction below.', 'prayer-global-porch' ) ?></h5>
                                    <button type="button" id="correction_close" class="d-flex brand-light" data-bs-dismiss="modal" aria-label="<?php echo esc_attr__( 'Close', 'prayer-global-porch' ) ?>">
                                        <i class="icon pg-close two-em"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p><span id="correction_title" class="correction_field"></span></p>
                                    <p>
                                        <?php echo esc_html( __( 'Section:', 'prayer-global-porch' ) ) ?><br>
                                        <select class="form-control form-select correction_field" id="correction_select"></select>
                                    </p>
                                    <p>
                                        <?php echo esc_html( __( 'Correction Requested:', 'prayer-global-porch' ) ) ?><br>
                                        <textarea class="form-control correction_field" id="correction_response" rows="3"></textarea>
                                    </p>
                                    <p>
                                        <button type="button" class="btn btn-primary" id="correction_submit_button"><?php echo esc_html( __( 'Submit', 'prayer-global-porch' ) ) ?></button> <span class="loading-spinner correction_modal_spinner"></span>
                                    </p>
                                    <p id="correction_error" class="correction_field"></p>
                                </div>
                            </div>
                        </div>
                    </div>

        <!-- Location counter -->
        <div class="prayer-odometer">
            <div>
                <i class="ion-location"></i><span class="location-count">0</span>
            </div>
        </div>

        <!-- content section -->
        <section>
            <div class="container" id="map">
                <div class="row">
                    <div class="col">
                        <div class="text-md-center" id="location-map"><span class="loading-spinner active"></span></div>
                    </div>
                </div>
            </div>
            <a href="#content" class="text-decoration-none" id="see-more-button">
                <div class="btn btn-secondary center d-block m-auto uppercase w-fit">
                    <?php echo esc_html__( 'See more', 'prayer-global-porch' ) ?>
                    <i class="icon pg-chevron-down d-block center"></i>
                </div>
            </a>
            <div id="content"></div>
            <div class="container">
                <div class="row text-center mb-3">
                    <div class="col">
                        <i class="icon pg-pray-hands-dark d-block icon-small mb-3" style="margin-top: -2rem"></i>
                        <button type="button" class="btn btn-outline-primary px-4 mx-auto gap-2" id="more_prayer_fuel"><?php echo esc_html__( 'Show More Guided Prayers', 'prayer-global-porch' ) ?><i class="icon pg-chevron-down"></i></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-center" style="padding-bottom:2em;">
                        <button class="brand-lighter" id="correction_button"><?php echo esc_html__( 'Correction Needed?', 'prayer-global-porch' ) ?></button>
                    </div>
                </div>
            </div>
        </section>

        <?php
    }

    public function question_buttons() {
        ?>

        <button type="button" class="btn btn-primary-dark btn-praying uppercase font-weight-normal two-em lh-sm" id="question__yes_done"><?php echo esc_html__( 'Done', 'prayer-global-porch' ) ?></button>
        <button type="button" class="btn btn-secondary btn-praying question__yes uppercase font-weight-normal two-em lh-sm" id="question__yes_next"><?php echo esc_html__( 'Next', 'prayer-global-porch' ) ?></button>

        <?php
    }

    public function decision_buttons() {
        ?>

        <button type="button" class="btn btn-primary-dark btn-praying flex-1" id="decision__home">
            <i class="icon pg-home"></i>
        </button>
        <button type="button" class="btn btn-primary-dark btn-praying uppercase flex-2 two-em font-weight-normal" id="decision__map"><?php echo esc_html__( 'Map', 'prayer-global-porch' ) ?></button>
        <button type="button" class="btn btn-primary-light btn-praying uppercase flex-1 two-em font-weight-normal" id="decision__next"><?php echo esc_html__( 'Next', 'prayer-global-porch' ) ?></button>

        <?php
    }


  /**
   * Log Data Model
   *
   * Lap information includes (post_id, post_type, type, subtype)
   *
   * Prayer information includes (value = number of minutes in prayer, grid_id = location_grid prayed for)
   *
   * User information includes (lng, lat, level, label = location information of the visitors ip address, hash = the unique user id stored by cookie on their client)
   *
   * @param $parts
   * @param $data
   * @return array|false|void|WP_Error
   */
    public function save_log( $parts, $data ) {

        if ( !isset( $parts['post_id'], $parts['root'], $parts['type'], $data['grid_id'] ) ) {
            return new WP_Error( __METHOD__, "Missing parameters", [ 'status' => 400 ] );
        }

        // prayer location log
        $args = [

            // lap information
            'post_id' => $parts['post_id'],
            'post_type' => 'laps',
            'type' => $parts['root'],
            'subtype' => $parts['type'],

            // prayer information
            'value' => $data['pace'] ?? 1,
            'grid_id' => $data['grid_id'],

            // user information
            'payload' => [
                'user_location' => $data['user']['label'] ?? null,
                'user_language' => 'en' // @todo expand for other languages
            ],
            'lng' => $data['user']['lng'] ?? null,
            'lat' => $data['user']['lat'] ?? null,
            'level' => $data['user']['level'] ?? null,
            'label' => $data['user']['country'] ?? null,
            'hash' => $data['user']['hash'] ?? null,
        ];
        if ( is_user_logged_in() ) {
            $args['user_id'] = get_current_user_id();
        }
        $id = dt_report_insert( $args, true, false );

        $response = $this->get_new_location( $parts );
        if ( $response ) {
            $response['report_id'] = $id;
        }

        return $response;
    }

  /**
   * @param $parts
   * @param $data
   * @return int|WP_Error
   */
    public function increment_log( $parts, $data) {
        if ( !isset( $parts['post_id'], $parts['root'], $parts['type'], $data['report_id'] ) ) {
            return new WP_Error( __METHOD__, "Missing parameters", [ 'status' => 400 ] );
        }
        /* Check that the report exists */
        $report = Disciple_Tools_Reports::get( $data['report_id'], 'id' );

        if ( !$report || empty( $report ) || is_wp_error( $report ) ) {
            return new WP_Error( __METHOD__, "Report doesn't exist", [ 'status' => 400 ] );
        }

        $new_value = (int) $report['value'] + 1;
        /* update the report */
        Disciple_Tools_Reports::update( [
            'id' => $data['report_id'],
            'value' => $new_value,
        ] );

        return $new_value;
    }

  /**
   * @param $parts
   * @param $data
   * @return array|false|int|WP_Error
   */
    public function save_correction( $parts, $data ) {

        if ( !isset( $parts['post_id'], $parts['root'], $parts['type'], $data['grid_id'] ) ) {
            return new WP_Error( __METHOD__, 'Missing parameters', [ 'status' => 400 ] );
        }

        if ( empty( $data['section_label'] ) ) {
            $title = $data['current_content']['location']['full_name'];
        } else {
            $title = $data['current_content']['location']['full_name'] . ' (' . $data['section_label'] . ')';
        }

        $current_location_list = 'SECTIONS AVAILABLE DURING REPORT' . PHP_EOL . PHP_EOL;
        foreach ( $data['current_content']['list'] as $list ) {
            $current_location_list .= strtoupper( $list['type'] ) . PHP_EOL;
            foreach ( $list['data'] as $k => $v ){
                if ( is_array( $v ) ) {
                    $v = serialize( $v );
                }
                $current_location_list .= $k . ': ' . $v . PHP_EOL;
            }
            $current_location_list .= PHP_EOL;
        }

        $user_location = 'USER LOCATION' . PHP_EOL . PHP_EOL;
        foreach ( $data['user'] as $uk => $uv ) {
            $user_location .= $uk . ': ' . $uv . PHP_EOL;
        }
        $user_location .= PHP_EOL . 'https://maps.google.com/maps?q='.$data['user']['lat'].','.$data['user']['lng'] .'&ll='.$data['user']['lat'].','.$data['user']['lng'] .'&z=7' .  PHP_EOL;

        $fields = [
            // lap information
            'title' => $title,
            'type' => 'location',
            'status' => 'new',
            'payload' => maybe_serialize( $data ),
            'response' => $data['response'],
            'location_grid_meta' => [
                'values' => [
                    [
                        'grid_id' => $data['grid_id']
                    ]
                ]
            ],
            'user_hash' => $data['user']['hash'],
            'notes' => [
                'Review Link' => get_site_url() . '/show_app/all_content/?grid_id='.$data['grid_id'],
                'Current_Location' => $current_location_list,
                'User_Location' => $user_location,
            ]
        ];

        if ( is_user_logged_in() ) {
            $contact_id = Disciple_Tools_users::get_contact_for_user( get_current_user_id() );
            if ( ! empty( $contact_id ) && ! is_wp_error( $contact_id ) ) {
                $fields['contacts'] = [
                    'values' => [
                        [ 'value' => $contact_id ],
                    ]
                ];
            }
        }

        $result = DT_Posts::create_post( 'feedback', $fields, true, false );

        return $result;
    }

  /**
   * Global query
   * @return array|false|void
   */
    public function get_new_location( $parts, $all = false ) {
        // get 4770 list
        $list_4770 = pg_query_4770_locations();

        // subtract prayed places
        $global_list_prayed = $this->_query_prayed_list();
        $remaining_global = array_diff( $list_4770, $global_list_prayed );

        /**
         * If empty, generate a new global prayer lap and continue
         */
        if ( empty( $remaining_global ) ) {
            dt_write_log( __METHOD__ . ' : generated a new prayer lap' );
            $post_id = $parts['post_id'];
            $remaining_global = pg_generate_new_global_prayer_lap( $post_id );
        }

        /**
         * Most restrictive, available global locations without all promises both global and custom
         */
        $recently_promised_locations = $this->_recently_promised_locations();
        $list_4770_without_all_promises = array_diff( $remaining_global, $recently_promised_locations['all'] );
        if ( ! empty( $list_4770_without_all_promises ) ) {
            shuffle( $list_4770_without_all_promises );
            if ( isset( $list_4770_without_all_promises[0] ) ) {
                $this->_log_promise( $parts, $list_4770_without_all_promises[0] );
                return PG_Stacker::build_location_stack( $list_4770_without_all_promises[0], $all );
            }
        }
        /**
         * Next level restrictive, available global locations without the global promises
         */
        $list_4770_without_custom_promises = array_diff( $remaining_global, $recently_promised_locations['minus_custom'] );
        if ( ! empty( $list_4770_without_custom_promises ) ) {
            shuffle( $list_4770_without_custom_promises );
            if ( isset( $list_4770_without_custom_promises[0] ) ) {
                $this->_log_promise( $parts, $list_4770_without_custom_promises[0] );
                return PG_Stacker::build_location_stack( $list_4770_without_custom_promises[0], $all );
            }
        }
        /**
         * Only the available global locations
         */
        shuffle( $remaining_global );
        return PG_Stacker::build_location_stack( $remaining_global[0], $all );
    }

    public function _query_prayed_list() {
        global $wpdb;
        $current_lap = pg_current_global_lap();
        $time = time();

        $raw_list = $wpdb->get_col( $wpdb->prepare(
            "SELECT DISTINCT grid_id
                    FROM $wpdb->dt_reports
                    WHERE timestamp >= %d
                      AND type = 'prayer_app'
                      AND timestamp <= %d
                      ",
        $current_lap['start_time'], $time ) );

        return array_unique( $raw_list );
    }

    public function get_ip_location() {
        if ( is_user_logged_in() ) {
            $user_id = get_current_user_id();
            $location_meta = get_user_meta( $user_id, PG_NAMESPACE . 'location', true );

            return $location_meta;
        } else {
            $response = DT_Ipstack_API::get_location_grid_meta_from_current_visitor();
            if ( $response ) {
                $response['hash'] = hash( 'sha256', serialize( $response ) . mt_rand( 1000000, 10000000000000000 ) );
                $array = array_reverse( explode( ', ', $response['label'] ) );
                $response['country'] = $array[0] ?? '';
            }
            return $response;
        }
    }
    public function _recently_promised_locations() {
        global $wpdb;
        $current_lap = pg_current_global_lap();
        $time = time();
        $time = $time - 150; // 150 seconds. 1 minute in que, 1 minute to pray, 30 sec to transition

        $raw_list = $wpdb->get_results( $wpdb->prepare(
            "
            SELECT meta_value as grid_id, 'global' as type
            FROM $wpdb->dt_activity_log
            WHERE hist_time > %d
                AND action = 'prayer_promise'
                AND object_type = 'prayer_global'
                AND object_subtype = 'global'
                AND object_id = %d
            UNION ALL
            SELECT meta_value as grid_id, 'custom' as type
            FROM $wpdb->dt_activity_log
            WHERE hist_time > %d
                AND action = 'prayer_promise'
                AND object_type = 'prayer_global'
                AND object_subtype = 'custom'
            ",
            $time, $current_lap['post_id'], $time
        ), ARRAY_A );

        $list = [
            'all' => [],
            'minus_custom' => []
        ];

        if ( empty( $raw_list ) ) {
            return $list;
        }

        // build different ranges of arrays
        foreach ( $raw_list as $item ) {
            $list['all'][] = $item['grid_id'];
            if ( 'global' === $item['type'] ) {
                $list['minus_custom'][] = $item['grid_id'];
            }
        }

        $list['all'] = array_unique( $list['all'] );
        $list['minus_custom'] = array_unique( $list['minus_custom'] );

        return $list;
    }

    public function _log_promise( $parts, $grid_id ) {
        dt_activity_insert( // insert activity record
            [
                'action'         => 'prayer_promise',
                'object_type'    => 'prayer_global',
                'object_subtype' => 'global',
                'object_id'      => $parts['post_id'],
                'object_name'    => '',
                'meta_value'    => $grid_id,
            ]
        );
    }


}
PG_Global_Prayer_App_Location_Map::instance();
