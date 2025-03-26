<?php
declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use WP_Queue\Job;

/**
 * Handles streak-based notifications for Prayer Global
 */
class PG_Streak_Notification_Job extends Job {
    private int $user_id;
    private int $streak_count;
    private string $notification_type;
    private bool $include_push;

    /**
     * Constructor
     *
     * @param int $user_id User ID
     * @param int $streak_count Current streak count
     * @param string $notification_type Type of streak notification (day7, streak_milestone)
     * @param bool $include_push Whether to send push notification
     */
    public function __construct(int $user_id, int $streak_count, string $notification_type, bool $include_push = false) {
        $this->user_id = $user_id;
        $this->streak_count = $streak_count;
        $this->notification_type = $notification_type;
        $this->include_push = $include_push;
    }

    /**
     * Handle the job
     */
    public function handle(): void {
        $user = get_user_by('ID', $this->user_id);
        if (!$user) {
            return;
        }

        $template_vars = [
            'UserFirstName' => $user->first_name,
            'StreakCount' => $this->streak_count
        ];

        switch ($this->notification_type) {
            case 'day7':
                $this->send_day7_notification($template_vars);
                break;
            case 'streak_milestone':
                $this->send_streak_milestone_notification($template_vars);
                break;
        }
    }

    /**
     * Send Day 7 notification
     */
    private function send_day7_notification(array $template_vars): void {
        $subject = '7 Days Strong! Keep Praying';
        $message = 'You\'ve prayed for 7 days straight—well done! Your dedication is making an impact. Let\'s keep this habit going!';

        $this->send_notification($subject, $message, 'email');
        if ($this->include_push) {
            $this->send_notification($message, $message, 'push');
        }
        $this->send_modal_notification($message);
    }

    /**
     * Send streak milestone notification (14, 30, 60, 100 days)
     */
    private function send_streak_milestone_notification(array $template_vars): void {
        $subject = 'Your Streak is Alive!';
        $message = sprintf(
            '%s, you\'ve prayed for %d days in a row! Let\'s not break it—keep your streak going today!',
            $template_vars['UserFirstName'],
            $template_vars['StreakCount']
        );

        $this->send_notification($subject, $message, 'email');
        if ($this->include_push) {
            $this->send_notification($message, $message, 'push');
        }
    }

    /**
     * Send notification through specified channel
     */
    private function send_notification(string $subject, string $message, string $channel): void {
        switch ($channel) {
            case 'email':
                $user = get_user_by('ID', $this->user_id);
                if ($user && $user->user_email) {
                    wp_mail($user->user_email, $subject, $message);
                }
                break;
            case 'push':
                do_action('pg_send_push_notification', $this->user_id, $message);
                break;
        }
    }

    /**
     * Send in-app modal notification
     */
    private function send_modal_notification(string $message): void {
        do_action('pg_show_modal_notification', $this->user_id, $message);
    }
}
