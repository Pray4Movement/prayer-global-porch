<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

require_once( 'abstract.php' );

class Prayer_Global_Migration_0016 extends Prayer_Global_Migration {
    public function up() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'dt_notifications_sent';
        $wpdb->dt_notifications_sent = $table_name;

        $wpdb->query( "DROP TABLE IF EXISTS $wpdb->dt_notifications_sent" );
        $wpdb->query(
            "CREATE TABLE IF NOT EXISTS $wpdb->dt_notifications_sent (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `user_id` bigint(20) UNSIGNED NOT NULL,
            `category` varchar(50) NOT NULL,
            `milestone_value` int(11) NOT NULL,
            `channel` varchar(50) NOT NULL,
            `sent_at` int(11) NOT NULL DEFAULT UNIX_TIMESTAMP(),
            PRIMARY KEY (`id`),
            KEY `user_notification` (`user_id`, `category`, `milestone_value`, `channel`)
        ) " );
    }

    public function down() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'dt_notifications_sent';
        $wpdb->dt_notifications_sent = $table_name;
        $wpdb->query( "DROP TABLE IF EXISTS $wpdb->dt_notifications_sent" );
    }

    public function test() {
        $this->test_expected_tables();
    }
}
