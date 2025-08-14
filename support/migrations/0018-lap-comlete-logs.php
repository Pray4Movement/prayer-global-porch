<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

require_once( 'abstract.php' );

/**
 * Backfill lap_completed logs into dt_reports for each completed lap per relay.
 *
 * Uses dt_relays to determine the number of completed laps per relay_key.
 * For each completed lap, inserts a row into
 * dt_reports with type = 'lap_completed' at the lap's end timestamp derived
 * from existing prayer_app reports.
 */
class Prayer_Global_Migration_0018 extends Prayer_Global_Migration {

    public function up() {
        global $wpdb;

        $wpdb->dt_reports = $wpdb->prefix . 'dt_reports';
        $wpdb->dt_relays = $wpdb->prefix . 'dt_relays';
        $wpdb->postmeta = $wpdb->prefix . 'postmeta';

        // Fetch all relays with their relay_key
        $relays = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT post_id, meta_value AS relay_key
                FROM $wpdb->postmeta
                WHERE meta_key = %s",
                'prayer_app_relay_key'
            ),
            ARRAY_A
        );

        if ( empty( $relays ) ) {
            return;
        }

        foreach ( $relays as $relay ) {
            $post_id = (int) $relay['post_id'];
            $relay_key = $relay['relay_key'];

            // Determine how many laps are completed for this relay: only if it has all 4770 rows
            $relay_stats = $wpdb->get_row(
                $wpdb->prepare(
                    "SELECT COUNT(*) AS relay_count, COALESCE(MIN(total), 0) AS min_total
                    FROM $wpdb->dt_relays
                    WHERE relay_key = %s",
                    $relay_key
                ),
                ARRAY_A
            );

            if ( empty( $relay_stats ) || (int) $relay_stats['relay_count'] !== 4770 ) {
                continue;
            }

            $completed_laps = (int) $relay_stats['min_total'];

            if ( $completed_laps <= 0 ) {
                continue;
            }

            for ( $lap = 1; $lap <= $completed_laps; $lap++ ) {
                // Skip if a lap_completed log already exists for this lap and relay
                $exists = (int) $wpdb->get_var(
                    $wpdb->prepare(
                        "SELECT COUNT(*) FROM $wpdb->dt_reports
                        WHERE type = %s AND post_type = %s AND post_id = %d AND value = %d",
                        'lap_completed', 'pg_relays', $post_id, $lap
                    )
                );
                if ( $exists > 0 ) {
                    continue;
                }

                // Determine the lap end timestamp based on prayer_app activity
                if ( $relay_key === '49ba4c' ) {
                    $end_ts = (int) $wpdb->get_var(
                        $wpdb->prepare(
                            "SELECT MAX(timestamp)
                            FROM $wpdb->dt_reports
                            WHERE type = 'prayer_app'
                            AND post_type = 'pg_relays'
                            AND global_lap_number = %d",
                            $lap
                        )
                    );
                } else {
                    $end_ts = (int) $wpdb->get_var(
                        $wpdb->prepare(
                            "SELECT MAX(timestamp)
                            FROM $wpdb->dt_reports
                            WHERE type = 'prayer_app'
                            AND post_type = 'pg_relays'
                            AND lap_number = %d
                            AND post_id = %d",
                            $lap, $post_id
                        )
                    );
                }

                if ( empty( $end_ts ) ) {
                    // If we can't determine an end timestamp, skip inserting
                    continue;
                }

                // Insert lap_completed record
                $wpdb->query(
                    $wpdb->prepare(
                        "INSERT INTO $wpdb->dt_reports (post_id, post_type, type, subtype, value, timestamp)
                        VALUES ( %d, %s, %s, %s, %d, %d )",
                        $post_id, 'pg_relays', 'lap_completed', '', $lap, $end_ts
                    )
                );

            }


            //update the number of completed laps
            update_post_meta( $post_id, 'number_of_completed_laps', $completed_laps );
        }

        //insert one for ICOM 1646 november 16 2024
        $wpdb->query(
            $wpdb->prepare(
                "INSERT INTO $wpdb->dt_reports (post_id, post_type, type, subtype, value, timestamp)
                VALUES ( %d, %s, %s, %s, %d, %d )",
                1646, 'pg_relays', 'lap_completed', '', 1, 1731724800
            )
        );
        //update the number of completed laps
        update_post_meta( 1646, 'number_of_completed_laps', 1 );

        //insert log for STUMO id: 1980, date jan 5 2025
        $wpdb->query(
            $wpdb->prepare(
                "INSERT INTO $wpdb->dt_reports (post_id, post_type, type, subtype, value, timestamp)
                VALUES ( %d, %s, %s, %s, %d, %d )",
                1980, 'pg_relays', 'lap_completed', '', 1, 1736083200
            )
        );
        //update the number of completed laps
        update_post_meta( 1980, 'number_of_completed_laps', 1 );
    }

    public function down() {
        // Intentionally left blank to prevent destructive data removal.
    }

    public function test() {
        $this->test_expected_tables();
    }
}
