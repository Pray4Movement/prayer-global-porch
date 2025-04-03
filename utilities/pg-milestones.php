<?php

class PG_Milestones {
    private User_Stats $user_stats;

    private $streak_milestones = [ 7, 14, 30, 60, 100 ];

    public function __construct( int $user_id ) {
        $this->user_stats = new User_Stats( $user_id );

        /* DEBUG TODO: Remove */
        $this->streak_milestones = [ 1, 2, 3, 4, 5, 6, 7, 14, 30, 60, 100 ];
    }

    /**
     * Get in app milestones
     *
     * @return PG_Milestone[]
     */
    public function get_in_app_milestones(): array {
        $all_milestones = $this->get_milestones();

        return array_filter(
            $all_milestones,
            function( $milestone ) {
                return $milestone->in_app();
            }
        );
    }

    /**
     * Get all milestones
     *
     * @return PG_Milestone[]
     */
    public function get_milestones(): array {
        $streak_milestones = $this->get_streak_milestones();

        return array_merge( $streak_milestones );
    }

    /**
     * Get the streak milestones
     *
     * @return PG_Milestone[]
     */
    private function get_streak_milestones(): array {
        $current_streak = $this->user_stats->current_streak_in_days();
        if ( in_array( $current_streak, $this->streak_milestones ) ) {
            return [
                new PG_Milestone(
                    'pg-streak',
                    __( 'Your Streak is Alive!', 'prayer-global-porch' ),
                    sprintf(
                        esc_html__( 'You have prayed for %s days in a row! Let\'s keep that streak going!', 'prayer-global-porch' ),
                        $current_streak
                    ),
                    'streak',
                    $current_streak,
                    [ PG_CHANNEL_IN_APP, PG_CHANNEL_PUSH, PG_CHANNEL_EMAIL ]
                )
            ];
        }
        return [];
    }
}
