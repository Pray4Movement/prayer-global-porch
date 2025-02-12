<?php
declare(strict_types=1);

if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly


require_once( 'abstract.php' );

/**
 * Class Disciple_Tools_Migration_0000
 */
class Prayer_Global_Migration_0010 extends Prayer_Global_Migration {

    /**
     * @throws \Exception  Got error when creating table $name.
     */
    public function up() {
        global $wpdb;
        $wpdb->postmeta = $wpdb->prefix . 'postmeta';
        $wpdb->posts = $wpdb->prefix . 'posts';

        $query = $wpdb->query( "
            DELETE FROM $wpdb->postmeta
            USING $wpdb->postmeta pm, $wpdb->postmeta pm1
            WHERE pm.meta_id > pm1.meta_id
            AND pm.meta_key = 'prayer_app_relay_key'
            AND pm.post_id = pm1.post_id
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
