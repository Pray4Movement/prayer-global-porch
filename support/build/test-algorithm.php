<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

Prayer_Global_Test_Algorithm::instance();

class Prayer_Global_Test_Algorithm extends DT_Magic_Url_Base
{

    public $magic = false;
    public $parts = false;
    public $page_title = 'Global Prayer - Show All';
    public $root = 'show_app';
    public $type = 'test_algorithm';
    public $type_name = 'Global Prayer - Test Algorithm';
    public static $token = 'show_app_test_algorithm';
    public $post_type = 'laps';

    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct() {
        parent::__construct();

        $url = dt_get_url_path();
        if ( str_contains( $url, $this->root . '/' . $this->type ) ) {

            $this->magic = new DT_Magic_URL( $this->root );
            $this->parts = $this->magic->parse_url_parts();


            // register url and access
            add_action( "template_redirect", [ $this, 'theme_redirect' ] );
            add_filter( 'dt_blank_access', function (){ return true;
            }, 100, 1 );
            add_filter( 'dt_allow_non_login_access', function (){ return true;
            }, 100, 1 );
            add_filter( 'dt_override_header_meta', function (){ return true;
            }, 100, 1 );

            // header content
            add_filter( "dt_blank_title", [ $this, "page_tab_title" ] ); // adds basic title to browser tab
            add_action( 'wp_print_scripts', [ $this, 'print_scripts' ], 1500 ); // authorizes scripts
            add_action( 'wp_print_styles', [ $this, 'print_styles' ], 1500 ); // authorizes styles


            // page content
            add_action( 'dt_blank_head', [ $this, '_header' ] );
            add_action( 'dt_blank_footer', [ $this, '_footer' ] );
            add_action( 'dt_blank_body', [ $this, 'body' ] ); // body for no post key

            add_filter( 'dt_magic_url_base_allowed_css', [ $this, 'dt_magic_url_base_allowed_css' ], 10, 1 );
            add_filter( 'dt_magic_url_base_allowed_js', [ $this, 'dt_magic_url_base_allowed_js' ], 10, 1 );
        }

    }

    public function dt_magic_url_base_allowed_js( $allowed_js ) {
        return [];
    }

    public function dt_magic_url_base_allowed_css( $allowed_css ) {
        return [];
    }

    public function header_javascript(){
        require_once( WP_CONTENT_DIR . '/plugins/prayer-global-porch/pages/assets/header.php' );
        ?>
        <link href="https://fonts.googleapis.com/css?family=Crimson+Text:400,400i,600|Montserrat:200,300,400" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo esc_url( WP_CONTENT_URL . '/plugins/prayer-global-porch/pages/' ) ?>assets/fonts/ionicons/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo esc_url( WP_CONTENT_URL . '/plugins/prayer-global-porch/pages/' ) ?>assets/css/basic.css?ver=<?php echo esc_attr( fileatime( WP_CONTENT_DIR . '/plugins/prayer-global-porch/pages/assets/css/basic.css' ) ) ?>" type="text/css" media="all">
        <?php
    }

    public function footer_javascript(){
        require_once( WP_CONTENT_DIR . '/plugins/prayer-global-porch/pages/assets/footer.php' );

        $global_lap = pg_current_global_lap();
        global $wpdb;
        $jsobject = [
            'map_key' => DT_Mapbox_API::get_key(),
            'root' => esc_url_raw( rest_url() ),
            'nonce' => wp_create_nonce( 'wp_rest' ),
            'parts' => $this->parts,
            'user' => [
                'country' => 'United States',
                'grid_id' =>'100364522',
                'hash' =>'3ba4f83cfbd24b4be862536cfd9babe2025a2e027b69e2defbf2e62edcf3efa5',
                'label' =>'Golden, Colorado, United States',
                'lat' =>39.828250885009766,
                'level' =>'district',
                'lng' =>-105.06230163574219,
                'source' =>'ip'
            ],
            'locations' => array_combine( array_keys( pg_query_4770_locations() ), array_fill( 0, 4770, 0 ) ),
            'posts' => [],
            'global_parts' => [
                'post_id' => $global_lap['post_id'],
                'post_type' => 'laps',
                'public_key' => $global_lap['key'],
                'meta_key' => 'prayer_app_global_magic_key',
                'root' => 'prayer_app',
                'type' => 'global',
                'action' => ''
            ]
        ];

        ?>
        <script>
            let jsObject = [<?php echo json_encode( $jsobject ) ?>][0]
        </script>
        <?php
    }

