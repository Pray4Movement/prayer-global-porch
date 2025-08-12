
<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

class PG_Events extends PG_Public_Page {
    public $url_path = 'events';
    public $page_title = 'Events';
    public $rest_route = 'pg/events';

    public function __construct() {
        $current_page_path_matches = parent::__construct();
        if ( !$current_page_path_matches ) {
            return;
        }
        /**
         * Register custom hooks here
         */
    }

    public function register_endpoints() {}

    public function wp_enqueue_scripts() {
        wp_enqueue_style( 'pg-login-style', plugin_dir_url( __FILE__ ) . 'login.css', array(), filemtime( plugin_dir_path( __FILE__ ) . 'login.css' ) );

        wp_localize_script( 'global-functions', 'jsObject', [
            'rest_url' => esc_url( rest_url( 'dt/v1' ) ),
            'translations' => [],
        ] );
    }

    public function dt_magic_url_base_allowed_js( $allowed_js ) {
        return $allowed_js;
    }

    public function dt_magic_url_base_allowed_css( $allowed_css ) {
        return $allowed_css;
    }


    /**
     * Print scripts to header
     */
    public function header_javascript(){}

    /**
     * Print styles to header
     */
    public function header_style(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/header.php' );
    }

    /**
     * Print scripts to footer
     */
    public function footer_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/footer.php' );
        ?>

        <?php
    }
    /**
     * Print body
     */
    public function body(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . '/assets/nav.php' );

        $svg_manager = new SVG_Spritesheet_Manager();
        $icons = [
            'pg-relay',
            'pg-chevron-down',
        ];
        $svgs_url = $svg_manager->get_cached_spritesheet_url( $icons );
        ?>

        <section class="page">
            <div class="container">
                <div class="row justify-content-md-center mb-5">
                    <h1 class="text-center"><?php echo esc_html__( 'Using Prayer.Global at your Event', 'prayer-global-porch' ) ?></h1>
                    <p class="text-center font-weight-bold font-italic"><?php echo esc_html__( 'Prayer.Global has been used by churches and conferences with great success! ', 'prayer-global-porch' ) ?></p>
                    <div class="switcher">
                        <div class="video">
                            <div style="padding:56.3% 0 0 0;position:relative;">
                                <iframe src="https://player.vimeo.com/video/913555379?h=b79d3f9229&title=0&byline=0&portrait=0" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>
                            </div>
                            <script src="https://player.vimeo.com/api/player.js"></script>
                            <p class="text-center font-title"><?php echo esc_html__( 'Conference Testimony', 'prayer-global-porch' ) ?></p>
                        </div>
                        <div class="video">
                            <div style="padding:56.3% 0 0 0;position:relative;">
                                <iframe src="https://player.vimeo.com/video/1058608038?h=b79d3f9229&title=0&byline=0&portrait=0" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>
                            </div>
                            <script src="https://player.vimeo.com/api/player.js"></script>
                            <p class="text-center font-title"><?php echo esc_html__( 'Event Testimony', 'prayer-global-porch' ) ?></p>
                        </div>
                    </div>
                    <div class="cluster">
                        <a href="#pre-event" class="btn btn-outline-primary"><?php echo esc_html__( 'Pre-Event Setup', 'prayer-global-porch' ) ?></a>
                        <a href="#promotion" class="btn btn-outline-primary"><?php echo esc_html__( 'Promotion', 'prayer-global-porch' ) ?></a>
                        <a href="#facilitate" class="btn btn-outline-primary"><?php echo esc_html__( 'Facilitate the Event', 'prayer-global-porch' ) ?></a>
                        <a href="#after-event" class="btn btn-outline-primary"><?php echo esc_html__( 'After the Event', 'prayer-global-porch' ) ?></a>
                    </div>
                </div>
            </div>
        </section>

        <?php

        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/working-footer.php' );
    }
}

new PG_Events();

