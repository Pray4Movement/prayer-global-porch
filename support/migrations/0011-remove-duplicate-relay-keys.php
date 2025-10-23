<?php
declare(strict_types=1);

if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly


require_once( 'abstract.php' );

/**
 * Class Disciple_Tools_Migration_0000
 */
class Prayer_Global_Migration_0011 extends Prayer_Global_Migration {

    /**
     * @throws \Exception  Got error when creating table $name.
     */
    public function up() {
        global $wpdb;
        $wpdb->postmeta = $wpdb->prefix . 'postmeta';

        $query = $wpdb->query( "
            DELETE pm1 FROM $wpdb->postmeta pm1
            JOIN $wpdb->postmeta pm2
            ON pm1.post_id = pm2.post_id
            AND pm1.meta_key = 'prayer_app_relay_key'
            AND pm2.meta_key = 'prayer_app_relay_key'
            AND pm1.meta_id > pm2.meta_id;
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