    public function body(){
        ?>

        <section class="page-section mt-5" >
            <div class="container">
                <div id="list">
                    <input type="number" id="concurrency" value="1">
                    <button type="button" class="btn start" style="border:1px solid grey;margin:5px;">Start</button>
                    <button type="button" class="btn stop" style="border:1px solid grey;margin:5px;">Stop</button>
                </div>
                <hr>
                <div id="results">
                    <p>Min: <span id="min"></span></p>
                    <p>Avg: <span id="avg"></span></p>
                    <p>Max: <span id="max"></span></p>
                    <p>Counts:</p>
                    <ul id="counts">
                    </ul>
                </div>
            </div>
        </section>
        <div style="position:absolute; bottom: 1em; right:1em; border-radius: 50%;background-color:lightgrey;padding: .5em 1em; font-size:3em;" id="counter">0</div>
        <script>
            window.addEventListener('load', function(){
                window.api_post = ( action, data, parts, url ) => {
                    return jQuery.ajax({
                        type: "POST",
                        data: JSON.stringify({ action: action, parts: parts, data: data }),
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        url: url,
                    })
                        .fail(function(e) {
                            console.log(e)
                        })
                }
                window.counter = 0
                window.globalcounter = 0
                const n = jsObject.locations.length

                let stop = false

                function send_log_global( parts, grid_id ) {
                    window.api_post( 'next_grid_id', {}, parts, '/wp-json/prayer_app/v1/global' )
                        .done(function(x) {
                            if ( x && !stop ) {
                                const grid_id = x.grid_id
                                window.globalcounter++
                                if (jsObject.locations[grid_id] === 0) {
                                    jsObject.locations[grid_id] = Number(x.total)
                                }
                                jsObject.locations[grid_id] += 1
                                jQuery('#counter').html(window.globalcounter)
                                send_log_global( jsObject.global_parts )
                            }
                        })
                }
                function calculateStats(locations) {
                    let min = Infinity
                    let max = 0
                    let total = 0
                    let counts = {}
                    for (let i = 0; i < Object.values(locations).length; i++) {
                        const locationCount = Object.values(locations)[i];
                        if (locationCount < min) {
                            min = locationCount
                        }
                        if (locationCount > max) {
                            max =locationCount
                        }
                        total += locationCount
                        if (!counts[locationCount]) {
                            counts[locationCount] = 0
                        }
                        counts[locationCount] += 1
                    }
                    const avg = total / Object.values(locations).length
                    return {
                        min,
                        max,
                        avg,
                        counts
                    }
                }
                jQuery('.stop').on('click', function() {
                    jQuery('.start').removeAttr('disabled')
                    jQuery('.stop').attr('disabled', true)
                    stop = true
                    const { min, max, counts, avg } = calculateStats(jsObject.locations)
                    jQuery('#min').html(min)
                    jQuery('#max').html(max)
                    jQuery('#avg').html(avg)
                    jQuery('#counts').html('')
                    Object.entries(counts).forEach(([locationCount, count]) => {
                        jQuery('#counts').append(`<li>${locationCount}: ${count}</li>`)
                    });
                })
                jQuery('.start').on('click', function() {
                    stop = false
                    jQuery('.start').attr('disabled', true)
                    jQuery('.stop').removeAttr('disabled')
                    const concurrency = jQuery('#concurrency').val()
                    for (let i = 0; i < Number(concurrency); i++) {
                        send_log_global( jsObject.global_parts )
                    }
                })
            })
        </script>
        <!-- END section -->

        <?php
    }

}

