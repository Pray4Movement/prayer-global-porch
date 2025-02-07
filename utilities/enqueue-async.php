<?php
/**
 * Async versions of script and style enqueuing loaders
 *
 * From https://github.com/joshuatz/joshuatz-wp-theme/blob/71a12bca12c5fa5b25b6eb3a70cd498845076834/inc/special-loader.php
 * + some adjustments to bring the latest loadCSS from https://www.filamentgroup.com/lab/load-css-simpler/
 */
/**
 * Fires after WordPress has finished loading but before any headers are sent.
 *
 */
add_action( 'init', function() : void {
    global $enqueue_async_handles;

    $enqueue_async_handles = (object) array(
        'styles' => (object) array(
            'async' => array(),
            'async_preload' => array()
        )
    );
} );

/**
 * Enqueue a style asyncrounously.
 *
 * Same signature as wp_enqueue_style, + $preload option
 *
 * @param string $handle
 * @param string $src_string
 * @param array $dep_array
 * @param bool|string|null $version
 * @param string $media
 * @param bool $preload
 * @return void
 */
function wp_enqueue_style_async( string $handle, string $src_string, array $dep_array, bool|string|null $version, string $media, bool $preload = false ){
    global $enqueue_async_handles;
    $load_method = $preload ? 'async_preload' : 'async';

    array_push( $enqueue_async_handles->styles->{$load_method}, $handle );
    wp_enqueue_style( $handle, $src_string, $dep_array, $version, $media );
}

function pg_filter_style_loader_tag( $tag, $handle ){
    global $enqueue_async_handles;
    $filter_tag = $tag;
    // Async loading via print mediaquery switching
    if ( in_array( $handle, array_merge( $enqueue_async_handles->styles->async, $enqueue_async_handles->styles->async_preload ), true ) ){
        if ( !preg_match( '/\sonload=|\smedia=["\']none["\']/', $tag ) ){
            // Lazy load with JS, but also but noscript in case no JS
            $no_script_str = '<noscript>' . $tag . '</noscript>';
            // Add onload and media="none" attr, and put together with noscript
            $matches = array();
            preg_match( '/(<link[^>]+)>/', $tag, $matches );
            $match = preg_replace( '/\/$/', '', $matches[1], 1 );
            $match = preg_replace( '/media=["\'].*["\']/', '', $match, 1 );
            $filter_tag = $match. ' media="print" onload="media=\'all\'" />' . $no_script_str;
        }
    }
    // Async loading via preload and loadCSS - https://github.com/filamentgroup/loadCSS/
    if ( in_array( $handle, $enqueue_async_handles->styles->async_preload, true ) ){
        // Do not touch if already modified
        if ( !preg_match( '/\srel=["\']preload|\sonload=["\']/', $tag ) ){
            // Strip rel="" & as="" portion, if exist
            $tag = preg_replace( '/\srel=["\'][^"\']*["\']|\sas=["\'][^"\']*["\']/', '', $tag, -1 );
            // Add onload, rel="preload", as="style", and put together with noscript
            $matches = array();
            preg_match( '/(<link[^>]+)>/', $tag, $matches );
            $filter_tag = preg_replace( '/\/$/', '', $matches[1], 1 ) . ' rel="preload" as="style" />' . $filter_tag;
        }
    }

    return $filter_tag;
}

add_filter( 'style_loader_tag', 'pg_filter_style_loader_tag', 10, 4 );
