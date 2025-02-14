<?php
declare(strict_types=1);

if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly


require_once( 'abstract.php' );

/**
 * Class Disciple_Tools_Migration_0010
 */
class Prayer_Global_Migration_0007 extends Prayer_Global_Migration {

    /**
     * @throws \Exception  Got error when creating table $name.
     */
    public function up() {
        global $wpdb;
        $wpdb->dt_reports = $wpdb->prefix . 'dt_reports';
        $wpdb->postmeta = $wpdb->prefix . 'postmeta';

        $wpdb->query( "
            ALTER TABLE $wpdb->dt_reports
            ADD COLUMN global_lap_number INT AFTER lap_number
        " );


        $wpdb->query( "
            UPDATE $wpdb->dt_reports
            SET global_lap_number = lap_number
            WHERE subtype = 'global'
        " );

        //set global lap numbers for custom laps
        //update custom reports where the time reported is between the start
        //and end date of a global lap
        //set the global lap number of the report to match the global lap matched
        $wpdb->query(
            "UPDATE wp_dt_reports r
            JOIN (
                SELECT
                    pm2.meta_value AS global_lap_number,
                    r.id AS report_id
                FROM wp_posts p
                JOIN wp_postmeta pm ON p.ID = pm.post_id AND pm.meta_key = 'start_time'
                JOIN wp_postmeta pm1 ON p.ID = pm1.post_id AND pm1.meta_key = 'end_time'
                JOIN wp_postmeta pm2 ON p.ID = pm2.post_id AND pm2.meta_key = 'global_lap_number'
                JOIN wp_dt_reports r ON pm.meta_value <= r.timestamp AND r.timestamp <= pm1.meta_value
                WHERE p.post_title LIKE 'Global #%'
                AND p.post_type = 'laps'
            ) AS subquery ON r.id = subquery.report_id
            SET r.global_lap_number = subquery.global_lap_number;
        " );
        $wpdb->query(
            "UPDATE wp_dt_reports r
            JOIN (
                SELECT
                    pm2.meta_value AS global_lap_number,
                    r.id AS report_id
                FROM wp_posts p
                JOIN wp_postmeta pm ON p.ID = pm.post_id AND pm.meta_key = 'start_time'
                JOIN wp_postmeta pm2 ON p.ID = pm2.post_id AND pm2.meta_key = 'global_lap_number'
                JOIN wp_dt_reports r ON pm.meta_value <= r.timestamp
                WHERE p.post_title LIKE 'Global #%'
                AND p.post_type = 'pg_relays'
            ) AS subquery ON r.id = subquery.report_id
            SET r.global_lap_number = subquery.global_lap_number;
        " );
    }

    /**
     * @throws \Exception  Got error when dropping table $name.
     */
    public function down() {
        global $wpdb;
        $wpdb->dt_reports = $wpdb->prefix . 'dt_reports';
        $wpdb->query( "
            ALTER TABLE $wpdb->dt_reports
            DROP COLUMN global_lap_number
        " );
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
