<?php
declare(strict_types=1);

if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly


require_once( 'abstract.php' );

/**
 * Class Disciple_Tools_Migration_0000
 */
class Prayer_Global_Migration_0000 extends Prayer_Global_Migration {

    /**
     * @throws \Exception  Got error when creating table $name.
     */
    public function up() {
        //create relays table
        global $wpdb;
        $wpdb->dt_relays = $wpdb->prefix . 'dt_relays';
        $wpdb->query( "
            CREATE TABLE IF NOT EXISTS $wpdb->dt_relays (
            id BIGINT(20) NOT NULL AUTO_INCREMENT,
            relay_id VARCHAR(20) NOT NULL,
            grid_id BIGINT(20) NOT NULL,
            total INT DEFAULT 0,
            epoch BIGINT(20) DEFAULT (UNIX_TIMESTAMP()),
            PRIMARY KEY (id)
        )" );

        //relay_id index
        $relay_id_index_exists = $wpdb->query( $wpdb->prepare("
                select distinct index_name
                from information_schema.statistics
                where table_schema = %s
                and table_name = '$wpdb->dt_relays'
                and index_name like %s
            ", DB_NAME, 'relay_id_index' ));
        if ( $relay_id_index_exists === 0 ){
            $wpdb->query( "ALTER TABLE $wpdb->dt_relays ADD INDEX relay_id_index (`relay_id`)" );
        }

        //relay_id epoch index
        $relay_id_epoch_index_exists = $wpdb->query( $wpdb->prepare("
                select distinct index_name
                from information_schema.statistics
                where table_schema = %s
                and table_name = '$wpdb->dt_relays'
                and index_name like %s
            ", DB_NAME, 'relay_id_epoch_index' ));
        if ( $relay_id_epoch_index_exists === 0 ){
            $wpdb->query( "ALTER TABLE $wpdb->dt_relays ADD INDEX relay_id_epoch_index (`relay_id`, `epoch`)" );
        }

        //relay_id grid_id index
        $relay_id_grid_id_index_exists = $wpdb->query( $wpdb->prepare("
                select distinct index_name
                from information_schema.statistics
                where table_schema = %s
                and table_name = '$wpdb->dt_relays'
                and index_name like %s
            ", DB_NAME, 'relay_id_grid_id_index' ));
        if ( $relay_id_grid_id_index_exists === 0 ){
            $wpdb->query( "ALTER TABLE $wpdb->dt_relays ADD INDEX relay_id_grid_id_index (`relay_id`, `grid_id`)" );
        }

        //relay_id total index
        $relay_id_total_index_exists = $wpdb->query( $wpdb->prepare("
                select distinct index_name
                from information_schema.statistics
                where table_schema = %s
                and table_name = '$wpdb->dt_relays'
                and index_name like %s
            ", DB_NAME, 'relay_id_total_index' ));
        if ( $relay_id_total_index_exists === 0 ){
            $wpdb->query( "ALTER TABLE $wpdb->dt_relays ADD INDEX relay_id_total_index (`relay_id`, `total`)" );
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
