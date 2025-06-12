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

        // we need to update each users prayer records based on the timezone found in the serialized object 'pg_location' user meta
        $users = get_users();
        foreach ( $users as $user ) {
            $location = maybe_unserialize( get_user_meta( $user->ID, 'pg_location', true ) );
            // get the timezone from the location object e.g. 'America/New_York'
            if ( !isset( $location['timezone'] ) ) {
                continue;
            }
            $timezone = $location['timezone'];
            // update each report for this user by using the unix timestamp of the report and updating the timezone_timestamp field
            $wpdb->query(
                $wpdb->prepare(
                    "UPDATE $wpdb->dt_reports SET timezone_timestamp = CONVERT_TZ(FROM_UNIXTIME(timestamp), 'UTC', %s) WHERE user_id = %d",
                    $timezone,
                    $user->ID
                )
            );
        }
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
