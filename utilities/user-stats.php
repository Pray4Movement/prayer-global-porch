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
        $days_of_inactivity = $this->days_of_inactivity();
        if ( $days_of_inactivity > 1 ) {
            return false;
        }
        return true;
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

    /* Count Number of places prayed for in relays */
    public function total_places_prayed_in_relays(): int {
        global $wpdb;

        return (int) $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT( r.grid_id ) as places_prayed_for
                FROM $wpdb->dt_reports r
                WHERE r.post_type = 'pg_relays'
                AND r.user_id = %s
                AND r.subtype = 'custom'
            ", $this->user_id ) );
    }

    private function user_relay_ids(): array {
        global $wpdb;
        $user_relay_ids = $wpdb->get_results( $wpdb->prepare(
            "SELECT post_id
                FROM $wpdb->postmeta pm
                JOIN $wpdb->posts p ON p.ID = pm.post_id AND p.post_type = 'pg_relays'
                WHERE meta_key = 'assigned_to'
                AND meta_value = %s
            ", 'user-' . $this->user_id ), ARRAY_A );

        return array_column( $user_relay_ids, 'post_id' );
    }

    public function total_relays_started(): int {
        $user_relay_ids = $this->user_relay_ids();
        return count( $user_relay_ids );
    }

    /* Count Number of people joined own relay */
    public function num_people_joined_own_relay(): int {
        global $wpdb;

        $user_relay_ids = $this->user_relay_ids();

        // phpcs:disable
        return (int) $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT( DISTINCT( r.user_id ) ) as people_joined_own_relay
                FROM $wpdb->dt_reports r
                WHERE r.post_type = 'pg_relays'
                AND r.subtype = 'custom'
                AND r.post_id IN ( " . implode( ',', $user_relay_ids ) . " )
            " ) );
        // phpcs:enable
    }

    /* Count Number of people joined own relay */
    public function total_locations_prayed_in_own_relay(): int {
        global $wpdb;

        $user_relay_ids = $this->user_relay_ids();

        // phpcs:disable
        return (int) $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT( r.grid_id ) as total_locations_prayed_in_own_relay
                FROM $wpdb->dt_reports r
                WHERE r.post_type = 'pg_relays'
                AND r.subtype = 'custom'
                AND r.post_id IN ( " . implode( ',', $user_relay_ids ) . " )
            " ) );
        // phpcs:enable
    }

    public function days_of_inactivity(): int {
        global $wpdb;
        $today = new DateTime();
        $today->setTimezone( new DateTimeZone( $this->location['time_zone'] ?? 'UTC' ) );
        return (int) $wpdb->get_var( $wpdb->prepare(
            "SELECT DATEDIFF( %s, MAX( r.timezone_timestamp ) ) as days_inactive
                FROM $wpdb->dt_reports r
                WHERE r.post_type = 'pg_relays'
                AND r.user_id = %s
            ", $today->format( 'Y-m-d H:i:s' ), $this->user_id ) );
    }

    public function days_prayed_this_month(): int {
        global $wpdb;
        $today = new DateTime();
        $today->setTimezone( new DateTimeZone( $this->location['time_zone'] ?? 'UTC' ) );
        return (int) $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT( DISTINCT( DATE( r.timezone_timestamp ) ) ) as days_prayed_this_month
                FROM $wpdb->dt_reports r
                WHERE r.post_type = 'pg_relays'
                AND r.user_id = %s
                AND MONTH( r.timezone_timestamp ) = %s
                AND YEAR( r.timezone_timestamp ) = %s
            ", $this->user_id, $today->format( 'm' ), $today->format( 'Y' ) ) );
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
                JOIN $wpdb->postmeta pm ON pm.post_id = r.post_id AND pm.meta_key = 'assigned_to' AND pm.meta_value != %s
                WHERE r.post_type = 'pg_relays'
                AND r.user_id = %s
            ", 'user-' . $this->user_id, $this->user_id ) );
    }

    /* Count number of finished relays part of */
    public function total_finished_relays_part_of(): int {
        global $wpdb;

        // We need to count the number of distinct grid_ids in the latest lap.
        // We can safely assume that if we are on lap 2, that lap 1 has finished.

        return (int) $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT( DISTINCT( CONCAT( r.post_id, '-', r.value ) ) )
                FROM $wpdb->dt_reports r
                JOIN $wpdb->postmeta pm ON pm.post_id = r.post_id
                    AND pm.meta_key = 'assigned_to'
                    AND pm.meta_value != %s
                WHERE r.type = 'lap_completed'
                AND r.post_type = 'pg_relays'
                AND EXISTS (
                    SELECT 1
                    FROM $wpdb->dt_reports r2
                    WHERE r2.user_id = %s
                    AND r2.post_id = r.post_id
                    AND r2.lap_number = r.value
                    AND r2.post_type = 'pg_relays'
                )
        ", 'user-' . $this->user_id ) );
    }

    /* Count number of finished relays started */
    public function total_finished_relays_started(): int {
        global $wpdb;

        return (int) $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT( DISTINCT( CONCAT( r.post_id, '-', r.value ) ) )
                FROM $wpdb->dt_reports r
                JOIN $wpdb->postmeta pm ON pm.post_id = r.post_id
                    AND pm.meta_key = 'assigned_to'
                    AND pm.meta_value = %s
                WHERE r.type = 'lap_completed'
                AND r.post_type = 'pg_relays'
        ", 'user-' . $this->user_id ) );
    }

    public function prayed_for_whole_world(): bool {
        $num_locations = count( pg_query_4770_locations() );
        return $this->total_unique_places_prayed() >= $num_locations;
    }

    public function total_unique_places_prayed(): int {
        global $wpdb;
        return (int) $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT( DISTINCT( r.grid_id ) ) as total_unique_places_prayed
                FROM $wpdb->dt_reports r
                WHERE r.post_type = 'pg_relays'
                AND r.user_id = %s
            ", $this->user_id ) );
    }

    /**
     * Check if the user has just returned
     * @return bool
     */
    public function has_just_returned(): bool {
        // use longest streak > 0 and streak secure === false and last prayer date is in the last 1 hour
        // @TODO surface key constants to top level of class
        return $this->best_streak_in_days() >= 3 && $this->current_streak_in_days() === 1 && $this->last_prayer_date() > time() - 3600;
    }

    /* Calculate current streak in days */
    private function current_streak( int $in_days = 1 ): int {
        $all_islands = $this->all_islands( $in_days );

        if ( empty( $all_islands ) ) {
            return 0;
        }

        if ( !$this->streak_secure() ) {
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
