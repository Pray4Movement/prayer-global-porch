<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

add_filter( 'dt_magic_url_base_allowed_js', function ( $allowed_js ){
    $allowed_js = array_merge( $allowed_js, [
        'jquery',
        'share-js',
        'components-js',
        'canvas-confetti',
        'global-functions',
        'median-js',
        'median-permissions',
        'main-js',
        'bootstrap',
        'slick',
        'heatmap-js',
        'jquery-easing',
        'jquery-waypoints',
        'umami',
        'lit-bundle',
        'glitchtip',
    ] );

    return $allowed_js;
}, 100, 1 );


function pg_enqueue_script( string $handle, string $rel_src, array $deps = array(), array|bool $args = false ) {
    wp_enqueue_script( $handle, Prayer_Global_Porch::get_url_path() . "$rel_src", $deps, filemtime( Prayer_Global_Porch::get_dir_path() . "$rel_src" ), $args );
}
function pg_enqueue_style( string $handle, string $rel_src, array $deps = array(), array|bool $args = false ) {
    wp_enqueue_style( $handle, Prayer_Global_Porch::get_url_path() . "$rel_src", $deps, filemtime( Prayer_Global_Porch::get_dir_path() . "$rel_src" ), $args );
}

add_action( 'wp_enqueue_scripts', function (){
    //only include scripts if the current page is a blank template
    $url_path = dt_get_url_path( true );
    $template = apply_filters( 'dt_templates_for_urls', [] );
    if ( !empty( $url_path ) && ( !isset( $template[$url_path] ) || $template[$url_path] !== 'template-blank.php' ) ) {
        return;
    }
    /**
     * Enqueue styles
     */
    wp_enqueue_style( 'bootstrap-css', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.2/css/bootstrap.min.css', [], '5.2.3' );
    wp_enqueue_style( 'ionicons-css', 'https://cdnjs.cloudflare.com/ajax/libs/ionicons/4.5.6/css/ionicons.min.css', [], '4.5.6' );
    pg_enqueue_style( 'pg-styles-css', 'pages/assets/fonts/prayer-global/style.css', [ 'bootstrap-css' ] );
    pg_enqueue_style( 'basic-css', 'pages/assets/css/basic.css', [ 'bootstrap-css' ] );
    wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Crimson+Text:400,400i,600|Montserrat:200,300,400', [], '1' );


    /**
     * Enqueue scripts
     */
    wp_deregister_script( 'jquery' );
    wp_enqueue_script( 'jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js', [], '3.7.1', [ 'strategy' => 'defer' ] );
    wp_enqueue_script( 'canvas-confetti', 'https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js', [], '1.5.1', [ 'strategy' => 'defer' ] );
    pg_enqueue_script( 'global-functions', 'pages/assets/js/global-functions.js', [], [ 'strategy' => 'defer' ] );
    pg_enqueue_script( 'median-permissions', 'pages/assets/js/median-permissions.js', [], [ 'strategy' => 'defer' ] );
    pg_enqueue_script( 'median-js', 'pages/assets/js/median.js', [ 'global-functions', 'median-permissions', 'bootstrap' ], [ 'strategy' => 'defer' ] );
    pg_enqueue_script( 'components-js', 'pages/assets/js/components.js', [ 'jquery', 'global-functions' ], [ 'strategy' => 'defer' ] );

    wp_enqueue_script( 'glitchtip', 'https://browser.sentry-cdn.com/7.60.0/bundle.min.js', [], '7.60.0', [ 'strategy' => 'defer' ] );
    pg_enqueue_script( 'main-js', 'pages/assets/js/main.js', [ 'jquery', 'global-functions', 'glitchtip' ], [ 'strategy' => 'defer' ] );
    pg_enqueue_script( 'share-js', 'pages/assets/js/share.js', [ 'jquery', 'global-functions', 'bootstrap' ], [ 'strategy' => 'defer' ] );
    pg_enqueue_script( 'lit-bundle', 'pages/assets/js/dist/assets/components-bundle.js', [ 'global-functions', 'share-js' ], [ 'strategy' => 'defer' ] );

    wp_enqueue_script( 'bootstrap', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js', [], '5.3.3', [ 'strategy' => 'defer' ] );
    wp_enqueue_script( 'slick', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js', [], '1.9.0', [ 'strategy' => 'defer' ] );
    //Easily execute a function when you scroll to an element
    wp_enqueue_script( 'jquery-waypoints', 'https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js', [ 'jquery' ], '4.0.1', [ 'strategy' => 'defer' ] );
    wp_enqueue_script( 'jquery-easing', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js', [ 'jquery' ], '1.4.1', [ 'strategy' => 'defer' ] );

    if ( !defined( 'WP_DEBUG' ) || !WP_DEBUG ) {
        wp_enqueue_script( 'umami', 'https://umami.gospelambition.com/script.js', [], 1, [ 'strategy' => 'defer', ] );
    }

    wp_localize_script( 'global-functions', 'pg_global', [
        'map_key' => DT_Mapbox_API::get_key(),
        'mirror_url' => dt_get_location_grid_mirror( true ),
        'cache_url' => dt_get_location_grid_mirror( true ),
        'json_cache_url' => 'https://s3.prayer.global/',
        'language' => pg_get_current_lang(),
        'root' => esc_url_raw( rest_url() ),
        'nonce' => wp_create_nonce( 'wp_rest' ),
        'is_logged_in' => is_user_logged_in(),
        'current_language' => pg_get_current_lang(),
        'has_requested_notifications' => is_user_logged_in() ? get_user_meta( get_current_user_id(), PG_NAMESPACE . 'requested_notifications', true ) : false,
        'has_notifications_permission' => is_user_logged_in() ? get_user_meta( get_current_user_id(), PG_NAMESPACE . 'notifications_permission', true ) : false,
        'has_used_app' => is_user_logged_in() ? get_user_meta( get_current_user_id(), PG_NAMESPACE . 'has_used_app', true ) === '1' : false,
        'user' => PG_User_API::get_user(),
        'home_url' => home_url(),
    ]);

    wp_localize_script( 'components-js', 'pg_components', [
        'translations' => [
            'years' => __( 'Years', 'prayer-global-porch' ),
            'days' => __( 'Days', 'prayer-global-porch' ),
            'hours' => __( 'Hours', 'prayer-global-porch' ),
            'minutes' => __( 'Minutes', 'prayer-global-porch' ),
            'seconds' => __( 'Seconds', 'prayer-global-porch' ),
        ],
    ] );

    wp_localize_script( 'share-js', 'pg_share', [
        'translations' => [
            'Join us in covering the world in prayer' => __( 'Join us in covering the world in prayer', 'prayer-global-porch' ),
        ],
    ] );
}, 1000 );

function pg_heatmap_scripts( $glass ){
    DT_Mapbox_API::load_mapbox_header_scripts();
    pg_enqueue_script( 'heatmap-js', 'pages/pray/heatmap.js', [ 'jquery', 'mapbox-gl' ], true );
    wp_localize_script( 'heatmap-js', 'pg_heatmap', [

        'translations' => [
            "Don't Know Jesus" => __( "Don't Know Jesus", 'prayer-global-porch' ),
            'one_believer_for_every' => __( '1 believer for every %d lost neighbors.', 'prayer-global-porch' ),
            'Know about Jesus' => __( 'Know About Jesus', 'prayer-global-porch' ),
            'Know Jesus' => __( 'Know Jesus', 'prayer-global-porch' ),
            'location_description1' => _x( '%1$s of %2$s has a population of %3$s.', 'The state of Colorado has a population of 5,773,714.', 'prayer-global-porch' ),
            'location_description2' => _x( 'We estimate %1$s has %2$s people who might know Jesus, %3$s people who might know about Jesus culturally, and %4$s people who do not know Jesus.', 'We estimate new york has 100 people who might know Jesus, 300 people who might know about Jesus culturally, and 500 people who do not know Jesus.', 'prayer-global-porch' ),
            'location_description3' => _x( '%1$s is 1 of %2$s %3$s.', 'Colorado is 1 of 50 states.', 'prayer-global-porch' ),
            'religion' => __( 'Religion', 'prayer-global-porch' ),
            'official_language' => __( 'Official Language', 'prayer-global-porch' ),
            'Community Stats' => __( 'Community Stats', 'prayer-global-porch' ),
            'Summary' => __( 'Summary', 'prayer-global-porch' ),
            'Activity' => __( 'Activity', 'prayer-global-porch' ),
            'Times prayed for' => __( 'Times prayed for', 'prayer-global-porch' ),
            'Total time prayed' => __( 'Total time prayed', 'prayer-global-porch' ),
            'minute' => __( 'minute', 'prayer-global-porch' ),
            'minutes' => __( 'minutes', 'prayer-global-porch' ),
        ]
    ] );
}


add_filter( 'script_loader_tag', function ( $tag, $handle ){

    if ( $handle === 'umami' ) {
        return '<script defer src="https://umami.gospelambition.com/script.js" data-website-id="c8b2d630-e64a-4354-b03a-f92ac853153e"></script>'; //phpcs:ignore
    }

    if ( str_starts_with( $handle, 'lit-bundle' ) ) {
        if ( str_contains( $tag, 'type=' ) ) {
            $tag = preg_replace( '/type="text\/javascript"/', 'type="module"', $tag );
        } else {
            $tag = preg_replace( '/(.*)(><\/script>)/', '$1 type="module"$2', $tag );
        }
    }

    return $tag;
}, 10, 2 );



add_action( 'dt_magic_url_base_allowed_css', function ( $allowed_css ){
    $allowed_css = [];
    $allowed_css[] = 'basic-css';
    $allowed_css[] = 'bootstrap-css';
    $allowed_css[] = 'ionicons-css';
    $allowed_css[] = 'pg-styles-css';
    $allowed_css[] = 'google-fonts';

    return $allowed_css;
}, 5, 1 );
