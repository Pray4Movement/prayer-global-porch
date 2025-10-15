<?php

class PG_Badge_Model {
    public static function create_badge( int $user_id, string $badge_id, string $category, int $value, ?int $timestamp = null, bool $retroactive = false ) {
        global $wpdb;
        $data = [
            'user_id' => $user_id,
            'badge_id' => $badge_id,
            'category' => $category,
            'value' => $value,
        ];
        $format = [ '%d', '%s', '%s', '%d' ];
        if ( $timestamp ) {
            $data['timestamp'] = $timestamp;
            $format[] = '%d';
        }
        if ( $retroactive ) {
            $data['retroactive'] = 1;
            $format[] = '%d';
        }
        return $wpdb->insert( $wpdb->dt_badges, $data, $format );
    }

    public static function get_all_badges( int $user_id ) {
        global $wpdb;
        return $wpdb->get_results( $wpdb->prepare(
            "SELECT category, badge_id as id, value, timestamp FROM $wpdb->dt_badges
            WHERE user_id = %d
            ORDER BY timestamp DESC
            ", $user_id
        ), ARRAY_A );
    }

    public static function delete_all_badges( int $user_id ) {
        global $wpdb;
        return $wpdb->delete( $wpdb->dt_badges, [ 'user_id' => $user_id ] );
    }
}
