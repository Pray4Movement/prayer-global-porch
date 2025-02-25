<?php
declare(strict_types=1);

if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly


require_once( 'abstract.php' );

/**
 * Class Disciple_Tools_Migration_0000
 */
class Prayer_Global_Migration_0006 extends Prayer_Global_Migration {

    /**
     * @throws \Exception  Got error when creating table $name.
     */
    public function up() {
        global $wpdb;
        $wpdb->dt_relays = $wpdb->prefix . 'dt_relays';

        $query = $wpdb->query( "
            ALTER TABLE $wpdb->dt_relays
            RENAME COLUMN relay_id TO relay_key
        " );
        if ( $query === false ) {
            throw new \Exception( "Got error when updating table $wpdb->dt_reports." );
        }
    }

    /**
     * @throws \Exception  Got error when dropping table $name.
     */
    public function down() {
        global $wpdb;
        $wpdb->dt_relays = $wpdb->prefix . 'dt_relays';

        $query = $wpdb->query( "
            ALTER TABLE $wpdb->dt_relays
            RENAME COLUMN relay_key TO relay_id;
        " );
        if ( $query === false ) {
            throw new \Exception( "Got error when updating table $wpdb->dt_reports." );
        }
    }

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
