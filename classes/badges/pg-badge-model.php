<?php

class PG_Badge_Model {
    public static function create_badge( int $user_id, string $badge_id, string $category, int $value ) {
        global $wpdb;
        return $wpdb->insert( $wpdb->dt_badges, [
            'user_id' => $user_id,
            'badge_id' => $badge_id,
            'category' => $category,
            'value' => $value,
        ], [ '%d', '%s', '%s', '%d' ] );
    }

    public static function get_all_badges( int $user_id ) {
        global $wpdb;
        return $wpdb->get_results( $wpdb->prepare(
            "SELECT * FROM $wpdb->dt_badges
            WHERE user_id = %d
            ", $user_id
        ), ARRAY_A );
    }

    public static function get_current_badges_by_category( int $user_id ) {
        global $wpdb;
        return $wpdb->get_results( $wpdb->prepare(
            "SELECT category, badge_id, MAX(value) as value, timestamp FROM $wpdb->dt_badges
            WHERE user_id = %d
            GROUP BY category
            ", $user_id
        ), ARRAY_A );
    }
}
