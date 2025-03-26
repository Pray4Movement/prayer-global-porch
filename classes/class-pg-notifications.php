<?php
declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Initialize notification system
 */
class PG_Notifications {
    private static ?PG_Notifications $instance = null;
    private PG_Streak_Handler $streak_handler;

    /**
     * Get singleton instance
     */
    public static function instance(): self {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct() {
        // Set up queue worker cron
        if (!wp_next_scheduled('pg_process_notification_queue')) {
            wp_schedule_event(time(), 'five_minutes', 'pg_process_notification_queue');
        }
        add_action('pg_process_notification_queue', [$this, 'process_queue']);

        // Initialize handlers
        $this->streak_handler = new PG_Streak_Handler();

        // Register deactivation hook
        register_deactivation_hook(__FILE__, [$this, 'deactivate']);
    }

    /**
     * Process the notification queue
     */
    public function process_queue(): void {
        wp_queue()->work();
    }

    /**
     * Clean up on deactivation
     */
    public function deactivate(): void {
        wp_clear_scheduled_hook('pg_process_notification_queue');
        wp_clear_scheduled_hook('pg_daily_streak_check');
    }
}

// Initialize notifications
add_action('plugins_loaded', function() {
    PG_Notifications::instance();
});
