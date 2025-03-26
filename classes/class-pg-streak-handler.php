<?php
declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Handles streak tracking and notification scheduling
 */
class PG_Streak_Handler {
    private array $milestone_days = [7, 14, 30, 60, 100];
    private array $push_enabled_milestones = [];

    public function __construct() {
        // Hook into prayer session completion
        add_action('pg_prayer_session_completed', [$this, 'handle_prayer_session'], 10, 1);

        // Schedule daily streak check
        if (!wp_next_scheduled('pg_daily_streak_check')) {
            wp_schedule_event(strtotime('tomorrow midnight'), 'daily', 'pg_daily_streak_check');
        }
        add_action('pg_daily_streak_check', [$this, 'check_all_streaks']);
    }

    /**
     * Handle prayer session completion
     */
    public function handle_prayer_session(int $user_id): void {
        $user_stats = new User_Stats($user_id);

        $this->check_milestones($user_stats);
    }

    /**
     * Check all user streaks daily
     */
    public function check_all_streaks(): void {
        $users = get_users(['fields' => ['ID']]);

        foreach ( $users as $user ) {
            $user_stats = new User_Stats($user->ID);
            if (!$user_stats->streak_secure()) {
                // Streak is broken, notification will be handled reingagement notifications
                continue;
            }
            // implement check for milestone days and send notification if met
            $this->check_milestones($user_stats);
        }
    }

    /**
     * Check for milestone days and send notification if met
     */
    private function check_milestones(User_Stats $user_stats): void {
        $streak = $user_stats->current_streak_in_days();
        if (in_array($streak, $this->milestone_days)) {
            $notification_type = $streak === 7 ? 'day7' : 'streak_milestone';
            $include_push = in_array($streak, $this->push_enabled_milestones);

            wp_queue()->push(new PG_Streak_Notification_Job(
                $user_stats->user_id,
                $streak,
                $notification_type,
                $include_push
            ));
        }
    }
}