<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

require_once( 'abstract.php' );

class Prayer_Global_Migration_0021 extends Prayer_Global_Migration {
    public function up() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'dt_badges';
        $wpdb->dt_badges = $table_name;

        $wpdb->query( "ALTER TABLE $wpdb->dt_badges ADD COLUMN retroactive TINYINT(1) NOT NULL DEFAULT 0" );
    }

    public function down() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'dt_badges';
        $wpdb->dt_badges = $table_name;
        $wpdb->query( "ALTER TABLE $wpdb->dt_badges DROP COLUMN retroactive" );
    }

    public function test() {
        $this->test_expected_tables();
    }
}
