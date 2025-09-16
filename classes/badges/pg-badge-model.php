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
            "SELECT category, badge_id as id, value, timestamp FROM $wpdb->dt_badges
            WHERE user_id = %d
            ORDER BY category, value DESC
            ", $user_id
        ), ARRAY_A );
    }

    public static function delete_all_badges( int $user_id ) {
        global $wpdb;
        return $wpdb->delete( $wpdb->dt_badges, [ 'user_id' => $user_id ] );
    }
}
