<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Handles streak tracking and notification scheduling
 */
abstract class PG_Notification_Base {
    private string $notification_type;
    private string $action_hook;
    /**
     * Constructor
     */
    private function __construct( string $notification_type, string $recurrence = 'hourly' ) {
        $this->notification_type = $notification_type;
        $this->action_hook = 'pg_notification_' . $this->notification_type;

        if ( !wp_next_scheduled( $this->action_hook ) ) {
            wp_schedule_event( time(), $recurrence, $this->action_hook );
        }
        add_action( $this->action_hook, [ $this, 'handle_notification' ] );

        register_deactivation_hook( __FILE__, [ $this, 'deactivate' ] );
    }

    /**
     * Clean up on deactivation
     */
    public function deactivate(): void {
        wp_clear_scheduled_hook( $this->action_hook );
    }

    abstract public function handle_notification(): void;

    /**
     * Check if notification has already been sent
     */
    public function has_notification_been_sent_recently( int $user_id, int $milestone_value ): bool {
        global $wpdb;

        $result = $wpdb->get_var( $wpdb->prepare(
            "SELECT id FROM $wpdb->dt_notifications_sent
            WHERE user_id = %d
            AND type = %s
            AND value = %d
            AND sent_at > UNIX_TIMESTAMP() - 60 * 60 * 24 * 2",
            $user_id,
            $this->notification_type,
            $milestone_value
        ) );

        return !empty( $result );
    }

    /**
     * Record that a notification has been sent
     */
    public function record_notification_sent( int $user_id, int $milestone_value ): void {
        global $wpdb;

        $wpdb->insert(
            $wpdb->dt_notifications_sent,
            [
                'user_id' => $user_id,
                'type' => $this->notification_type,
                'value' => $milestone_value,
            ],
            [ '%d', '%s', '%d' ]
        );
    }
}
