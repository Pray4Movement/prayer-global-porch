<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

Prayer_Global_JSON_Generator::instance();

class Prayer_Global_JSON_Generator extends DT_Magic_Url_Base
{

    public $magic = false;
    public $parts = false;
    public $page_title = 'Global Prayer - Show All';
    public $root = 'build';
    public $type = 'json-generator';
    public $type_name = 'Global Prayer - JSON Generator';
    public static $token = 'build_json-generator';
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

        if ( dt_is_rest() ) {
            add_action( 'rest_api_init', [ $this, 'add_endpoints' ] );
        }

        $url = dt_get_url_path();
        if ( str_contains( $url, $this->root . '/' . $this->type ) ) {

            $this->magic = new DT_Magic_URL( $this->root );
            $this->parts = $this->magic->parse_url_parts();

            // register url and access
            add_action( 'template_redirect', [ $this, 'theme_redirect' ] );
            add_filter( 'dt_blank_access', function (){ return true;
            }, 100, 1 );
            add_filter( 'dt_allow_non_login_access', function (){ return true;
            }, 100, 1 );
            add_filter( 'dt_override_header_meta', function (){ return true;
            }, 100, 1 );

            // header content
            add_filter( 'dt_blank_title', [ $this, 'page_tab_title' ] ); // adds basic title to browser tab
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
        $jsobject = [
            'map_key' => DT_Mapbox_API::get_key(),
            'root' => esc_url_raw( rest_url() ),
            'nonce' => wp_create_nonce( 'wp_rest' ),
            'parts' => $this->parts,
        ];

        ?>
        <script>
            let jsObject = [<?php echo json_encode( $jsobject ) ?>][0]
        </script>
        <?php
    }

    public function footer_javascript(){
    }

    public function body(){
        ?>

        <h1>JSON Generator</h1>
        <p>JSON should be generating now. Please check the build directory</p>

        <hr>
        <div id="results"></div>

        <script>

            generateJSON()

            async function generateJSON() {
                /* Start while loop */
                let processing = true
                let startId = 0
                const resultsContainer = document.querySelector('#results')
                while (processing) {
                    const result = await generateBatch(startId)

                    console.log(result)
                    if (result.status !== 'done') {
                        /* print to screen */
                        const something =document.createElement('p')
                        result.innerHTML = `Generated ${result.start_id}`
                        resultsContainer.appendChild(something)
                        startId = result.start_id
                    } else {
                        /* print to screen */
                        const something = document.createElement('p')
                        result.innerHTML = `Completed ${result.start_id}`
                        resultsContainer.appendChild(something)
                        processing = false
                    }
                }

            }

            function generateBatch(startId = 0) {
                return fetch( jsObject.root + 'dt-public/build/v1/generate?start_id=' + startId, {
                    headers: {
                        'X-Wp-Nonce': jsObject.nonce,
                    },
                } )
                    .then((res) => {
                        console.log(res)
                        if (!res.ok) {
                            throw Error(`${res.status} - ${res.statusText}`)
                        }

                        return res.json()
                    })
                    .catch((error) => {
                        console.error(error)
                    })
            }

        </script>

        <?php
    }
    /**
     * Register REST Endpoints
     * @link https://github.com/DiscipleTools/disciple-tools-theme/wiki/Site-to-Site-Link for outside of wordpress authentication
     */
    public function add_endpoints() {
        $namespace = 'dt-public/build/v1';
        register_rest_route(
            $namespace,
            '/generate',
            [
                [
                    'methods' => WP_REST_Server::READABLE,
                    'callback' => [ $this, 'build_json' ],
                    'permission_callback' => '__return_true',
                ],
            ]
        );
    }

    public function build_json( WP_REST_Request $request ) {

        $batch_size = 500;
        $start_id = $request->has_param( 'start_id' ) ? $request->get_param( 'start_id' ) : 0;

        if ( !is_int( (int) $start_id ) ) {
            return wp_send_json_error( 'next_id is not an integer', 500 );
        }

        $start_id = (int) $start_id;

        /* Grab all the state ids */
        $location_ids = pg_query_4770_locations();

        $location_ids = array_keys( $location_ids );

        $save_folder = __DIR__ . '/json-files';

        /* Loop through and generate prayer JSON */
        $end = $start_id + $batch_size < count( $location_ids ) ? $start_id + $batch_size : count( $location_ids );
        for ( $i = $start_id; $i < $end; $i++ ) {
            $grid_id = $location_ids[$i];

            $json = PG_Stacker::build_location_stack( $grid_id );

            file_put_contents( $save_folder . '/' . $grid_id . '.json', json_encode( $json ) );
        }

        $status = $i < PG_TOTAL_STATES ? 'processing' : 'done';

        return wp_send_json( [
            'start_id' => $i,
            'status' => $status,
        ] );
    }
}


