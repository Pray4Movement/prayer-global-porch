<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

/**
 * Class Prayer_Global_Porch_Public_Porch_Profile
 */
class PG_User_App_Profile extends DT_Magic_Url_Base {

    public $page_title = 'User Profile';
    public $root = 'dashboard';
    private string $spritesheet_url = '';
    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct() {
        parent::__construct();

        add_action( 'rest_api_init', [ $this, 'add_endpoints' ] );

        /**
         * tests if other URL
         */
        $url = dt_get_url_path();
        if ( strpos( $url, $this->root ) !== 0 ) {
            return;
        }

        if ( !is_user_logged_in() ) {
            wp_redirect( '/login' );
            exit;
        }


        $svg_manager = new SVG_Spritesheet_Manager();

        $icons = [
            'pg-go-logo',
            'pg-relay',
            'pg-prayer',
            'pg-plus',
            'pg-settings',
            'pg-close',
            'pg-streak',
            'pg-logo-prayer',
            'pg-private',
            'pg-world-light',
            'pg-info',
            'pg-chevron-left',
            'pg-bell',
            'pg-share',
            'ion-ellipsis-horizontal',
        ];

        $this->spritesheet_url = $svg_manager->get_cached_spritesheet_url( $icons );

        // load if valid url
        add_action( 'dt_blank_body', [ $this, 'body' ] ); // body for no post key
        add_action( 'dt_blank_head', [ $this, '_header' ] );
        add_action( 'dt_blank_footer', [ $this, '_footer' ] );
        add_action( 'dt_blank_title', [ $this, 'page_tab_title' ] );

        add_action( 'template_redirect', [ $this, 'theme_redirect' ] );
        add_filter( 'dt_blank_access', '__return_true', 100, 1 );
        add_filter( 'dt_allow_non_login_access', '__return_true', 100, 1 );
        add_filter( 'dt_override_header_meta', '__return_true', 100, 1 );
        add_filter( 'dt_templates_for_urls', [ $this, 'register_url' ], 199, 1 ); // registers url as valid once tests are passed

        add_filter( 'dt_magic_url_base_allowed_css', [ $this, 'dt_magic_url_base_allowed_css' ], 10, 1 );
        add_filter( 'dt_magic_url_base_allowed_js', [ $this, 'dt_magic_url_base_allowed_js' ], 10, 1 );
        add_action( 'wp_enqueue_scripts', [ $this, 'wp_enqueue_scripts' ], 1000 );
        add_action( 'wp_print_scripts', [ $this, 'print_scripts' ], 5 ); // authorizes scripts
        add_action( 'wp_print_footer_scripts', [ $this, 'print_scripts' ], 5 ); // authorizes scripts
        add_action( 'wp_print_styles', [ $this, 'print_styles' ], 1500 ); // authorizes styles
    }

    public function page_tab_title(){
        return __( 'User Profile', 'prayer-global-porch' );
    }

    public function register_url( $template_for_url ){
        $url = dt_get_url_path( true );
        $url_parts = explode( '/', $url );
        $template_for_url[join( '/', $url_parts )] = 'template-blank.php';
        return $template_for_url;
    }

    public function dt_magic_url_base_allowed_css( $allowed_css ) {
        $allowed_css[] = 'porch-user-style-css';
        $allowed_css[] = 'jquery-ui-site-css';
        $allowed_css[] = 'foundations-css';
        $allowed_css[] = 'dt-components-css';
        return $allowed_css;
    }

    public function dt_magic_url_base_allowed_js( $allowed_js ) {
        return [
            'porch-user-site-js',
            'components-js',
            'user-profile-js',
            'lit-bundle-js',
            'dt-components',
        ];
    }

