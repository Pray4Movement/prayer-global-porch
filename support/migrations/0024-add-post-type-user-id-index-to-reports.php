<?php
declare(strict_types=1);

if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly


require_once( 'abstract.php' );

class Prayer_Global_Migration_0024 extends Prayer_Global_Migration {

    /**
     * @throws \Exception  Got error when creating table $name.
     */
    public function up() {
        global $wpdb;
        $wpdb->dt_reports = $wpdb->prefix . 'dt_reports';

        $post_type_user_id_index_exists = $wpdb->query( $wpdb->prepare("
                select distinct index_name
                from information_schema.statistics
                where table_schema = %s
                and table_name = '$wpdb->dt_reports'
                and index_name like %s
            ", DB_NAME, 'post_type_user_id_index' ));
        if ( $post_type_user_id_index_exists === 0 ){
            $wpdb->query( "ALTER TABLE $wpdb->dt_reports ADD INDEX post_type_user_id_index (`post_type`, `user_id`)" );
        }
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
