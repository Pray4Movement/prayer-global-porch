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
        $has_processed_monthly_challenge_badges = false;
        foreach ( $all_badges as $key => &$badge ) {
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
                // We are adding more badges to the array and we don't want to process them again.
                if ( $has_processed_monthly_challenge_badges ) {
                    continue;
                }
                $has_processed_monthly_challenge_badges = true;
                // for monthly challenge badges, we need to generate them as needed.
                // so if a user has earned it, it should be in the array.
                // and the upcoming badge to earn should also be in the array.
                $badge_id = $badge->get_id();
                $earned_challenge_badges = array_filter( $all_earned_badges, function( $earned_badge ) use ( $badge_id ) {
                    return str_starts_with( $earned_badge['id'], $badge_id );
                } );
                foreach ( $earned_challenge_badges as $earned_challenge_badge ) {
                    if ( str_starts_with( $earned_challenge_badge['id'], $badge_id ) ) {
                        $id_parts = explode( '_', $earned_challenge_badge['id'] );
                        $current_month = $id_parts[ count( $id_parts ) - 2 ];
                        $current_year = $id_parts[ count( $id_parts ) - 1 ];
                        $earned_badge = new PG_Badge(
                            $earned_challenge_badge['id'],
                            sprintf( $badge->get_title(), $current_month, $current_year ),
                            sprintf( $badge->get_description_unearned(), $current_month ),
                            sprintf( $badge->get_description_earned(), $current_month ),
                            implode( '_', [ 'challenge', $current_month, $current_year ] ) . '.png',
                            implode( '_', [ 'challenge', $current_month, $current_year, 'bw.png' ] ),
                            $badge->get_category(),
                            $badge->get_value(),
                            $badge->get_type(),
                            [],
                            $badge->is_hidden(),
                            $badge->is_deprecated(),
                        );
                        $earned_badge->set_has_earned_badge( true );
                        $earned_badge->set_timestamp( $earned_challenge_badge['timestamp'] );
                        $all_badges[$earned_challenge_badge['id']] = $earned_badge;
                    }
                }

                // get the current month as a word
                $current_month = gmdate( 'F' );
                $current_month_lower = strtolower( $current_month );
                // get the current year as a 4 digit number
                $current_year = gmdate( 'Y' );
                $current_month_badge_id = implode( '_', [ $badge_id, $current_month_lower, $current_year ] );
                if ( !in_array( $current_month_badge_id, $all_earned_badge_ids ) ) {
                    $current_month_badge = new PG_Badge(
                        $current_month_badge_id,
                        sprintf( $badge->get_title(), $current_month, $current_year ),
                        sprintf( $badge->get_description_unearned(), $current_month ),
                        sprintf( $badge->get_description_earned(), $current_month ),
                        implode( '_', [ 'challenge', $current_month_lower, $current_year, '.png' ] ),
                        implode( '_', [ 'challenge', $current_month_lower, $current_year, 'bw.png' ] ),
                        $badge->get_category(),
                        $badge->get_value(),
                        $badge->get_type(),
                        [],
                        $badge->is_hidden(),
                        $badge->is_deprecated(),
                    );
                    $all_badges[$current_month_badge_id] = $current_month_badge;
                }

                unset( $all_badges[$badge_id] );
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
        if ( !$badge && str_starts_with( $badge_id, 'monthly_challenge' ) ) {
            $badge = $this->pg_badges->get_badge( 'monthly_challenge' );
        }
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
