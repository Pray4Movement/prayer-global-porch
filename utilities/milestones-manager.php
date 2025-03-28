<?php

class Milestones_Manager {
    private User_Stats $user_stats;

    private $streak_milestones = [ 7, 14, 30, 60, 100 ];

    public function __construct( int $user_id ) {
        $this->user_stats = new User_Stats( $user_id );
    }

    public function get_milestones(): array {
        $streak_milestones = $this->get_streak_milestones();

        return array_merge( $streak_milestones );
    }

    private function get_streak_milestones(): array {
        //if ( in_array( $this->user_stats->current_streak_in_days(), $this->streak_milestones ) ) {
        if ( in_array( $this->user_stats->current_streak_in_days(), $this->streak_milestones ) ) {
            return [
                [
                    'icon' => 'pg-streak',
                    'title' => __( 'Your Streak is Alive!', 'prayer-global-porch' ),
                    'message' => sprintf( esc_html__( 'You’ve prayed for %s days in a row! Let’s keep that streak going!', 'prayer-global-porch' ), $this->user_stats->current_streak_in_days() ),
                    'type' => 'streak',
                    'channel' => 'in-app',
                ]
            ];
        }
        return [];
    }
}
