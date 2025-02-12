<?php
declare(strict_types=1);

if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly


require_once( 'abstract.php' );

/**
 * Class Disciple_Tools_Migration_0010
 */
class Prayer_Global_Migration_0010 extends Prayer_Global_Migration {

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
        $wpdb->query( "
            UPDATE $wpdb->dt_reports AS r 
              JOIN (
                SELECT id, @n:=IF( global_lap_number is NULL, @n, global_lap_number ) global_lap_number
                  FROM ( SELECT * FROM $wpdb->dt_reports ORDER BY id ) r,
                ( SELECT @n:=NULL ) t
              ) t2
              ON r.id = t2.id
            SET r.global_lap_number = t2.global_lap_number
            WHERE subtype = 'custom'
        " );
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
