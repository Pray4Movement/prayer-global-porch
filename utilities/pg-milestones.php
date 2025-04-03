<?php

class PG_Milestones
{
    private User_Stats $user_stats;

    private $streak_milestones = [ 7, 14, 30, 60, 100 ];

    public function __construct( int $user_id )
    {
        $this->user_stats = new User_Stats( $user_id );

        /* DEBUG TODO: Remove */
        $this->streak_milestones = [ 1, 2, 3, 4, 5, 6, 7, 14, 30, 60, 100 ];
    }

    /**
     * Get in app milestones
     *
     * @return PG_Milestone[]
     */
    public function get_in_app_milestones(): array
    {
        $all_milestones = $this->get_milestones();

        return array_filter(
            $all_milestones,
            function ( $milestone ) {
                return $milestone->in_app();
            }
        );
    }

    /**
     * Get all milestones
     *
     * @return PG_Milestone[]
     */
    public function get_milestones(): array
    {
        $streak_milestones = $this->get_streak_milestones();
        $inactivity_milestones = $this->get_inactivity_milestones();

        return array_merge( $streak_milestones, $inactivity_milestones );
    }

    /**
     * Get the streak milestones
     *
     * @return PG_Milestone[]
     */
    private function get_streak_milestones(): array
    {
        $current_streak = $this->user_stats->current_streak_in_days();
        if ( in_array( $current_streak, $this->streak_milestones ) ) {
            return [
                new PG_Milestone(
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

    /**
     * Get the inactivity milestones
     *
     * @return PG_Milestone[]
     */
    private function get_inactivity_milestones(): array
    {
        $last_prayer_timestamp = $this->user_stats->last_prayer_date();
        if ( !$last_prayer_timestamp ) {
            return [];
        }

        $now = time();
        $hours_inactive = ( $now - $last_prayer_timestamp ) / 3600;
        $days_inactive = floor( $hours_inactive / 24 );

        if ( $hours_inactive >= 36 && $hours_inactive < 48 ) {
            return [
                new PG_Milestone(
                    __( 'Keep your streak alive', 'prayer-global-porch' ),
                    __( 'Keep praying to maintain your streak!', 'prayer-global-porch' ),
                    'inactivity',
                    1,
                    [ PG_CHANNEL_EMAIL, PG_CHANNEL_PUSH ]
                )
            ];
        }

        if ( $days_inactive === 2 ) {
            return [
                new PG_Milestone(
                    __( 'Oh no! Your streak has ended', 'prayer-global-porch' ),
                    __( 'Your prayer streak has ended. Start a new one today!', 'prayer-global-porch' ),
                    'inactivity',
                    2,
                    [ PG_CHANNEL_EMAIL, PG_CHANNEL_PUSH ]
                )
            ];
        }

        if ( $days_inactive === 7 ) {
            return [
                new PG_Milestone(
                    __( 'We Miss You—Let\'s Pray Today!', 'prayer-global-porch' ),
                    __( 'Haven\'t seen you in a while—take a moment today to reconnect in prayer!', 'prayer-global-porch' ),
                    'inactivity',
                    7,
                    [ PG_CHANNEL_EMAIL, PG_CHANNEL_PUSH ]
                )
            ];
        }

        if ( $days_inactive === 14 ) {
            return [
                new PG_Milestone(
                    __( 'Prayer Changes Everything—Come Back!', 'prayer-global-porch' ),
                    __( 'Your prayers matter! Take a moment today and join us in covering the world in prayer again.', 'prayer-global-porch' ),
                    'inactivity',
                    14,
                    [ PG_CHANNEL_EMAIL, PG_CHANNEL_PUSH ]
                )
            ];
        }

        if ( $days_inactive === 30 ) {
            return [
                new PG_Milestone(
                    __( 'Let\'s Reconnect—Your Prayers Are Needed', 'prayer-global-porch' ),
                    __( 'The world needs prayer warriors like you. Jump back in today and be part of something bigger!', 'prayer-global-porch' ),
                    'inactivity',
                    30,
                    [ PG_CHANNEL_EMAIL, PG_CHANNEL_PUSH ]
                )
            ];
        }

        if ( $days_inactive === 60 ) {
            return [
                new PG_Milestone(
                    __( 'Time to Come Back', 'prayer-global-porch' ),
                    __( 'We\'d love to have you back praying with us!', 'prayer-global-porch' ),
                    'inactivity',
                    60,
                    [ PG_CHANNEL_EMAIL ]
                )
            ];
        }

        if ( $days_inactive === 90 ) {
            return [
                new PG_Milestone(
                    __( 'Missing Your Prayers', 'prayer-global-porch' ),
                    __( 'Your prayer journey can restart anytime - join us again!', 'prayer-global-porch' ),
                    'inactivity',
                    90,
                    [ PG_CHANNEL_EMAIL ]
                )
            ];
        }

        if ( $days_inactive === 180 ) {
            return [
                new PG_Milestone(
                    __( 'It\'s been a while!', 'prayer-global-porch' ),
                    __( 'Would you like to restart with a fresh goal?', 'prayer-global-porch' ),
                    'inactivity',
                    180,
                    [ PG_CHANNEL_EMAIL ]
                )
            ];
        }

        if ( $days_inactive === 365 ) {
            return [
                new PG_Milestone(
                    __( 'Is This Goodbye?', 'prayer-global-porch' ),
                    __( 'We understand life gets busy, but your prayers make an impact. We\'d love to have you back whenever you\'re ready.', 'prayer-global-porch' ),
                    'inactivity',
                    365,
                    [ PG_CHANNEL_EMAIL ]
                )
            ];
        }

        return [];
    }
}
