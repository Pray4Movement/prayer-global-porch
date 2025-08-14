<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

require_once( 'abstract.php' );

class Prayer_Global_Migration_0019 extends Prayer_Global_Migration {

    public function up() {
        global $wpdb;

        $wpdb->posts = $wpdb->prefix . 'posts';
        $wpdb->postmeta = $wpdb->prefix . 'postmeta';

        // Insert lap_number = 1 where no lap_number meta exists for pg_relays
        $wpdb->query(
            "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value)
             SELECT p.ID, 'lap_number', '1'
             FROM $wpdb->posts p
             LEFT JOIN $wpdb->postmeta pm
               ON pm.post_id = p.ID AND pm.meta_key = 'lap_number'
             WHERE p.post_type = 'pg_relays'
               AND pm.post_id IS NULL"
        );

        // Normalize empty/zero lap_number values to 1
        $wpdb->query(
            "UPDATE $wpdb->postmeta
             SET meta_value = '1'
             WHERE meta_key = 'lap_number'
               AND (meta_value IS NULL OR meta_value = '' OR meta_value = '0')"
        );
    }

    public function down() {
        // No-op: do not remove lap numbers once set
    }

    public function test() {
        $this->test_expected_tables();
    }
}
