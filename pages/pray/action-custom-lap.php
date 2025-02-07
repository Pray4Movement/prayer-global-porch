<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.


/**
 * Class PG_Custom_Prayer_App_Lap
 */
class PG_Custom_Prayer_App_Lap extends PG_Custom_Prayer_App {

    public $lap_title;
    public $lap_title_initials;
    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct() {
        parent::__construct();

        /**
         * post type and module section
         */
        if ( dt_is_rest() ) {
            add_action( 'rest_api_init', [ $this, 'add_endpoints' ] );
        }

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
        if ( ! empty( $this->parts['action'] ) ) {
            return;
        }

        // redirect to completed if not current global lap
        add_action( 'dt_blank_body', [ $this, 'body' ] );
        add_filter( 'dt_magic_url_base_allowed_css', [ $this, 'dt_magic_url_base_allowed_css' ], 10, 1 );
        add_filter( 'dt_magic_url_base_allowed_js', [ $this, 'dt_magic_url_base_allowed_js' ], 10, 1 );
        add_action( 'wp_enqueue_scripts', [ $this, 'wp_enqueue_scripts' ], 100 );

        $lap = pg_get_custom_lap_by_post_id( $this->parts['post_id'] );
        $title_words = preg_split( '/[\s\-_]+/', $lap['title'] );

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
        $allowed_js = [];
        $allowed_js[] = 'lap-js';
        $allowed_js[] = 'report-js';
        return $allowed_js;
    }

    public function dt_magic_url_base_allowed_css( $allowed_css ) {
        return [];
    }

