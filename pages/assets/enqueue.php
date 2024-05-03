<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

add_filter( 'dt_magic_url_base_allowed_js', function ( $allowed_js ){
    $allowed_js[] = 'jQuery';
    $allowed_js[] = 'share-js';
    $allowed_js[] = 'components-js';
    $allowed_js[] = 'canvas-confetti';
    $allowed_js[] = 'global-functions';
    $allowed_js[] = 'main-js';
    $allowed_js[] = 'bootstrap';
    $allowed_js[] = 'slick';

    return $allowed_js;
}, 100, 1 );


function pg_enqueue_script( string $handle, string $rel_src, array $deps = array(), bool $in_footer = false ) {
    wp_enqueue_script( $handle, Prayer_Global_Porch::get_url_path() . "$rel_src", $deps, filemtime( Prayer_Global_Porch::get_dir_path() . "$rel_src" ), $in_footer );
}

add_action( 'wp_enqueue_scripts', function (){

    wp_enqueue_script( 'jQuery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js', [], '3.7.1', false );
    wp_enqueue_script( 'canvas-confetti', 'https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js', [], '1.5.1', true );
    pg_enqueue_script( 'global-functions', 'pages/assets/js/global-functions.js', ['jQuery'], true );
    pg_enqueue_script( 'components-js', 'pages/assets/js/components.js', ['jQuery', 'global-functions'], true );

    pg_enqueue_script( 'main-js', 'pages/assets/js/main.js', ['jQuery', 'global-functions'], true );
    pg_enqueue_script( 'share-js', 'pages/assets/js/share.js', ['jQuery', 'global-functions'], true );

    wp_enqueue_script( 'bootstrap', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js', [], '5.3.3', true );
    wp_enqueue_script( 'slick', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js', [], '1.9.0', true );
    //Easily execute a function when you scroll to an element
    wp_enqueue_script( 'jquery-waypoints', 'https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js', ['jQuery'], '4.0.1', true );
    //A jQuery plugin from GSGD to give advanced easing options

    wp_localize_script( 'components-js', 'pg_components', [
        'translations' => [
            'years' => __( 'Years', 'prayer-global-porch' ),
            'days' => __( 'Days', 'prayer-global-porch' ),
            'hours' => __( 'Hours', 'prayer-global-porch' ),
            'minutes' => __( 'Minutes', 'prayer-global-porch' ),
            'seconds' => __( 'Seconds', 'prayer-global-porch' ),
        ],
    ] );
});


/**
 * Enqueue styles
 * https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css
 *
 */