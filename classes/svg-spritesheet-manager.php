<?php

class SVG_Spritesheet_Manager {
    private string $icon_dir;
    private string $cache_dir;
    private string $cache_url;

    public function __construct( string $dir = 'pages/assets/images/icons', string $cache_path = 'pages/assets/images/spritesheet-cache' ) {
        $plugin_dir = plugin_dir_path( __DIR__ );
        $plugin_url = plugin_dir_url( __DIR__ );
        $this->icon_dir = trailingslashit( $plugin_dir ) . $dir;
        $this->cache_dir = trailingslashit( $plugin_dir ) . $cache_path;
        $this->cache_url = trailingslashit( $plugin_url ) . $cache_path;

        if ( !is_dir( $this->cache_dir ) ) {
            $old_umask = umask( 0 );
            mkdir( $this->cache_dir, 0775 );
            umask( $old_umask );
        }
    }

    public function get_cached_spritesheet_url( array $icons, string $namespace = 'pg' ) {
        return trailingslashit( $this->cache_url ) . $this->get_cached_spritesheet_filename( $icons, $namespace );
    }

    public function get_cached_spritesheet_dir( array $icons, string $namespace = 'pg' ) {
        return trailingslashit( $this->cache_dir ) . $this->get_cached_spritesheet_filename( $icons, $namespace );
    }

    private function get_cached_spritesheet_filename( array $icons, string $namespace ) {
        if ( empty( $icons ) ) {
            return '';
        }

        sort( $icons );

        $icons_hash = md5( implode( '-', $icons ) );

        $cache_filename = $namespace . '-' . $icons_hash . '.svg';
        $cached_file = trailingslashit( $this->cache_dir ) . $cache_filename;

        if ( defined( 'WP_DEBUG' ) && WP_DEBUG === true ) {
            $this->save_spritesheet( $icons, $cached_file );

            return $cache_filename;
        }

        $regenerate = false;
        if ( !file_exists( $cached_file ) ) {
            $regenerate = true;
        } else {
            $cache_timestamp = filemtime( $cached_file );

            foreach ( $icons as $icon ) {
                $icon_filename = trailingslashit( $this->icon_dir ) . $icon;
                if ( filemtime( $icon_filename ) > $cache_timestamp ) {
                    $regenerate = true;
                    break;
                }
            }
        }

        if ( $regenerate === true ) {
            $this->save_spritesheet( $icons, $cache_filename );
        }

        return $cache_filename;
    }

    private function save_spritesheet( array $icons, string $filename ) {
        $spritesheet = $this->generate_spritesheet( $icons );
        file_put_contents( $filename, $spritesheet );
        chmod( $filename, 0664 );
    }

    private function generate_spritesheet( array $icons ) {
        $spritesheet = '<svg xmlns="http://www.w3.org/2000/svg" style="display:none">';
        $spritesheet .= '<defs>';

        foreach ( $icons as $icon ) {
            $spritesheet .= $this->create_symbol( $icon );
        }

        $spritesheet .= '</defs>';
        $spritesheet .= '</svg>';

        return $spritesheet;
    }

    private function create_symbol( string $icon ) {
        $icon_filename = trailingslashit( $this->icon_dir ) . $icon . '.svg';

        if ( !file_exists( $icon_filename ) ) {
            return '';
        }

        $icon_content = file_get_contents( $icon_filename );

        $viewbox = $this->extract_viewbox( $icon_content );
        $content = $this->extract_inner_content( $icon_content );

        return sprintf(
            '<symbol id="%s" viewBox="%s">%s</symbol>',
            $icon,
            $viewbox,
            $content
        );
    }

    private function extract_viewbox( $icon_content ) {
        if ( preg_match( '/viewBox=["\'](.*?)["\']/i', $icon_content, $matches ) ) {
            return $matches[1];
        }
        if ( preg_match( '/width=["\'](.*?)["\']/i', $icon_content, $width ) && preg_match( '/height=["\'](.*?)["\']/i', $icon_content, $height ) ) {
            return '0 0 ' . $width[1] . ' ' . $height[1];
        }
        return '0 0 32 32';
    }

    // Extract the inner content, removing outer <svg> tags
    private function extract_inner_content( $icon_content ) {
        $icon_content = preg_replace( '/<\?xml.*?\?>/i', '', $icon_content );

        $icon_content = preg_replace( '/<svg[^>]*>|<\/svg>/i', '', $icon_content );

        $icon_content = preg_replace( '/<title>.*?<\/title>/i', '', $icon_content );
        $icon_content = preg_replace( '/<desc>.*?<\/desc>/i', '', $icon_content );

        return trim( $icon_content );
    }
}
