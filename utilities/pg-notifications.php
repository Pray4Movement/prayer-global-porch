<?php

class PG_Notifications {

    public static function record_notification( int $user_id, string $category, int $milestone_value ) {
        global $wpdb;

        return $wpdb->insert(
            $wpdb->dt_notifications_sent,
            [
                'user_id' => $user_id,
                'type' => $category,
                'value' => $milestone_value,
                'sent_at' => time()
            ],
            [ '%d', '%s', '%d', '%d' ]
        );
    }

    public static function has_sent_notification_recently( int $user_id, string $category, int $milestone_value, int $hours = 48 ) {
        global $wpdb;

        $cutoff_time = time() - ( $hours * HOUR_IN_SECONDS );

        $result = $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT(*) FROM $wpdb->dt_notifications_sent
            WHERE user_id = %d
            AND type = %s
            AND value = %d
            AND sent_at > %d",
            $user_id,
            $category,
            $milestone_value,
            $cutoff_time
        ) );

        return (int) $result > 0;
    }
}