    public function wp_enqueue_scripts() {
        if ( is_user_logged_in() ) {
            $user = wp_get_current_user();
            $gravatar_url = get_avatar_url( $user->user_login );
            $user_stats = new User_Stats( $user->ID );
            $badge_manager = new PG_Badge_Manager( $user->ID );
            $available_badges = $badge_manager->get_all_badges();
            $badge_images_url = trailingslashit( plugin_dir_url( __DIR__ ) ) . 'assets/images/badges/';
            $available_badges = [
                /* ==== EARNED BADGES ==== */
                /* Progression */
                [
                    'id' => 'streak_10',
                    'title' => '10 DayStreak',
                    'description_unearned' => 'Earn this badge by praying for 10 days straight',
                    'description_earned' => 'You earned this badge by praying for 10 days straight',
                    'value' => 10,
                    'image' => $badge_images_url . 'streak_10.png',
                    'bw_image' => $badge_images_url . 'streak_10_bw.png',
                    'type' => 'progression',
                    'category' => 'streak',
                    'hidden' => false,
                    'has_earned_badge' => true,
                    'timestamp' => 1726723200,
                    'next_badge' => [
                        'id' => 'streak_20',
                        'title' => '20 Day Streak',
                        'description_unearned' => 'Earn this badge by praying for 20 days straight',
                        'description_earned' => 'You earned this badge by praying for 20 days straight',
                        'value' => 20,
                        'image' => $badge_images_url . 'streak_20.png',
                        'bw_image' => $badge_images_url . 'streak_20_bw.png',
                    ],
                    'progress' => [
                        'from' => 10,
                        'to' => 20,
                        'current' => 15,
                        'text' => '5 left',
                    ],
                ],
                /* Multiple */
                [
                    'id' => 'perfect_week',
                    'title' => __( 'Perfect Week ', 'prayer-global-porch' ),
                    'description_unearned' => __( 'Earn this badge by praying every day this week', 'prayer-global-porch' ),
                    'description_earned' => __( 'You earned this badge by praying every day this week', 'prayer-global-porch' ),
                    'value' => 7,
                    'image' => $badge_images_url . 'perfect_week.png',
                    'bw_image' => $badge_images_url . 'perfect_week_bw.png',
                    'type' => 'multiple',
                    'category' => 'consistency',
                    'hidden' => false,
                    'has_earned_badge' => true,
                    'no_times_earned' => 3,
                    'timestamp' => 1726723200,
                ],
                /* Achievement */
                [
                    'id' => 'first_prayer',
                    'title' => 'First Prayer',
                    'description_unearned' => 'Earn this badge by praying for the first time',
                    'description_earned' => 'You earned this badge by praying for the first time',
                    'value' => 1,
                    'image' => $badge_images_url . 'first_prayer.png',
                    'bw_image' => $badge_images_url . 'first_prayer_bw.png',
                    'type' => 'achievement',
                    'category' => 'community',
                    'hidden' => false,
                    'has_earned_badge' => true,
                    'timestamp' => 1726723200,
                ],
                /* Challenge */
                [
                    'id' => 'challenge_october_2025',
                    'title' => 'October Challenge 2025',
                    'description_unearned' => 'Earn this badge by praying for the October Challenge 2025',
                    'description_earned' => 'You earned this badge by praying for the October Challenge 2025',
                    'value' => 1,
                    'image' => $badge_images_url . 'challenge_october_2025.png',
                    'bw_image' => $badge_images_url . 'challenge_october_2025_bw.png',
                    'type' => 'challenge',
                    'category' => 'community',
                    'hidden' => false,
                    'has_earned_badge' => true,
                    'timestamp' => 1726723200,
                ],
                /* ==== NOT EARNED BADGES ==== */
                /* Progression */
                [
                    'id' => 'relay_location',
                    'title' => 'Relay Location',
                    'description_unearned' => 'Earn this badge by praying for 100 locations in a relay',
                    'description_earned' => 'You earned this badge by praying for 100 locations in a relay',
                    'value' => 100,
                    'image' => $badge_images_url . 'relay_location_100.png',
                    'bw_image' => $badge_images_url . 'relay_location_100_bw.png',
                    'type' => 'progression',
                    'category' => 'location',
                    'hidden' => false,
                    'has_earned_badge' => false,
                    'progress' => [
                        'from' => 0,
                        'to' => 10,
                        'current' => 0,
                        'text' => '10 left',
                    ],
                ],
                /* Achievement */
                [
                    'id' => 'team_player',
                    'title' => 'Team Player',
                    'description_unearned' => 'Earn this badge by joining a relay',
                    'description_earned' => 'You earned this badge by joining a relay',
                    'value' => 1,
                    'image' => $badge_images_url . 'team_player.png',
                    'bw_image' => $badge_images_url . 'team_player_bw.png',
                    'type' => 'achievement',
                    'category' => 'community',
                    'hidden' => false,
                    'has_earned_badge' => false,
                ],
                [
                    'id' => 'challenge_december_2025',
                    'title' => 'December Challenge 2025',
                    'description_unearned' => 'Earn this badge by praying for the December Challenge 2025',
                    'description_earned' => 'You earned this badge by praying for the December Challenge 2025',
                    'value' => 1,
                    'image' => $badge_images_url . 'challenge_december_2025.png',
                    'bw_image' => $badge_images_url . 'challenge_december_2025_bw.png',
                    'type' => 'challenge',
                    'category' => 'community',
                    'hidden' => false,
                    'has_earned_badge' => false,
                    'challenge_cutoff' => 1726723200,
                ],
                /* Hidden Achievement */
                [
                    'id' => 'comeback_champion',
                    'title' => __( 'Comeback Champion', 'prayer-global-porch' ),
                    'description_earned' => __( 'You earned this badge by restarting praying after breaking a streak', 'prayer-global-porch' ),
                    'value' => 1,
                    'hidden' => true,
                    'category' => 're-engagement',
                    'image' => $badge_images_url . 'perfect_month.png',
                    'bw_image' => $badge_images_url . 'perfect_month_bw.png',
                    'type' => 'achievement',
                    'has_earned_badge' => false,
                ],
            ];
        }
        dt_theme_enqueue_script( 'dt-components', 'dt-assets/build/components/index.js', [] );
        dt_theme_enqueue_style( 'dt-components-css', 'dt-assets/build/css/light.min.css', [] );

        wp_localize_script( 'components-js', 'jsObject', [
            'parts' => $this->parts,
            'translations' => [
                'see_all' => esc_html( __( 'See all', 'prayer-global-porch' ) ),
                'prayer_milestones' => esc_html( __( 'Prayer Milestones', 'prayer-global-porch' ) ),
                'start_praying' => esc_html( __( 'Start Praying', 'prayer-global-porch' ) ),
                'change' => esc_html( __( 'Change', 'prayer-global-porch' ) ),
                'select_a_location' => esc_html( __( 'Please select a location', 'prayer-global-porch' ) ),
                'select_location' => wp_kses( __( 'Select Location', 'prayer-global-porch' ), 'post' ),
                'delete_location' => esc_html( __( 'Delete Location', 'prayer-global-porch' ) ),
                'estimated_location' => esc_html( __( '(This is your estimated location)', 'prayer-global-porch' ) ),
                'profile' => esc_html( __( 'Profile Settings', 'prayer-global-porch' ) ),
                'prayers' => esc_html( __( 'Prayer Activity', 'prayer-global-porch' ) ),
                'challenges' => esc_html( __( 'My Prayer Relays', 'prayer-global-porch' ) ),
                'are_you_enjoying_the_app' => esc_html( __( 'Are you enjoying this app?', 'prayer-global-porch' ) ),
                'would_you_like_to_partner' => esc_html( __( 'Partner with us in helping others pray for the world!', 'prayer-global-porch' ) ),
                'consider_giving' => esc_html( __( 'Consider giving to help us increase prayer for the world.', 'prayer-global-porch' ) ),
                'donate' => esc_html( __( 'Donate', 'prayer-global-porch' ) ),
                'logout' => esc_html( __( 'Logout', 'prayer-global-porch' ) ),
                'name_text' => esc_html( __( 'Name', 'prayer-global-porch' ) ),
                'email_text' => esc_html( __( 'Email', 'prayer-global-porch' ) ),
                'location_text' => esc_html( __( 'Location', 'prayer-global-porch' ) ),
                'locations_text' => esc_html( __( 'Locations', 'prayer-global-porch' ) ),
                'communication_preferences' => esc_html( __( 'Communication Preferences', 'prayer-global-porch' ) ),
                'edit_account' => esc_html__( 'Change Your Details', 'prayer-global-porch' ),
                'delete_account' => esc_html( __( 'Delete my account', 'prayer-global-porch' ) ),
                'minutes' => esc_html( __( 'Minutes', 'prayer-global-porch' ) ),
                'load_more' => esc_html( __( 'Load more', 'prayer-global-porch' ) ),
                'time_prayed_for' => esc_html( _x( '%1$s for %2$s', '1 min for Paris, France', 'prayer-global-porch' ) ),
                'in_group_text' => esc_html( _x( 'in %s', 'in Global Lap', 'prayer-global-porch' ) ),
                'new_challenge' => esc_html( _x( 'New %s Relay', 'New public Relay', 'prayer-global-porch' ) ),
                'public' => esc_html( __( 'Public', 'prayer-global-porch' ) ),
                'private' => esc_html( __( 'Private', 'prayer-global-porch' ) ),
                'public_relays' => esc_html( __( 'My Public Relays', 'prayer-global-porch' ) ),
                'private_relays' => esc_html( __( 'My Private Relays', 'prayer-global-porch' ) ),
                'private_explanation1' => sprintf( esc_html( __( 'Private relays do not show on the %s page, but can be shared with your team mates.', 'prayer-global-porch' ) ), '<a href="/challenges/active">' . esc_html__( 'Prayer Relays', 'prayer-global-porch' ) . '</a>' ),
                'public_explanation1' => sprintf( esc_html( __( 'Your public relays will also appear on the %s page.', 'prayer-global-porch' ) ), '<a href="/challenges/active">' . esc_html__( 'Prayer Relays', 'prayer-global-porch' ) . '</a>' ),
                'no_relays_found' => esc_html__( 'You have not created any %s relays yet', 'prayer-global-porch' ),
                'view_join_other_relays' => esc_html__( 'View other public relays', 'prayer-global-porch' ),
                'edit' => esc_html__( 'Edit', 'prayer-global-porch' ),
                'display_map' => esc_html__( 'Display Map', 'prayer-global-porch' ),
                'language' => esc_html__( 'Language', 'prayer-global-porch' ),
                'delete_account_confirmation' => esc_html__( 'This will delete your account from Prayer.Global.', 'prayer-global-porch' ),
                'delete_account_warning' => esc_html__( 'You will lose all progress and data assosciated with your account', 'prayer-global-porch' ),
                'delete_account_confirm_proceed' => __( 'If you are sure you want to proceed please type "delete" into the box below and click "I am sure" button', 'prayer-global-porch' ) ,
                'confirm_delete' => __( 'Confirm delete', 'prayer-global-porch' ) ,
                'cancel' => esc_html__( 'Cancel', 'prayer-global-porch' ),
                'save' => esc_html__( 'Save', 'prayer-global-porch' ),
                'subscribe' => esc_html__( 'Subscribe to news', 'prayer-global-porch' ),
                'subscribed' => esc_html__( 'Subscribed', 'prayer-global-porch' ),
                'send_general_emails_text' => wp_kses( sprintf( __( 'Send information about %1$s, %2$s, %3$s and other %4$s projects via email', 'prayer-global-porch' ), 'Prayer.Global', 'Zume', 'Pray4Movement', 'Gospel Ambition' ), 'post' ),
                'prayer_activity' => esc_html__( 'Prayer Activity', 'prayer-global-porch' ),
                'strengthen_text' => esc_html__( 'Strengthen your prayer life one day at a time!', 'prayer-global-porch' ),
                'daily_streak' => esc_html__( 'Daily Prayer Streak', 'prayer-global-porch' ),
                'best' => esc_html__( 'Best', 'prayer-global-porch' ),
                'weeks_in_a_row' => esc_html__( 'Weeks in a row', 'prayer-global-porch' ),
                'days_this_year' => esc_html__( 'Days this year', 'prayer-global-porch' ),
                'minutes_prayed' => esc_html__( 'Minutes prayed', 'prayer-global-porch' ),
                'places_prayed_for' => esc_html__( 'Places prayed for', 'prayer-global-porch' ),
                'active_laps' => esc_html__( 'Active Laps', 'prayer-global-porch' ),
                'finished_laps' => esc_html__( 'Finished Laps', 'prayer-global-porch' ),
                'prayer_relays' => esc_html__( 'Prayer Relays', 'prayer-global-porch' ),
                'pray' => esc_html__( 'Pray', 'prayer-global-porch' ),
                'lap' => esc_html__( 'Lap', 'prayer-global-porch' ),
                'map' => esc_html__( 'Map', 'prayer-global-porch' ),
                'share' => esc_html__( 'Share', 'prayer-global-porch' ),
                'display' => esc_html__( 'Display', 'prayer-global-porch' ),
                'hide' => esc_html__( 'Hide', 'prayer-global-porch' ),
                'unhide' => esc_html__( 'Unhide', 'prayer-global-porch' ),
                'hide_hidden_relays' => esc_html__( 'Hide Hidden Relays', 'prayer-global-porch' ),
                'show_hidden_relays' => esc_html__( 'Show Hidden Relays', 'prayer-global-porch' ),
                'no_custom_relays' => esc_html__( 'You have not created or joined any Prayer Relays yet.', 'prayer-global-porch' ),
                'new_relay' => esc_html__( 'New Prayer Relay', 'prayer-global-porch' ),
                'new_public_relay' => esc_html__( 'New Public Relay', 'prayer-global-porch' ),
                'new_private_relay' => esc_html__( 'New Private Relay', 'prayer-global-porch' ),
                'create_public_relay' => esc_html__( 'Create Public Relay', 'prayer-global-porch' ),
                'create_private_relay' => esc_html__( 'Create Private Relay', 'prayer-global-porch' ),
                'join_a_relay' => esc_html__( 'Join a Relay', 'prayer-global-porch' ),
                'title' => esc_html__( 'Relay Title', 'prayer-global-porch' ),
                'advanced' => esc_html__( 'Advanced Options', 'prayer-global-porch' ),
                'create' => esc_html__( 'Create', 'prayer-global-porch' ),
                'start_date' => esc_html__( 'Start Date', 'prayer-global-porch' ),
                'end_date' => esc_html__( 'End Date', 'prayer-global-porch' ),
                'now' => esc_html__( 'Now', 'prayer-global-porch' ),
                'single_lap_relay' => esc_html__( 'Single Lap', 'prayer-global-porch' ),
                'update' => esc_html__( 'Update', 'prayer-global-porch' ),
                'edit_relay' => esc_html__( 'Edit Relay', 'prayer-global-porch' ),
                'join_a_relay_info' => esc_html__( 'Find and join a public prayer relay created by individuals, churches or organizations.', 'prayer-global-porch' ),
                'create_public_relay_info' => esc_html__( 'Start your own public relay for anyone to find and join.', 'prayer-global-porch' ),
                'create_private_relay_info' => esc_html__( 'Create a private relay, hidden from the public list, and share it with friends, family, or the church.', 'prayer-global-porch' ),
                'download_the_app' => esc_html__( 'Download the Prayer.Global app to get streak notifications and more!', 'prayer-global-porch' ),
                'update_the_app' => esc_html__( 'Update the Prayer.Global app to get streak notifications and more!', 'prayer-global-porch' ),
                'go_to_app_store' => esc_html__( 'Go to App Store', 'prayer-global-porch' ),
                'notifications_toggle' => esc_html__( 'Allow push notifications', 'prayer-global-porch' ),
                'notifications_text' => esc_html__( '(Encouragements, streaks, lap status and more)', 'prayer-global-porch' ),
                'notifications_text_mobile' => esc_html__( 'Push notifications are only available on the latest version of the Prayer.Global mobile app.', 'prayer-global-porch' ),
                'notifications_text_mismatch' => esc_html__( 'Push notifications are not enabled on your device.', 'prayer-global-porch' ),
                'request_notifications' => esc_html__( 'Manage Device Notifications', 'prayer-global-porch' ),
            ],
            'is_logged_in' => is_user_logged_in() ? 1 : 0,
            'logout_url' => esc_url( '/user_app/logout' ),
            'user' => PG_User_API::get_user(),
            'languages' => pg_enabled_translations(),
            'current_language' => pg_get_current_lang(),
            'spritesheet_url' => $this->spritesheet_url,
            'icons_url' => trailingslashit( plugin_dir_url( __DIR__ ) ) . 'assets/images/icons' ,
            'gravatar_url' => $gravatar_url,
            'stats' => [
                'total_minutes_prayed' => $user_stats->total_minutes_prayed(),
                'total_places_prayed' => $user_stats->total_places_prayed(),
                'total_relays_part_of' => $user_stats->total_relays_part_of(),
                'total_finished_relays_part_of' => $user_stats->total_finished_relays_part_of(),
                'best_streak_in_days' => $user_stats->best_streak_in_days(),
                'current_streak_in_days' => $user_stats->current_streak_in_days(),
                'current_streak_in_weeks' => $user_stats->current_streak_in_weeks(),
                'days_this_year' => $user_stats->days_this_year(),
            ],
            'available_badges' => $available_badges,
        ] );
    }

