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

    public function body(){
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

        wp_enqueue_style_async( 'mapbox-gl-css', DT_Mapbox_API::$mapbox_gl_css, [], '1.1.0', 'all' );
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
                    'map_key' => DT_Mapbox_API::get_key(),
                    'mirror_url' => dt_get_location_grid_mirror( true ),
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
            <?php
        }
    }

    public function footer_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/footer.php' );
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/share-modal.php' );
    }

}
PG_Global_Prayer_App_Location_Map::instance();
