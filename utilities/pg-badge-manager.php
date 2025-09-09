<?php

class PG_Badge_Manager {
    private int $user_id;
    private User_Stats $user_stats;
    private array $streak_badges;
    private array $progress_badges;

    public function __construct( int $user_id ) {
        $this->user_id = $user_id;
        $this->user_stats = new User_Stats( $user_id );
        $this->streak_badges = [
            7 => [
                'title' => __( 'One Week Warrior ', 'prayer-global-porch' ),
                'description' => sprintf( __( 'You have prayed for %d days straight', 'prayer-global-porch' ), 7 ),
                'badge' => PG_Badges::ONE_WEEK_WARRIOR,
            ],
            14 => [
                'title' => __( 'Two Week Faithful', 'prayer-global-porch' ),
                'description' => sprintf( __( 'You have prayed for %d days straight', 'prayer-global-porch' ), 14 ),
                'badge' => PG_Badges::TWO_WEEK_FAITHFUL,
            ],
            30 => [
                'title' => __( 'One Month Devoted', 'prayer-global-porch' ),
                'description' => sprintf( __( 'You have prayed for %d days straight', 'prayer-global-porch' ), 30 ),
                'badge' => PG_Badges::ONE_MONTH_DEVOTED,
            ],
            100 => [
                'title' => __( 'One Hundred Days', 'prayer-global-porch' ),
                'description' => sprintf( __( 'You have prayed for %d days straight', 'prayer-global-porch' ), 100 ),
                'badge' => PG_Badges::HUNDRED_DAYS,
            ],
            365 => [
                'title' => __( 'One Year of Prayer', 'prayer-global-porch' ),
                'description' => sprintf( __( 'You have prayed for %d days straight', 'prayer-global-porch' ), 365 ),
                'badge' => PG_Badges::YEAR_OF_PRAYER,
            ],
            500 => [
                'title' => __( 'Unbreakable', 'prayer-global-porch' ),
                'description' => sprintf( __( 'You have prayed for %d days straight', 'prayer-global-porch' ), 500 ),
                'badge' => PG_Badges::UNBREAKABLE,
            ],
        ];
        $this->progress_badges = [
            5 => [
                'title' => __( 'Prayer Starter', 'prayer-global-porch' ),
                'description' => sprintf( __( 'You have prayed for %d locations', 'prayer-global-porch' ), 5 ),
                'badge' => PG_Badges::PRAYER_STARTER,
            ],
            10 => [
                'title' => __( 'Neighbourhood Intercessor', 'prayer-global-porch' ),
                'description' => sprintf( __( 'You have prayed for %d locations', 'prayer-global-porch' ), 10 ),
                'badge' => PG_Badges::NEIGHBOURHOOD_INTERCESSOR,
            ],
            50 => [
                'title' => __( 'Kingdom Builder', 'prayer-global-porch' ),
                'description' => sprintf( __( 'You have prayed for %d locations', 'prayer-global-porch' ), 50 ),
                'badge' => PG_Badges::KINGDOM_BUILDER,
            ],
            500 => [
                'title' => __( 'Regional Watchman', 'prayer-global-porch' ),
                'description' => sprintf( __( 'You have prayed for %d locations', 'prayer-global-porch' ), 500 ),
                'badge' => PG_Badges::REGIONAL_WATCHMAN,
            ],
            1193 => [
                'title' => __( 'Global Intercessor', 'prayer-global-porch' ),
                'description' => sprintf( __( 'You have prayed for %d%% of the world', 'prayer-global-porch' ), 25 ),
                'badge' => PG_Badges::GLOBAL_INTERCESSOR,
            ],
            3578 => [
                'title' => __( 'Prayer Warrior', 'prayer-global-porch' ),
                'description' => sprintf( __( 'You have prayed for %d%% of the world', 'prayer-global-porch' ), 50 ),
                'badge' => PG_Badges::PRAYER_WARRIOR,
            ],
            4770 => [
                'title' => __( 'World Changer', 'prayer-global-porch' ),
                'description' => __( 'You have prayed for the whole world', 'prayer-global-porch' ),
                'badge' => PG_Badges::WORLD_CHANGER,
            ],
            9540 => [
                'title' => __( 'Legacy Intercessor', 'prayer-global-porch' ),
                'description' => sprintf( __( 'You have prayed %d laps of the world', 'prayer-global-porch' ), 2 ),
                'badge' => PG_Badges::LEGACY_INTERCESSOR,
            ],
            23850 => [
                'title' => __( 'Marathon Prayer', 'prayer-global-porch' ),
                'description' => sprintf( __( 'You have prayed %d laps of the world', 'prayer-global-porch' ), 5 ),
                'badge' => PG_Badges::MARATHON_PRAYER,
            ],
            47700 => [
                'title' => __( 'Eternal Watchman', 'prayer-global-porch' ),
                'description' => sprintf( __( 'You have prayed %d laps of the world', 'prayer-global-porch' ), 10 ),
                'badge' => PG_Badges::ETERNAL_WATCHMAN,
            ],
        ];
    }

    /**
     * Returns all the badges that the user has earned historically based on their user stats
     * @return array
     */
    public function get_badges(): array {
        return [];
    }

    /**
     * Returns any badges that the user has earned that they didn't already have
     * @return array
     */
    public function get_new_badges(): array {
        return [];
    }
}
