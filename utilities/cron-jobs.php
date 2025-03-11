<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class PG_Cron_Jobs {

    private static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct() {
        if ( ! wp_next_scheduled( 'pg_daily_cron_job' ) ) {
            wp_schedule_event( time(), 'daily', 'pg_daily_cron_job' );
        }

        add_action( 'pg_daily_cron_job', [ $this, 'pg_daily_cron_job' ] );
    }

    public function pg_daily_cron_job() {
        // get the relays with post_type = 'pg_relays' that have a recent record in the dt_reports table in the last month
        global $wpdb;
        $to_archive = $wpdb->get_results("
            SELECT ID FROM $wpdb->posts p
            INNER JOIN $wpdb->postmeta pm ON ( pm.post_id = p.ID AND pm.meta_key = 'status' AND pm.meta_value = 'active' )
            WHERE post_type = 'pg_relays'
            AND NOT ID IN (
                SELECT post_id FROM $wpdb->dt_reports
                WHERE timestamp > UNIX_TIMESTAMP() - 30*24*60*60
                AND post_type = 'pg_relays' and type = 'prayer_app'
            )
        ", ARRAY_A );

        // archive the relays
        foreach ( $to_archive as $relay ) {
            $post_id = $relay['ID'];
            $relay_key = pg_get_relay_key( $post_id );
            if ( empty( $relay_key ) ) {
                continue;
            }
            //delete all the relay table rows that are 0
            $wpdb->query( $wpdb->prepare( "
                DELETE FROM $wpdb->dt_relays
                WHERE relay_key = %s
                AND total = 0
            ", $relay_key ) );

            update_post_meta( $post_id, 'status', 'complete' );
        }
    }
}
PG_Cron_Jobs::instance();
