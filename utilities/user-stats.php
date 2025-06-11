<?php

class User_Stats {
    public int $user_id;
    public int $user_timezone_offset;
    public DateTimeZone $user_timezone;
    private static int $day_in_seconds = 24 * 60 * 60;

    public function __construct( int $user_id ) {
        $this->user_id = $user_id;
        $user_location = get_user_meta( $user_id, 'location', true );

        if ( $user_location && isset( $user_location['timezone'] ) ) {
            $user_timezone_string = $user_location['timezone'];
        } else {
            $user_timezone_string = 'America/New_York';
        }

        $this->user_timezone = new DateTimeZone( $user_timezone_string );
        $date_time = new DateTime( 'now', $this->user_timezone );

        $this->user_timezone_offset = timezone_offset_get( $this->user_timezone, $date_time );
        if ( ! $this->user_timezone_offset ) {
            $this->user_timezone_offset = 0;
        }
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

    public function streak_secure( int $in_days = 1 ): bool {
        global $wpdb;

        $last_prayed_timestamp = (int) $wpdb->get_var( $wpdb->prepare(
            "SELECT MAX( r.timestamp ) as last_prayed
                FROM $wpdb->dt_reports r
                WHERE r.user_id = %s
                AND r.post_type = 'pg_relays'
            ", $this->user_id ) );

        return $this->difference_in_days( $last_prayed_timestamp, time() ) < $in_days;
    }

    public function difference_in_days( int $timestamp1, int $timestamp2 ): int {
        // Calculate difference in hours
        $difference_in_hours = ( $timestamp1 - $timestamp2 ) / 3600;

        // If less than 24 hours, check if we crossed midnight
        if ( $difference_in_hours < 24 ) {
            $last_prayed_date = new DateTime( gmdate( 'Y-m-d H:i:s', $timestamp1 ), $this->user_timezone );
            $current_date = new DateTime( gmdate( 'Y-m-d H:i:s', $timestamp2 ), $this->user_timezone );

            // If dates are different, count as 1 day
            $difference_in_days = $last_prayed_date->format( 'Y-m-d' ) !== $current_date->format( 'Y-m-d' ) ? 1 : 0;
        } else {
            // For longer periods, use calendar days
            $difference_in_days = ceil( $difference_in_hours / 24 );
        }

        return $difference_in_days;
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
        if ( ! $this->streak_secure( $in_days ) ) {
            return 0;
        }

        $all_islands = $this->all_islands( $in_days );

        if ( empty( $all_islands ) ) {
            return 0;
        }

        $latest_streak = $all_islands[0];

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

        $in_seconds = $in_days * self::$day_in_seconds;

        /* Add a days grace as we will make this timezone agnostic */
        ++$in_days;

        $timespan_seconds = $in_days * self::$day_in_seconds;

        return $wpdb->get_results( $wpdb->prepare(
            "WITH CTE_TIMESTAMP AS (
                SELECT
                    timestamp,
                    LAG(timestamp) OVER (ORDER BY timestamp) AS previous_timestamp,
                    LEAD(timestamp) OVER (ORDER BY timestamp) AS next_timestamp,
                    ROW_NUMBER() OVER (ORDER BY timestamp) AS island_location
                FROM $wpdb->dt_reports
                WHERE user_id = %s
            ),
            CTE_ISLAND_START AS (
                SELECT
                    ROW_NUMBER() OVER (ORDER BY timestamp) AS island_number,
                    timestamp AS island_start_timestamp,
                    island_location AS island_start_location
                FROM CTE_TIMESTAMP
                WHERE timestamp - previous_timestamp > %d # Where there is a gap of 1 day from midnight to midnight according to the user's timezone
                    OR previous_timestamp IS NULL),
            CTE_ISLAND_END AS (
                SELECT
                    ROW_NUMBER() OVER (ORDER BY timestamp) AS island_number,
                    timestamp AS island_end_timestamp,
                    island_location AS island_end_location
                FROM CTE_TIMESTAMP
                WHERE next_timestamp - timestamp > %d # Where there is a gap of 1 day from midnight to midnight according to the user's timezone
                    OR next_timestamp IS NULL)
            SELECT
                CTE_ISLAND_START.island_start_timestamp,
                CTE_ISLAND_END.island_end_timestamp,
                (SELECT COUNT(*)
                FROM CTE_TIMESTAMP
                WHERE CTE_TIMESTAMP.timestamp BETWEEN
                    CTE_ISLAND_START.island_start_timestamp AND
                    CTE_ISLAND_END.island_end_timestamp)
                AS island_row_count,
                FLOOR( ( CTE_ISLAND_END.island_end_timestamp - CTE_ISLAND_START.island_start_timestamp ) / %d ) + 1 # calculate the total number of days from midnight to midnight according to the user's timezone
                AS island_days
            FROM CTE_ISLAND_START
            INNER JOIN CTE_ISLAND_END
            ON CTE_ISLAND_END.island_number = CTE_ISLAND_START.island_number
            ORDER BY CTE_ISLAND_END.island_end_timestamp DESC
        ", $this->user_id, $timespan_seconds, $timespan_seconds, $in_seconds ), ARRAY_A );
    }
}
