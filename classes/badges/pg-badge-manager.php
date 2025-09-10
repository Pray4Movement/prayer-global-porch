<?php

class PG_Badge_Manager {
    private int $user_id;
    private User_Stats $user_stats;
    private array $badges;

    public function __construct( int $user_id ) {
        $this->user_id = $user_id;
        $this->user_stats = new User_Stats( $user_id );
        $this->badges = [
            'streak' => [
                7 => [
                    'id' => PG_Badges::ONE_WEEK_WARRIOR,
                    'title' => __( 'One Week Warrior ', 'prayer-global-porch' ),
                    'description' => sprintf( __( 'You have prayed for %d days straight', 'prayer-global-porch' ), 7 ),
                ],
                14 => [
                    'id' => PG_Badges::TWO_WEEK_FAITHFUL,
                    'title' => __( 'Two Week Faithful', 'prayer-global-porch' ),
                    'description' => sprintf( __( 'You have prayed for %d days straight', 'prayer-global-porch' ), 14 ),
                ],
                30 => [
                    'id' => PG_Badges::ONE_MONTH_DEVOTED,
                    'title' => __( 'One Month Devoted', 'prayer-global-porch' ),
                    'description' => sprintf( __( 'You have prayed for %d days straight', 'prayer-global-porch' ), 30 ),
                ],
                100 => [
                    'id' => PG_Badges::HUNDRED_DAYS,
                    'title' => __( 'One Hundred Days', 'prayer-global-porch' ),
                    'description' => sprintf( __( 'You have prayed for %d days straight', 'prayer-global-porch' ), 100 ),
                ],
                365 => [
                    'id' => PG_Badges::YEAR_OF_PRAYER,
                    'title' => __( 'One Year of Prayer', 'prayer-global-porch' ),
                    'description' => sprintf( __( 'You have prayed for %d days straight', 'prayer-global-porch' ), 365 ),
                ],
                500 => [
                    'id' => PG_Badges::UNBREAKABLE,
                    'title' => __( 'Unbreakable', 'prayer-global-porch' ),
                    'description' => sprintf( __( 'You have prayed for %d days straight', 'prayer-global-porch' ), 500 ),
                ],
            ],
            'location' => [
                5 => [
                    'id' => PG_Badges::PRAYER_STARTER,
                    'title' => __( 'Prayer Starter', 'prayer-global-porch' ),
                    'description' => sprintf( __( 'You have prayed for %d locations', 'prayer-global-porch' ), 5 ),
                ],
                10 => [
                    'id' => PG_Badges::NEIGHBOURHOOD_INTERCESSOR,
                    'title' => __( 'Neighbourhood Intercessor', 'prayer-global-porch' ),
                    'description' => sprintf( __( 'You have prayed for %d locations', 'prayer-global-porch' ), 10 ),
                ],
                50 => [
                    'id' => PG_Badges::KINGDOM_BUILDER,
                    'title' => __( 'Kingdom Builder', 'prayer-global-porch' ),
                    'description' => sprintf( __( 'You have prayed for %d locations', 'prayer-global-porch' ), 50 ),
                ],
                500 => [
                    'id' => PG_Badges::REGIONAL_WATCHMAN,
                    'title' => __( 'Regional Watchman', 'prayer-global-porch' ),
                    'description' => sprintf( __( 'You have prayed for %d locations', 'prayer-global-porch' ), 500 ),
                ],
                1193 => [
                    'id' => PG_Badges::GLOBAL_INTERCESSOR,
                    'title' => __( 'Global Intercessor', 'prayer-global-porch' ),
                    'description' => sprintf( __( 'You have prayed for %d%% of the world', 'prayer-global-porch' ), 25 ),
                ],
                3578 => [
                    'id' => PG_Badges::PRAYER_WARRIOR,
                    'title' => __( 'Prayer Warrior', 'prayer-global-porch' ),
                    'description' => sprintf( __( 'You have prayed for %d%% of the world', 'prayer-global-porch' ), 50 ),
                ],
                4770 => [
                    'id' => PG_Badges::WORLD_CHANGER,
                    'title' => __( 'World Changer', 'prayer-global-porch' ),
                    'description' => __( 'You have prayed for the whole world', 'prayer-global-porch' ),
                ],
                9540 => [
                    'id' => PG_Badges::LEGACY_INTERCESSOR,
                    'title' => __( 'Legacy Intercessor', 'prayer-global-porch' ),
                    'description' => sprintf( __( 'You have prayed %d laps of the world', 'prayer-global-porch' ), 2 ),
                ],
                23850 => [
                    'id' => PG_Badges::MARATHON_PRAYER,
                    'title' => __( 'Marathon Prayer', 'prayer-global-porch' ),
                    'description' => sprintf( __( 'You have prayed %d laps of the world', 'prayer-global-porch' ), 5 ),
                ],
                47700 => [
                    'id' => PG_Badges::ETERNAL_WATCHMAN,
                    'title' => __( 'Eternal Watchman', 'prayer-global-porch' ),
                    'description' => sprintf( __( 'You have prayed %d laps of the world', 'prayer-global-porch' ), 10 ),
                ],
            ],
        ];
    }

