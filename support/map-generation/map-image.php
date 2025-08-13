<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

/**
 * Class Prayer_Global_Prayer_App
 */
class PG_Global_Prayer_App_Location_Map extends PG_Public_Page {

    public $grid_id;
    public $url_path = 'map-image';
    public $page_title = 'Map Image';

    public function __construct() {
        parent::__construct();

        $grid_id = isset( $_GET['grid_id'] ) ? sanitize_text_field( wp_unslash( $_GET['grid_id'] ) ) : null;
        $this->grid_id = $grid_id;
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
        <?php
    }


    public function dt_magic_url_base_allowed_js( $allowed_js ) {
        $allowed_js[] = 'map-image-js';
        return $allowed_js;
    }

    public function dt_magic_url_base_allowed_css( $allowed_css ) {
        $allowed_css[] = 'lap-css';
        $allowed_css[] = 'mapbox-gl-css';
        return $allowed_css;
    }

    public function wp_enqueue_scripts(){
        pg_enqueue_script( 'map-image-js', 'support/map-generation/map-image.js', [ 'jquery', 'global-functions' ], true );

        wp_enqueue_style_async( 'mapbox-gl-css', DT_Mapbox_API::$mapbox_gl_css, [], '1.1.0', 'all' );
        wp_enqueue_style( 'lap-css', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'lap.css', [ 'basic-css' ], fileatime( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'lap.css' ), 'all' );
    }

    public function header_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . '../pages/assets/header.php' );

        $current_url = trailingslashit( value: site_url() ) . $this->parts['root'] . '/' . $this->parts['type'] . '/' . $this->parts['public_key'] . '/';

        $url = new DT_URL( dt_get_url_path() );
        $grid_id = $url->query_params->get( 'grid_id' );

        $stack = [];
        if ( $grid_id && $this->is_valid_grid_id( $grid_id ) ) {
            $stack = PG_Stacker::_stack_query( $grid_id );
        }

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
}
new PG_Global_Prayer_App_Location_Map();