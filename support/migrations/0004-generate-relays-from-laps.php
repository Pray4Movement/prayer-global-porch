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

        /* Change active lap posts to have type 'relays' */
        $wpdb->get_col( "
            UPDATE $wpdb->posts
            SET post_type = 'pg_relays'
            WHERE ID in (
                SELECT ID from $wpdb->posts
                LEFT JOIN $wpdb->p2p
                ON ID = p2p_from
                WHERE post_type = 'laps'
                AND p2p_from IS NULL
            )
        " );
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
