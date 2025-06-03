<?php

class PG_Milestones
{
    private User_Stats $user_stats;

    private $streak_milestones = [ 2, 7, 14, 30, 60, 100 ];

    public function __construct( int $user_id )
    {
        $this->user_stats = new User_Stats( $user_id );

        if ( false && defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            $this->streak_milestones = [ 1, 2, 3, 4, 5, 6, 7, 14, 30, 60, 100 ];
        }
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
        $streak_milestones = $this->get_streak_milestone();
        $inactivity_milestones = $this->get_inactivity_milestone();

        return array_merge( $streak_milestones, $inactivity_milestones );
    }

    /**
     * Get the next milestones
     *
     * @return PG_Milestone[]
     */
    public function get_next_milestones(): array
    {
        $streak_milestones = $this->get_streak_milestone( true );
        $inactivity_milestones = $this->get_inactivity_milestone( true );

        return array_merge( $streak_milestones, $inactivity_milestones );
    }

    /**
     * Get the streak milestones
     *
     * @return PG_Milestone[]
     */
    private function get_streak_milestone( bool $next_milestone = false ): array
    {
        $current_streak = $this->user_stats->current_streak_in_days();
        if ( $next_milestone ) {
            foreach ( $this->streak_milestones as $i => $milestone ) {
                if ( $current_streak >= $milestone ) {
                    $current_streak = $this->streak_milestones[ $i + 1 ];
                    break;
                }
            }
        }
        if ( in_array( $current_streak, $this->streak_milestones ) ) {
            return [
                new PG_Milestone(
                    __( 'Your Streak is Alive!', 'prayer-global-porch' ),
                    sprintf(
                        __( "You have prayed for %s days in a row! Let's keep that streak going!", 'prayer-global-porch' ),
                        $current_streak
                    ),
                    'streak',
                    $current_streak,
                    [ PG_CHANNEL_IN_APP, PG_CHANNEL_PUSH, PG_CHANNEL_EMAIL ]
                )
            ];
        }
        if ( $current_streak > 0 ) {
            return [
                $this->get_celebratory_message()
            ];
        }
        return [];
    }

    /**
     * Returns a random celebratory milestone
     *
     * @return PG_Milestone
     */
    private function get_celebratory_message(): PG_Milestone
    {
        $titles = [
            __( 'Thank You for Being Here', 'prayer-global-porch' ),
            __( 'Grateful You\'re Part of This', 'prayer-global-porch' ),
            __( 'We Appreciate You Joining Us', 'prayer-global-porch' ),
            __( 'It Means a Lot to Have You With Us', 'prayer-global-porch' ),
            __( 'Quiet Thanks for Faithful Hearts', 'prayer-global-porch' ),
            __( 'Thank You for Taking Time to Pray', 'prayer-global-porch' ),
            __( 'We\'re Glad to Be Praying With You', 'prayer-global-porch' ),
            __( 'Together in Prayer—Thank You', 'prayer-global-porch' ),
        ];

        $messages = [
            __( 'Amen! We agree with your prayers!', 'prayer-global-porch' ),
            __( 'Don\'t be discouraged as you pray. Cheat. Read to see how the Bible finishes!', 'prayer-global-porch' ),
            __( 'Every great Gospel movement has been preceeded by extraordinary prayer! Good work!', 'prayer-global-porch' ),
            __( 'Faithful in prayer, fierce in love — thank you for showing up.', 'prayer-global-porch' ),
            __( 'From your phone to the throne — heaven hears.', 'prayer-global-porch' ),
            __( 'God delights in your persistence — one prayer at a time.', 'prayer-global-porch' ),
            __( 'He who sees in secret will reward — thanks for showing up.', 'prayer-global-porch' ),
            __( 'Imagine it: a global prayer chorus rising. You\'re part of it.', 'prayer-global-porch' ),
            __( 'It\'s amazing that God invites us to pray without ceasing!', 'prayer-global-porch' ),
            __( 'Off to a strong start — heaven hears and you\'re making waves!', 'prayer-global-porch' ),
            __( 'Others may not know you prayed, but God does, and loves it!', 'prayer-global-porch' ),
            __( 'Prayer changes things... including us! Keep on!', 'prayer-global-porch' ),
            __( 'Thank you for again joining us today in God\'s throne room.', 'prayer-global-porch' ),
            __( 'That moment of faith just added light to a dark place.', 'prayer-global-porch' ),
            __( 'That prayer might have felt small, but remember God is HUGE!', 'prayer-global-porch' ),
            __( 'The gates of Hell won\'t withstand those prayers.', 'prayer-global-porch' ),
            __( 'The kingdom is advancing — and you\'re fueling it.', 'prayer-global-porch' ),
            __( 'Today\'s prayer might be the turning point for someone.', 'prayer-global-porch' ),
            __( 'Jesus loves to see you coming every time you pray.', 'prayer-global-porch' ),
            __( 'You fought in the heavenlies again, today. We honor you.', 'prayer-global-porch' ),
            //__( 'You just prayed for a place where no known believers live—thank you for standing in the gap.', 'prayer-global-porch' ),
            __( 'You prayed, and that matters more than you know.', 'prayer-global-porch' ),
            __( 'You\'re a world-changer in prayer!', 'prayer-global-porch' ),
            __( 'You\'re helping cover the earth in prayer — one place at a time.', 'prayer-global-porch' ),
            __( 'You\'re linking arms with believers around the world — unstoppable.', 'prayer-global-porch' ),
            __( 'You\'re loving your Prayer.Global neighbors as yourself!', 'prayer-global-porch' ),
            __( 'You\'re not just praying — you\'re joining a global movement of God.', 'prayer-global-porch' ),
            __( 'You\'re part of a global movement — prayer is the engine.', 'prayer-global-porch' ),
            __( 'Your prayer today covered people who\'ve never heard the name of Jesus — and He is listening.', 'prayer-global-porch' ),
            __( 'Your yes today could lead to someone else\'s first yes to Jesus.', 'prayer-global-porch' ),
            __( 'You showed up today, and God heard you!', 'prayer-global-porch' ),
            __( 'You\'ve already lifted voices today — what a start!', 'prayer-global-porch' ),
        ];

        return new PG_Milestone(
            $titles[ array_rand( $titles ) ],
            $messages[ array_rand( $messages ) ],
            'celebratory',
            $this->user_stats->current_streak_in_days(),
            [ PG_CHANNEL_IN_APP, PG_CHANNEL_PUSH ]
        );
    }

