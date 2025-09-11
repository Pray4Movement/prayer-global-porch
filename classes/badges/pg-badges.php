<?php

class PG_Badges {
    // Streaks and consistency
    const ONE_WEEK_WARRIOR = 'one_week_warrior';
    const TWO_WEEK_FAITHFUL = 'two_week_faithful';
    const ONE_MONTH_DEVOTED = 'one_month_devoted';
    const HUNDRED_DAYS = 'hundred_days';
    const YEAR_OF_PRAYER = 'year_of_prayer';
    const COMEBACK_CHAMPION = 'comeback_champion';
    const UNBREAKABLE = 'unbreakable';

    // levels and progression
    const PRAYER_STARTER = 'prayer_starter';
    const NEIGHBOURHOOD_INTERCESSOR = 'neighbourhood_intercessor';
    const KINGDOM_BUILDER = 'kingdom_builder';
    const REGIONAL_WATCHMAN = 'regional_watchman';
    const GLOBAL_INTERCESSOR = 'global_intercessor';
    const PRAYER_WARRIOR = 'prayer_warrior';
    const WORLD_CHANGER = 'world_changer';
    const LEGACY_INTERCESSOR = 'legacy_intercessor';
    const MARATHON_PRAYER = 'marathon_prayer';
    const ETERNAL_WATCHMAN = 'eternal_watchman';

    // category types
    const TYPE_PROGRESSION = 'progression';
    const TYPE_ACHIEVEMENT = 'achievement';

    // categories
    const CATEGORY_STREAK = 'streak';
    const CATEGORY_LOCATION = 'location';
    const CATEGORY_RE_ENGAGEMENT = 're-engagement';

    public ?array $badges = null;

