<?php

class PG_Badge_Manager {
    private int $user_id;
    private User_Stats $user_stats;
    private PG_Badges $pg_badges;
    public function __construct( int $user_id ) {
        $this->user_id = $user_id;
        $this->user_stats = new User_Stats( $user_id );
        $this->pg_badges = new PG_Badges();
    }

    /**
     * Returns all the badges
     * @return array<PG_Badge>
     */
    public function get_user_badges(): array {
        // Get all badges from the usermeta
        $badges = PG_Badge_Model::get_all_badges( $this->user_id );
        return $this->hydrate_db_badges( $badges );
    }

    /**
     * Returns the current badges that the user has earned (only the highest badge in each category that is a progression)
     * @return array<PG_Badge>
     */
    public function get_user_current_badges(): array {
        $badges = PG_Badge_Model::get_all_badges( $this->user_id );
        $badges = $this->hydrate_db_badges( $badges );
        $current_badges = [];
        $progression_categories_done = [];
        foreach ( $badges as $badge ) {
            // this works because get_all_badges is ordered by category and value DESC
            if ( $badge->get_type() === PG_Badges::TYPE_PROGRESSION ) {
                if ( in_array( $badge->get_category(), $progression_categories_done ) ) {
                    continue;
                }
                $current_badges[] = $badge;
                $progression_categories_done[] = $badge->get_category();
            }
            if ( $badge->get_type() === PG_Badges::TYPE_ACHIEVEMENT ) {
                $current_badges[] = $badge;
            }
        }
        return $current_badges;
    }
    /**
     * Hydrate the badges from the database to the objects
     * @param array $badges
     * @return array<PG_Badge>
     */
    private function hydrate_db_badges( array $badges ): array {
        $user_badges = array_filter( $badges, function( array $badge ) {
            return $this->pg_badges->has_category( $badge['category'] ) &&
                isset( $this->pg_badges->get_category_badges( $badge['category'] )[$badge['id']] );
        } );
        return array_map( function( array $badge ) {
            $category_badges = $this->pg_badges->get_category_badges( $badge['category'] );
            return $category_badges[$badge['id']];
        }, $user_badges );
    }

    /**
     * For badges the user already has, return the next badge in the sequence (for that category)
     * @return array<PG_Badge>
     */
    public function get_next_badge_in_progressions() {
        $badges = $this->get_user_current_badges();
        $next_badges = [];
        foreach ( $badges as $badge ) {
            if ( $badge === null ) {
                continue;
            }
            if ( $badge->get_type() !== 'progression' ) {
                continue;
            }

            $category_badges = $this->pg_badges->get_category_badges( $badge->get_category() );
            $i = 0;
            $next_badge = null;
            foreach ( $category_badges as $current_badge ) {
                if ( $badge->less_than( $current_badge ) ) {
                    $next_badge = $current_badge;
                    break;
                }
                $i++;
            }

            if ( $this->has_user_got_badge( $next_badge ) ) {
                $next_badge = pg_null_badge( $badge->get_category(), $badge->get_type() );
            }

            if ( !$next_badge ) {
                $next_badge = pg_null_badge( $badge->get_category(), $badge->get_type() );
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

        $categories = $this->pg_badges->get_categories();

        $new_badges = [];
        foreach ( $categories as $category ) {
            // For categories which are progressions.
            // If the user is on a progression, see if they have earned the next badge
            $type = $this->pg_badges->get_category_type( $category );
            if ( $type === 'progression' ) {
                $first_badge_in_progression = $this->first_badge_in_progression( $category );
                if ( $first_badge_in_progression ) {
                    $new_badges[] = $first_badge_in_progression;
                }
            } else {
                // If not see if they have earned any of the achievements
                $badges = $this->pg_badges->get_category_badges( $category );
                foreach ( $badges as $badge ) {
                    if ( $this->has_earned_achievement_badge( $badge ) ) {
                        $new_badges[] = $badge;
                    }
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

    /**
     * Check for the highest badge in a category
     * @param string $category
     * @return PG_Badge|null
     */
    private function first_badge_in_progression( string $category ): ?PG_Badge {
        $badges = $this->pg_badges->get_category_badges( $category );

        $badges = array_reverse( $badges );

        foreach ( $badges as $badge ) {
            if ( $this->has_earned_progression_badge( $badge ) ) {
                if ( $this->has_user_got_badge( $badge ) ) {
                    break;
                }
                return $badge;
            }
        }
        return null;
    }
    /**
     * Dose the users's stats meet the requirements for the progression badge
     * @param PG_Badge $badge
     * @return bool
     */
    private function has_earned_progression_badge( PG_Badge $badge ): bool {
        if ( $badge->get_category() === PG_Badges::CATEGORY_STREAK ) {
            $best_streak = $this->user_stats->best_streak_in_days();
            if ( $badge->get_value() <= $best_streak ) {
                return true;
            }
        }
        if ( $badge->get_category() === PG_Badges::CATEGORY_LOCATION ) {
            $total_locations = $this->user_stats->total_places_prayed();
            if ( $badge->get_value() <= $total_locations ) {
                return true;
            }
        }
        return false;
    }

    /**
     * Dose the user's stats meet the requirements for the achievement badge
     * @param PG_Badge $badge
     * @return bool
     */
    private function has_earned_achievement_badge( PG_Badge $badge ): bool {
        if ( $this->has_user_got_badge( $badge ) ) {
            return false;
        }

        if ( $badge->get_id() === PG_Badges::COMEBACK_CHAMPION ) {
            // TODO: implement has_just_returned
            return $this->user_stats->has_just_returned();
        }
        return false;
    }
    /**
     * Check if the user has already earned a badge
     * @param PG_Badge $badge
     * @return bool
     */
    private function has_user_got_badge( PG_Badge $badge ): bool {
        $earned_badges = $this->get_user_badges();
        foreach ( $earned_badges as $earned_badge ) {
            if ( $badge->equals( $earned_badge ) ) {
                return true;
            }
        }
        return false;
    }
}