    public function wp_enqueue_scripts(){
        pg_enqueue_script( 'report-js', 'pages/pray/report.js', [ 'jquery', 'global-functions' ], true );
        pg_enqueue_script( 'lap-js', 'pages/pray/lap.js', [ 'jquery', 'global-functions', 'report-js' ], true );
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

        $current_lap = pg_get_custom_lap_by_post_id( $this->parts['post_id'] );
        $current_url = trailingslashit( site_url() ) . $this->parts['root'] . '/' . $this->parts['type'] . '/' . $this->parts['public_key'] . '/';
        if ( (int) $current_lap['post_id'] === (int) $this->parts['post_id'] ) {
            ?>
            <!-- Resources -->
            <script src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js?ver=3"></script>
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
                    'user_id' => get_current_user_id(),
                    'is_custom' => ( 'custom' === $this->parts['type'] ),
                    'is_cta_feature_on' => !$current_lap['ctas_off'],
                    'direct_api_url' => plugin_dir_url( dirname( __DIR__ ) ),
                    'cache_url' => 'https://s3.prayer.global/',
                ]) ?>][0]
            </script>
            <link rel="stylesheet" href="<?php echo esc_url( trailingslashit( plugin_dir_url( __FILE__ ) ) ) ?>lap.css?ver=<?php echo esc_attr( fileatime( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'lap.css' ) ) ?>" type="text/css" media="all">
            <?php
        }
    }

    public function footer_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/footer.php' );
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/share-modal.php' );
    }

    public function body(){

        ?>

        <?php //phpcs:ignore ?>
        <?php echo file_get_contents( plugin_dir_path( __DIR__ ) . '/assets/images/ionicon-subset.svg' ); ?>
        <?php //phpcs:ignore ?>
        <?php echo file_get_contents( plugin_dir_path( __DIR__ ) . '/assets/images/pgicon-subset.svg' ); ?>

        <!-- navigation & widget -->
        <nav class="prayer-navbar">
            <div class="container praying-button-group" id="praying-panel" role="group" aria-label="Praying Button">
                <div class="btn btn-praying prayer-odometer">

                    <?php if ( is_user_logged_in() ) : ?>

                        <?php //phpcs:ignore ?>
                        <?php echo pg_profile_icon() ?>

                    <?php else : ?>

                        <svg fill="currentColor" width="1em" height="1em" viewBox="0 0 33 33">
                            <use href="#pg-prayer"></use>
                        </svg>

                    <?php endif; ?>

                    <span class="location-count">-</span>
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
                <button type="button" class="btn btn-praying bg-light" id="praying__open_options" data-bs-toggle="modal" data-bs-target="#option_filter">
                    <svg height="1em" width="1em" viewBox="0 0 33 33" fill="currentColor" >
                        <use href="#pg-settings"></use>
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
            <div class="container flow space-sm text-center">
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
        <section class="prayer-content flow space-lg">
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
            <div class="container flow space-md relative" id="content">

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
                    <button class="btn simple" id="correction_button"><?php echo esc_html__( 'Correction Needed?', 'prayer-global-porch' ) ?></button>
                </div>
            </div>

        </section>
        <div class="modal fade" id="correction_modal" tabindex="-1" role="dialog" aria-labelledby="correction_modal_label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo esc_html( __( 'Thank you! Leave us a correction below.', 'prayer-global-porch' ) ) ?></h5>
                        <button type="button" id="correction_close" data-bs-dismiss="modal" aria-label="<?php esc_attr( __( 'Close', 'prayer-global-porch' ) ) ?>">
                            <svg class="f-xlg" height="1em" width="1em" viewBox="0 0 33 33" fill="currentColor" >
                                <use href="<?php echo esc_url( plugin_dir_url( __DIR__ ) . 'assets/images/close.svg#pg-icon' ) ?>"></use>
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body flow space-md">
                        <p><span id="correction_title" class="correction_field"></span></p>
                        <div class="flow space-sm form-group">
                            <label for="correction_select">
                                <?php echo esc_html( __( 'Section:', 'prayer-global-porch' ) ) ?>
                            </label>
                            <select class="form-control form-select correction_field" id="correction_select"></select>
                        </div>
                        <div class="flow space-sm form-group">
                            <label for="correction_response">
                                <?php echo esc_html( __( 'Correction Requested:', 'prayer-global-porch' ) ) ?>
                            </label>
                            <textarea class="form-control correction_field" id="correction_response" rows="3"></textarea>
                        </div>
                        <p id="correction_error" class="correction_field"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" id="correction_submit_button">
                            <?php echo esc_html( __( 'Submit', 'prayer-global-porch' ) ) ?>
                            <span class="loading-spinner correction_modal_spinner"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="option_filter" tabindex="-1" role="dialog" aria-labelledby="option_filter_label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><?php echo esc_html__( 'Set Your Prayer Experience', 'prayer-global-porch' ) ?></h5>
                        <button type="button" id="option_filter_close" data-bs-dismiss="modal" aria-label="<?php esc_attr( __( 'Close', 'prayer-global-porch' ) ) ?>">
                            <svg class="f-xlg" height="1em" width="1em" viewBox="0 0 33 33" fill="currentColor" >
                                <use href="<?php echo esc_url( plugin_dir_url( __DIR__ ) . 'assets/images/close.svg#pg-icon' ) ?>"></use>
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <p><?php echo esc_html__( 'Prayer pace per place', 'prayer-global-porch' ) ?></p>
                        </div>
                        <div class="btn-group vertical">
                            <button type="button" class="btn pace-btn" id="pace__1" value="1"><?php echo esc_html( sprintf( __( '%d Minute', 'prayer-global-porch' ), 1 ) ) ?></button>
                            <button type="button" class="btn pace-btn" id="pace__2" value="2"><?php echo esc_html( sprintf( __( '%d Minutes', 'prayer-global-porch' ), 2 ) ) ?></button>
                            <button type="button" class="btn pace-btn" id="pace__3" value="3"><?php echo esc_html( sprintf( __( '%d Minutes', 'prayer-global-porch' ), 3 ) ) ?></button>
                            <button type="button" class="btn pace-btn" id="pace__5" value="5"><?php echo esc_html( sprintf( __( '%d Minutes', 'prayer-global-porch' ), 5 ) ) ?></button>
                            <button type="button" class="btn pace-btn" id="pace__10" value="10"><?php echo esc_html( sprintf( __( '%d Minutes', 'prayer-global-porch' ), 10 ) ) ?></button>
                            <button type="button" class="btn pace-btn" id="pace__15" value="15"><?php echo esc_html( sprintf( __( '%d Minutes', 'prayer-global-porch' ), 15 ) ) ?></button>
                        </div>
                    </div>
                    <div class="modal-footer center">
                        <button type="button" class="btn btn-primary" id="option_filter_done" data-bs-dismiss="modal"><?php echo esc_html__( "Let's Go!", 'prayer-global-porch' ) ?></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="welcome_screen" tabindex="-1" role="dialog" aria-labelledby="welcome_screen_label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <h5 class="center"><?php echo esc_html( sprintf( __( 'How %s works', 'prayer-global-porch' ), 'Prayer.Global' ) ) ?></h5>
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
                        <button id="welcome_screen_done" class="btn"><?php echo esc_html( __( "Let's Go!", 'prayer-global-porch' ) ) ?></button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }


    /**
     * Register REST Endpoints
     * @link https://github.com/DiscipleTools/disciple-tools-theme/wiki/Site-to-Site-Link for outside of wordpress authentication
     */
    public function add_endpoints() {
        $namespace = $this->root . '/v1';
        register_rest_route(
            $namespace,
            '/'.$this->type,
            [
                [
                    'methods' => WP_REST_Server::CREATABLE,
                    'callback' => [ $this, 'endpoint' ],
                    'permission_callback' => '__return_true'
                ],
            ]
        );
    }

    public function endpoint( WP_REST_Request $request ) {
        $params = $request->get_params();

        if ( ! isset( $params['parts'], $params['action'], $params['data'] ) ) {
            return new WP_Error( __METHOD__, 'Missing parameters', [ 'status' => 400 ] );
        }

        $params = dt_recursive_sanitize_array( $params );

        switch ( $params['action'] ) {
            case 'log':
                $stack = $this->save_log( $params['parts'], $params['data'] );
                $current_lap = pg_current_custom_lap( $params['parts']['post_id'] );
                $params['parts']['post_id'] = $current_lap['post_id'];
                $params['parts']['public_key'] = $current_lap['key'];
                $stack['parts'] = $params['parts'];
                return $stack;
            case 'correction':
                return $this->save_correction( $params['parts'], $params['data'] );
            case 'refresh':
                $stack = $this->get_new_location( $params['parts'] );
                $current_lap = pg_current_custom_lap( $params['parts']['post_id'] );
                $params['parts']['post_id'] = $current_lap['post_id'];
                $params['parts']['public_key'] = $current_lap['key'];
                $stack['parts'] = $params['parts'];
                return $stack;
            case 'ip_location':
                return $this->get_ip_location();
            case 'increment_log':
                return $this->increment_log( $params['parts'], $params['data'] );
            default:
                return new WP_Error( __METHOD__, 'Incorrect action', [ 'status' => 400 ] );
        }
    }

    /**
     * @param $parts
     * @param $data
     * @return int|WP_Error
     */
    public function increment_log( $parts, $data ) {
        if ( !isset( $parts['post_id'], $parts['root'], $parts['type'], $data['report_id'] ) ) {
            return new WP_Error( __METHOD__, 'Missing parameters', [ 'status' => 400 ] );
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
            return new WP_Error( __METHOD__, 'Missing parameters', [ 'status' => 400, 'data' => [ $parts, $data ] ] );
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
                'user_location' => $data['user']['label'],
                'user_language' => 'en' // @todo expand for other languages
            ],
            'lng' => $data['user']['lng'],
            'lat' => $data['user']['lat'],
            'level' => $data['user']['level'],
            'label' => $data['user']['country'],
            'hash' => $data['user']['hash'],
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
            $contact_id = Disciple_Tools_Users::get_contact_for_user( get_current_user_id() );
            if ( ! empty( $contact_id ) && ! is_wp_error( $contact_id ) ) {
                $fields['contacts'] = [
                    'values' => [
                        [ 'value' => $contact_id ],
                    ]
                ];
            }
        }

        return DT_Posts::create_post( 'feedback', $fields, true, false );
    }

    /**
     * Custom query
     * @return array|false|void
     */
    public function get_new_location( $parts ) {
//        dt_write_log( __METHOD__ . ': Start' );

        if ( empty( $this->parts ) && ! empty( $parts ) ) {
            $this->parts = $parts;
        }

        /**
         * GET LISTS
         * $list_4770 is a full static list of the 4770
         */
        $list_4770 = pg_query_4770_locations();

        /**
         * GET REMAINING CUSTOM PRAYER LOCATIONS
         * The current recorded custom list reduces the full 4770 list, leaving only locations that remain to be covered.
         */
        $remaining_custom = $this->_query_custom_prayed_list( $parts['post_id'], $list_4770 );

        /**
         * HANDLE COMPLETED LAP
         */
        if ( empty( $remaining_custom ) ) {
            if ( $this->_is_single_lap( $parts['post_id'] ) ) {
                $time = time();
                update_post_meta( $parts['post_id'], 'status', 'complete' );
                update_post_meta( $parts['post_id'], 'end_time', $time );
                update_post_meta( $parts['post_id'], 'end_date', $time );

                if ( dt_is_rest() ) { // signal new lap to rest request
                    return [];
                } else { // if first load on finished lap, redirect to new lap
                    wp_redirect( '/prayer_app/custom/'. $this->parts['public_key'] .'/map' );
                    exit;
                }
            } else {
                $remaining_custom = pg_generate_new_custom_prayer_lap( $parts['post_id'] );
            }
        }

        /**
         * GET MATCH FOR GLOBAL PRIORITY
         *
         * $global_remaining is a list of those locations still available for prayer in the global lap
         * $promised_locations is a list of locations issued in the last 90 seconds
         */
        $remaining_global = self::_remaining_global_prayed_list( $list_4770 );
        $global_priority_list = array_intersect( $remaining_custom, $remaining_global );
        $recently_promised_locations = $this->_recently_promised_locations( $parts['post_id'] );

        // global priority minus all promises global and custom
        $global_priority_not_promised_all = array_diff( $global_priority_list, $recently_promised_locations['all'] );
        if ( ! empty( $global_priority_not_promised_all ) ) {
            shuffle( $global_priority_not_promised_all );
            if ( isset( $global_priority_not_promised_all[0] ) ) {
                $this->_log_promise( $parts, $global_priority_not_promised_all[0] );
                return PG_Stacker::build_location_stack( $global_priority_not_promised_all[0] );
            }
        }
        // global priority minus extra custom laps, leaving just global promises and this custom laps promises
        $global_priority_not_promised_minus_custom = array_diff( $global_priority_list, $recently_promised_locations['minus_custom'] );
        if ( ! empty( $global_priority_not_promised_minus_custom ) ) {
            shuffle( $global_priority_not_promised_minus_custom );
            if ( isset( $global_priority_not_promised_minus_custom[0] ) ) {
                $this->_log_promise( $parts, $global_priority_not_promised_minus_custom[0] );
                return PG_Stacker::build_location_stack( $global_priority_not_promised_minus_custom[0] );
            }
        }
        // global priority minus all but promises for this lap
        $global_priority_not_promised_post_only = array_diff( $global_priority_list, $recently_promised_locations['post_only'] );
        if ( ! empty( $global_priority_not_promised_post_only ) ) {
            shuffle( $global_priority_not_promised_post_only );
            if ( isset( $global_priority_not_promised_post_only[0] ) ) {
                $this->_log_promise( $parts, $global_priority_not_promised_post_only[0] );
                return PG_Stacker::build_location_stack( $global_priority_not_promised_post_only[0] );
            }
        }
        // remaining custom lap minus all current promises
        $custom_remaining_not_promised_all = array_diff( $remaining_custom, $recently_promised_locations['all'] );
        if ( ! empty( $custom_remaining_not_promised_all ) ) {
            shuffle( $custom_remaining_not_promised_all );
            if ( isset( $custom_remaining_not_promised_all[0] ) ) {
                $this->_log_promise( $parts, $custom_remaining_not_promised_all[0] );
                return PG_Stacker::build_location_stack( $custom_remaining_not_promised_all[0] );
            }
        }
        // remaining custom lap minus promises to other custom laps
        $custom_remaining_not_promised_minus_custom = array_diff( $remaining_custom, $recently_promised_locations['minus_custom'] );
        if ( ! empty( $custom_remaining_not_promised_minus_custom ) ) {
            shuffle( $custom_remaining_not_promised_minus_custom );
            if ( isset( $custom_remaining_not_promised_minus_custom[0] ) ) {
                $this->_log_promise( $parts, $custom_remaining_not_promised_minus_custom[0] );
                return PG_Stacker::build_location_stack( $custom_remaining_not_promised_minus_custom[0] );
            }
        }
        // remaining custom lap minus all promises for this custom lap
        $custom_remaining_not_promised_post_only = array_diff( $remaining_custom, $recently_promised_locations['post_only'] );
        if ( ! empty( $custom_remaining_not_promised_post_only ) ) {
            shuffle( $custom_remaining_not_promised_post_only );
            if ( isset( $custom_remaining_not_promised_post_only[0] ) ) {
                $this->_log_promise( $parts, $custom_remaining_not_promised_post_only[0] );
                return PG_Stacker::build_location_stack( $custom_remaining_not_promised_post_only[0] );
            }
        }
        // global priority list ignoring promises
        if ( ! empty( $global_priority_list ) ) {
            shuffle( $global_priority_list );
            if ( isset( $global_priority_list[0] ) ) {
                $this->_log_promise( $parts, $global_priority_list[0] );
                return PG_Stacker::build_location_stack( $global_priority_list[0] );
            }
        }
        // remaining custom lap ignoring promises
        shuffle( $remaining_custom );
        if ( isset( $remaining_custom[0] ) ) {
            $this->_log_promise( $parts, $remaining_custom[0] );
            return PG_Stacker::build_location_stack( $remaining_custom[0] );
        } else {
            return [];
        }
    }

    private function _is_single_lap( $post_id ) {
        $lap = pg_get_custom_lap_by_post_id( $post_id );

        $single_lap = isset( $lap['single_lap'] ) ? $lap['single_lap'] : false;

        return $single_lap === '1';
    }

    public function _log_promise( $parts, $grid_id ) {
        dt_activity_insert( // insert activity record
            [
                'action'         => 'prayer_promise',
                'object_type'    => 'prayer_global',
                'object_subtype' => 'custom',
                'object_id'      => $parts['post_id'],
                'object_name'    => '',
                'meta_value'    => $grid_id,
            ]
        );
    }

    public function _recently_promised_locations( $post_id ) {
        global $wpdb;
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
            UNION ALL
            SELECT meta_value as grid_id, 'custom' as type
            FROM $wpdb->dt_activity_log
            WHERE hist_time > %d
                AND action = 'prayer_promise'
                AND object_type = 'prayer_global'
                AND object_subtype = 'custom'
            UNION ALL
            SELECT meta_value as grid_id, 'post' as type
            FROM $wpdb->dt_activity_log
            WHERE hist_time > %d
                AND action = 'prayer_promise'
                AND object_type = 'prayer_global'
                AND object_subtype = 'custom'
                AND object_id = %d
            ",
            $time, $time, $time, $post_id
        ), ARRAY_A );

        $list = [
            'all' => [],
            'minus_custom' => [],
            'post_only' => []
        ];

        if ( empty( $raw_list ) ) {
            return $list;
        }

        // build different ranges of arrays
        foreach ( $raw_list as $item ) {
            $list['all'][] = $item['grid_id'];
            if ( 'post' === $item['type'] || 'global' === $item['type'] ) {
                $list['minus_custom'][] = $item['grid_id'];
            }
            if ( 'post' === $item['type'] ) {
                $list['post_only'][] = $item['grid_id'];
            }
        }

        $list['all'] = array_unique( $list['all'] );
        $list['minus_custom'] = array_unique( $list['minus_custom'] );
        $list['post_only'] = array_unique( $list['post_only'] );

        return $list;
    }

    public static function _remaining_global_prayed_list( $list_4770 = null ) {
        global $wpdb;
        if ( empty( $list_4770 ) ) {
            $list_4770 = pg_query_4770_locations();
        }
        $current_lap = pg_current_global_lap();

        $raw_list = $wpdb->get_col( $wpdb->prepare(
            "SELECT DISTINCT grid_id
                    FROM $wpdb->dt_reports
                    WHERE timestamp >= %d
                    AND type = 'prayer_app'
                    AND subtype != 'event'
                    ",
        $current_lap['start_time'] ) );

        $prayed_list = array_unique( $raw_list );
        $remaining_4770 = array_diff( $list_4770, $prayed_list );

        if ( empty( $remaining_4770 ) ) {
            dt_write_log( __METHOD__ . ' :: new global lap generated' );
            $post_id = $current_lap['post_id'];
            $remaining_4770 = pg_generate_new_global_prayer_lap( $post_id );
        }

        return $remaining_4770;
    }

    public function _query_custom_prayed_list( $post_id, $list_4770 ) {
        global $wpdb;
        $time = time();

        $list = $wpdb->get_col( $wpdb->prepare(
            "SELECT DISTINCT grid_id
                    FROM $wpdb->dt_reports
                    WHERE
                      post_id = %d
                      AND type = 'prayer_app'
                      AND subtype = 'custom'
                      AND timestamp <= %d
                      ",
        $post_id, $time ) );

        $custom_prayed = array_unique( $list );
        return array_diff( $list_4770, $custom_prayed );
    }

    public function get_ip_location() {
        if ( is_user_logged_in() ) {
            $user_id = get_current_user_id();

            return get_user_meta( $user_id, PG_NAMESPACE . 'location', true );
        } else {
            $response = DT_Ipstack_API::get_location_grid_meta_from_current_visitor();
            if ( $response ) {
                $response['hash'] = hash( 'sha256', serialize( $response ). mt_rand( 1000000, 10000000000000000 ) );
                $array = array_reverse( explode( ', ', $response['label'] ) );
                $response['country'] = $array[0] ?? '';
            }
            return $response;
        }
    }
}
PG_Custom_Prayer_App_Lap::instance();
