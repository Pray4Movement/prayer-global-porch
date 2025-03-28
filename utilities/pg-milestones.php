<?php

class PG_Milestones {
    private User_Stats $user_stats;

    private $streak_milestones = [ 7, 14, 30, 60, 100 ];

    public function __construct( int $user_id ) {
        $this->user_stats = new User_Stats( $user_id );
    }

    public function get_in_app_milestones() {
        $all_milestones = $this->get_milestones();

        return array_filter( $all_milestones, function( $milestone ) {
            return in_array( 'in-app', $milestone['channel'] );
        } );
    }

    public function get_milestones(): array {
        $streak_milestones = $this->get_streak_milestones();

        return array_merge( $streak_milestones );
    }

    private function get_streak_milestones(): array {
        $current_streak = $this->user_stats->current_streak_in_days();
        if ( in_array( $current_streak, $this->streak_milestones ) ) {
            return [
                /* @todo refactor this into an object called PG_Milestone */
                /* But then we will need to convert to an associative array when sending to the frontend */
                [
                    'icon' => 'pg-streak',
                    'title' => __( 'Your Streak is Alive!', 'prayer-global-porch' ),
                    'message' => sprintf( esc_html__( 'You’ve prayed for %s days in a row! Let’s keep that streak going!', 'prayer-global-porch' ), $current_streak ),
                    'category' => 'streak',
                    'value' => $current_streak,
                    'channel' => [ 'in-app' ],
                ]
            ];
        }
        return [];
    }
}
