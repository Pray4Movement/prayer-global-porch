<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

/**
 * Class PG_Custom_Prayer_App_Lap
 */
class PG_Custom_High_Volume_Prayer_App_Lap extends PG_Custom_Prayer_App {

    public $lap_title;
    public $lap_title_initials;
    private static $_instance = null;
    public $type = 'custom';
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

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

        // has empty action, of stop
        if ( 'event' !== $this->parts['action'] ) {
            return;
        }

        // redirect to completed if not current global lap
        add_action( 'dt_blank_body', [ $this, 'body' ] );
        add_filter( 'dt_magic_url_base_allowed_css', [ $this, 'dt_magic_url_base_allowed_css' ], 10, 1 );
        add_filter( 'dt_magic_url_base_allowed_js', [ $this, 'dt_magic_url_base_allowed_js' ], 200, 1 );
        add_action( 'wp_enqueue_scripts', [ $this, 'wp_enqueue_scripts' ], 100 );

        $lap = pg_get_custom_lap_by_post_id( $this->parts['post_id'] );
        $title_words = preg_split( "/[\s\-_]+/", $lap['title'] );

        $this->lap_title = $lap['title'];
        if ( strlen( $lap['title'] ) < 6 ) {
            $this->lap_title = $lap['title'];
        } else if ( $title_words !== false ) {
            $little_words = [
                'of',
                'in',
                'the',
                'a',
                'it',
                'for',
            ];

            $filtered_title_words = array_filter( $title_words, function( $word ) use ( $little_words ) {
                return !in_array( strtolower( $word ), $little_words );
            });
            $title_initials = implode( array_map( function( $word ) {
                return ucfirst( substr( $word, 0, 1 ) );
            }, $filtered_title_words ) );

            $this->lap_title_initials = $title_initials;
        }
    }

    public function dt_magic_url_base_allowed_js( $allowed_js ) {
        $allowed_js = [
            'lap-event-js',
            'canvas-confetti',
            'global-functions',
        ];
        return $allowed_js;
    }

    public function dt_magic_url_base_allowed_css( $allowed_css ) {
        return [];
    }

    public function wp_enqueue_scripts(){
        pg_enqueue_script( 'lap-event-js', 'pages/pray/lap-event.js', [], [ 'strategy' => 'defer' ] );
    }

    public function _header() {
        $this->header_style();
        $this->header_javascript();
    }
    public function _footer(){
        $this->footer_javascript();
    }

    public function header_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/header-event.php' );

        $url = new DT_URL( dt_get_url_path() );
        $grid_id = $url->query_params->has( 'grid_id' ) ? $url->query_params->get( 'grid_id' ) : 0;

        $current_lap = pg_get_custom_lap_by_post_id( $this->parts['post_id'] );
        $current_url = trailingslashit( site_url() ) . $this->parts['root'] . '/' . $this->parts['type'] . '/' . $this->parts['public_key'] . '/';
        if ( (int) $current_lap['post_id'] === (int) $this->parts['post_id'] ) {

            ?>
            <!-- Resources -->
            <script>
                let jsObject = [<?php echo json_encode([
                    'parts' => $this->parts,
                    'current_lap' => pg_current_global_lap(),
                    'translations' => [
                        'state_of_location' => _x( '%1$s of %2$s', 'state of California', 'prayer-global-porch' ),
                        'keep_praying' => __( 'Keep Praying...', 'prayer-global-porch' ),
                        "Don't Know Jesus" => __( "Don't Know Jesus", 'prayer-global-porch' ),
                        'Know About Jesus' => __( 'Know About Jesus', 'prayer-global-porch' ),
                        'Know Jesus' => __( 'Know Jesus', 'prayer-global-porch' ),
                        'praying_paused' => __( 'Praying Paused', 'prayer-global-porch' ),
                        'Prayer Added!' => __( 'Prayer Added!', 'prayer-global-porch' ),
                    ],
                    'nope' => plugin_dir_url( __DIR__ ) . 'assets/images/anon.jpeg',
                    'cache_url' => 'https://s3.prayer.global/',
                    'images_url' => pg_grid_image_url(),
                    'image_folder' => plugin_dir_url( __DIR__ ) . 'assets/images/',
                    'json_folder' => plugin_dir_url( __DIR__ ) . 'assets/json/',
                    'current_url' => $current_url,
                    'stats_url' => $current_url . 'stats',
                    'map_url' => $current_url . 'map',
                    'api_url' => PG_API_ENDPOINT,
                    'is_custom' => ( 'custom' === $this->parts['type'] ),
                    'is_cta_feature_on' => !$current_lap['ctas_off'],
                ]) ?>][0]
            </script>

            <link rel="stylesheet" href="<?php echo esc_url( trailingslashit( plugin_dir_url( __FILE__ ) ) ) ?>lap-event.css?ver=<?php echo esc_attr( fileatime( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'lap-event.css' ) ) ?>" type="text/css" media="all">
            <link rel="preload" href="https://s3.prayer.global/maps/<?php echo esc_attr( $grid_id ) ?>.jpg" >

            <?php
        }
    }

    public function footer_javascript(){}

    public function body(){

        ?>

        <script>
            const url = new URL(location.href)
            const gridId = url.searchParams.get('grid_id')

            if (gridId) {
                //const jsonUrl = jsObject.json_folder + '100000002' + '.json'
                //const jsonUrl = jsObject.json_folder + '100000003' + '.json'
                const jsonUrl = jsObject.cache_url + 'json/' + gridId + '.json'

                fetch(jsonUrl)
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error("Failed to fetch JSON", response.status)
                        }
                        return response.json()
                    })
                    .then((json) => {
                        jsObject.current_content = {
                            location: json
                        }
                    })
                    .catch((error) => {
                        console.error(error)
                    })
            } else {
                console.log('no grid_id found')
            }
        </script>

        <?php //phpcs:ignore ?>
        <?php echo file_get_contents( plugin_dir_path( __DIR__ ) . '/assets/images/ionicon-subset.svg' ); ?>
        <?php //phpcs:ignore ?>
        <?php echo file_get_contents( plugin_dir_path( __DIR__ ) . '/assets/images/pgicon-subset.svg' ); ?>

        <!-- navigation & widget -->
        <nav class="prayer-navbar">
            <div class="container praying-button-group" id="praying-panel" role="group" aria-label="Praying Button">
                <div class="btn btn-praying prayer-odometer">
                    <svg fill="currentColor" width="1em" height="1em" viewBox="0 0 33 33">
                        <use href="#pg-prayer"></use>
                    </svg>
                    <span class="location-count">0</span>
                </div>
                <button type="button" class="btn praying-timer" id="praying-button" data-percent="0" data-seconds="0">
                    <div class="praying__progress"></div>
                    <span class="praying__text uppercase font-weight-normal"></span>
                </button>
                <button type="button" class="btn btn-praying bg-dark" data-display="flex" id="praying__pause_button">
                    <svg fill="currentColor" width="1em" height="1em" viewBox="0 0 33 33">
                        <use href="#pg-pause"></use>
                    </svg>
                </button>
                <button type="button" class="btn btn-praying bg-dark" data-display="flex" id="praying__continue_button">
                    <svg height="1em" width="1em" viewBox="0 0 33 33" fill="currentColor" >
                        <use href="<?php echo esc_url( plugin_dir_url( __DIR__ ) . 'assets/images/start.svg#pg-icon' ) ?>"></use>
                    </svg>
                </button>
            </div>
            <div class="container" id="question-panel">
                <div class="btn-group question" role="group" aria-label="Praying Button">
                    <button type="button" class="btn btn-praying lh-sm bg-dark" id="question__yes_done"><?php echo esc_html( __( 'Done', 'prayer-global-porch' ) ) ?></button>
                    <button type="button" class="btn btn-praying lh-sm bg-orange" id="question__yes_next"><?php echo esc_html( __( 'Next', 'prayer-global-porch' ) ) ?></button>
                </div>
            </div>
            <div class="w-100" ></div>
            <div class="container" id="decision-panel">
                <div class="btn-group decision" role="group" aria-label="Decision Button">
                    <button type="button" class="btn btn-praying bg-dark" id="decision__home">
                        <svg height="1em" width="1em" viewBox="0 0 33 33" fill="currentColor" >
                            <use href="<?php echo esc_url( plugin_dir_url( __DIR__ ) . 'assets/images/home.svg#pg-icon' ) ?>"></use>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="w-100" ></div>
            <div class="container flow sm text-center">
                <p class="tutorial uc f-xlg lh-1" id="tutorial-location"><?php echo esc_html__( 'Pray for', 'prayer-global-porch' ) ?></p>
                <h2 class="lh-1 center bold w-75 f-md" id="location-name">
                    <div class="skeleton" data-title></div>
                </h2>
                <p class="f-sm">
                    <?php echo sprintf( esc_html__( 'In Prayer Relay %s', 'prayer-global-porch' ), esc_html( $this->lap_title ) ) ?>
                </p>
            </div>
        </nav>

        <div class="celebrate-panel text-center" id="celebrate-panel">
            <div class="container">
                <h2>
                    <?php echo esc_html__( 'Great Job!', 'prayer-global-porch' ) ?>
                    <br />
                    <?php echo esc_html__( 'Prayer Added!', 'prayer-global-porch' ) ?>
                </h2>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="decision_leave_modal" tabindex="-1" role="dialog" aria-labelledby="option_filter_label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="option_filter_label"><?php echo esc_html__( 'Are you sure you want to leave?', 'prayer-global-porch' ) ?></h5>
                        <button type="button" id="decision__close" aria-label="<?php esc_attr( __( 'Close', 'prayer-global-porch' ) ) ?>">
                            <svg class="f-xlg" height="1em" width="1em" viewBox="0 0 33 33" fill="currentColor" >
                                <use href="<?php echo esc_url( plugin_dir_url( __DIR__ ) . 'assets/images/close.svg#pg-icon' ) ?>"></use>
                            </svg>
                        </button>
                    </div>
                    <p class="modal-body">
                        <?php echo esc_html__( "If you leave now, this place won't have been prayed for." ) ?>
                    </p>
                    <div class="modal-footer">
                        <button type="button" class="btn outline" id="decision__keep_praying" data-bs-dismiss="modal"><?php echo esc_html__( "Keep Praying", 'prayer-global-porch' ) ?></button>
                        <button type="button" class="btn bg-dark" id="decision__leave" data-bs-dismiss="modal"><?php echo esc_html__( "Leave", 'prayer-global-porch' ) ?></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- content section -->
        <section class="prayer-content flow lg">
            <div class="container" id="map">
                <div class="text-md-center location-map" id="location-map">
                    <div class="skeleton" data-map></div>
                </div>
                <div class="population-info">
                    <div>
                        <svg class="icon dark" width="0.75em" height="0.75em" viewBox="0 0 512 512">
                            <use href="#ion-ios-body"></use>
                        </svg>
                        <span class="no">
                            <div class="skeleton" data-number></div>
                        </span>
                    </div>
                    <div>
                        <svg class="icon light" width="0.75em" height="0.75em" viewBox="0 0 512 512">
                            <use href="#ion-ios-body"></use>
                        </svg>
                        <span class="neutral">
                            <div class="skeleton" data-number></div>
                        </span>
                    </div>
                    <div>
                        <svg class="icon orange" width="0.75em" height="0.75em" viewBox="0 0 512 512">
                            <use href="#ion-ios-body"></use>
                        </svg>
                        <span class="yes">
                            <div class="skeleton" data-number></div>
                        </span>
                    </div>
                </div>
            </div>
            <a href="#content-anchor" class="btn bg-orange" id="see-more-button" style="display: none">
                <?php echo esc_html__( 'See more', 'prayer-global-porch' ) ?>
                <svg viewBox="0 0 33 33" width="1em" height="1em" fill="currentColor">
                    <use href="#pg-chevron-down"></use>
                </svg>
            </a>
            <div class="container flow md relative" id="content">

                <hr />

                <div class="block basic-block text-center">
                    <div class="block__header">
                        <h5 class="mb-0 uc">
                            <div class="skeleton" data-title></div>
                        </h5>
                    </div>
                    <div class="block__content">
                        <p class="skeleton" data-text></p>
                        <p class="skeleton" data-text></p>
                    </div>
                </div>

                <hr />


                <div class="block basic-block text-center">
                    <div class="block__header">
                        <h5 class="mb-0 uc">
                            <div class="skeleton" data-title></div>
                        </h5>
                    </div>
                    <div class="block__content">
                        <p class="skeleton" data-text></p>
                        <p class="skeleton" data-text></p>
                    </div>
                </div>

                <hr>
            </div>
            <div class="container">
                <div class="flow text-center">
                    <svg class="f-xxlg" height="1em" width="1em" viewBox="0 0 33 33" fill="currentColor" >
                        <use href="<?php echo esc_url( plugin_dir_url( __DIR__ ) . 'assets/images/pray-hands-dark.svg#pg-icon' ) ?>"></use>
                    </svg>
                    <button type="button" class="btn outline" id="more_prayer_fuel"><?php echo esc_html__( 'Show More Guided Prayers', 'prayer-global-porch' ) ?><i class="icon pg-chevron-down"></i></button>
                </div>
            </div>
        </section>

        <?php
    }

}
PG_Custom_High_Volume_Prayer_App_Lap::instance();