    public function header_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/header.php' );
        ?>

        <link rel="preload" href="<?php echo esc_url( $this->spritesheet_url ) ?>" as="image" type="image/svg+xml">
        <style>
            #login_form input {
                padding:.5em;
            }
        </style>
        <?php
    }

    public function footer_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/footer.php' );
    }

    public function body(){
        // DT_Mapbox_API::load_mapbox_search_widget();
        // DT_Mapbox_API::mapbox_search_widget_css();

        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . '/assets/nav.php' );

        ?>

        <pg-router></pg-router>

        <?php
    }

    /**
     * Register REST Endpoints
     * @link https://github.com/DiscipleTools/disciple-tools-theme/wiki/Site-to-Site-Link for outside of wordpress authentication
     */
    public function add_endpoints() {
        $namespace = 'pg-api/v1/' . $this->root;
        register_rest_route(
            $namespace,
            '/api',
            [
                [
                    'methods'  => 'POST',
                    'callback' => [ $this, 'endpoint' ],
                    'permission_callback' => '__return_true',
                ],
            ]
        );
        DT_Route::post( $namespace, 'delete_user', [ $this, 'delete_user' ] );
        DT_Route::post( $namespace, 'subscribe_to_news', [ $this, 'subscribe_to_news' ] );
        DT_Route::post( $namespace, 'relays', [ $this, 'get_relays' ] );
        DT_Route::post( $namespace, 'relays/hide', [ $this, 'hide_relay' ] );
        DT_Route::post( $namespace, 'relays/unhide', [ $this, 'unhide_relay' ] );
        DT_Route::post( $namespace, 'create_relay', [ $this, 'create_relay' ] );
        DT_Route::post( $namespace, 'edit_relay', [ $this, 'edit_relay' ] );
        DT_Route::post( $namespace, 'link_anonymous_prayers', [ $this, 'link_anonymous_prayers' ] );
        DT_Route::post( $namespace, 'save_location', [ $this, 'save_location' ] );
    }

    public function endpoint( WP_REST_Request $request ) {

        $params = $request->get_params();

        if ( ! isset( $params['parts'], $params['action'] ) ) {
            return new WP_Error( __METHOD__, 'Missing parameters', [ 'status' => 400 ] );
        }

        $params = dt_recursive_sanitize_array( $params );

        switch ( $params['action'] ) {
            case 'ip_location':
                return $this->get_ip_location( $params['data'] );
            default:
                return $params;
        }
    }

    /**
     * Programmatically logs a user in
     *
     * @param string $username
     * @return bool True if the login was successful; false if it wasn't
     */
    public function programmatic_login( $username ): bool
    {
        if ( is_user_logged_in() ) {
            wp_logout();
        }

        add_filter( 'authenticate', [ $this, 'allow_programmatic_login' ], 10, 3 );    // hook in earlier than other callbacks to short-circuit them
        $user = wp_signon( array( 'user_login' => $username ) );
        remove_filter( 'authenticate', [ $this, 'allow_programmatic_login' ], 10, 3 );

        if ( is_a( $user, 'WP_User' ) ) {
            wp_set_current_user( $user->ID, $user->user_login );

            if ( is_user_logged_in() ) {
                return true;
            }
        }

        return false;
    }

    /**
     * An 'authenticate' filter callback that authenticates the user using only     the username.
     *
     * To avoid potential security vulnerabilities, this should only be used in     the context of a programmatic login,
     * and unhooked immediately after it fires.
     *
     * @param WP_User $user
     * @param string $username
     * @param string $password
     * @return bool|WP_User a WP_User object if the username matched an existing user, or false if it didn't
     */
    public function allow_programmatic_login( $user, $username, $password ) {
        return get_user_by( 'login', $username );
    }

    public function subscribe_to_news() {
        $user_id = get_current_user_id();

        if ( !$user_id ) {
            return new WP_Error( __METHOD__, 'Unauthorised', [ 'status' => 401 ] );
        }

        pg_connect_to_crm();

        return true;
    }
    public function delete_user() {
        $user_id = get_current_user_id();

        if ( !$user_id ) {
            return new WP_Error( __METHOD__, 'Unauthorised', [ 'status' => 401 ] );
        }

        /* Delete user_id from all prayers with this user_id */
        global $wpdb;
        $update_reports = $wpdb->update( $wpdb->dt_reports, [ 'user_id' => null ], [ 'user_id' => $user_id ] );

        /* Unassign user_id from all laps that they have started */
        $unassign_laps = $wpdb->query( $wpdb->prepare( "
            DELETE FROM $wpdb->postmeta
            WHERE meta_id IN (
                SELECT meta_id FROM (
                    SELECT pm.meta_id FROM $wpdb->posts p
                    JOIN $wpdb->postmeta pm
                    ON p.ID = pm.post_id
                    WHERE p.post_type = 'pg_relays'
                    AND pm.meta_key = 'assigned_to'
                    AND pm.meta_value = %s
                ) x
            )
        ", "user-$user_id" ) );

        $contact_id = Disciple_Tools_Users::get_contact_for_user( $user_id );
        DT_Contacts_Utils::erase_data( $contact_id, 'this-user@no.op' );

        /* Delete user */
        require_once( ABSPATH . 'wp-admin/includes/user.php' );
        wp_delete_user( $user_id );

        return true;
    }

    public function get_ip_location( $data ) {
        $user_id = get_current_user_id();

        if ( !$user_id ) {
            return new WP_Error( __METHOD__, 'Unauthorised', [ 'status' => 401 ] );
        }

        $response = DT_Ipstack_API::get_location_grid_meta_from_current_visitor();

        if ( $response ) {
            /* Use the existing supplied hash if given */
            if ( isset( $data['hash'] ) ) {
                $hash = sanitize_text_field( wp_unslash( $data['hash'] ) );
            } else {
                $hash = hash( 'sha256', serialize( $response ) . mt_rand( 1000000, 10000000000000000 ) );
            }
            $country = $this->_extract_country_from_label( $response['label'] );
            $response['country'] = $country;
            $response['lat'] = strval( $response['lat'] );
            $response['lng'] = strval( $response['lng'] );
            $response['hash'] = $hash;
        }

        $data = [
            'location' => $response,
            'location_hash' => $hash,
        ];

        PG_User_API::update_user_meta( $data );

        return $data;
    }



    public function link_anonymous_prayers( WP_REST_Request $request ) {

        $user_id = get_current_user_id();

        if ( !$user_id ) {
            return new WP_Error( __METHOD__, 'Unauthorised', [ 'status' => 401 ] );
        }

        $data = $request->get_params();

        if ( $data['hash'] ) {
            return new WP_Error( __METHOD__, 'user_id or hash missing', [ 'status' => 400, ] );
        }

        global $wpdb;

        $updates = $wpdb->get_var( $wpdb->prepare( "
            SELECT COUNT(*) FROM $wpdb->dt_reports
            WHERE hash = %s
            AND type = 'prayer_app'
            AND user_id IS NULL
        ", $data['hash'] ) );

        $has_updates = $updates > 0;
        if ( $has_updates ) {
            $wpdb->query( $wpdb->prepare( "
                UPDATE $wpdb->dt_reports
                SET user_id = %d
                WHERE hash = %s
                AND type = 'prayer_app'
                AND user_id IS NULL
            ", $data['user_id'], $data['hash'] ) );
        }

        return [
            'has_updates' => $has_updates,
            'number_of_updates' => $updates,
        ];
    }

    public function save_location( WP_REST_Request $request ) {
        $user_id = get_current_user_id();

        if ( !$user_id ) {
            return new WP_Error( __METHOD__, 'Unauthorised', [ 'status' => 401 ] );
        }

        $params = $request->get_params();

        $params = dt_recursive_sanitize_array( $params );


        PG_User_API::update_user_meta( $params );

        return true;
    }

    public function geolocate_by_latlng( $data ) {
        if ( !isset( $data['lat'], $data['lng'] ) ) {
            return new WP_Error( __METHOD__, 'Latitude or longitude missing', [ 'status' => 400 ] );
        }

        $user_id = get_current_user_id();

        if ( !$user_id ) {
            return new WP_Error( __METHOD__, 'Unauthorised', [ 'status' => 401 ] );
        }

        $geocoder = new Location_Grid_Geocoder();

        $grid_row = $geocoder->get_grid_id_by_lnglat( (float) $data['lng'], (float) $data['lat'] );

        if ( !$grid_row ) {
            return '';
        }

        $label = $geocoder->_format_full_name( $grid_row );

        return $label;
    }

    public function create_relay( WP_REST_Request $request ) {
        $user_id = get_current_user_id();

        if ( !$user_id || !DT_Posts::can_create( 'pg_relays' ) ) {
            return new WP_Error( __METHOD__, 'Unauthorised', [ 'status' => 401 ] );
        }

        $params = $request->get_json_params();
        $data = dt_recursive_sanitize_array( $params );

        if ( !isset( $data['title'] ) ) {
            return new WP_Error( __METHOD__, 'Challenge Title', [ 'status' => 400 ] );
        }

        $title = sanitize_text_field( wp_unslash( $data['title'] ) );
        $challenge_type = sanitize_text_field( wp_unslash( $data['challenge_type'] ) ) ?? 'ongoing_challenge';
        $visibility = sanitize_text_field( wp_unslash( $data['visibility'] ) ) ?? 'public';

        $fields = [
            'title' => $title,
            'challenge_type' => $challenge_type,
            'visibility' => $visibility,
        ];

        if ( isset( $data['start_date'] ) ) {
            $fields['start_date'] = (int) $data['start_date'];
            $fields['start_time'] = (int) $data['start_date'];
        }
        if ( isset( $data['end_date'] ) ) {
            $fields['end_date'] = (int) $data['end_date'];
            $fields['end_time'] = (int) $data['end_date'];
        }

        $fields['assigned_to'] = $user_id;
        $fields['type'] = 'custom';
        $fields['single_lap'] = (bool) $data['single_lap'] ?? false;

        $post = DT_Posts::create_post( 'pg_relays', $fields );

        return $post;
    }

    public function edit_relay( WP_REST_Request $request ) {
        $user_id = get_current_user_id();

        if ( !$user_id ) {
            return new WP_Error( __METHOD__, 'Unauthorised', [ 'status' => 401 ] );
        }

        $params = $request->get_json_params();
        $data = dt_recursive_sanitize_array( $params );

        if ( !isset( $data['relay_id'] ) ) {
            return new WP_Error( __METHOD__, 'relay_id is missing', [ 'status' => 400 ] );
        }

        $relay_id = $data['relay_id'];

        $old_challenge = DT_Posts::get_post( 'pg_relays', $relay_id );

        if ( !$old_challenge || !DT_Posts::can_update( 'pg_relays', $relay_id ) ) {
            return new WP_Error( __METHOD__, 'Unauthorised', [ 'status' => 401 ] );
        }

        $fields = [];

        if ( isset( $data['title'] ) ) {
            $fields['title'] = $data['title'];
        }

        if ( isset( $data['challenge_type'] ) ) {
            $fields['challenge_type'] = $data['challenge_type'];
        }

        if ( isset( $data['visibility'] ) ) {
            $fields['visibility'] = $data['visibility'];
        }

        if ( isset( $data['start_date'] ) ) {
            $fields['start_date'] = (int) $data['start_date'];
            $fields['start_time'] = (int) $data['start_date'];
        }
        if ( isset( $data['end_date'] ) ) {
            $fields['end_date'] = (int) $data['end_date'];
            $fields['end_time'] = (int) $data['end_date'];
        }
        if ( isset( $data['single_lap'] ) ) {
            $fields['single_lap'] = (bool) $data['single_lap'];
        }

        $post = DT_Posts::update_post( 'pg_relays', $relay_id, $fields );

        return $post;
    }

    public function get_relays( WP_REST_Request $request ) {
        global $wpdb;

        $user_id = get_current_user_id();

        if ( !$user_id || !DT_Posts::can_access( 'pg_relays' ) ) {
            return new WP_Error( __METHOD__, 'Unauthorised', [ 'status' => 401 ] );
        }

        $data = [];

        $user_meta_value = "user-$user_id";

        $all_relays = $wpdb->get_results( $wpdb->prepare(
            "WITH user_relays AS (
                SELECT %d as post_id
                UNION
                SELECT pm.post_id
                    FROM $wpdb->posts wp
                    JOIN $wpdb->postmeta pm ON pm.post_id = wp.ID AND pm.meta_key = 'assigned_to' AND pm.meta_value = %s
                    WHERE wp.post_type = 'pg_relays'
                UNION
                SELECT DISTINCT( r.post_id ) as post_id FROM $wpdb->dt_reports r
                    WHERE r.user_id = %d
                    AND r.post_type = 'pg_relays'
            )
            SELECT
                pm.post_id,
                p.post_title,
                pm.meta_value as relay_type,
                pm2.meta_value as status,
                pm3.meta_value as lap_key,
                pm4.meta_value as start_time,
                pm5.meta_value as visibility,
                pm7.meta_value as end_time,
                pm8.meta_value as challenge_type,
                pm9.meta_value as single_lap,
                r.timestamp as last_report_timestamp,
                IF( pm6.meta_value = %s, 1, 0 ) as is_owner
            FROM $wpdb->posts p
            JOIN user_relays ur ON ur.post_id = p.ID
            JOIN $wpdb->postmeta pm ON pm.post_id=p.ID AND pm.meta_key = 'type'
            JOIN $wpdb->postmeta pm2 ON pm2.post_id=p.ID AND pm2.meta_key = 'status'
            LEFT JOIN $wpdb->postmeta pm3 ON pm3.post_id=p.ID AND pm3.meta_key = 'prayer_app_relay_key'
            LEFT JOIN $wpdb->postmeta pm4 ON pm4.post_id=p.ID AND pm4.meta_key = 'start_time'
            LEFT JOIN $wpdb->postmeta pm5 ON pm5.post_id=p.ID AND pm5.meta_key = 'visibility'
            LEFT JOIN $wpdb->postmeta pm6 ON pm6.post_id=p.ID AND pm6.meta_key = 'assigned_to'
            LEFT JOIN $wpdb->postmeta pm7 ON pm7.post_id=p.ID AND pm7.meta_key = 'end_time'
            LEFT JOIN $wpdb->postmeta pm8 ON pm8.post_id=p.ID AND pm8.meta_key = 'challenge_type'
            LEFT JOIN $wpdb->postmeta pm9 ON pm9.post_id=p.ID AND pm9.meta_key = 'single_lap'
            LEFT JOIN (
                SELECT * FROM $wpdb->dt_reports r
                WHERE r.user_id = %d
                ORDER BY r.timestamp DESC
                LIMIT 1
            ) r ON r.post_id = p.ID
            WHERE p.post_type = 'pg_relays'
            ORDER BY last_report_timestamp DESC,
            p.post_title ASC
        ", pg_get_relay_id( '49ba4c' ), $user_meta_value, $user_id, $user_meta_value, $user_id ), ARRAY_A );

        $hidden_relays = get_user_meta( $user_id, 'pg_hidden_relays' );

        foreach ( $all_relays as $row ) {
            $row['stats'] = Prayer_Stats::get_lap_stats( $row['post_id'] );
            $data[] = $row;
        }

        return [
            'relays' => $data,
            'hidden_relays' => $hidden_relays,
        ];
    }

    public function hide_relay( WP_REST_Request $request ) {
        $user_id = get_current_user_id();

        if ( !$user_id || !DT_Posts::can_access( 'pg_relays' ) ) {
            return new WP_Error( __METHOD__, 'Unauthorised', [ 'status' => 401 ] );
        }

        $relay_id = $request->get_param( 'relay_id' );

        if ( !$relay_id ) {
            return new WP_Error( __METHOD__, 'Relay ID is required', [ 'status' => 400 ] );
        }

        add_user_meta( $user_id, 'pg_hidden_relays', $relay_id );
        return true;
    }
    public function unhide_relay( WP_REST_Request $request ) {
        $user_id = get_current_user_id();

        if ( !$user_id || !DT_Posts::can_access( 'pg_relays' ) ) {
            return new WP_Error( __METHOD__, 'Unauthorised', [ 'status' => 401 ] );
        }

        $relay_id = $request->get_param( 'relay_id' );

        if ( !$relay_id ) {
            return new WP_Error( __METHOD__, 'Relay ID is required', [ 'status' => 400 ] );
        }

        delete_user_meta( $user_id, 'pg_hidden_relays', $relay_id );
        return true;
    }
}
PG_User_App_Profile::instance();
