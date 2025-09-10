<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

require_once( 'abstract.php' );

class Prayer_Global_Migration_0020 extends Prayer_Global_Migration {
    public function up() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'dt_badges';
        $wpdb->dt_badges = $table_name;

        $wpdb->query( "DROP TABLE IF EXISTS $wpdb->dt_badges" );
        $wpdb->query(
            "CREATE TABLE IF NOT EXISTS $wpdb->dt_badges (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `user_id` bigint(20) UNSIGNED NOT NULL,
            `badge_id` varchar(50) NOT NULL,
            `category` varchar(50) NOT NULL,
            `value` int(11) NOT NULL,
            `timestamp` int(11) NOT NULL DEFAULT (UNIX_TIMESTAMP()),
            PRIMARY KEY (`id`),
            KEY `user_badge` (`user_id`, `category`, `value`, `badge_id`)
        ) " );
    }

    public function down() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'dt_badges';
        $wpdb->dt_badges = $table_name;
        $wpdb->query( "DROP TABLE IF EXISTS $wpdb->dt_badges" );
    }

    public function test() {
        $this->test_expected_tables();
    }
}
