<?php

if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.


/**
 * Base class for public pages
 *
 * This class is used to create a base class for all public pages.
 * It is used to register the url, add the necessary filters, and add the necessary actions.
 * It is also used to check if the current url path is the same as the url path of the page.
 *
 * Stub functions are provided to be overridden by the extending class. They are:
 * - register_endpoints()
 * - header_style()
 * - header_javascript()
 * - footer_javascript()
 * - dt_magic_url_base_allowed_js()
 * - dt_magic_url_base_allowed_css()
 * - body()
 * - wp_enqueue_scripts()
 */

abstract class PG_Public_Page {

    public $url_path = '';
    public $page_title = '';
    public $rest_route = '';

    public function __construct() {
        $path = dt_get_url_path();
        $is_rest = dt_is_rest();
        if ( $is_rest ) {
            add_action( 'rest_api_init', [ $this, 'register_endpoints' ] );
            add_filter( 'dt_allow_rest_access', [ $this, 'authorize_url' ], 10, 1 );
        }

        //if current url path is not this url path, return
        if ( $path !== $this->url_path ) {
            return false;
        }

        add_filter( 'dt_templates_for_urls', [ $this, 'register_url' ], 199, 1 ); // registers url as valid once tests are passed
        add_filter( 'dt_allow_non_login_access', '__return_true', 100, 1 );
        add_action( 'dt_blank_access', '__return_true', 100, 1 );
        add_action( 'template_redirect', [ $this, 'theme_redirect' ] );
        add_filter( 'dt_override_header_meta', '__return_true', 100, 1 );
        add_filter( 'dt_magic_url_base_allowed_css', [ $this, 'dt_magic_url_base_allowed_css' ], 200, 1 );
        add_filter( 'dt_magic_url_base_allowed_js', [ $this, 'dt_magic_url_base_allowed_js' ], 200, 1 );
        add_action( 'wp_print_scripts', [ $this, 'print_scripts' ], 5 ); // authorizes scripts
        add_action( 'wp_print_footer_scripts', [ $this, 'print_scripts' ], 5 ); // authorizes scripts
        add_action( 'wp_print_styles', [ $this, 'print_styles' ], 1500 ); // authorizes styles
        add_action( 'dt_blank_head', [ $this, '_header' ] );
        add_action( 'dt_blank_footer', [ $this, '_footer' ] );
        add_action( 'dt_blank_body', [ $this, 'body' ] );
        //title
        add_filter( 'dt_blank_title', [ $this, 'title' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'wp_enqueue_scripts' ], 1001 );
        return true;
    }

    public function title(){
        return $this->page_title;
    }

    public function register_url( $template_for_url ){
        $template_for_url[ $this->url_path ] = 'template-blank.php';
        return $template_for_url;
    }

    /**
     * Used as an alternate to register_url, primarily for root home page applications
     */
    public function theme_redirect() {
        $path = get_theme_file_path( 'template-blank.php' );
        include( $path );
        die();
    }

    /**
     * Open default restrictions for access to registered endpoints
     * @param $authorized
     * @return bool
     */
    public function authorize_url( $authorized ){
        $path = dt_get_url_path();
        if ( str_starts_with( $path, 'wp-json/' . $this->rest_route ) ){
            $authorized = true;
        }
        return $authorized;
    }

    public function register_endpoints(){}

        /**
     * Loads enqueued scripts and custom printed scripts to header
     * @note this is a required method because the standard DT header includes authentication requirements
     * @note Copy function to 'extends' class to override or modify
     */
    public function _header(){
        wp_head();
        $this->header_style();
        $this->header_javascript();
    }
    /**
     * Loads enqueued styles and custom printed styles to header
     * @note Copy function to 'extends' class to override or modify
     */
    public function _footer(){
        wp_footer();
        $this->footer_javascript();
    }
    /**
     * Adds printed styles to header
     * @note Copy function to 'extends' class to override or modify
     */
    public function header_style(){}

    /**
     * Adds printed scripts to header
     * @note Copy function to 'extends' class to override or modify
     */
    public function header_javascript(){}

    /**
     * Adds printed scripts to footer
     * @note Copy function to 'extends' class to override or modify
     */
    public function footer_javascript(){}

    public function body(){}



    /**
     * Authorizes scripts allowed to load in magic link
     *
     * Controls the linked scripts loaded into the header.
     * @note This overrides standard DT header assets which natively have login authentication requirements.
     */
    public function print_scripts(){
        // @link /disciple-tools-theme/dt-assets/functions/enqueue-scripts.php
        $allowed_js = apply_filters( 'dt_magic_url_base_allowed_js', [] );

        global $wp_scripts;

        if ( isset( $wp_scripts ) ){
            foreach ( $wp_scripts->queue as $key => $item ){
                if ( ! in_array( $item, $allowed_js ) ){
                    unset( $wp_scripts->queue[$key] );
                }
            }
        }
        if ( isset( $wp_scripts ) ){
            foreach ( $wp_scripts->registered as $key => $item ){
                if ( ! in_array( $key, $allowed_js ) ){
                    unset( $wp_scripts->registered[$key] );
                }
            }
        }
        if ( isset( $wp_scripts->registered['mapbox-search-widget'] ) && is_object( $wp_scripts->registered['mapbox-search-widget'] ) ){
            unset( $wp_scripts->registered['mapbox-search-widget']->extra['group'] ); //lets the mapbox geocoder work
        }
    }

    /**
     * Authorizes styles allowed to load in magic link
     *
     * Controls the linked styles loaded into the header.
     * @note This overrides standard DT header assets.
     */
    public function print_styles(){
        // @link /disciple-tools-theme/dt-assets/functions/enqueue-scripts.php
        $allowed_css = apply_filters( 'dt_magic_url_base_allowed_css', [] );

        global $wp_styles;
        if ( isset( $wp_styles ) ) {
            foreach ( $wp_styles->queue as $key => $item ) {
                if ( !in_array( $item, $allowed_css ) ) {
                    unset( $wp_styles->queue[$key] );
                }
            }
        }
    }
}