    /**
     * Get the inactivity milestones
     *
     * @return PG_Milestone[]
     */
    private function get_inactivity_milestone( bool $next_milestone = false ): array
    {
        $days_inactive = $this->user_stats->days_of_inactivity();
        if ( $days_inactive === 0 ) {
            return [];
        }

        $url = site_url( 'dashboard' );

        if ( $next_milestone ) {
            $hours_inactive = $this->user_stats->hours_of_inactivity();
        }
        if ( $days_inactive === 1 || ( $next_milestone && $hours_inactive < 1 ) ) {
            return [
            new PG_Milestone(
                __( 'Keep your streak alive', 'prayer-global-porch' ),
                __( 'Keep praying to maintain your streak!', 'prayer-global-porch' ),
                'inactivity',
                1,
                [ PG_CHANNEL_EMAIL, PG_CHANNEL_PUSH ],
                $url,
            )
            ];
        }

        if ( $days_inactive === 2 || ( $next_milestone && $days_inactive < 2 ) ) {
            return [
            new PG_Milestone(
                __( 'Oh no! Your streak has ended', 'prayer-global-porch' ),
                __( 'Your prayer streak has ended. Start a new one today!', 'prayer-global-porch' ),
                'inactivity',
                2,
                [ PG_CHANNEL_EMAIL, PG_CHANNEL_PUSH ],
                $url,
            )
            ];
        }

        if ( $days_inactive === 7 || ( $next_milestone && $days_inactive < 7 ) ) {
            return [
            new PG_Milestone(
                __( 'We Miss You—Let\'s Pray Today!', 'prayer-global-porch' ),
                __( 'Haven\'t seen you in a while—take a moment today to reconnect in prayer!', 'prayer-global-porch' ),
                'inactivity',
                7,
                [ PG_CHANNEL_EMAIL, PG_CHANNEL_PUSH ],
                $url,
            )
            ];
        }

        if ( $days_inactive === 14 || ( $next_milestone && $days_inactive < 14 ) ) {
            return [
            new PG_Milestone(
                __( 'Prayer Changes Everything—Come Back!', 'prayer-global-porch' ),
                __( 'Your prayers matter! Take a moment today and join us in covering the world in prayer again.', 'prayer-global-porch' ),
                'inactivity',
                14,
                [ PG_CHANNEL_EMAIL, PG_CHANNEL_PUSH ],
                $url,
            )
            ];
        }

        if ( $days_inactive === 30 || ( $next_milestone && $days_inactive < 30 ) ) {
            return [
            new PG_Milestone(
                __( 'Let\'s Reconnect—Your Prayers Are Needed', 'prayer-global-porch' ),
                __( 'The world needs prayer warriors like you. Jump back in today and be part of something bigger!', 'prayer-global-porch' ),
                'inactivity',
                30,
                [ PG_CHANNEL_EMAIL, PG_CHANNEL_PUSH ],
                $url,
            )
            ];
        }

        if ( $days_inactive === 60 || ( $next_milestone && $days_inactive < 60 ) ) {
            return [
            new PG_Milestone(
                __( 'Time to Come Back', 'prayer-global-porch' ),
                __( 'We\'d love to have you back praying with us!', 'prayer-global-porch' ),
                'inactivity',
                60,
                [ PG_CHANNEL_EMAIL, PG_CHANNEL_PUSH ],
                $url,
            )
            ];
        }

        if ( $days_inactive === 90 || ( $next_milestone && $days_inactive < 90 ) ) {
            return [
            new PG_Milestone(
                __( 'Missing Your Prayers', 'prayer-global-porch' ),
                __( 'Your prayer journey can restart anytime - join us again!', 'prayer-global-porch' ),
                'inactivity',
                90,
                [ PG_CHANNEL_EMAIL, PG_CHANNEL_PUSH ],
                $url,
            )
            ];
        }

        if ( $days_inactive === 180 || ( $next_milestone && $days_inactive < 180 ) ) {
            return [
            new PG_Milestone(
                __( 'It\'s been a while!', 'prayer-global-porch' ),
                __( 'Would you like to restart with a fresh goal?', 'prayer-global-porch' ),
                'inactivity',
                180,
                [ PG_CHANNEL_EMAIL, PG_CHANNEL_PUSH ],
                $url,
            )
            ];
        }

        if ( $days_inactive === 365 || ( $next_milestone && $days_inactive < 365 ) ) {
            return [
            new PG_Milestone(
                __( 'Is This Goodbye?', 'prayer-global-porch' ),
                __( 'We understand life gets busy, but your prayers make an impact. We\'d love to have you back whenever you\'re ready.', 'prayer-global-porch' ),
                'inactivity',
                365,
                [ PG_CHANNEL_EMAIL, PG_CHANNEL_PUSH ],
                $url,
            )
            ];
        }

        return [];
    }
}
