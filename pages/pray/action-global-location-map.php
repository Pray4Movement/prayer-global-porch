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
        $current_lap = Prayer_Stats::get_relay_details( $this->parts['public_key'], $this->parts['post_id'] );
        if ( $current_lap['status'] === 'complete' ) {
            wp_redirect( trailingslashit( site_url() ) . $this->root . '/' . $this->type . '/' . $this->parts['public_key'] . '/map' );
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
                  <div id='mapbox-map' style="border-radius: 0"></div>
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
                zoom: 1,
                zoomControls: false,
              });
              map.dragRotate.disable();
              map.touchZoomRotate.disableRotation();

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
                      'beforeId': 'poi-labels',
                      'type': 'line',
                      'source': 'parent_collection',
                      'paint': {
                        'line-color': '#6e6f70',
                        'line-width': 2
                      }
                    });
                    map.addLayer({
                      'id': 'parent_collection_fill',
                      'beforeId': 'poi-labels',
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
                      'beforeId': 'poi-labels',
                      'type': 'fill',
                      'source': 'parent_collection',
                      'paint': {
                        'fill-color': 'white',
                        'fill-opacity': 0
                      }
                    });

                    console.log(map)

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

                    map.moveLayer('poi-labels')

                    const paddingBoundary = 500 * 0.2
                    const padding = {
                      top: paddingBoundary,
                      bottom: paddingBoundary,
                      left: 315 + paddingBoundary,
                      right: 315 + paddingBoundary,
                    }

                    map.fitBounds([
                      [parseFloat( grid_row.p_west_longitude), parseFloat(grid_row.p_south_latitude)], // southwestern corner of the bounds
                      [parseFloat(grid_row.p_east_longitude), parseFloat(grid_row.p_north_latitude)] // northeastern corner of the bounds
                    ], {padding: padding, duration: 0});

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

                      map.moveLayer('country_outline_lines', 'poi-labels')
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
        $allowed_css[] = 'lap-css';
        $allowed_css[] = 'mapbox-gl-css';
        return $allowed_css;
    }

    public function wp_enqueue_scripts(){
        pg_enqueue_script( 'report-js', 'pages/pray/report.js', [ 'jquery', 'global-functions' ], true );

        wp_enqueue_style_async( 'mapbox-gl-css', DT_Mapbox_API::$mapbox_gl_css, [], '1.1.0', 'all' );
        wp_enqueue_style( 'lap-css', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'lap.css', [ 'basic-css' ], fileatime( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'lap.css' ), 'all' );
    }

    public function header_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/header.php' );

        $current_url = trailingslashit( value: site_url() ) . $this->parts['root'] . '/' . $this->parts['type'] . '/' . $this->parts['public_key'] . '/';

        $url = new DT_URL( dt_get_url_path() );
        $grid_id = $url->query_params->get( 'grid_id' );

        $stack = PG_Stacker::_stack_query( $grid_id );

        ?>
        <!-- Resources -->
        <script src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js?ver=3" defer></script>
        <script>
            let jsObject = [<?php echo json_encode([
                'parts' => $this->parts,
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
                'location' => $stack['location'],
                'nope' => plugin_dir_url( __DIR__ ) . 'assets/images/anon.jpeg',
                'images_url' => pg_grid_image_url(),
                'image_folder' => plugin_dir_url( __DIR__ ) . 'assets/images/',
                'current_url' => $current_url,
                'map_url' => $current_url . 'map',
                'is_custom' => ( 'custom' === $this->parts['type'] ),
                'is_cta_feature_on' => true,
            ]) ?>][0]
        </script>
        <script type="text/javascript" src="<?php echo esc_url( DT_Mapbox_API::$mapbox_gl_js ) ?>" defer></script>
        <?php
    }

    public function footer_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/footer.php' );
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/share-modal.php' );
    }
}
PG_Global_Prayer_App_Location_Map::instance();
