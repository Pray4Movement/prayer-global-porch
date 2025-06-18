<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

require_once( 'abstract.php' );

class Prayer_Global_Migration_0017 extends Prayer_Global_Migration {
    public function up() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'dt_reports';
        $wpdb->dt_reports = $table_name;

        $wpdb->query(
            "ALTER TABLE $wpdb->dt_reports ADD COLUMN `timezone_timestamp` datetime not null DEFAULT CURRENT_TIMESTAMP"
        );

        $wpdb->query(
            "UPDATE $wpdb->dt_reports SET timezone_timestamp = FROM_UNIXTIME(timestamp)"
        );

        // Perform a single efficient update for all users' reports based on their timezone in usermeta
        $wpdb->query(
            "UPDATE $wpdb->dt_reports r
            JOIN $wpdb->usermeta m ON ( r.user_id = m.user_id AND m.meta_key = 'pg_location' AND m.meta_value LIKE '%timezone%' )
            SET r.timezone_timestamp = CONVERT_TZ(
                FROM_UNIXTIME(r.timestamp),
                'UTC',
                SUBSTRING(
                    m.meta_value,
                    LOCATE('s:8:\"timezone\";s:', m.meta_value) + LENGTH('s:8:\"timezone\";s:')
                    + LOCATE('\"', m.meta_value, LOCATE('s:8:\"timezone\";s:', m.meta_value) + LENGTH('s:8:\"timezone\";s:')) - (LOCATE('s:8:\"timezone\";s:', m.meta_value) + LENGTH('s:8:\"timezone\";s:')) + 1,
                    LOCATE('\";', m.meta_value, LOCATE('s:8:\"timezone\";s:', m.meta_value) + LENGTH('s:8:\"timezone\";s:')) - (LOCATE('s:8:\"timezone\";s:', m.meta_value) + LENGTH('s:8:\"timezone\";s:'))
                    - (LOCATE('\"', m.meta_value, LOCATE('s:8:\"timezone\";s:', m.meta_value) + LENGTH('s:8:\"timezone\";s:')) - (LOCATE('s:8:\"timezone\";s:', m.meta_value) + LENGTH('s:8:\"timezone\";s:')) + 1)
                )
            )"
        );
    }

    public function down() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'dt_reports';
        $wpdb->dt_reports = $table_name;
        $wpdb->query( "ALTER TABLE $wpdb->dt_reports DROP COLUMN `timezone_timestamp`" );
    }

    public function test() {
        $this->test_expected_tables();
    }
}