    public function __construct() {
        $badges = [
            self::CATEGORY_STREAK => [
                'type' => self::TYPE_PROGRESSION,
                'badges' => [
                    [
                        'id' => self::ONE_WEEK_WARRIOR,
                        'title' => __( 'One Week Warrior ', 'prayer-global-porch' ),
                        'description' => sprintf( __( 'You have prayed for %d days straight', 'prayer-global-porch' ), 7 ),
                        'value' => 7,
                    ],
                    [
                        'id' => self::TWO_WEEK_FAITHFUL,
                        'title' => __( 'Two Week Faithful', 'prayer-global-porch' ),
                        'description' => sprintf( __( 'You have prayed for %d days straight', 'prayer-global-porch' ), 14 ),
                        'value' => 14,
                    ],
                    [
                        'id' => self::ONE_MONTH_DEVOTED,
                        'title' => __( 'One Month Devoted', 'prayer-global-porch' ),
                        'description' => sprintf( __( 'You have prayed for %d days straight', 'prayer-global-porch' ), 30 ),
                        'value' => 30,
                    ],
                    [
                        'id' => self::HUNDRED_DAYS,
                        'title' => __( 'One Hundred Days', 'prayer-global-porch' ),
                        'description' => sprintf( __( 'You have prayed for %d days straight', 'prayer-global-porch' ), 100 ),
                        'value' => 100,
                    ],
                    [
                        'id' => self::YEAR_OF_PRAYER,
                        'title' => __( 'One Year of Prayer', 'prayer-global-porch' ),
                        'description' => sprintf( __( 'You have prayed for %d days straight', 'prayer-global-porch' ), 365 ),
                        'value' => 365,
                    ],
                    [
                        'id' => self::UNBREAKABLE,
                        'title' => __( 'Unbreakable', 'prayer-global-porch' ),
                        'description' => sprintf( __( 'You have prayed for %d days straight', 'prayer-global-porch' ), 500 ),
                        'value' => 500,
                    ],
                ],
            ],
            self::CATEGORY_LOCATION => [
                'type' => self::TYPE_PROGRESSION,
                'badges' => [
                    [
                        'id' => self::PRAYER_STARTER,
                        'title' => __( 'Prayer Starter', 'prayer-global-porch' ),
                        'description' => sprintf( __( 'You have prayed for %d locations', 'prayer-global-porch' ), 5 ),
                        'value' => 5,
                    ],
                    [
                        'id' => self::NEIGHBOURHOOD_INTERCESSOR,
                        'title' => __( 'Neighbourhood Intercessor', 'prayer-global-porch' ),
                        'description' => sprintf( __( 'You have prayed for %d locations', 'prayer-global-porch' ), 10 ),
                        'value' => 10,
                    ],
                    [
                        'id' => self::KINGDOM_BUILDER,
                        'title' => __( 'Kingdom Builder', 'prayer-global-porch' ),
                        'description' => sprintf( __( 'You have prayed for %d locations', 'prayer-global-porch' ), 50 ),
                        'value' => 50,
                    ],
                    [
                        'id' => self::REGIONAL_WATCHMAN,
                        'title' => __( 'Regional Watchman', 'prayer-global-porch' ),
                        'description' => sprintf( __( 'You have prayed for %d locations', 'prayer-global-porch' ), 500 ),
                        'value' => 500,
                    ],
                    [
                        'id' => self::GLOBAL_INTERCESSOR,
                        'title' => __( 'Global Intercessor', 'prayer-global-porch' ),
                        'description' => sprintf( __( 'You have prayed for %d%% of the world', 'prayer-global-porch' ), 25 ),
                        'value' => 1193,
                    ],
                    [
                        'id' => self::PRAYER_WARRIOR,
                        'title' => __( 'Prayer Warrior', 'prayer-global-porch' ),
                        'description' => sprintf( __( 'You have prayed for %d%% of the world', 'prayer-global-porch' ), 50 ),
                        'value' => 3578,
                    ],
                    [
                        'id' => self::WORLD_CHANGER,
                        'title' => __( 'World Changer', 'prayer-global-porch' ),
                        'description' => __( 'You have prayed for the whole world', 'prayer-global-porch' ),
                        'value' => 4770,
                    ],
                    [
                        'id' => self::LEGACY_INTERCESSOR,
                        'title' => __( 'Legacy Intercessor', 'prayer-global-porch' ),
                        'description' => sprintf( __( 'You have prayed %d laps of the world', 'prayer-global-porch' ), 2 ),
                        'value' => 9540,
                    ],
                    [
                        'id' => self::MARATHON_PRAYER,
                        'title' => __( 'Marathon Prayer', 'prayer-global-porch' ),
                        'description' => sprintf( __( 'You have prayed %d laps of the world', 'prayer-global-porch' ), 5 ),
                        'value' => 23850,
                    ],
                    [
                        'id' => self::ETERNAL_WATCHMAN,
                        'title' => __( 'Eternal Watchman', 'prayer-global-porch' ),
                        'description' => sprintf( __( 'You have prayed %d laps of the world', 'prayer-global-porch' ), 10 ),
                        'value' => 47700,
                    ],
                ]
            ],
            self::CATEGORY_RE_ENGAGEMENT => [
                'type' => self::TYPE_ACHIEVEMENT,
                'badges' => [
                    [
                        'id' => self::COMEBACK_CHAMPION,
                        'title' => __( 'Comeback Champion', 'prayer-global-porch' ),
                        'description' => __( 'It\'s great to have you back!', 'prayer-global-porch' ),
                        'value' => 1,
                    ],
                ],
            ]
        ];

        $badges_as_objects = [];
        foreach ( $badges as $category_name => $category ) {
            $type = $category['type'];
            $badges_as_objects[$category_name] = [
                'type' => $type,
                'badges' => [],
            ];
            foreach ( $category['badges'] as $badge ) {
                $badges_as_objects[$category_name]['badges'][$badge['id']] = new PG_Badge(
                    $badge['id'],
                    $badge['title'],
                    $badge['description'],
                    $category_name,
                    $badge['value'],
                    $type
                );
            }
        }
        $this->badges = $badges_as_objects;
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
     * Get the type of this category
     * @param string $category
     * @return string
     */
    public function get_category_type( string $category ): string {
        return $this->badges[$category]['type'];
    }
    /**
     * Get the badges in this category
     * @param string $category
     * @return array<PG_Badge>
     */
    public function get_category_badges( string $category ): array {
        return $this->badges[$category]['badges'];
    }
    /**
     * Get the available categories
     * @return array<string>
     */
    public function get_categories(): array {
        return array_keys( $this->badges );
    }
}
