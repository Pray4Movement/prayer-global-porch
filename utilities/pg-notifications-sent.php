<?php

class PG_Notifications_Sent {

    public static function record( int $user_id, PG_Milestone $milestone ) {
        global $wpdb;

        return $wpdb->insert(
            $wpdb->dt_notifications_sent,
            [
                'user_id' => $user_id,
                'category' => $milestone->get_category(),
                'milestone_value' => $milestone->get_value(),
                'channel' => $milestone->get_channel(),
                'sent_at' => time()
            ],
            [ '%d', '%s', '%d', '%s', '%d' ]
        );
    }

    public static function is_recent( int $user_id, PG_Milestone $milestone, int $hours = 48 ) {
        global $wpdb;

        $cutoff_time = time() - ( $hours * HOUR_IN_SECONDS );

        $result = $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT(*) FROM $wpdb->dt_notifications_sent
            WHERE user_id = %d
            AND category = %s
            AND milestone_value = %d
            AND channel = %s
            AND sent_at > %d",
            $user_id,
            $milestone->get_category(),
            $milestone->get_value(),
            $milestone->get_channel(),
            $cutoff_time
        ) );

        return (int) $result > 0;
    }
}
