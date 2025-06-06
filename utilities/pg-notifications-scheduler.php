<?php

class PG_Notifications_Scheduler {
    public function __construct() {
        // Schedule notifications to be sent at 10:00 AM every day

        if ( ! wp_next_scheduled( 'pg_notifications_scheduler' ) ) {
            wp_schedule_event( time(), '15min', 'pg_notifications_scheduler' );
        }
        add_action( 'pg_notifications_scheduler', [ $this, 'create_push_handler_job' ] );
    }

    public function create_push_handler_job() {
        // Create job for sending push notifications
        dt_write_log( 'PG_Notifications_Scheduler: create_push_handler_job' );
        wp_queue()->push( new PG_Notification_Handler_Job() );
    }
}

new PG_Notifications_Scheduler();
