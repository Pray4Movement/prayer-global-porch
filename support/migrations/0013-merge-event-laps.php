<?php
declare(strict_types=1);

if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly


require_once( 'abstract.php' );

/**
 * Class Disciple_Tools_Migration_0011
 */
class Prayer_Global_Migration_0013 extends Prayer_Global_Migration {

    /**
     * @throws \Exception  Got error when creating table $name.
     */
    public function up() {
        global $wpdb;
        $wpdb->dt_reports = $wpdb->prefix . 'dt_reports';
        $wpdb->dt_relays = $wpdb->prefix . 'dt_relays';
        $event_laps_query = $wpdb->get_results( "
            SELECT COUNT(post_id) as count, post_id, subtype
            FROM $wpdb->dt_reports
            where subtype = 'event'
            GROUP BY post_id
            ORDER BY post_id
        ", ARRAY_A);

        $event_laps = [];
        foreach ( $event_laps_query as $event_lap ){
            if ( $event_lap['count'] > 1000 ){
                $event_laps[] = $event_lap['post_id'];
            }
        }

        if ( empty( $event_laps ) ){
            return;
        }

        $current_lap_number = $wpdb->get_var( $wpdb->prepare(
            "SELECT MIN(total) + 1 as lap_number
            FROM $wpdb->dt_relays
            WHERE relay_key = %s", '49ba4c' ) );
        $relay_id = $wpdb->get_var( $wpdb->prepare( "
            SELECT pm.post_id
            FROM $wpdb->postmeta as pm
            WHERE pm.meta_key = %s
            AND pm.meta_value = %s
            ORDER BY pm.post_id DESC
            LIMIT 1
        ", 'prayer_app_relay_key', '49ba4c' ) );


        /**
         * Create a gap for the 2 event laps
         */
        $wpdb->query( $wpdb->prepare( "
            UPDATE $wpdb->dt_reports
            SET lap_number = lap_number +2, global_lap_number = global_lap_number +2 
            WHERE lap_number >=  %d
            AND post_id = %d
        ", $current_lap_number -1, $relay_id ) );

        /**
         * Update event one
         */
        $wpdb->query( $wpdb->prepare( "
            UPDATE $wpdb->dt_reports
            SET lap_number = %d, global_lap_number = %d, subtype = 'global'
            WHERE post_id = %d
        ", $current_lap_number - 1, $current_lap_number -1, $event_laps[0] ) );

        /**
         * Update event two
         */
        $wpdb->query( $wpdb->prepare( "
            UPDATE $wpdb->dt_reports
            SET lap_number = %d, global_lap_number = %d, subtype = 'global'
            WHERE post_id = %d
        ", $current_lap_number, $current_lap_number, $event_laps[1] ) );


        /**
         * Update the relays table
         */
        $wpdb->query( $wpdb->prepare( "
            UPDATE $wpdb->dt_relays
            SET total = total + 2
            WHERE relay_key = %s
        ", '49ba4c' ) );
    }

    /**
     * @throws \Exception  Got error when dropping table $name.
     */
    public function down() {
        global $wpdb;
        $wpdb->dt_reports = $wpdb->prefix . 'dt_reports';
        $wpdb->query( "
            UPDATE $wpdb->dt_reports
            SET lap_number NULL
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
