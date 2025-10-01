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

    public function get_all_badges(): array {
        $all_earned_badges = PG_Badge_Model::get_all_badges( $this->user_id );
        $all_earned_badge_ids = array_column( $all_earned_badges, 'id' );
        $all_badges = $this->pg_badges->get_all_badges();
        foreach ( $all_badges as &$badge ) {
            if ( $badge->get_type() === PG_Badges::TYPE_PROGRESSION ) {
                // for progression badges, we need to have the current data of their progression in the badge also.
                $first_progression_badge = null;
                $latest_earned_badge = null;
                foreach ( $badge->get_progression_badges() as &$progression_badge ) {
                    if ( !$first_progression_badge ) {
                        $first_progression_badge = $progression_badge;
                    }
                    $badge_id = $progression_badge->get_id();
                    if ( in_array( $badge_id, $all_earned_badge_ids ) ) {
                        $progression_badge->set_has_earned_badge( true );
                        $progression_badge->set_timestamp( $all_earned_badges[array_search( $badge_id, $all_earned_badge_ids )]['timestamp'] );
                        $latest_earned_badge = $progression_badge;
                    } else {
                        break;
                    }
                }
                if ( $latest_earned_badge ) {
                    $badge->set_progression_root_badge( $latest_earned_badge );
                } else {
                    $badge->set_progression_root_badge( $first_progression_badge );
                }
            }

            if ( $badge->get_type() === PG_Badges::TYPE_MULTIPLE ) {
                // add the count for how many times they have earned the badge.
                // use the timestamp from the latest earned badge.
                $badge_id = $badge->get_id();
                $num_times_earned = count( array_filter( $all_earned_badge_ids, function( $earned_badge_id ) use ( $badge_id ) {
                    return $earned_badge_id === $badge_id;
                } ) );
                if ( $num_times_earned > 0 ) {
                    $badge->set_has_earned_badge( true );
                    $badge->set_num_times_earned( $num_times_earned );
                    // the earned badges are in TIMESTAMP DESC order, so the latest earned badge is the first one.
                    $latest_earned_badge_timestamp = $all_earned_badges[array_search( $badge_id, $all_earned_badge_ids )]['timestamp'];
                    $badge->set_timestamp( $latest_earned_badge_timestamp );
                }
            }

            if ( $badge->get_type() === PG_Badges::TYPE_MONTHLY_CHALLENGE ) {
                // for monthly challenge badges, we need to generate them as needed.
                // so if a user has earned it, it should be in the array.
                // and the upcoming badge to earn should also be in the array.
            }

            if ( $badge->get_type() === PG_Badges::TYPE_ACHIEVEMENT ) {
                $badge_id = $badge->get_id();
                if ( in_array( $badge_id, $all_earned_badge_ids ) ) {
                    $badge->set_has_earned_badge( true );
                    $badge->set_timestamp( $all_earned_badges[array_search( $badge_id, $all_earned_badge_ids )]['timestamp'] );
                }
            }
        }
        // for each progression badge, include the stat to show how far they are towards the next badge
        return array_map( function( PG_Badge $badge ) {
            return $badge->to_array();
        }, $all_badges );
    }

    public function earn_badge( string $badge_id ) {
        $badge = $this->pg_badges->get_badge( $badge_id );
        if ( $badge ) {
            PG_Badge_Model::create_badge( $this->user_id, $badge_id, $badge->get_category(), $badge->get_value() );
        }
    }

    public function get_newly_earned_badges(): array {
        // filter out the badges that the user has already earned from pg_badges
        // check if any of the remaining badges have been earned since the last time they were checked
        // check if the next badge(s) in the progression have been earned since the last time they were checked
        return [];
    }
}
