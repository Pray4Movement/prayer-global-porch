<?php

class User_Stats {
    public int $user_id;
    private static int $day_in_seconds = 24 * 60 * 60;
    public array $location = [];

    public function __construct( int $user_id ) {
        $this->user_id = $user_id;
        $this->location = maybe_unserialize( get_user_meta( $user_id, 'pg_location', true ) ) ?: [];
    }

    public function current_streak_in_days(): int {
        return $this->current_streak( 1 );
    }
    public function current_streak_in_weeks(): int {
        return $this->current_streak( 7 );
    }
    public function best_streak_in_days(): int {
        return $this->best_streak( 1 );
    }

    /* Count total days since 1st Jan */
    public function days_this_year(): int {
        $all_islands = $this->all_islands();

        if ( empty( $all_islands ) ) {
            return 0;
        }

        /* sum all numbers in a column */
        return array_sum( array_column( $all_islands, 'island_days' ) );
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

    public function streak_secure(): bool {
        global $wpdb;

        $last_prayed_timestamp = (int) $wpdb->get_var( $wpdb->prepare(
            "SELECT MAX( r.timestamp ) as last_prayed
                FROM $wpdb->dt_reports r
                WHERE r.user_id = %s
                AND r.post_type = 'pg_relays'
            ", $this->user_id ) );

        return time() - $last_prayed_timestamp < self::$day_in_seconds;
    }

    public function last_prayer_date(): ?int {
        global $wpdb;

        $last_prayed_timestamp = $wpdb->get_var( $wpdb->prepare(
            "SELECT MAX( r.timestamp ) as last_prayed
                FROM $wpdb->dt_reports r
                WHERE r.user_id = %s
                AND r.post_type = 'pg_relays'
            ", $this->user_id ) );

        return $last_prayed_timestamp ? (int) $last_prayed_timestamp : null;
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

    public function days_of_inactivity(): int {
        $hours_inactive = $this->hours_of_inactivity();
        if ( !$hours_inactive ) {
            return 0;
        }
        $days_inactive = floor( $hours_inactive / 24 );
        return $days_inactive;
    }

    public function hours_of_inactivity(): int {
        $last_prayer_date = $this->last_prayer_date();
        if ( !$last_prayer_date ) {
            return 0;
        }
        $now = time();
        $hours_inactive = ( $now - $last_prayer_date ) / 3600;
        return $hours_inactive;
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
            "WITH cte AS (
                SELECT MAX( r.lap_number ) as current_lap_number, r.post_id as post_id
                FROM $wpdb->dt_reports r
                GROUP BY r.post_id
            )

            SELECT COUNT( DISTINCT( CONCAT( r.post_id, '-', r.lap_number ) ) )
                FROM $wpdb->dt_reports r, cte
                WHERE r.user_id = %s
                AND r.lap_number < cte.current_lap_number
                AND r.post_id = cte.post_id
        ", $this->user_id ) );
    }

    /* Calculate current streak in days */
    private function current_streak( int $in_days = 1 ): int {
        $all_islands = $this->all_islands( $in_days );

        if ( empty( $all_islands ) ) {
            return 0;
        }

        $latest_streak = $all_islands[0];

        $streak_gap_size_days = $in_days;
        $today = new DateTime();
        $today->setTimezone( new DateTimeZone( $this->location['time_zone'] ?? 'UTC' ) );

        $latest_streak_end_date = new DateTime( $latest_streak['island_end_timezone_timestamp'] );

        $diff = $today->diff( $latest_streak_end_date );

        if ( $diff->days > $streak_gap_size_days ) {
            return 0;
        }

        return (int) $latest_streak['island_days'];
    }

    /* Calculate best streak in days */
    private function best_streak( int $in_days = 1 ): int {
        $all_islands = $this->all_islands( $in_days );

        if ( empty( $all_islands ) ) {
            return 0;
        }

        $max_streak = (int) max( array_column( $all_islands, 'island_days' ) );

        return $max_streak;
    }
    private function all_islands( int $in_days = 1 ): array {
        global $wpdb;

        return $wpdb->get_results( $wpdb->prepare(
            "WITH CTE_TIMESTAMP AS (
                SELECT
                    timestamp,
                    timezone_timestamp,
                    LAG(timezone_timestamp) OVER (ORDER BY timezone_timestamp) AS previous_timestamp,
                    LEAD(timezone_timestamp) OVER (ORDER BY timezone_timestamp) AS next_timestamp,
                    ROW_NUMBER() OVER (ORDER BY timezone_timestamp) AS island_location
                FROM $wpdb->dt_reports
                WHERE user_id = %s
            ),
            CTE_ISLAND_START AS (
                SELECT
                    ROW_NUMBER() OVER (ORDER BY timezone_timestamp) AS island_number,
                    timestamp AS island_start_timestamp,
                    timezone_timestamp AS island_start_timezone_timestamp,
                    island_location AS island_start_location
                FROM CTE_TIMESTAMP
                WHERE DATEDIFF(timezone_timestamp, previous_timestamp) > %d
                    OR previous_timestamp IS NULL),
            CTE_ISLAND_END AS (
                SELECT
                    ROW_NUMBER() OVER (ORDER BY timezone_timestamp) AS island_number,
                    timestamp AS island_end_timestamp,
                    timezone_timestamp AS island_end_timezone_timestamp,
                    island_location AS island_end_location
                FROM CTE_TIMESTAMP
                WHERE DATEDIFF(next_timestamp, timezone_timestamp) > %d
                    OR next_timestamp IS NULL)
            SELECT
                CTE_ISLAND_START.island_start_timestamp,
                CTE_ISLAND_END.island_end_timestamp,
                CTE_ISLAND_START.island_start_timezone_timestamp,
                CTE_ISLAND_END.island_end_timezone_timestamp,
                (SELECT COUNT(*)
                FROM CTE_TIMESTAMP
                WHERE CTE_TIMESTAMP.timestamp BETWEEN
                    CTE_ISLAND_START.island_start_timestamp AND
                    CTE_ISLAND_END.island_end_timestamp)
                AS island_row_count,
                FLOOR( DATEDIFF( CTE_ISLAND_END.island_end_timezone_timestamp, CTE_ISLAND_START.island_start_timezone_timestamp ) / %d ) + 1
                AS island_days
            FROM CTE_ISLAND_START
            INNER JOIN CTE_ISLAND_END
            ON CTE_ISLAND_END.island_number = CTE_ISLAND_START.island_number
            ORDER BY CTE_ISLAND_END.island_end_timestamp DESC
        ", $this->user_id, $in_days, $in_days, $in_days ), ARRAY_A );
    }
}
