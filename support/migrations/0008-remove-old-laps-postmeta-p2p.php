<?php
declare(strict_types=1);

if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly


require_once( 'abstract.php' );

/**
 * Class Disciple_Tools_Migration_0000
 */
class Prayer_Global_Migration_0008 extends Prayer_Global_Migration {

    /**
     * @throws \Exception  Got error when creating table $name.
     */
    public function up() {
        global $wpdb;
        $wpdb->postmeta = $wpdb->prefix . 'postmeta';
        $wpdb->posts = $wpdb->prefix . 'posts';
        $wpdb->p2p = $wpdb->prefix . 'p2p';

        /* Remove old lap postmeta */
        $query = $wpdb->query( "
            DELETE $wpdb->postmeta FROM $wpdb->postmeta
            JOIN $wpdb->posts p ON ID = post_id
            WHERE p.post_type = 'laps'
        " );
        if ( $query === false ) {
            throw new \Exception( "Got error when updating table $wpdb->dt_reports." );
        }
        /* Remove old lap p2p */
        $query = $wpdb->query( "
            DELETE $wpdb->p2p FROM $wpdb->p2p
            JOIN $wpdb->posts ON (ID = p2p_from OR ID = p2p_to)
            WHERE post_type = 'laps'
        " );
        if ( $query === false ) {
            throw new \Exception( "Got error when updating table $wpdb->dt_reports." );
        }
        /* Remove old laps */

        $query = $wpdb->query( "
            DELETE FROM $wpdb->posts
            WHERE post_type = 'laps'
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