    /**
     * Returns all the badge names that the user has earned
     * @return array of PG_Badge objects
     */
    public function get_badges(): array {
        // Get all badges from the usermeta
        $badges = PG_Badge_Model::get_all_badges( $this->user_id );
        return array_map( function( $badge ) {
            if ( !isset( $this->badges[$badge['category']][$badge['value']] ) ) {
                return null;
            }
            $badge = $this->badges[$badge['category']][$badge['value']];
            return new PG_Badge( $badge['id'], $badge['title'], $badge['description'] );
        }, $badges );
    }

    public function get_current_badges(): array {
        $badges = PG_Badge_Model::get_current_badges_by_category( $this->user_id );
        return array_map( function( $badge ) {
            if ( !isset( $this->badges[$badge['category']][$badge['value']] ) ) {
                return null;
            }
            $badge = $this->badges[$badge['category']][$badge['value']];
            return new PG_Badge( $badge['id'], $badge['title'], $badge['description'] );
        }, $badges );
    }

    public function get_next_badges(): array {
        $badges = $this->get_current_badges();
        $next_badges = [];
        foreach ( $badges as $badge ) {
            $next_badge = next( $this->badges[$badge->get_category()] );
            if ( !$next_badge ) {
                continue;
            }
            $next_badges[] = new PG_Badge( $next_badge['id'], $next_badge['title'], $next_badge['description'], $badge->get_category(), $next_badge['value'] );
        }
        return $next_badges;
    }

    /**
     * Returns any badges that the user has earned that they didn't already have
     * @return array
     */
    public function get_new_badges(): array {
        $next_badges = $this->get_next_badges();

        $new_badges = [];

        foreach ( $next_badges as $badge ) {
            if ( $badge->get_category() === 'streak' ) {
                $streak = $this->user_stats->current_streak_in_days();

                if ( $streak >= $badge->get_value() ) {
                    $new_badges[] = $badge;
                }
            }
            if ( $badge->get_category() === 'location' ) {
                $locations = $this->user_stats->total_places_prayed();
                if ( $locations >= $badge->get_value() ) {
                    $new_badges[] = $badge;
                }
            }
        }

        return $new_badges;
    }

    public function save_badges( array $badges ) {
        if ( empty( $badges ) ) {
            return;
        }

        if ( !$badges[0] instanceof PG_Badge ) {
            throw new Exception( 'Badges must be an array of PG_Badge objects' );
        }

        foreach ( $badges as $badge ) {
            PG_Badge_Model::create_badge( $this->user_id, $badge->get_id(), $badge->get_category(), $badge->get_value() );
        }
    }
}
