<?php
declare(strict_types=1);

if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly


require_once( 'abstract.php' );

/**
 * The notification/stats code reads the user timezone from pg_location under the
 * key 'time_zone', but the settings save path historically stored it under
 * 'timezone'. Normalize existing rows onto the canonical 'time_zone' key so the
 * two spellings stop diverging.
 */
class Prayer_Global_Migration_0025 extends Prayer_Global_Migration {

    public function up() {
        global $wpdb;

        $rows = $wpdb->get_results(
            "SELECT user_id, meta_value FROM $wpdb->usermeta WHERE meta_key = 'pg_location'",
            ARRAY_A
        );

        foreach ( $rows as $row ) {
            $location = maybe_unserialize( $row['meta_value'] );
            if ( !is_array( $location ) || !array_key_exists( 'timezone', $location ) ) {
                continue;
            }

            // Only adopt the legacy value when the canonical key is empty, so we
            // never clobber a good 'time_zone' with a stale 'timezone'.
            if ( empty( $location['time_zone'] ) && !empty( $location['timezone'] ) ) {
                $location['time_zone'] = $location['timezone'];
            }
            unset( $location['timezone'] );

            update_user_meta( (int) $row['user_id'], 'pg_location', $location );
        }
    }

    public function down() {}

    public function get_expected_tables(): array {
        return [];
    }

    public function test() {
        $this->test_expected_tables();
    }
}
