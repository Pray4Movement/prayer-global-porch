<?php
declare(strict_types=1);

if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly


require_once( 'abstract.php' );

/**
 * Class Disciple_Tools_Migration_0011
 */
class Prayer_Global_Migration_0012 extends Prayer_Global_Migration {

    /**
     * @throws \Exception  Got error when creating table $name.
     */
    public function up() {
        global $wpdb;
        $wpdb->dt_reports = $wpdb->prefix . 'dt_reports';
        $wpdb->postmeta = $wpdb->prefix . 'postmeta';

        //post_id lap_number index
        $post_id_lap_number_index_exists = $wpdb->query( $wpdb->prepare("
                select distinct index_name
                from information_schema.statistics
                where table_schema = %s
                and table_name = '$wpdb->dt_reports'
                and index_name like %s
            ", DB_NAME, 'post_id_lap_number_index' ));
        if ( $post_id_lap_number_index_exists === 0 ){
            $wpdb->query( "ALTER TABLE $wpdb->dt_reports ADD INDEX post_id_lap_number_index (`post_id`, `lap_number`)" );
        }
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
