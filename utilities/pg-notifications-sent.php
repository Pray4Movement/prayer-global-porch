<?php

class PG_Notifications_Sent {

    public static function record( int $user_id, PG_Notification $notification, string $channel ) {
        global $wpdb;

        return $wpdb->insert(
            $wpdb->dt_notifications_sent,
            [
                'user_id' => $user_id,
                'category' => $notification->category,
                'value' => $notification->value,
                'channel' => $channel,
                'sent_at' => time()
            ],
            [ '%d', '%s', '%d', '%s', '%d' ]
        );
    }

    public static function is_recent( int $user_id, PG_Notification $notification, int $hours = 48 ) {
        $cutoff_time = time() - ( $hours * HOUR_IN_SECONDS );

        if ( $notification->category === 'badges' ) {
            foreach ( $notification->data as $badge ) {
                if ( self::is_notification_recent( $user_id, PG_Notification::from_badge( PG_Badge::from_array( $badge ) ), $cutoff_time ) ) {
                    return true;
                }
            }
        } else {
            return self::is_notification_recent( $user_id, $notification, $cutoff_time );
        }
    }

    private static function is_notification_recent( int $user_id, PG_Notification $notification, int $cutoff_time ) {
        global $wpdb;

        $result = $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT(*) FROM $wpdb->dt_notifications_sent
            WHERE user_id = %d
            AND category = %s
            AND milestone_value = %d
            AND sent_at > %d",
            $user_id,
            $notification->category,
            $notification->value,
            $cutoff_time
        ) );

        return (int) $result > 0;
    }
}
