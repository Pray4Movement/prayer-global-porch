<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

require_once( 'abstract.php' );

class Prayer_Global_Migration_0023 extends Prayer_Global_Migration {
    public function up() {
        global $wpdb;
        $wpdb->dt_notifications_sent = $wpdb->prefix . 'dt_notifications_sent';
        $wpdb->query( "ALTER TABLE $wpdb->dt_notifications_sent
            CHANGE COLUMN milestone_value value INT(11) NOT NULL
        " );
    }

    public function down() {
        global $wpdb;
        $wpdb->dt_notifications_sent = $wpdb->prefix . 'dt_notifications_sent';
        $wpdb->query( "ALTER TABLE $wpdb->dt_notifications_sent
            CHANGE COLUMN value milestone_value INT(11) NOT NULL
        " );
    }

    public function test() {
        $this->test_expected_tables();
    }
}
