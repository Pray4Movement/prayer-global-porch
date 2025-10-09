<?php

class PG_Badges {
    // Ids
    const ID_STREAK = 'streak';
    const ID_MONTHLY_CHALLENGE = 'monthly_challenge';
    const ID_LOCATION = 'location';
    const ID_PRAYER_MOBILIZER = 'prayer_mobilizer';
    const ID_RELAY_LOCATION = 'relay_location';
    const ID_WHOLE_WORLD = 'whole_world';
    const ID_COMEBACK_CHAMPION = 'comeback_champion';
    const ID_TEAM_PLAYER = 'team_player';
    const ID_FIRST_PRAYER_RELAY = 'first_prayer_relay';
    const ID_RELAY_COMPLETED_PARTICIPANT = 'relay_completed_participant';
    const ID_RELAY_COMPLETED_ORGANIZER = 'relay_completed_organizer';
    const ID_PERFECT_WEEK = 'perfect_week';
    const ID_PERFECT_MONTH = 'perfect_month';
    const ID_PERFECT_YEAR = 'perfect_year';
    // category types
    const TYPE_PROGRESSION = 'progression';
    const TYPE_ACHIEVEMENT = 'achievement';
    const TYPE_MULTIPLE = 'multiple';
    const TYPE_MONTHLY_CHALLENGE = 'challenge';
    // categories
    const CATEGORY_CONSISTENCY = 'consistency';
    const CATEGORY_LOCATION = 'location';
    const CATEGORY_RE_ENGAGEMENT = 're-engagement';
    const CATEGORY_MOBILIZATION = 'mobilization';

    public ?array $badges = null;

