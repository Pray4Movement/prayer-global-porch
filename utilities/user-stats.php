<?php

class User_Stats {
    private int $user_id;

    public function __construct( int $user_id ) {
        $this->user_id = $user_id;
    }

    public function current_streak_in_days(): int {
        return $this->current_streak( 'days' );
    }
    public function current_streak_in_weeks(): int {
        return $this->current_streak( 'weeks' );
    }
    public function best_streak_in_days(): int {
        return $this->best_streak( 'days' );
    }

    /* Count total days since 1st Jan */
    public function days_this_year(): int {
        return -1;
    }

    /* Calculate total minutes prayed */
    public function total_minutes_prayed(): int {
        global $wpdb;

        return (int) $wpdb->get_var( $wpdb->prepare(
            "SELECT SUM( r.value ) as minutes_prayed
                FROM $wpdb->dt_reports r
                WHERE r.post_type = 'pg_relays'
                AND r.user_id = %s
            ", $this->user_id ) );
    }

    /* Count Number of places prayed for */
    public function total_places_prayed(): int {
        global $wpdb;

        return (int) $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT( r.grid_id ) as places_prayed_for
                FROM $wpdb->dt_reports r
                WHERE r.post_type = 'pg_relays'
                AND r.user_id = %s
            ", $this->user_id ) );
    }

    /* Count number of relays part of */
    public function total_relays_part_of(): int {
        global $wpdb;

        return (int) $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT( DISTINCT( r.post_id ) ) as total_relays_part_of
                FROM $wpdb->dt_reports r
                WHERE r.post_type = 'pg_relays'
                AND r.user_id = %s
            ", $this->user_id ) );
    }

    /* Count number of finished relays part of */
    public function total_finished_relays_part_of(): int {
        global $wpdb;

        return (int) $wpdb->get_var( $wpdb->prepare(
            "WITH cte AS ( SELECT MAX( r.lap_number ) as current_lap_number, r.post_id as post_id
                FROM $wpdb->dt_reports r
                GROUP BY r.post_id )

            SELECT COUNT( DISTINCT( CONCAT( r.post_id, '-', r.lap_number ) ) )
                FROM $wpdb->dt_reports r, cte
                WHERE r.user_id = %s
                AND r.lap_number < cte.current_lap_number
                AND r.post_id = cte.post_id
        ", $this->user_id ) );
    }

    /* Calculate current streak in days */
    private function current_streak( string $in_timespan = 'days' ): int {
        return -1;
    }

    /* Calculate best streak in days */
    private function best_streak( string $in_timespan = 'days' ): int {
        return -1;
    }
}
