<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

class MY_Public_Page extends PG_Public_Page {
    public $url_path = 'base-url-path/sub-path';
    public $page_title = 'My Page Title';
    public $rest_route = 'my-page-api';

    public function __construct() {
        $current_page_path_matches = parent::__construct();
        if ( !$current_page_path_matches ) {
            return;
        }
         /**
         * Register custom hooks here
         */
    }

    public function register_endpoints(){
        register_rest_route( $this->rest_route, '/my-endpoint', [
            'methods' => 'GET',
            'callback' => [ $this, 'my_endpoint' ],
        ] );
    }

    public function my_endpoint( WP_REST_Request $request ){
        return new WP_REST_Response( 'Hello World', 200 );
    }

    public function wp_enqueue_scripts() {
        //add styles
        //wp_enqueue_style( 'my-page-style', plugin_dir_url( __FILE__ ) . 'assets/css/my-page.css' );

        //add scripts
        //wp_enqueue_script( 'my-page-script', plugin_dir_url( __FILE__ ) . 'assets/js/my-page.js' );

        //add settings object
        // $settings = [
        //     'my_setting' => 'my_value',
        // ];
        // wp_localize_script( 'my-page-script', 'page_settings', $settings );
    }

    public function dt_magic_url_base_allowed_js( $allowed_js ) {
        $allowed_js = [];
        $allowed_js[] = 'my-page-script';
        return $allowed_js;
    }

    public function dt_magic_url_base_allowed_css( $allowed_css ) {
        $allowed_css = [];
        return [];
    }


    /**
     * Print scripts to header
     */
    public function header_javascript(){}

    /**
     * Print styles to header
     */
    public function header_style(){
        ?>
        <style></style>
        <?php
    }

    /**
     * Print scripts to footer
     */
    public function footer_javascript(){
        ?>
        <script>
            // Add your custom JavaScript here
        </script>
        <?php
    }
    /**
     * Print body
     */
    public function body(){
        ?>
        <h1>My Page</h1>
        <?php
    }
}

new MY_Public_Page();
