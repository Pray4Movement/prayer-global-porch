<?php
declare(strict_types=1);

if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly


require_once( 'abstract.php' );

/**
 * Class Disciple_Tools_Migration_0000
 */
class Prayer_Global_Migration_0004 extends Prayer_Global_Migration {

    /**
     * @throws \Exception  Got error when creating table $name.
     */
    public function up() {
        global $wpdb;
        $wpdb->posts = $wpdb->prefix . 'posts';
        $wpdb->postmeta = $wpdb->prefix . 'postmeta';
        $wpdb->p2p = $wpdb->prefix . 'p2p';

        /* Change last child posts to have type 'relays' */
        $query = $wpdb->get_col( "
            UPDATE $wpdb->posts p
            LEFT JOIN $wpdb->p2p p2p ON p.ID = p2p.p2p_from
            SET p.post_type = 'pg_relays'
            WHERE p.post_type = 'laps'
            AND p2p.p2p_from IS NULL
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
