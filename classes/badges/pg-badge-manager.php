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
                'type' => 'progression',
                'badges' => [
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
                ]
            ],
            'location' => [
                'type' => 'progression',
                'badges' => [
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
                ]
            ],
            're-engagement' => [
                'type' => 'achievement',
                'badges' => [
                    [
                        'id' => PG_Badges::COMEBACK_CHAMPION,
                        'title' => __( 'Comeback Champion', 'prayer-global-porch' ),
                        'description' => __( 'It\'s great to have you back!', 'prayer-global-porch' ),
                    ],
                ],
            ]
        ];
    }

    /**
     * Returns all the badges
     * @return array<PG_Badge>
     */
    public function get_user_badges(): array {
        // Get all badges from the usermeta
        $badges = PG_Badge_Model::get_all_badges( $this->user_id );
        return array_map( function( array $badge ) {
            $category = isset( $this->badges[$badge['category']] ) ? $this->badges[$badge['category']] : null;
            if ( !$category ) {
                return null;
            }
            if ( $category['type'] === 'progression' ) {
                $badge_info = $category['badges'][$badge['value']];
                $type = 'progression';
            } else {
                $badge_info = $category['badges'][$badge['badge_id']];
                $type = 'achievement';
            }
            return new PG_Badge( $badge_info['id'], $badge_info['title'], $badge_info['description'], $badge['category'], $badge['value'], $type );
        }, $badges );
    }

    /**
     * Returns the current badges that the user has earned (only the highest badge in each category)
     * @return array<PG_Badge>
     */
    public function get_user_current_badges(): array {
        $badges = PG_Badge_Model::get_current_badges_by_category( $this->user_id );
        $user_badges = array_filter( $badges, function( array $badge ) {
            $category = isset( $this->badges[$badge['category']] ) ? $this->badges[$badge['category']] : null;
            return $category !== null;
        } );
        return array_map( function( array $badge ) {
            $category = isset( $this->badges[$badge['category']] ) ? $this->badges[$badge['category']] : null;
            if ( $category['type'] === 'progression' ) {
                $badge_info = $category['badges'][$badge['value']];
                $type = 'progression';
            } else {
                $badge_info = $category['badges'][$badge['badge_id']];
                $type = 'achievement';
            }
            return new PG_Badge( $badge_info['id'], $badge_info['title'], $badge_info['description'], $badge['category'], (int) $badge['value'], $type );
        }, $user_badges );
    }

    /**
     * For badges the user already has, return the next badge in the sequence (for that category)
     * @return array<PG_Badge>
     */
    public function get_next_badge_in_progressions(): array {
        $badges = $this->get_user_current_badges();
        $next_badges = [];
        foreach ( $badges as $badge ) {
            if ( $badge === null ) {
                continue;
            }
            if ( $badge->get_type() !== 'progression' ) {
                continue;
            }

            $i = 0;
            foreach ( $this->badges[$badge->get_category()]['badges'] as $current_badge ) {
                if ( $current_badge['value'] === $badge->get_value() && $i !== count( $this->badges[$badge->get_category()]['badges'] ) - 1 ) {
                    $badge_info = $this->badges[$badge->get_category()]['badges'][$i + 1];
                    $next_badge = new PG_Badge( $badge_info['id'], $badge_info['title'], $badge_info['description'], $badge->get_category(), $badge_info['value'], 'progression' );
                    break;
                }
                $i++;
            }

            if ( !$next_badge ) {
                continue;
            }
            $next_badges[] = $next_badge;
        }
        return $next_badges;
    }

    /**
     * Returns any badges that the user has earned that they didn't already have
     * @return array
     */
    public function get_new_badges(): array {
        // If the user has a next badge, see if they have earned it.
        $next_badges = $this->get_next_badge_in_progressions();

        $next_badges_by_category = [];
        foreach ( $next_badges as $badge ) {
            $next_badges_by_category[$badge->get_category()][] = $badge;
        }

        $categories = array_keys( $this->badges );

        foreach ( $categories as $category ) {
            // For categories which are progressions.
            // If the user is on a progression, see if they have earned the next badge
            $type = $this->badges[$category]['type'];
            if ( $type === 'progression' ) {
                if ( isset( $next_badges_by_category[$category] ) ) {
                    $new_badges[] = $next_badges_by_category[$category];
                } else {
                    $new_badges[] = $this->check_for_highest_badge_in_category( $category );
                }
            } else {
                // If not see if they have earned any of the achievements
                $badges = $this->badges[$category]['badges'];
                foreach ( $badges as $badge ) {
                    $new_badges[] = $this->has_earned_badge( $badge );
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

    private function get_available_badges_by_category( string $category ): array {
        if ( !isset( $this->badges[$category] ) ) {
            throw new Exception( 'Category not found ' . $category );
        }
        $badges = $this->badges[$category]['badges'];
        $type = $this->badges[$category]['type'];
        // badges is a key => value pair of value => badge
        // return the array of badges with the value added to the badge data
        return array_map_assoc( function( $badge, $value ) use ( $category, $type ) {
            return new PG_Badge( $badge['id'], $badge['title'], $badge['description'], $category, $value, $type );
        }, $badges );
    }

    private function check_for_highest_badge_in_category( string $category ): ?PG_Badge {
        $badges = $this->get_available_badges_by_category( $category );

        $badges = array_reverse( $badges );

        if ( $category === 'streak' ) {
            $best_streak = $this->user_stats->best_streak_in_days();
            foreach ( $badges as $badge ) {
                if ( $badge->get_value() <= $best_streak ) {
                    return $badge;
                }
            }
        }
        if ( $category === 'location' ) {
            $total_locations = count( $this->user_stats->location );
            foreach ( $badges as $badge ) {
                if ( $badge->get_value() <= $total_locations ) {
                    return $badge;
                }
            }
        }
        return null;
    }
    private function has_earned_badge( array $badge ): ?PG_Badge {
        // check if the user already has the badge
        $badges = PG_Badge_Model::get_all_badges( $this->user_id );
        foreach ( $badges as $badge ) {
            if ( $badge['badge_id'] === $badge['id'] ) {
                return null;
            }
        }
        if ( $badge['id'] === PG_Badges::COMEBACK_CHAMPION ) {
            // TODO: implement has_just_returned
            return $this->user_stats->has_just_returned() ? new PG_Badge( $badge['id'], $badge['title'], $badge['description'], $badge['category'], $badge['value'], 'achievement' ) : null;
        }
        return null;
    }
}
