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
     * Returns the current badges that the user has earned (only the highest badge in each category)
     * @return array<PG_Badge>
     */
    public function get_user_current_badges(): array {
        $badges = PG_Badge_Model::get_current_badges_by_category( $this->user_id );
        return $this->hydrate_db_badges( $badges );
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

            $category_badges = $this->pg_badges->get_category_badges( $badge->get_category() );
            $i = 0;
            foreach ( $category_badges as $current_badge ) {
                if ( $badge->less_than( $current_badge ) ) {
                    $next_badge = $current_badge;
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

        $categories = $this->pg_badges->get_categories();

        foreach ( $categories as $category ) {
            // For categories which are progressions.
            // If the user is on a progression, see if they have earned the next badge
            $type = $this->pg_badges->get_category_type( $category );
            if ( $type === 'progression' ) {
                if ( isset( $next_badges_by_category[$category] ) ) {
                    $new_badges[] = $next_badges_by_category[$category];
                } else {
                    $new_badges[] = $this->check_for_highest_badge_in_category( $category );
                }
            } else {
                // If not see if they have earned any of the achievements
                $badges = $this->pg_badges->get_category_badges( $category );
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

    private function check_for_highest_badge_in_category( string $category ): ?PG_Badge {
        $badges = $this->pg_badges->get_category_badges( $category );

        $badges = array_reverse( $badges );

        if ( $category === PG_Badges::CATEGORY_STREAK ) {
            $best_streak = $this->user_stats->best_streak_in_days();
            foreach ( $badges as $badge ) {
                if ( $badge->get_value() <= $best_streak ) {
                    return $badge;
                }
            }
        }
        if ( $category === PG_Badges::CATEGORY_LOCATION ) {
            $total_locations = $this->user_stats->total_places_prayed();
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
