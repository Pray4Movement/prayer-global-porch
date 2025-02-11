<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.


/**
 * Class PG_Custom_Prayer_App_Stats
 */
class PG_Custom_Prayer_App_Stats extends PG_Custom_Prayer_App {

    private static $_instance = null;
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

        // must be specific action
        if ( 'stats' !== $this->parts['action'] ) {
            return;
        }

        add_action( 'dt_blank_body', [ $this, 'body' ] );
        add_filter( 'dt_magic_url_base_allowed_css', [ $this, 'dt_magic_url_base_allowed_css' ], 10, 1 );
        add_filter( 'dt_magic_url_base_allowed_js', [ $this, 'dt_magic_url_base_allowed_js' ], 10, 1 );

        require( __DIR__ . '/nav-custom-lap.php' );
    }

    public function dt_magic_url_base_allowed_js( $allowed_js ) {
        return [];
    }

    public function dt_magic_url_base_allowed_css( $allowed_css ) {
        return [];
    }

    public function _header() {
        $this->header_style();
        $this->header_javascript();
    }
    public function _footer(){
        $this->footer_javascript();
    }

    public function header_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/header.php' );
    }

    public function footer_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/footer.php' );
    }

    public function body(){
        $parts = $this->parts;
        $lap_stats = Prayer_Stats::get_relay_current_lap_stats( $parts['public_key'] );

        global $wpdb;
        if ( empty( $lap_stats['end_time'] ) ) {
            $lap_stats['end_time'] = time();
        }
        $participant_locations = $wpdb->get_results( $wpdb->prepare( "
           SELECT r.label as location, COUNT(r.label) as count
            FROM $wpdb->dt_reports r
            WHERE r.post_type = 'pg_relays'
            AND r.type = 'prayer_app'
            AND r.post_id = %d
            AND r.lap_number = %d
			AND r.label IS NOT NULL
            GROUP BY r.label
			ORDER BY count DESC
			LIMIT 10
        ", $lap_stats['post_id'], $lap_stats['lap_number'] ), ARRAY_A );

        ?>
        <style>
            .cover.completed-lap .container .row {
                height: 10vh;
                padding-top:10vh;
            }
            .cover {
                height: 100vh;
            }
        </style>


        <?php pg_custom_lap_nav( $parts['public_key'] ) ?>

        <section class="hero full-height cover bg-center completed-lap cover-black" style="background-image: url(<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>assets/images/map_background.jpg)" id="section-home">
            <div class="container">
                <div class="row ">
                    <div class="col text-center">
                        <h2 class="heading mb-5">Lap <?php echo esc_attr( $lap_stats['lap_number'] ) ?> </h2>
                        <!--                        <a href="--><?php //echo '/'. $this->parts['root'] . '/' . $this->parts['type'] . '/' . $this->parts['public_key'] . '/map' ?><!--" role="button" class="btn smoothscroll cta_button btn-primary">Map</a><br>-->
                        <hr style="border:1px solid white;margin-top:5vh;">
                    </div>
                    <div class="w-100"></div>
                    <div class="col-md-6 justify-content-end">
                        <h2 class="heading mb-3">Prayer</h2>
                        <div class="sub-heading ps-4">
                            <p class="mb-0"><?php echo esc_attr( $lap_stats['minutes_prayed'] ) ?> Minutes of Prayer</p>
                            <p class="mb-0"><?php echo esc_attr( $lap_stats['completed_percent'] ) ?>% of the World Covered in Prayer</p>

                        </div>
                    </div>
                    <div class="col-md-6 justify-content-end">
                        <h2 class="heading mb-3">Pace</h2>
                        <div class="sub-heading ps-4">
                            <p class="mb-0">Start: <?php echo esc_attr( gmdate( 'M j, Y', $lap_stats['start_time'] ) ) ?></p>
                            <p class="mb-0">End: <?php echo esc_attr( ( $lap_stats['end_time'] ) ? gmdate( 'M j, Y', $lap_stats['end_time'] ) : 'ongoing' ) ?></p>
                            <p class="mb-0"><?php echo esc_attr( $lap_stats['time_elapsed'] ) ?></p>
                        </div>
                    </div>
                    <div class="w-100"></div>
                    <div class="col justify-content-end">
                        <h2 class="heading mb-3">Participants</h2>
                    </div>
                    <div class="w-100"></div>

                    <div class="col-md-6">
                        <div class="sub-heading ps-4">
                            <p class="mb-0"><?php echo esc_attr( $lap_stats['participants'] ) ?> Prayer Intercessors Participated</p>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="sub-heading ps-4">
                            <p class="mb-2"><u>Top Intercessor Locations</u></p>
                            <ol>
                                <?php
                                if ( ! empty( $participant_locations ) ) {
                                    foreach ( $participant_locations as $location ) {
                                        ?>
                                        <li class="mb-0"><?php echo esc_html( $location['location'] ) ?></li>
                                        <?php
                                    }
                                }
                                ?>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- END section -->
        <?php require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . '/assets/working-footer.php' ) ?>
        <?php // end html
    }
}
PG_Custom_Prayer_App_Stats::instance();
