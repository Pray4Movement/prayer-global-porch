<?php
declare(strict_types=1);

if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly


require_once( 'abstract.php' );

/**
 * Class Disciple_Tools_Migration_0000
 */
class Prayer_Global_Migration_0009 extends Prayer_Global_Migration {

    /**
     * @throws \Exception  Got error when creating table $name.
     */
    public function up() {
        global $wpdb;
        $wpdb->postmeta = $wpdb->prefix . 'postmeta';
        $wpdb->posts = $wpdb->prefix . 'posts';

        $query = $wpdb->query( "
            DELETE $wpdb->postmeta FROM $wpdb->postmeta
            JOIN $wpdb->posts ON ID = post_id AND post_type = 'pg_relays'
            WHERE meta_key = 'prayer_app_global_magic_key'
                OR meta_key = 'prayer_app_custom_magic_key'
                OR meta_key = 'global_lap_number'
        " );
        if ( $query === false ) {
            throw new \Exception( "Got error when updating table $wpdb->dt_reports." );
        }
    }

    /**
     * @throws \Exception  Got error when dropping table $name.
     */
    public function down() {}

    /**
     * @return array
     */
    public function get_expected_tables(): array {
        return [];
    }

    /**
     * Test function
     */
    public function test() {
        $this->test_expected_tables();
    }
}
