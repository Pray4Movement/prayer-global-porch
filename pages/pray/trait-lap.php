<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

trait PG_Lap_Trait {

    private $icons = [
        'ion-android-warning',
        'ion-happy',
        'ion-ios-body',
        'ion-map',
        'ion-sad',
        'pg-chevron-down',
        'pg-close',
        'pg-pause',
        'pg-play',
        'pg-pray-hands-dark',
        'pg-prayer',
        'pg-settings',
        'pg-streak',
    ];

    public function dt_magic_url_base_allowed_js( $allowed_js ) {
        return [
            'lap-js',
            'report-js',
            'global-functions',
            'canvas-confetti',
            'umami',
        ];
    }

    public function dt_magic_url_base_allowed_css( $allowed_css ) {
        return [
            'lap-css',
        ];
    }

    public function wp_enqueue_scripts(){
        pg_enqueue_script( 'report-js', 'pages/pray/report.js', [ 'global-functions' ], true );
        pg_enqueue_script( 'lap-js', 'pages/pray/lap.js', [ 'global-functions', 'report-js' ], true );

        wp_enqueue_style( 'lap-css', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'lap.css', [], fileatime( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'lap.css' ), 'all' );
    }

    public function header_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/header-event.php' );
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . '../utilities/security.php' );

        $current_url = trailingslashit( site_url() ) . $this->parts['root'] . '/' . $this->parts['type'] . '/' . $this->parts['public_key'] . '/';
        $nonce = PG_Nonce::create( 'direct-api' );

        $svg_manager = new SVG_Spritesheet_Manager();
        $spritesheet_url = $svg_manager->get_cached_spritesheet_url( $this->icons, 'pg' );
        ?>
        <!-- Resources -->
        <script>
            let jsObject = [<?php echo json_encode([
                'parts' => $this->parts,
                'nonce' => PG_Nonce::create( 'direct-api' ),
                'translations' => [
                    'state_of_location' => esc_html__( '%1$s of %2$s', 'prayer-global-porch' ),
                    'Keep Praying...' => esc_html__( 'Keep Praying...', 'prayer-global-porch' ),
                    "Don't Know Jesus" => esc_html__( "Don't Know Jesus", 'prayer-global-porch' ),
                    'Know About Jesus' => esc_html__( 'Know About Jesus', 'prayer-global-porch' ),
                    'Know Jesus' => esc_html__( 'Know Jesus', 'prayer-global-porch' ),
                    'Praying Paused' => esc_html__( 'Praying Paused', 'prayer-global-porch' ),
                    'Great Job!' => esc_html__( 'Great Job!', 'prayer-global-porch' ),
                    'Prayer Added!' => esc_html__( 'Prayer Added!', 'prayer-global-porch' ),
                    'join_and_create_custom_prayer_relays' => esc_html__( 'Join and create custom prayer relays', 'prayer-global-porch' ),
                    'view_your_interactive_prayer_history' => esc_html__( 'View your interactive prayer history', 'prayer-global-porch' ),
                    'prayer_streaks_badges_and_more' => esc_html__( 'Prayer streaks, badges and more', 'prayer-global-porch' ),
                    'register_now' => esc_html__( 'Register Now', 'prayer-global-porch' ),
                    'create_your_own_free_login' => esc_html__( 'Create your own free login', 'prayer-global-porch' ),
                    'no_thanks' => esc_html__( 'No Thanks', 'prayer-global-porch' ),
                    'daily_streak' => esc_html__( 'Daily Prayer Streak', 'prayer-global-porch' ),
                    'best' => esc_html__( 'Best', 'prayer-global-porch' ),
                    'done' => esc_html__( 'Done', 'prayer-global-porch' ),
                    'fetching_stats' => esc_html__( 'Fetching your stats...', 'prayer-global-porch' ),
                    'download_the_app' => esc_html__( 'Download the Prayer.Global app to get streak notifications and more!', 'prayer-global-porch' ),
                    'update_the_app' => esc_html__( 'Update the Prayer.Global app to get streak notifications and more!', 'prayer-global-porch' ),
                    'go_to_app_store' => esc_html__( 'Go to App Store', 'prayer-global-porch' ),
                ],
                'nope' => plugin_dir_url( __DIR__ ) . 'assets/images/anon.jpeg',
                'images_url' => pg_grid_image_url(),
                'image_folder' => plugin_dir_url( __DIR__ ) . 'assets/images/',
                'current_url' => $current_url,
                'map_url' => $current_url . 'map',
                'is_custom' => ( 'custom' === $this->parts['type'] ),
                'is_cta_feature_on' => true,
                'user_id' => get_current_user_id(),
                'cache_url' => 'https://s3.prayer.global/',
                'direct_api_url' => plugin_dir_url( dirname( __DIR__ ) ),
                'icons_url' => plugin_dir_url( __DIR__ ) . 'assets/images/icons',
                'spritesheet_url' => $spritesheet_url,
            ]) ?>][0]
        </script>
        <?php
    }

    public function footer_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/footer.php' );
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/share-modal.php' );
    }

    public function body(): void {

        $svg_manager = new SVG_Spritesheet_Manager();

        $spritesheet_dir = $svg_manager->get_cached_spritesheet_dir( $this->icons, 'pg' );
        ?>

        <?php //phpcs:ignore ?>
        <?php echo file_get_contents( $spritesheet_dir ); ?>

        <!-- navigation & widget -->
        <nav class="prayer-navbar">
            <div class="container praying-button-group" id="praying-panel" role="group" aria-label="Praying Button">
                <div class="btn btn-praying prayer-odometer">

                    <?php if ( is_user_logged_in() ) : ?>

                        <?php //phpcs:ignore ?>
                        <?php echo pg_profile_icon( true ) ?>

                    <?php else : ?>

                        <svg fill="currentColor" width="1em" height="1em" >
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
                    <svg fill="currentColor" width="1em" height="1em" >
                        <use href="#pg-pause"></use>
                    </svg>
                </button>
                <button type="button" class="btn btn-praying bg-dark" data-display="flex" id="praying__continue_button">
                    <svg height="1em" width="1em" fill="currentColor" >
                        <use href="#pg-play"></use>
                    </svg>
                </button>
                <button type="button" class="btn btn-praying bg-light" id="praying__open_options" data-bs-toggle="modal" data-bs-target="#option_filter">
                    <svg height="1em" width="1em" fill="currentColor" >
                        <use href="#pg-settings"></use>
                    </svg>
                </button>
            </div>
            <div class="container" id="question-panel">
                <div class="btn-group question" role="group" aria-label="Praying Button">

                    <?php $this->question_buttons() ?>

                </div>
            </div>
            <div class="w-100" ></div>
            <div class="container" id="decision-panel">
                <div class="btn-group decision" role="group" aria-label="Decision Button">

                    <?php $this->decision_buttons() ?>

                </div>
            </div>
            <div class="w-100" ></div>
            <div class="container flow space-sm text-center">
                <p class="tutorial uc f-xlg lh-1" id="tutorial-location"><?php echo esc_html__( 'Pray for', 'prayer-global-porch' ) ?></p>
                <h2 class="lh-1 text-center bold f-md" id="location-name">
                    <div class="skeleton" data-title></div>
                </h2>
                <p class="f-sm">
                    <?php echo sprintf( esc_html__( 'In Prayer Relay %s', 'prayer-global-porch' ), esc_html( $this->page_title ) ) ?>
                </p>
            </div>
        </nav>

        <div class="celebrate-panel text-center" id="celebrate-panel">
            <div class="container flow" data-small>
                <h2>
                    <?php echo esc_html__( 'Great Job!', 'prayer-global-porch' ) ?>
                    <br />
                    <?php echo esc_html__( 'Prayer Added!', 'prayer-global-porch' ) ?>
                </h2>
                <div id="celebrate-content"></div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="decision_leave_modal" tabindex="-1" role="dialog" aria-labelledby="option_filter_label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="option_filter_label"><?php echo esc_html__( 'Are you sure you want to leave?', 'prayer-global-porch' ) ?></h5>
                        <button type="button" id="decision__close" aria-label="<?php esc_attr( __( 'Close', 'prayer-global-porch' ) ) ?>">
                            <svg class="f-xlg" height="1em" width="1em" fill="currentColor" >
                                <use href="#pg-close"></use>
                            </svg>
                        </button>
                    </div>
                    <p class="modal-body">
                        <?php echo esc_html__( "If you leave now, this place won't have been prayed for." ) ?>
                    </p>
                    <div class="modal-footer">
                        <button type="button" class="btn outline" id="decision__keep_praying" data-bs-dismiss="modal"><?php echo esc_html__( 'Keep Praying', 'prayer-global-porch' ) ?></button>
                        <button type="button" class="btn bg-dark" id="decision__leave" data-bs-dismiss="modal"><?php echo esc_html__( 'Leave', 'prayer-global-porch' ) ?></button>
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
                        <svg class="icon dark" width="0.75em" height="0.75em">
                            <use href="#ion-ios-body"></use>
                        </svg>
                        <span class="no">
                            <div class="skeleton" data-number></div>
                        </span>
                    </div>
                    <div>
                        <svg class="icon light" width="0.75em" height="0.75em">
                            <use href="#ion-ios-body"></use>
                        </svg>
                        <span class="neutral">
                            <div class="skeleton" data-number></div>
                        </span>
                    </div>
                    <div>
                        <svg class="icon orange" width="0.75em" height="0.75em">
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
                <svg width="1em" height="1em" fill="currentColor">
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
                <div class="flow text-center center">
                    <svg class="f-xxlg" height="1em" width="1em" fill="currentColor" >
                        <use href="#pg-pray-hands-dark"></use>
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
                            <svg class="f-xlg" height="1em" width="1em" fill="currentColor" >
                                <use href="#pg-close"></use>
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
                            <div class="loading-spinner correction_modal_spinner"></div>
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
                            <svg class="f-xlg" height="1em" width="1em" fill="currentColor" >
                                <use href="#pg-close"></use>
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
                    <div class="modal-footer text-center">
                        <button type="button" class="btn btn-primary" id="option_filter_done" data-bs-dismiss="modal"><?php echo esc_html__( "Let's Go!", 'prayer-global-porch' ) ?></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="welcome_screen" tabindex="-1" role="dialog" aria-labelledby="welcome_screen_label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" id="welcome_screen_close" data-bs-dismiss="modal" aria-label="<?php esc_attr( __( 'Close', 'prayer-global-porch' ) ) ?>">
                            <svg class="f-xlg" height="1em" width="1em" viewBox="0 0 33 33" fill="currentColor" >
                                <use href="<?php echo esc_url( plugin_dir_url( __DIR__ ) . 'assets/images/close.svg#pg-icon' ) ?>"></use>
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5 class="text-center"><?php echo esc_html( sprintf( __( 'How %s works', 'prayer-global-porch' ), 'Prayer.Global' ) ) ?></h5>
                        <h4 class="text-center"><?php echo esc_html( __( 'Step 1', 'prayer-global-porch' ) ) ?></h4>
                        <p>
                            <?php echo esc_html( __( 'Pray over the location provided using the maps, photos, prayers, people group info, and facts.', 'prayer-global-porch' ) ) ?>
                        </p>

                        <h4 class="text-center"><?php echo esc_html( __( 'Step 2', 'prayer-global-porch' ) ) ?></h4>
                        <p>
                            <?php echo esc_html( __( 'Pray for one minute (or longer) as the Spirit leads.', 'prayer-global-porch' ) ) ?>
                        </p>
                        <p>
                            <img src="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>assets/images/welcome-keep.png" style="opacity:0.5;" class="img-fluid" />
                        </p>
                        <h4 class="text-center"><?php echo esc_html( __( 'Step 3', 'prayer-global-porch' ) ) ?></h4>
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

    public function question_buttons() {
        ?>

        <button type="button" class="btn btn-praying lh-sm bg-dark" id="question__yes_done"><?php echo esc_html( __( 'Done', 'prayer-global-porch' ) ) ?></button>
        <button type="button" class="btn btn-praying lh-sm bg-orange" id="question__yes_next"><?php echo esc_html( __( 'Next', 'prayer-global-porch' ) ) ?></button>

        <?php
    }

    public function decision_buttons() {
        ?>

        <button type="button" class="btn btn-praying bg-dark" id="decision__home">
            <?php echo esc_html__( 'Map', 'prayer-global-porch' ) ?>
        </button>

        <?php
    }


    /**
     * @param $parts
     * @param $data
     * @return int|WP_Error
     */
    public function increment_prayer_time( $parts, $data ) {
        if ( !isset( $parts['post_id'], $parts['root'], $parts['type'], $data['report_id'] ) ) {
            return new WP_Error( __METHOD__, 'Missing parameters', [ 'status' => 400 ] );
        }
        /* Check that the report exists */
        $report = Disciple_Tools_Reports::get( $data['report_id'], 'id' );

        if ( !$report || empty( $report ) || is_wp_error( $report ) ) {
            return new WP_Error( __METHOD__, "Report doesn't exist", [ 'status' => 400 ] );
        }

        $new_value = (int) $report['value'] + 1;
        if ( $new_value <= 60 ){
            /* update the report */
            global $wpdb;
            $wpdb->query( $wpdb->prepare( "
                UPDATE $wpdb->dt_reports
                SET value = value + 1
                WHERE id = %d
            ", $data['report_id'] ) );
        }

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
}
