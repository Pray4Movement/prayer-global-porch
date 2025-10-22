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
    public ?array $priorities = null;

    public function __construct() {
        $this->priorities = [
            self::ID_LOCATION => 1,
            self::ID_TEAM_PLAYER => 2,
            self::ID_FIRST_PRAYER_RELAY => 2,
            self::ID_PERFECT_WEEK => 2,
            self::ID_PRAYER_MOBILIZER => 3,
            self::ID_STREAK => 4,
            self::ID_RELAY_LOCATION => 6,
            self::ID_RELAY_COMPLETED_PARTICIPANT => 10,
            self::ID_RELAY_COMPLETED_ORGANIZER => 10,
        ];
        $badges = [
            self::CATEGORY_LOCATION => [
                [
                    'id' => self::ID_LOCATION,
                    'type' => self::TYPE_PROGRESSION,
                    'priority' => $this->priorities[self::ID_LOCATION],
                    'progression_badges' => [
                        [
                            'id' => 'location_10',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 10 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 10 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 10 ),
                            'value' => 10,
                            'image' => 'location_10.png',
                            'bw_image' => 'location_10_bw.png',
                        ],
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
                        [
                            'id' => 'location_300',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 300 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 300 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 300 ),
                            'value' => 300,
                            'image' => 'location_300.png',
                            'bw_image' => 'location_300_bw.png',
                        ],
                        [
                            'id' => 'location_400',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 400 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 400 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 400 ),
                            'value' => 400,
                            'image' => 'location_400.png',
                            'bw_image' => 'location_400_bw.png',
                        ],
                        [
                            'id' => 'location_500',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 500 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 500 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 500 ),
                            'value' => 500,
                            'image' => 'location_500.png',
                            'bw_image' => 'location_500_bw.png',
                        ],
                        [
                            'id' => 'location_600',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 600 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 600 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 600 ),
                            'value' => 600,
                            'image' => 'location_600.png',
                            'bw_image' => 'location_600_bw.png',
                        ],
                        [
                            'id' => 'location_700',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 700 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 700 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 700 ),
                            'value' => 700,
                            'image' => 'location_700.png',
                            'bw_image' => 'location_700_bw.png',
                        ],
                        [
                            'id' => 'location_800',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 800 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 800 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 800 ),
                            'value' => 800,
                            'image' => 'location_800.png',
                            'bw_image' => 'location_800_bw.png',
                        ],
                        [
                            'id' => 'location_900',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 900 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 900 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 900 ),
                            'value' => 900,
                            'image' => 'location_900.png',
                            'bw_image' => 'location_900_bw.png',
                        ],
                        [
                            'id' => 'location_1000',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 1000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 1000 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 1000 ),
                            'value' => 1000,
                            'image' => 'location_1000.png',
                            'bw_image' => 'location_1000_bw.png',
                        ],
                        [
                            'id' => 'location_1500',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 1500 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 1500 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 1500 ),
                            'value' => 1500,
                            'image' => 'location_1500.png',
                            'bw_image' => 'location_1500_bw.png',
                        ],
                        [
                            'id' => 'location_2000',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 2000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 2000 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 2000 ),
                            'value' => 2000,
                            'image' => 'location_2000.png',
                            'bw_image' => 'location_2000_bw.png',
                        ],
                        [
                            'id' => 'location_2500',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 2500 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 2500 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 2500 ),
                            'value' => 2500,
                            'image' => 'location_2500.png',
                            'bw_image' => 'location_2500_bw.png',
                        ],
                        [
                            'id' => 'location_3000',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 3000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 3000 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 3000 ),
                            'value' => 3000,
                            'image' => 'location_3000.png',
                            'bw_image' => 'location_3000_bw.png',
                        ],
                        [
                            'id' => 'location_3500',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 3500 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 3500 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 3500 ),
                            'value' => 3500,
                            'image' => 'location_3500.png',
                            'bw_image' => 'location_3500_bw.png',
                        ],
                        [
                            'id' => 'location_4000',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 4000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 4000 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 4000 ),
                            'value' => 4000,
                            'image' => 'location_4000.png',
                            'bw_image' => 'location_4000_bw.png',
                        ],
                        [
                            'id' => 'location_4500',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 4500 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 4500 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 4500 ),
                            'value' => 4500,
                            'image' => 'location_4500.png',
                            'bw_image' => 'location_4500_bw.png',
                        ],
                        [
                            'id' => 'location_5000',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 5000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 5000 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 5000 ),
                            'value' => 5000,
                            'image' => 'location_5000.png',
                            'bw_image' => 'location_5000_bw.png',
                        ],
                        [
                            'id' => 'location_6000',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 6000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 6000 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 6000 ),
                            'value' => 6000,
                            'image' => 'location_6000.png',
                            'bw_image' => 'location_6000_bw.png',
                        ],
                        [
                            'id' => 'location_7000',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 7000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 7000 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 7000 ),
                            'value' => 7000,
                            'image' => 'location_7000.png',
                            'bw_image' => 'location_7000_bw.png',
                        ],
                        [
                            'id' => 'location_8000',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 8000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 8000 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 8000 ),
                            'value' => 8000,
                            'image' => 'location_8000.png',
                            'bw_image' => 'location_8000_bw.png',
                        ],
                        [
                            'id' => 'location_9000',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 9000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 9000 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 9000 ),
                            'value' => 9000,
                            'image' => 'location_9000.png',
                            'bw_image' => 'location_9000_bw.png',
                        ],
                        [
                            'id' => 'location_10000',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 10000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 10000 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 10000 ),
                            'value' => 10000,
                            'image' => 'location_10000.png',
                            'bw_image' => 'location_10000_bw.png',
                        ],
                        [
                            'id' => 'location_12500',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 12500 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 12500 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 12500 ),
                            'value' => 12500,
                            'image' => 'location_12500.png',
                            'bw_image' => 'location_12500_bw.png',
                        ],
                        [
                            'id' => 'location_15000',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 15000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 15000 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 15000 ),
                            'value' => 15000,
                            'image' => 'location_15000.png',
                            'bw_image' => 'location_15000_bw.png',
                        ],
                        [
                            'id' => 'location_17500',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 17500 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 17500 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 17500 ),
                            'value' => 17500,
                            'image' => 'location_17500.png',
                            'bw_image' => 'location_17500_bw.png',
                        ],
                        [
                            'id' => 'location_20000',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 20000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 20000 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 20000 ),
                            'value' => 20000,
                            'image' => 'location_20000.png',
                            'bw_image' => 'location_20000_bw.png',
                        ],
                        [
                            'id' => 'location_25000',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 25000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 25000 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 25000 ),
                            'value' => 25000,
                            'image' => 'location_25000.png',
                            'bw_image' => 'location_25000_bw.png',
                        ],
                        [
                            'id' => 'location_30000',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 30000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 30000 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 30000 ),
                            'value' => 30000,
                            'image' => 'location_30000.png',
                            'bw_image' => 'location_30000_bw.png',
                        ],
                        [
                            'id' => 'location_35000',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 35000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 35000 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 35000 ),
                            'value' => 35000,
                            'image' => 'location_35000.png',
                            'bw_image' => 'location_35000_bw.png',
                        ],
                        [
                            'id' => 'location_40000',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 40000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 40000 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 40000 ),
                            'value' => 40000,
                            'image' => 'location_40000.png',
                            'bw_image' => 'location_40000_bw.png',
                        ],
                        [
                            'id' => 'location_45000',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 45000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 45000 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 45000 ),
                            'value' => 45000,
                            'image' => 'location_45000.png',
                            'bw_image' => 'location_45000_bw.png',
                        ],
                        [
                            'id' => 'location_50000',
                            'title' => sprintf( __( '%d Locations', 'prayer-global-porch' ), 50000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 50000 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d locations in a relay', 'prayer-global-porch' ), 50000 ),
                            'value' => 50000,
                            'image' => 'location_50000.png',
                            'bw_image' => 'location_50000_bw.png',
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
                    'image' => 'WorldChanger.png',
                    'bw_image' => 'WorldChanger_bw.png',
                ]
            ],
            self::CATEGORY_MOBILIZATION => [
                [
                    'id' => self::ID_TEAM_PLAYER,
                    'type' => self::TYPE_ACHIEVEMENT,
                    'title' => __( 'Team Player', 'prayer-global-porch' ),
                    'description_unearned' => __( 'Earn this badge by joining a relay', 'prayer-global-porch' ),
                    'description_earned' => __( 'You earned this badge by joining a relay', 'prayer-global-porch' ),
                    'priority' => $this->priorities[self::ID_TEAM_PLAYER],
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
                    'priority' => $this->priorities[self::ID_FIRST_PRAYER_RELAY],
                    'value' => 1,
                    'image' => 'FirstPrayerRelay.png',
                    'bw_image' => 'FirstPrayerRelay_bw.png',
                ],
                [
                    'id' => self::ID_RELAY_COMPLETED_PARTICIPANT,
                    'type' => self::TYPE_ACHIEVEMENT,
                    'title' => __( 'Relay Completed - Participant', 'prayer-global-porch' ),
                    'description_unearned' => __( 'Earn this badge by helping to complete a relay', 'prayer-global-porch' ),
                    'description_earned' => __( 'You earned this badge by helping to complete a relay', 'prayer-global-porch' ),
                    'priority' => $this->priorities[self::ID_RELAY_COMPLETED_PARTICIPANT],
                    'value' => 1,
                    'image' => 'RelayCompleted_Participant.png',
                    'bw_image' => 'RelayCompleted_Participant_bw.png',
                ],
                [
                    'id' => self::ID_RELAY_COMPLETED_ORGANIZER,
                    'type' => self::TYPE_ACHIEVEMENT,
                    'title' => __( 'Relay Completed - Leader', 'prayer-global-porch' ),
                    'description_unearned' => __( 'Earn this badge by starting a relay that gets completed', 'prayer-global-porch' ),
                    'description_earned' => __( 'You earned this badge by starting a relay that gets completed', 'prayer-global-porch' ),
                    'priority' => $this->priorities[self::ID_RELAY_COMPLETED_ORGANIZER],
                    'value' => 1,
                    'image' => 'RelayCompleted_Leader.png',
                    'bw_image' => 'RelayCompleted_Leader_bw.png',
                ],
                [
                    'id' => self::ID_PRAYER_MOBILIZER,
                    'type' => self::TYPE_PROGRESSION,
                    'priority' => $this->priorities[self::ID_PRAYER_MOBILIZER],
                    'progression_badges' => [
                        [
                            'id' => 'prayer_mobilizer_5',
                            'title' => sprintf( __( 'Mobilize %d People', 'prayer-global-porch' ), 5 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by mobilizing %d people to pray on your relay', 'prayer-global-porch' ), 5 ),
                            'description_earned' => sprintf( __( 'You earned this badge by mobilizing %d people to pray on your relay', 'prayer-global-porch' ), 5 ),
                            'value' => 5,
                            'image' => 'prayer_mobilizer_5.png',
                            'bw_image' => 'prayer_mobilizer_5_bw.png',
                        ],
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
                            'id' => 'prayer_mobilizer_20',
                            'title' => sprintf( __( 'Mobilize %d People', 'prayer-global-porch' ), 20 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by mobilizing %d people to pray on your relay', 'prayer-global-porch' ), 20 ),
                            'description_earned' => sprintf( __( 'You earned this badge by mobilizing %d people to pray on your relay', 'prayer-global-porch' ), 20 ),
                            'value' => 20,
                            'image' => 'prayer_mobilizer_20.png',
                            'bw_image' => 'prayer_mobilizer_20_bw.png',
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
                        ],
                        [
                            'id' => 'prayer_mobilizer_250',
                            'title' => sprintf( __( 'Mobilize %d People', 'prayer-global-porch' ), 250 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by mobilizing %d people to pray on your relay', 'prayer-global-porch' ), 250 ),
                            'description_earned' => sprintf( __( 'You earned this badge by mobilizing %d people to pray on your relay', 'prayer-global-porch' ), 250 ),
                            'value' => 250,
                            'image' => 'prayer_mobilizer_250.png',
                            'bw_image' => 'prayer_mobilizer_250_bw.png',
                        ],
                        [
                            'id' => 'prayer_mobilizer_500',
                            'title' => sprintf( __( 'Mobilize %d People', 'prayer-global-porch' ), 500 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by mobilizing %d people to pray on your relay', 'prayer-global-porch' ), 500 ),
                            'description_earned' => sprintf( __( 'You earned this badge by mobilizing %d people to pray on your relay', 'prayer-global-porch' ), 500 ),
                            'value' => 500,
                            'image' => 'prayer_mobilizer_500.png',
                            'bw_image' => 'prayer_mobilizer_500_bw.png',
                        ],
                        [
                            'id' => 'prayer_mobilizer_1000',
                            'title' => sprintf( __( 'Mobilize %d People', 'prayer-global-porch' ), 1000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by mobilizing %d people to pray on your relay', 'prayer-global-porch' ), 1000 ),
                            'description_earned' => sprintf( __( 'You earned this badge by mobilizing %d people to pray on your relay', 'prayer-global-porch' ), 1000 ),
                            'value' => 1000,
                            'image' => 'prayer_mobilizer_1000.png',
                            'bw_image' => 'prayer_mobilizer_1000_bw.png',
                        ],
                        [
                            'id' => 'prayer_mobilizer_1500',
                            'title' => sprintf( __( 'Mobilize %d People', 'prayer-global-porch' ), 100 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by mobilizing %d people to pray on your relay', 'prayer-global-porch' ), 1500 ),
                            'description_earned' => sprintf( __( 'You earned this badge by mobilizing %d people to pray on your relay', 'prayer-global-porch' ), 1500 ),
                            'value' => 1500,
                            'image' => 'prayer_mobilizer_1500.png',
                            'bw_image' => 'prayer_mobilizer_1500_bw.png',
                        ],
                        [
                            'id' => 'prayer_mobilizer_2000',
                            'title' => sprintf( __( 'Mobilize %d People', 'prayer-global-porch' ), 2000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by mobilizing %d people to pray on your relay', 'prayer-global-porch' ), 2000 ),
                            'description_earned' => sprintf( __( 'You earned this badge by mobilizing %d people to pray on your relay', 'prayer-global-porch' ), 2000 ),
                            'value' => 2000,
                            'image' => 'prayer_mobilizer_2000.png',
                            'bw_image' => 'prayer_mobilizer_2000_bw.png',
                        ],
                        [
                            'id' => 'prayer_mobilizer_2500',
                            'title' => sprintf( __( 'Mobilize %d People', 'prayer-global-porch' ), 2500 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by mobilizing %d people to pray on your relay', 'prayer-global-porch' ), 2500 ),
                            'description_earned' => sprintf( __( 'You earned this badge by mobilizing %d people to pray on your relay', 'prayer-global-porch' ), 2500 ),
                            'value' => 2500,
                            'image' => 'prayer_mobilizer_2500.png',
                            'bw_image' => 'prayer_mobilizer_2500_bw.png',
                        ],
                        [
                            'id' => 'prayer_mobilizer_5000',
                            'title' => sprintf( __( 'Mobilize %d People', 'prayer-global-porch' ), 5000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by mobilizing %d people to pray on your relay', 'prayer-global-porch' ), 5000 ),
                            'description_earned' => sprintf( __( 'You earned this badge by mobilizing %d people to pray on your relay', 'prayer-global-porch' ), 5000 ),
                            'value' => 5000,
                            'image' => 'prayer_mobilizer_5000.png',
                            'bw_image' => 'prayer_mobilizer_5000_bw.png',
                        ],
                    ],
                ],
                [
                    'id' => self::ID_RELAY_LOCATION,
                    'type' => self::TYPE_PROGRESSION,
                    'priority' => $this->priorities[self::ID_RELAY_LOCATION],
                    'progression_badges' => [
                        [
                            'id' => 'team_location_100',
                            'title' => sprintf( __( '%d Relay Locations', 'prayer-global-porch' ), 100 ),
                            'description_unearned' => sprintf( __( 'Earn this badge when your relays have %d locations prayed for.', 'prayer-global-porch' ), 100 ),
                            'description_earned' => sprintf( __( 'You earned this badge when your relays had %d locations prayed for.', 'prayer-global-porch' ), 100 ),
                            'value' => 100,
                            'image' => 'team_location_100.png',
                            'bw_image' => 'team_location_100_bw.png',
                        ],
                        [
                            'id' => 'team_location_500',
                            'title' => sprintf( __( '%d Relay Locations', 'prayer-global-porch' ), 500 ),
                            'description_unearned' => sprintf( __( 'Earn this badge when your relays have %d locations prayed for.', 'prayer-global-porch' ), 500 ),
                            'description_earned' => sprintf( __( 'You earned this badge when your relays had %d locations prayed for.', 'prayer-global-porch' ), 500 ),
                            'value' => 500,
                            'image' => 'team_location_500.png',
                            'bw_image' => 'team_location_500_bw.png',
                        ],
                        [
                            'id' => 'team_location_1000',
                            'title' => sprintf( __( '%d Relay Locations', 'prayer-global-porch' ), 1000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge when your relays have %d locations prayed for.', 'prayer-global-porch' ), 1000 ),
                            'description_earned' => sprintf( __( 'You earned this badge when your relays had %d locations prayed for.', 'prayer-global-porch' ), 1000 ),
                            'value' => 1000,
                            'image' => 'team_location_1000.png',
                            'bw_image' => 'team_location_1000_bw.png',
                        ],
                        [
                            'id' => 'team_location_2000',
                            'title' => sprintf( __( '%d Relay Locations', 'prayer-global-porch' ), 2000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge when your relays have %d locations prayed for.', 'prayer-global-porch' ), 2000 ),
                            'description_earned' => sprintf( __( 'You earned this badge when your relays had %d locations prayed for.', 'prayer-global-porch' ), 2000 ),
                            'value' => 2000,
                            'image' => 'team_location_2000.png',
                            'bw_image' => 'team_location_2000_bw.png',
                        ],
                        [
                            'id' => 'team_location_3000',
                            'title' => sprintf( __( '%d Relay Locations', 'prayer-global-porch' ), 3000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge when your relays have %d locations prayed for.', 'prayer-global-porch' ), 3000 ),
                            'description_earned' => sprintf( __( 'You earned this badge when your relays had %d locations prayed for.', 'prayer-global-porch' ), 3000 ),
                            'value' => 3000,
                            'image' => 'team_location_3000.png',
                            'bw_image' => 'team_location_3000_bw.png',
                        ],
                        [
                            'id' => 'team_location_4000',
                            'title' => sprintf( __( '%d Relay Locations', 'prayer-global-porch' ), 4000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge when your relays have %d locations prayed for.', 'prayer-global-porch' ), 4000 ),
                            'description_earned' => sprintf( __( 'You earned this badge when your relays had %d locations prayed for.', 'prayer-global-porch' ), 4000 ),
                            'value' => 4000,
                            'image' => 'team_location_4000.png',
                            'bw_image' => 'team_location_4000_bw.png',
                        ],
                        [
                            'id' => 'team_location_5000',
                            'title' => sprintf( __( '%d Relay Locations', 'prayer-global-porch' ), 5000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge when your relays have %d locations prayed for.', 'prayer-global-porch' ), 5000 ),
                            'description_earned' => sprintf( __( 'You earned this badge when your relays had %d locations prayed for.', 'prayer-global-porch' ), 5000 ),
                            'value' => 5000,
                            'image' => 'team_location_5000.png',
                            'bw_image' => 'team_location_5000_bw.png',
                        ],
                        [
                            'id' => 'team_location_6000',
                            'title' => sprintf( __( '%d Relay Locations', 'prayer-global-porch' ), 6000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge when your relays have %d locations prayed for.', 'prayer-global-porch' ), 6000 ),
                            'description_earned' => sprintf( __( 'You earned this badge when your relays had %d locations prayed for.', 'prayer-global-porch' ), 6000 ),
                            'value' => 6000,
                            'image' => 'team_location_6000.png',
                            'bw_image' => 'team_location_6000_bw.png',
                        ],
                        [
                            'id' => 'team_location_7000',
                            'title' => sprintf( __( '%d Relay Locations', 'prayer-global-porch' ), 7000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge when your relays have %d locations prayed for.', 'prayer-global-porch' ), 7000 ),
                            'description_earned' => sprintf( __( 'You earned this badge when your relays had %d locations prayed for.', 'prayer-global-porch' ), 7000 ),
                            'value' => 7000,
                            'image' => 'team_location_7000.png',
                            'bw_image' => 'team_location_7000_bw.png',
                        ],
                        [
                            'id' => 'team_location_8000',
                            'title' => sprintf( __( '%d Relay Locations', 'prayer-global-porch' ), 8000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge when your relays have %d locations prayed for.', 'prayer-global-porch' ), 8000 ),
                            'description_earned' => sprintf( __( 'You earned this badge when your relays had %d locations prayed for.', 'prayer-global-porch' ), 8000 ),
                            'value' => 8000,
                            'image' => 'team_location_8000.png',
                            'bw_image' => 'team_location_8000_bw.png',
                        ],
                        [
                            'id' => 'team_location_9000',
                            'title' => sprintf( __( '%d Relay Locations', 'prayer-global-porch' ), 9000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge when your relays have %d locations prayed for.', 'prayer-global-porch' ), 9000 ),
                            'description_earned' => sprintf( __( 'You earned this badge when your relays had %d locations prayed for.', 'prayer-global-porch' ), 9000 ),
                            'value' => 9000,
                            'image' => 'team_location_9000.png',
                            'bw_image' => 'team_location_9000_bw.png',
                        ],
                        [
                            'id' => 'team_location_10000',
                            'title' => sprintf( __( '%d Relay Locations', 'prayer-global-porch' ), 10000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge when your relays have %d locations prayed for.', 'prayer-global-porch' ), 10000 ),
                            'description_earned' => sprintf( __( 'You earned this badge when your relays had %d locations prayed for.', 'prayer-global-porch' ), 10000 ),
                            'value' => 10000,
                            'image' => 'team_location_10000.png',
                            'bw_image' => 'team_location_10000_bw.png',
                        ],
                        [
                            'id' => 'team_location_12500',
                            'title' => sprintf( __( '%d Relay Locations', 'prayer-global-porch' ), 12500 ),
                            'description_unearned' => sprintf( __( 'Earn this badge when your relays have %d locations prayed for.', 'prayer-global-porch' ), 12500 ),
                            'description_earned' => sprintf( __( 'You earned this badge when your relays had %d locations prayed for.', 'prayer-global-porch' ), 12500 ),
                            'value' => 12500,
                            'image' => 'team_location_12500.png',
                            'bw_image' => 'team_location_12500_bw.png',
                        ],
                        [
                            'id' => 'team_location_15000',
                            'title' => sprintf( __( '%d Relay Locations', 'prayer-global-porch' ), 15000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge when your relays have %d locations prayed for.', 'prayer-global-porch' ), 15000 ),
                            'description_earned' => sprintf( __( 'You earned this badge when your relays had %d locations prayed for.', 'prayer-global-porch' ), 15000 ),
                            'value' => 15000,
                            'image' => 'team_location_15000.png',
                            'bw_image' => 'team_location_15000_bw.png',
                        ],
                        [
                            'id' => 'team_location_17500',
                            'title' => sprintf( __( '%d Relay Locations', 'prayer-global-porch' ), 17500 ),
                            'description_unearned' => sprintf( __( 'Earn this badge when your relays have %d locations prayed for.', 'prayer-global-porch' ), 17500 ),
                            'description_earned' => sprintf( __( 'You earned this badge when your relays had %d locations prayed for.', 'prayer-global-porch' ), 17500 ),
                            'value' => 17500,
                            'image' => 'team_location_17500.png',
                            'bw_image' => 'team_location_17500_bw.png',
                        ],
                        [
                            'id' => 'team_location_20000',
                            'title' => sprintf( __( '%d Relay Locations', 'prayer-global-porch' ), 20000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge when your relays have %d locations prayed for.', 'prayer-global-porch' ), 20000 ),
                            'description_earned' => sprintf( __( 'You earned this badge when your relays had %d locations prayed for.', 'prayer-global-porch' ), 20000 ),
                            'value' => 20000,
                            'image' => 'team_location_20000.png',
                            'bw_image' => 'team_location_20000_bw.png',
                        ],
                        [
                            'id' => 'team_location_25000',
                            'title' => sprintf( __( '%d Relay Locations', 'prayer-global-porch' ), 25000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge when your relays have %d locations prayed for.', 'prayer-global-porch' ), 25000 ),
                            'description_earned' => sprintf( __( 'You earned this badge when your relays had %d locations prayed for.', 'prayer-global-porch' ), 25000 ),
                            'value' => 25000,
                            'image' => 'team_location_25000.png',
                            'bw_image' => 'team_location_25000_bw.png',
                        ],
                        [
                            'id' => 'team_location_30000',
                            'title' => sprintf( __( '%d Relay Locations', 'prayer-global-porch' ), 30000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge when your relays have %d locations prayed for.', 'prayer-global-porch' ), 30000 ),
                            'description_earned' => sprintf( __( 'You earned this badge when your relays had %d locations prayed for.', 'prayer-global-porch' ), 30000 ),
                            'value' => 30000,
                            'image' => 'team_location_30000.png',
                            'bw_image' => 'team_location_30000_bw.png',
                        ],
                        [
                            'id' => 'team_location_35000',
                            'title' => sprintf( __( '%d Relay Locations', 'prayer-global-porch' ), 35000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge when your relays have %d locations prayed for.', 'prayer-global-porch' ), 35000 ),
                            'description_earned' => sprintf( __( 'You earned this badge when your relays had %d locations prayed for.', 'prayer-global-porch' ), 35000 ),
                            'value' => 35000,
                            'image' => 'team_location_35000.png',
                            'bw_image' => 'team_location_35000_bw.png',
                        ],
                        [
                            'id' => 'team_location_40000',
                            'title' => sprintf( __( '%d Relay Locations', 'prayer-global-porch' ), 40000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge when your relays have %d locations prayed for.', 'prayer-global-porch' ), 40000 ),
                            'description_earned' => sprintf( __( 'You earned this badge when your relays had %d locations prayed for.', 'prayer-global-porch' ), 40000 ),
                            'value' => 40000,
                            'image' => 'team_location_40000.png',
                            'bw_image' => 'team_location_40000_bw.png',
                        ],
                        [
                            'id' => 'team_location_45000',
                            'title' => sprintf( __( '%d Relay Locations', 'prayer-global-porch' ), 45000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge when your relays have %d locations prayed for.', 'prayer-global-porch' ), 45000 ),
                            'description_earned' => sprintf( __( 'You earned this badge when your relays had %d locations prayed for.', 'prayer-global-porch' ), 45000 ),
                            'value' => 45000,
                            'image' => 'team_location_45000.png',
                            'bw_image' => 'team_location_45000_bw.png',
                        ],
                        [
                            'id' => 'team_location_50000',
                            'title' => sprintf( __( '%d Relay Locations', 'prayer-global-porch' ), 50000 ),
                            'description_unearned' => sprintf( __( 'Earn this badge when your relays have %d locations prayed for.', 'prayer-global-porch' ), 50000 ),
                            'description_earned' => sprintf( __( 'You earned this badge when your relays had %d locations prayed for.', 'prayer-global-porch' ), 50000 ),
                            'value' => 50000,
                            'image' => 'team_location_50000.png',
                            'bw_image' => 'team_location_50000_bw.png',
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
                    'priority' => $this->priorities[self::ID_PERFECT_WEEK],
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
                    'image' => 'perfect_year.png',
                    'bw_image' => 'perfect_year_bw.png',
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
                    'priority' => $this->priorities[self::ID_STREAK],
                    'progression_badges' => [
                        [
                            'id' => 'streak_70',
                            'title' => sprintf( __( '%d Perfect Weeks', 'prayer-global-porch' ), 10 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d weeks straight', 'prayer-global-porch' ), 10 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d weeks straight', 'prayer-global-porch' ), 10 ),
                            'value' => 70,
                            'image' => 'streak_70.png',
                            'bw_image' => 'streak_70_bw.png',
                        ],
                        [
                            'id' => 'streak_90',
                            'title' => sprintf( __( '%d Perfect Months', 'prayer-global-porch' ), 3 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d months straight', 'prayer-global-porch' ), 3 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d months straight', 'prayer-global-porch' ), 3 ),
                            'value' => 90,
                            'image' => 'streak_90.png',
                            'bw_image' => 'streak_90_bw.png',
                        ],
                        [
                            'id' => 'streak_140',
                            'title' => sprintf( __( '%d Perfect Weeks', 'prayer-global-porch' ), 20 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d weeks straight', 'prayer-global-porch' ), 20 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d weeks straight', 'prayer-global-porch' ), 20 ),
                            'value' => 140,
                            'image' => 'streak_140.png',
                            'bw_image' => 'streak_140_bw.png',
                        ],
                        [
                            'id' => 'streak_180',
                            'title' => sprintf( __( '%d Perfect Months', 'prayer-global-porch' ), 6 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d months straight', 'prayer-global-porch' ), 6 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d months straight', 'prayer-global-porch' ), 6 ),
                            'value' => 180,
                            'image' => 'streak_180.png',
                            'bw_image' => 'streak_180_bw.png',
                        ],
                        [
                            'id' => 'streak_210',
                            'title' => sprintf( __( '%d Perfect Weeks', 'prayer-global-porch' ), 30 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d weeks straight', 'prayer-global-porch' ), 30 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d weeks straight', 'prayer-global-porch' ), 30 ),
                            'value' => 210,
                            'image' => 'streak_210.png',
                            'bw_image' => 'streak_210_bw.png',
                        ],
                        [
                            'id' => 'streak_270',
                            'title' => sprintf( __( '%d Perfect Months', 'prayer-global-porch' ), 9 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d months straight', 'prayer-global-porch' ), 9 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d months straight', 'prayer-global-porch' ), 9 ),
                            'value' => 270,
                            'image' => 'streak_270.png',
                            'bw_image' => 'streak_270_bw.png',
                        ],
                        [
                            'id' => 'streak_180',
                            'title' => sprintf( __( '%d Perfect Months', 'prayer-global-porch' ), 6 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d months straight', 'prayer-global-porch' ), 6 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d months straight', 'prayer-global-porch' ), 6 ),
                            'value' => 180,
                            'image' => 'streak_180.png',
                            'bw_image' => 'streak_180_bw.png',
                        ],
                        [
                            'id' => 'streak_730',
                            'title' => sprintf( __( '%d Perfect Years', 'prayer-global-porch' ), 2 ),
                            'description_unearned' => sprintf( __( 'Earn this badge by praying for %d years straight', 'prayer-global-porch' ), 2 ),
                            'description_earned' => sprintf( __( 'You earned this badge by praying for %d years straight', 'prayer-global-porch' ), 2 ),
                            'value' => 730,
                            'image' => 'streak_730.png',
                            'bw_image' => 'streak_730_bw.png',
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
                    'image' => 'ComeBackChampion.png',
                    'bw_image' => 'ComeBackChampion_bw.png',
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