    public function __construct() {
        $badges = [
            self::CATEGORY_LOCATION => [
                [
                    'id' => self::ID_LOCATION,
                    'type' => self::TYPE_PROGRESSION,
                    'priority' => 1,
                    'progression_badges' => [
                        [
                            'id' => 'location_25',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 25 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 25 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 25 ),
                            'value' => 25,
                            'image' => 'location_25.png',
                            'bw_image' => 'location_25_bw.png',
                        ],
                        [
                            'id' => 'location_50',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 50 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 50 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 50 ),
                            'value' => 50,
                            'image' => 'location_50.png',
                            'bw_image' => 'location_50_bw.png',
                        ],
                        [
                            'id' => 'location_75',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 75 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 75 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 75 ),
                            'value' => 75,
                            'image' => 'location_75.png',
                            'bw_image' => 'location_75_bw.png',
                        ],
                        [
                            'id' => 'location_100',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 100 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 100 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 100 ),
                            'value' => 100,
                            'image' => 'location_100.png',
                            'bw_image' => 'location_100_bw.png',
                        ],
                        [
                            'id' => 'location_150',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 150 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 150 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 150 ),
                            'value' => 150,
                            'image' => 'location_150.png',
                            'bw_image' => 'location_150_bw.png',
                        ],
                        [
                            'id' => 'location_200',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 200 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 200 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 200 ),
                            'value' => 200,
                            'image' => 'location_200.png',
                            'bw_image' => 'location_200_bw.png',
                        ],
                        [
                            'id' => 'location_250',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 250 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 250 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 250 ),
                            'value' => 250,
                            'image' => 'location_250.png',
                            'bw_image' => 'location_250_bw.png',
                        ],
                    ]
                ],
                [
                    'id' => self::ID_WHOLE_WORLD,
                    'type' => self::TYPE_ACHIEVEMENT,
                    'title' => __( 'Whole World', 'prayer-global-porch' ),
                    'description_unearned' => __( 'Earn this badge by praying for the whole world', 'prayer-global-porch' ),
                    'description_earned' => __( 'You earned this badge by praying for the whole world', 'prayer-global-porch' ),
                    'value' => 1,
                    'image' => 'whole_world.png',
                    'bw_image' => 'whole_world_bw.png',
                ]
            ],
            self::CATEGORY_MOBILIZATION => [
                [
                    'id' => self::ID_TEAM_PLAYER,
                    'type' => self::TYPE_ACHIEVEMENT,
                    'title' => __( 'Team Player', 'prayer-global-porch' ),
                    'description_unearned' => __( 'Earn this badge by joining a relay', 'prayer-global-porch' ),
                    'description_earned' => __( 'You earned this badge by joining a relay', 'prayer-global-porch' ),
                    'priority' => 2,
                    'value' => 1,
                    'image' => 'team_player.png',
                    'bw_image' => 'team_player_bw.png',
                ],
                [
                    'id' => self::ID_FIRST_PRAYER_RELAY,
                    'type' => self::TYPE_ACHIEVEMENT,
                    'title' => __( 'First Prayer Relay', 'prayer-global-porch' ),
                    'description_unearned' => __( 'Earn this badge by creating your first relay', 'prayer-global-porch' ),
                    'description_earned' => __( 'You earned this badge by creating your first relay', 'prayer-global-porch' ),
                    'priority' => 4,
                    'value' => 1,
                    'image' => 'first_prayer_relay.png',
                    'bw_image' => 'first_prayer_relay_bw.png',
                ],
                [
                    'id' => self::ID_RELAY_COMPLETED_PARTICIPANT,
                    'type' => self::TYPE_ACHIEVEMENT,
                    'title' => __( 'Relay Completed - Participant', 'prayer-global-porch' ),
                    'description_unearned' => __( 'Earn this badge by helping to complete a relay', 'prayer-global-porch' ),
                    'description_earned' => __( 'You earned this badge by helping to complete a relay', 'prayer-global-porch' ),
                    'priority' => 10,
                    'value' => 1,
                    'image' => 'relay_completed.png',
                    'bw_image' => 'relay_completed_bw.png',
                ],
                [
                    'id' => self::ID_RELAY_COMPLETED_ORGANIZER,
                    'type' => self::TYPE_ACHIEVEMENT,
                    'title' => __( 'Relay Completed - Organizer', 'prayer-global-porch' ),
                    'description_unearned' => __( 'Earn this badge by organizing a relay that gets completed', 'prayer-global-porch' ),
                    'description_earned' => __( 'You earned this badge by organizing a relay that gets completed', 'prayer-global-porch' ),
                    'priority' => 10,
                    'value' => 1,
                    'image' => 'relay_completed.png',
                    'bw_image' => 'relay_completed_bw.png',
                ],
                [
                    'id' => self::ID_PRAYER_MOBILIZER,
                    'type' => self::TYPE_PROGRESSION,
                    'priority' => 5,
                    'progression_badges' => [
                        [
                            'id' => 'prayer_mobilizer_10',
                            'title' => sprintf( __( 'Mobilize %d People', 'prayer-global-porch' ), 10 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by mobilizing %d people to pray on your relay', 'prayer-global-porch' ), 10 ),
                            'description_earned' => sprintf( __( 'You earned this badge by mobilizing %d people to pray on your relay', 'prayer-global-porch' ), 10 ),
                            'value' => 10,
                            'image' => 'prayer_mobilizer_10.png',
                            'bw_image' => 'prayer_mobilizer_10_bw.png',
                        ],
                        [
                            'id' => 'prayer_mobilizer_25',
                            'title' => sprintf( __( 'Mobilize %d People', 'prayer-global-porch' ), 25 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by mobilizing %d people to pray on your relay', 'prayer-global-porch' ), 25 ),
                            'description_earned' => sprintf( __( 'You earned this badge by mobilizing %d people to pray on your relay', 'prayer-global-porch' ), 25 ),
                            'value' => 25,
                            'image' => 'prayer_mobilizer_25.png',
                            'bw_image' => 'prayer_mobilizer_25_bw.png',
                        ],
                        [
                            'id' => 'prayer_mobilizer_50',
                            'title' => sprintf( __( 'Mobilize %d People', 'prayer-global-porch' ), 50 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by mobilizing %d people to pray on your relay', 'prayer-global-porch' ), 50 ),
                            'description_earned' => sprintf( __( 'You earned this badge by mobilizing %d people to pray on your relay', 'prayer-global-porch' ), 50 ),
                            'value' => 50,
                            'image' => 'prayer_mobilizer_50.png',
                            'bw_image' => 'prayer_mobilizer_50_bw.png',
                        ],
                        [
                            'id' => 'prayer_mobilizer_100',
                            'title' => sprintf( __( 'Mobilize %d People', 'prayer-global-porch' ), 100 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by mobilizing %d people to pray on your relay', 'prayer-global-porch' ), 100 ),
                            'description_earned' => sprintf( __( 'You earned this badge by mobilizing %d people to pray on your relay', 'prayer-global-porch' ), 100 ),
                            'value' => 100,
                            'image' => 'prayer_mobilizer_100.png',
                            'bw_image' => 'prayer_mobilizer_100_bw.png',
                        ]
                    ],
                ],
                [
                    'id' => self::ID_RELAY_LOCATION,
                    'type' => self::TYPE_PROGRESSION,
                    'priority' => 6,
                    'progression_badges' => [
                        [
                            'id' => 'relay_location_25',
                            'title' => sprintf( __( '%d Relay Locations', 'prayer-global-porch' ), 25 ),
                            'description_unearned' => sprintf( __( 'Earn this badge when your relays have %d locations prayed for.', 'prayer-global-porch' ), 25 ),
                            'description_earned' => sprintf( __( 'You earned this badge when your relays had %d locations prayed for.', 'prayer-global-porch' ), 25 ),
                            'value' => 25,
                            'image' => 'location_25.png',
                            'bw_image' => 'location_25_bw.png',
                        ],
                        [
                            'id' => 'relay_location_50',
                            'title' => sprintf( __( '%d Relay Locations', 'prayer-global-porch' ), 50 ),
                            'description_unearned' => sprintf( __( 'Earn this badge when your relays have %d locations prayed for.', 'prayer-global-porch' ), 50 ),
                            'description_earned' => sprintf( __( 'You earned this badge when your relays had %d locations prayed for.', 'prayer-global-porch' ), 50 ),
                            'value' => 50,
                            'image' => 'location_50.png',
                            'bw_image' => 'location_50_bw.png',
                        ],
                        [
                            'id' => 'relay_location_75',
                            'title' => sprintf( __( '%d Relay Locations', 'prayer-global-porch' ), 75 ),
                            'description_unearned' => sprintf( __( 'Earn this badge when your relays have %d locations prayed for.', 'prayer-global-porch' ), 75 ),
                            'description_earned' => sprintf( __( 'You earned this badge when your relays had %d locations prayed for.', 'prayer-global-porch' ), 75 ),
                            'value' => 75,
                            'image' => 'location_75.png',
                            'bw_image' => 'location_75_bw.png',
                        ],
                        [
                            'id' => 'relay_location_100',
                            'title' => sprintf( __( '%d Relay Locations', 'prayer-global-porch' ), 100 ),
                            'description_unearned' => sprintf( __( 'Earn this badge when your relays have %d locations prayed for.', 'prayer-global-porch' ), 100 ),
                            'description_earned' => sprintf( __( 'You earned this badge when your relays had %d locations prayed for.', 'prayer-global-porch' ), 100 ),
                            'value' => 100,
                            'image' => 'location_100.png',
                            'bw_image' => 'location_100_bw.png',
                        ],
                        [
                            'id' => 'relay_location_150',
                            'title' => sprintf( __( '%d Relay Locations', 'prayer-global-porch' ), 150 ),
                            'description_unearned' => sprintf( __( 'Earn this badge when your relays have %d locations prayed for.', 'prayer-global-porch' ), 150 ),
                            'description_earned' => sprintf( __( 'You earned this badge when your relays had %d locations prayed for.', 'prayer-global-porch' ), 150 ),
                            'value' => 150,
                            'image' => 'location_150.png',
                            'bw_image' => 'location_150_bw.png',
                        ],
                        [
                            'id' => 'relay_location_200',
                            'title' => sprintf( __( '%d Relay Locations', 'prayer-global-porch' ), 200 ),
                            'description_unearned' => sprintf( __( 'Earn this badge when your relays have %d locations prayed for.', 'prayer-global-porch' ), 200 ),
                            'description_earned' => sprintf( __( 'You earned this badge when your relays had %d locations prayed for.', 'prayer-global-porch' ), 200 ),
                            'value' => 200,
                            'image' => 'location_200.png',
                            'bw_image' => 'location_200_bw.png',
                        ],
                        [
                            'id' => 'relay_location_250',
                            'title' => sprintf( __( '%d Relay Locations', 'prayer-global-porch' ), 250 ),
                            'description_unearned' => sprintf( __( 'Earn this badge when your relays have %d locations prayed for.', 'prayer-global-porch' ), 250 ),
                            'description_earned' => sprintf( __( 'You earned this badge when your relays had %d locations prayed for.', 'prayer-global-porch' ), 250 ),
                            'value' => 250,
                            'image' => 'location_250.png',
                            'bw_image' => 'location_250_bw.png',
                        ],
                    ]
                ]
            ],
            self::CATEGORY_CONSISTENCY => [
                [
                    'id' => self::ID_PERFECT_WEEK,
                    'type' => self::TYPE_MULTIPLE,
                    'title' => __( 'Perfect Week ', 'prayer-global-porch' ),
                    'description_unearned' => __( 'Earn this badge by praying every day for a week', 'prayer-global-porch' ),
                    'description_earned' => __( 'You have earned this badge by praying every day for a week', 'prayer-global-porch' ),
                    'image' => 'perfect_week.png',
                    'bw_image' => 'perfect_week_bw.png',
                    'priority' => 2,
                    'value' => 7,
                ],
                [
                    'id' => self::ID_PERFECT_MONTH,
                    'type' => self::TYPE_MULTIPLE,
                    'title' => __( 'Perfect Month ', 'prayer-global-porch' ),
                    'description_unearned' => __( 'Earn this badge by praying every day this month', 'prayer-global-porch' ),
                    'description_earned' => __( 'You have earned this badge by praying every day this month', 'prayer-global-porch' ),
                    'image' => 'perfect_month.png',
                    'bw_image' => 'perfect_month_bw.png',
                    'value' => 30,
                ],
                [
                    'id' => self::ID_PERFECT_YEAR,
                    'type' => self::TYPE_MULTIPLE,
                    'title' => __( 'Perfect Year ', 'prayer-global-porch' ),
                    'description_unearned' => __( 'Earn this badge by praying every day this year', 'prayer-global-porch' ),
                    'description_earned' => __( 'You have earned this badge by praying every day this year', 'prayer-global-porch' ),
                    'image' => 'mystery_badge.png',
                    'bw_image' => 'mystery_badge.png',
                    'value' => 365,
                ],
                [
                    'id' => self::ID_MONTHLY_CHALLENGE,
                    'type' => self::TYPE_MONTHLY_CHALLENGE,
                    'title' => __( '%1$s %2$d Challenge', 'prayer-global-porch' ),
                    'description_unearned' => __( 'Earn this badge by praying for %1$d days in %2$s', 'prayer-global-porch' ),
                    'description_earned' => __( 'You earned this badge by praying for %1$d days in %2$s', 'prayer-global-porch' ),
                    'value' => 27,
                ],
                [
                    'id' => self::ID_STREAK,
                    'type' => self::TYPE_PROGRESSION,
                    'priority' => 3,
                    'progression_badges' => [
                        [
                            'id' => 'streak_10',
                            'title' => sprintf( __( '%d Day Streak', 'prayer-global-porch' ), 10 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d days straight', 'prayer-global-porch' ), 10 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d days straight', 'prayer-global-porch' ), 10 ),
                            'value' => 10,
                            'image' => 'streak_10.png',
                            'bw_image' => 'streak_10_bw.png',
                        ],
                        [
                            'id' => 'streak_20',
                            'title' => sprintf( __( '%d Day Streak', 'prayer-global-porch' ), 20 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d days straight', 'prayer-global-porch' ), 20 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d days straight', 'prayer-global-porch' ), 20 ),
                            'value' => 20,
                            'image' => 'streak_20.png',
                            'bw_image' => 'streak_20_bw.png',
                        ],
                        [
                            'id' => 'streak_30',
                            'title' => sprintf( __( '%d Day Streak', 'prayer-global-porch' ), 30 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d days straight', 'prayer-global-porch' ), 30 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d days straight', 'prayer-global-porch' ), 30 ),
                            'value' => 30,
                            'image' => 'streak_30.png',
                            'bw_image' => 'streak_30_bw.png',
                        ],
                        [
                            'id' => 'streak_40',
                            'title' => sprintf( __( '%d Day Streak', 'prayer-global-porch' ), 40 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d days straight', 'prayer-global-porch' ), 40 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d days straight', 'prayer-global-porch' ), 40 ),
                            'value' => 40,
                            'image' => 'streak_40.png',
                            'bw_image' => 'streak_40_bw.png',
                        ],
                    ],
                ],
            ],
            self::CATEGORY_RE_ENGAGEMENT => [
                [
                    'id' => self::ID_COMEBACK_CHAMPION,
                    'type' => self::TYPE_ACHIEVEMENT,
                    'title' => __( 'Comeback Champion', 'prayer-global-porch' ),
                    'description_unearned' => '',
                    'description_earned' => __( 'You earned this badge by restarting praying after breaking a streak', 'prayer-global-porch' ),
                    'value' => 1,
                    'image' => 'mystery_badge.png',
                    'bw_image' => 'mystery_badge.png',
                    'hidden' => true,
                ],
            ],
        ];

        $all_badges = [];
        foreach ( $badges as $category_name => $category_badges ) {
            $all_badges[$category_name] = [];
            foreach ( $category_badges as $badge ) {
                if ( $badge['type'] === self::TYPE_PROGRESSION ) {
                    $all_badges[$category_name][$badge['id']] = $this->create_badge( $badge, $category_name, $badge['type'] );
                } else {
                    $all_badges[$category_name][$badge['id']] = $this->create_badge( $badge, $category_name, $badge['type'] );
                }
            }
        }
        $this->badges = $all_badges;
    }

    private function create_badge( array $badge, string $category_name, string $type ): PG_Badge {
        $progression_badges = [];
        $root_badge = $badge;
        if ( $type === self::TYPE_PROGRESSION && isset( $badge['progression_badges'] ) ) {
            // replace root of progression badge with first badge in progression
            $root_badge = $badge['progression_badges'][array_keys( $badge['progression_badges'] )[0] ];
            foreach ( $badge['progression_badges'] as $progression_badge ) {
                $progression_badges[$progression_badge['id']] = $this->create_badge( $progression_badge, $category_name, $badge['type'] );
            }
        }
        return new PG_Badge(
            $badge['id'],
            $root_badge['title'] ?? '',
            $root_badge['description_unearned'] ?? '',
            $root_badge['description_earned'] ?? '',
            $root_badge['image'] ?? '',
            $root_badge['bw_image'] ?? '',
            $category_name,
            $badge['priority'] ?? 10000,
            $root_badge['value'] ?? 0,
            $type,
            $progression_badges,
            $badge['hidden'] ?? false,
            $badge['deprecated'] ?? false
        );
    }

    /**
     * Does the category exist
     * @param string $category
     * @return bool
     */
    public function has_category( string $category ): bool {
        return isset( $this->badges[$category] );
    }

    /**
     * Get the badges in this category
     * @param string $category
     * @return array<PG_Badge>
     */
    public function get_category_badges( string $category ): array {
        return $this->badges[$category];
    }

    /**
     * Get all the badges
     * @return array<PG_Badge>
     */
    public function get_all_badges(): array {
        $all_badges = [];
        foreach ( $this->badges as $badges ) {
            $all_badges = array_merge( $all_badges, $badges );
        }
        return $all_badges;
    }

    public function get_badge( string $badge_id ): ?PG_Badge {
        $all_badges = $this->get_all_badges();

        foreach ( $all_badges as $badge ) {
            if ( $badge->get_type() === self::TYPE_PROGRESSION ) {
                $all_badges = array_merge( $all_badges, $badge->get_progression_badges() );
            }
        }

        if ( isset( $all_badges[$badge_id] ) ) {
            return $all_badges[$badge_id];
        }
        return null;
    }

    /**
     * Get the available categories
     * @return array<string>
     */
    public function get_categories(): array {
        return array_keys( $this->badges );
    }
}
