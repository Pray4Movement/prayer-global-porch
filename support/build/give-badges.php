<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

class PG_Give_Badges extends PG_Public_Page {
    public $url_path = 'support/give-badges';
    public $page_title = 'Give Badges';
    public $rest_route = 'pg/give-badges';

    public function __construct() {
        $current_page_path_matches = parent::__construct();
        if ( !$current_page_path_matches ) {
            return;
        }
        if ( !is_user_logged_in() ){
            wp_redirect( home_url( '/login' ) );
            exit;
        }
        // if user is not an admin, redirect to dashboard
        if ( !dt_user_has_role( get_current_user_id(), 'administrator' ) ){
            wp_redirect( home_url( '/dashboard' ) );
            exit;
        }
        /**
         * Register custom hooks here
         */
    }

    public function register_endpoints() {
        register_rest_route( $this->rest_route, '/give-badges', [
            'methods' => 'GET',
            'callback' => [ $this, 'give_badges' ],
            'permission_callback' => [ $this, 'permission_callback' ],
        ] );
        register_rest_route( $this->rest_route, '/give-perfect-badges', [
            'methods' => 'GET',
            'callback' => [ $this, 'give_perfect_badges' ],
            'permission_callback' => [ $this, 'permission_callback' ],
        ] );
        register_rest_route( $this->rest_route, '/give-streak-badges', [
            'methods' => 'GET',
            'callback' => [ $this, 'give_streak_badges' ],
            'permission_callback' => [ $this, 'permission_callback' ],
        ] );
        register_rest_route( $this->rest_route, '/give-team-location-badges', [
            'methods' => 'GET',
            'callback' => [ $this, 'give_team_location_badges' ],
            'permission_callback' => [ $this, 'permission_callback' ],
        ] );
        register_rest_route( $this->rest_route, '/correct-perfect-badges', [
            'methods' => 'GET',
            'callback' => [ $this, 'correct_perfect_badges' ],
            'permission_callback' => [ $this, 'permission_callback' ],
        ] );
        register_rest_route( $this->rest_route, '/clear-retroactive-badges', [
            'methods' => 'GET',
            'callback' => [ $this, 'clear_retroactive_badges' ],
            'permission_callback' => [ $this, 'permission_callback' ],
        ] );
    }

    public function give_badges( WP_REST_Request $request ) {
        $users = get_users();
        foreach ( $users as $i => $user ) {
            $has_given_badges = get_user_meta( $user->ID, 'give-badges-progress', true );
            if ( $has_given_badges ) {
                continue;
            }

            if ( pg_is_user_in_ab_test( $user->ID ) ) {
                continue;
            }

            $badge_manager = new PG_Badge_Manager( $user->ID );
            $newly_earned_badges = $badge_manager->get_newly_earned_badges();
            foreach ( $newly_earned_badges as $badge ) {
                $badge_manager->earn_badge( $badge->get_id(), retroactive: true );
            }
            add_user_meta( $user->ID, 'give-badges-progress', 1, true );


            //delete_user_meta( $user->ID, 'give-badges-progress' );
        }

        return new WP_REST_Response([
            'finished' => true,
            'count' => count( $users ),
        ]);
    }

    public function give_perfect_badges() {
        $users = get_users();
        foreach ( $users as $user ) {
            $has_given_perfect_badges = get_user_meta( $user->ID, 'give-perfect-badges-progress', true );
            if ( $has_given_perfect_badges ) {
                continue;
            }
            if ( pg_is_user_in_ab_test( $user->ID ) ) {
                continue;
            }

            $badge_manager = new PG_Badge_Manager( $user->ID );
            $user_stats = new User_Stats( $user->ID );
            $all_islands = $user_stats->all_islands();
            foreach ( $all_islands as $island ) {
                if ( $island['island_days'] >= 7 ) {
                    for ( $i = 0; $i < $island['island_days'] / 7; $i++ ) {
                        $badge_manager->earn_badge( 'perfect_week', retroactive: true );
                    }
                }
                if ( $island['island_days'] >= 30 ) {
                    for ( $i = 0; $i < $island['island_days'] / 30; $i++ ) {
                        $badge_manager->earn_badge( 'perfect_month', retroactive: true );
                    }
                }
                if ( $island['island_days'] >= 365 ) {
                    for ( $i = 0; $i < $island['island_days'] / 365; $i++ ) {
                        $badge_manager->earn_badge( 'perfect_year', retroactive: true );
                    }
                }
            }
            add_user_meta( $user->ID, 'give-perfect-badges-progress', 1, true );
        }
    }

    public function correct_perfect_badges( WP_REST_Request $request ) {
        $dry_run = $request->get_param( 'dry_run' ) ?? false;
        $batch_size = $request->get_param( 'batch_size' ) ?? 50;
        $count = $request->get_param( 'count' ) ?? 0;
        $users = get_users();
        $total = count( $users );

        $users = array_slice( $users, $count, $batch_size );
        foreach ( $users as $user ) {
            $count++;
            $has_correct_perfect_badges = get_user_meta( $user->ID, 'correct-perfect-badges-progress', true );
            if ( !$dry_run ) {
                $has_correct_perfect_badges = false;
            }
            if ( $has_correct_perfect_badges ) {
                continue;
            }
            if ( pg_is_user_in_ab_test( $user->ID ) ) {
                continue;
            }

            $badge_manager = new PG_Badge_Manager( $user->ID );
            $all_earned_badges = $badge_manager->get_all_badges();
            $total_perfect_weeks = 0;
            $total_perfect_months = 0;
            $total_perfect_years = 0;
            foreach ( $all_earned_badges as $badge ) {
                if ( $badge->get_type() === PG_Badges::ID_PERFECT_WEEK ) {
                    $total_perfect_weeks = $badge->get_num_times_earned();
                }
                if ( $badge->get_type() === PG_Badges::ID_PERFECT_MONTH ) {
                    $total_perfect_months = $badge->get_num_times_earned();
                }
                if ( $badge->get_type() === PG_Badges::ID_PERFECT_YEAR ) {
                    $total_perfect_years = $badge->get_num_times_earned();
                }
            }
            $user_stats = new User_Stats( $user->ID );
            $all_islands = $user_stats->all_islands();
            $total_perfect_weeks_correct = 0;
            $total_perfect_months_correct = 0;
            $total_perfect_years_correct = 0;
            foreach ( $all_islands as $island ) {
                if ( $island['island_days'] >= 7 ) {
                    for ( $i = 0; $i < $island['island_days'] / 7; $i++ ) {
                        $total_perfect_weeks_correct++;
                    }
                }
                if ( $island['island_days'] >= 30 ) {
                    for ( $i = 0; $i < $island['island_days'] / 30; $i++ ) {
                        $total_perfect_months_correct++;
                    }
                }
                if ( $island['island_days'] >= 365 ) {
                    for ( $i = 0; $i < $island['island_days'] / 365; $i++ ) {
                        $total_perfect_years_correct++;
                    }
                }
            }
            $result = [
                'perfect_weeks' => [],
                'perfect_months' => [],
                'perfect_years' => [],
            ];
            if ( $total_perfect_weeks < $total_perfect_weeks_correct ) {
                if ( $dry_run ) {
                    $result['perfect_weeks'][$user->ID] = [
                        'user_id' => $user->ID,
                        'total_perfect_weeks' => $total_perfect_weeks,
                        'total_perfect_weeks_correct' => $total_perfect_weeks_correct,
                    ];
                } else {
                    for ( $i = 0; $i < abs( $total_perfect_weeks - $total_perfect_weeks_correct ); $i++ ) {
                        $badge_manager->earn_badge( 'perfect_week', retroactive: true );
                    }
                }
            }
            if ( $total_perfect_months < $total_perfect_months_correct ) {
                if ( $dry_run ) {
                    $result['perfect_months'][$user->ID] = [
                        'user_id' => $user->ID,
                        'total_perfect_months' => $total_perfect_months,
                        'total_perfect_months_correct' => $total_perfect_months_correct,
                    ];
                } else {
                    for ( $i = 0; $i < abs( $total_perfect_months - $total_perfect_months_correct ); $i++ ) {
                        $badge_manager->earn_badge( 'perfect_month', retroactive: true );
                    }
                }
            }
            if ( $total_perfect_years < $total_perfect_years_correct ) {
                if ( $dry_run ) {
                    $result['perfect_years'][$user->ID] = [
                        'user_id' => $user->ID,
                        'total_perfect_years' => $total_perfect_years,
                        'total_perfect_years_correct' => $total_perfect_years_correct,
                    ];
                } else {
                    for ( $i = 0; $i < abs( $total_perfect_years - $total_perfect_years_correct ); $i++ ) {
                            $badge_manager->earn_badge( 'perfect_year', retroactive: true );
                    }
                }
            }
            if ( !$dry_run ) {
                add_user_meta( $user->ID, 'correct-perfect-badges-progress', 1, true );
            }
        }
        return new WP_REST_Response([
            'result' => $result,
            'count' => $count,
            'total' => $total,
        ]);
    }

    public function give_team_location_badges( WP_REST_Request $request ) {
        $count = $request->get_param( 'count' );
        $batch_size = $request->get_param( 'batch_size' ) ?? 50;
        $users = get_users();
        $total = count( $users );

        $users = array_slice( $users, $count, $batch_size );

        foreach ( $users as $user ) {
            $count++;
            $has_given_team_location_badges = get_user_meta( $user->ID, 'give-team-location-badges-progress', true );
            if ( $has_given_team_location_badges ) {
                continue;
            }
            if ( pg_is_user_in_ab_test( $user->ID ) ) {
                continue;
            }
            $badge_manager = new PG_Badge_Manager( $user->ID );
            $newly_earned_badges = $badge_manager->get_newly_earned_badges_array();
            foreach ( $newly_earned_badges as $badge ) {
                if ( str_starts_with( $badge['id'], PG_Badges::ID_TEAM_LOCATION ) ) {
                    $badge_manager->earn_badge( $badge['id'], retroactive: true );
                }
            }
            add_user_meta( $user->ID, 'give-team-location-badges-progress', 1, true );
        }
        return new WP_REST_Response([
            'count' => $count,
            'total' => $total,
        ]);
    }
    public function give_streak_badges() {
        $users = get_users();
        foreach ( $users as $user ) {
            $has_given_streak_badges = get_user_meta( $user->ID, 'give-streak-badges-progress', true );
            if ( $has_given_streak_badges ) {
                continue;
            }
            if ( pg_is_user_in_ab_test( $user->ID ) ) {
                continue;
            }
            $badge_manager = new PG_Badge_Manager( $user->ID );
            $user_stats = new User_Stats( $user->ID );
            if ( $user_stats->best_streak_in_days() >= 14 ) {
                $badge_manager->earn_badge( 'streak_14', retroactive: true );
            }
            if ( $user_stats->best_streak_in_days() >= 35 ) {
                $badge_manager->earn_badge( 'streak_35', retroactive: true );
            }
            add_user_meta( $user->ID, 'give-streak-badges-progress', 1, true );
        }
    }

    public function clear_retroactive_badges() {
        $users = get_users();
        foreach ( $users as $user ) {
            $badge_manager = new PG_Badge_Manager( $user->ID );
            $badge_manager->clear_badges();
            delete_user_meta( $user->ID, 'give-badges-progress' );
        }
    }

    public function permission_callback( $request ) {
        return current_user_can( 'manage_dt' );
    }

    public function wp_enqueue_scripts() {
        wp_enqueue_style( 'pg-login-style', plugin_dir_url( __FILE__ ) . 'login.css', array(), filemtime( plugin_dir_path( __FILE__ ) . 'login.css' ) );

        wp_localize_script( 'global-functions', 'jsObject', [
            'rest_url' => esc_url( rest_url( 'pg/give-badges' ) ),
            'nonce' => wp_create_nonce( 'wp_rest' ),
            // does the url start with prayer.global?
            'is_live' => str_starts_with( $_SERVER['REQUEST_URI'], 'https://prayer.global' ),
            'translations' => [
                'invalid_credentials' => esc_html__( 'Invalid email or password. Please try again.', 'prayer-global-porch' ),
                'email_not_found' => esc_html__( 'Email not found. Please register.', 'prayer-global-porch' ),
                'auth_failed' => esc_html__( 'Authentication failed. Please try again or register for an account.', 'prayer-global-porch' ),
                'email_required' => esc_html__( 'Email is required', 'prayer-global-porch' ),
                'no_account_found' => esc_html__( 'No account found with that email address', 'prayer-global-porch' ),
            ],
        ] );
    }

    public function dt_magic_url_base_allowed_js( $allowed_js ) {
        return $allowed_js;
    }

    public function dt_magic_url_base_allowed_css( $allowed_css ) {
        return $allowed_css;
    }

    /**
     * Print scripts to header
     */
    public function header_javascript(){}

    /**
     * Print styles to header
     */
    public function header_style(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . '../pages/assets/header.php' );
        ?>
        <style>
            tr > td + td {
                padding-left: 20px;
            }
        </style>
        <?php
    }

    /**
     * Print scripts to footer
     */
    public function footer_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . '../pages/assets/footer.php' );
        ?>

        <?php
    }
    /**
     * Print body
     */
    public function body(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . '../pages/assets/nav.php' );
        ?>

        <section class="pg-container page" id="section-test-push">
            <div class="flow">

                <div>
                    <h3>Give badges Retroactively to users</h3>
                </div>

                <div class="flow-small">
                    <div>
                        <label for="batch-size">Batch Size</label>
                        <input type="number" id="batch-size" value="50">
                    </div>
                    <div>
                        <label for="dry-run">Dry Run</label>
                        <input type="checkbox" id="dry-run" checked>
                    </div>
                    <button class="btn btn-primary" id="give-badges">Give Badges</button>
                    <button class="btn btn-primary" id="give-perfect-badges">Give Multiple Perfect X Badges</button>
                    <button class="btn btn-primary" id="give-streak-badges">Give 2 & 5 Week streak Badges</button>
                    <button class="btn btn-primary" id="give-team-location-badges">Give team location badges</button>
                    <button class="btn btn-primary" id="correct-perfect-badges">Correct Perfect X Badges</button>

                    <?php if ( !str_starts_with( $_SERVER['REQUEST_URI'], 'https://prayer.global' ) ): ?>
                        <button class="btn btn-primary" id="clear-retroactive-badges">Clear Retroactive Badges</button>
                    <?php endif; ?>
                </div>
                <div class="progress-list"></div>

            </div>

        </section>

        <script>

            const progressList = document.querySelector('.progress-list')

            document.querySelector('#give-badges').addEventListener('click', () => {

                const giveBadges = () => fetch(jsObject.rest_url + '/give-badges' , {
                    headers: {
                        'Content-Type': 'application/json',
                        'X-WP-Nonce': jsObject.nonce,
                    },
                })
                    .then((response) => response.json())
                    .then((response) => {
                        const progressDiv = document.createElement('div')
                        progressDiv.innerHTML = 'Processed ' + response.count + ' users'
                        progressList.appendChild(progressDiv)
                    })

                giveBadges();
            })

            document.querySelector('#give-perfect-badges').addEventListener('click', () => {
                fetch(jsObject.rest_url + '/give-perfect-badges', {
                    headers: {
                        'Content-Type': 'application/json',
                        'X-WP-Nonce': jsObject.nonce,
                    },
                })
                    .then((response) => response.json())
                    .then((response) => {
                        const progressDiv = document.createElement('div')
                        progressDiv.innerHTML = 'Processed ' + response.count + ' users'
                        progressList.appendChild(progressDiv)
                    })
            })

            document.querySelector('#give-streak-badges').addEventListener('click', () => {
                fetch(jsObject.rest_url + '/give-streak-badges', {
                    headers: {
                        'Content-Type': 'application/json',
                        'X-WP-Nonce': jsObject.nonce,
                    },
                })
                    .then((response) => response.json())
                    .then((response) => {
                        const progressDiv = document.createElement('div')
                        progressDiv.innerHTML = 'Processed ' + response.count + ' users'
                        progressList.appendChild(progressDiv)
                    })
            })

            document.querySelector('#give-team-location-badges').addEventListener('click', () => {
                const batchSize = document.querySelector('#batch-size').value;
                const giveBadges = (count = 0) => {
                    return fetch(jsObject.rest_url + '/give-team-location-badges?count=' + count + '&batch_size=' + batchSize, {
                        headers: {
                            'Content-Type': 'application/json',
                            'X-WP-Nonce': jsObject.nonce,
                        },
                    })
                        .then((response) => response.json())
                        .then((response) => {
                            const progressDiv = document.createElement('div')
                            progressDiv.innerHTML = 'Processed ' + response.count + ' users'
                            progressList.appendChild(progressDiv)

                            if ( response.count < response.total ) {
                                giveBadges(response.count);
                            }
                        })
                }
                giveBadges();

            })

            document.querySelector('#correct-perfect-badges').addEventListener('click', () => {
                const dryRun = document.querySelector('#dry-run').checked;
                const batchSize = document.querySelector('#batch-size').value;
                const correctPerfectBadges = (count = 0) => {
                    return fetch(jsObject.rest_url + '/correct-perfect-badges?dry_run=' + dryRun + '&batch_size=' + batchSize + '&count=' + count, {
                        headers: {
                            'Content-Type': 'application/json',
                            'X-WP-Nonce': jsObject.nonce,
                        },
                    })
                        .then((response) => response.json())
                        .then((response) => {
                            const progressDiv = document.createElement('div')
                            progressDiv.innerHTML = 'Processed ' + response.count + ' users'

                            if ( response.result.perfect_weeks.length > 0 || response.result.perfect_months.length > 0 || response.result.perfect_years.length > 0 ) {
                                progressDiv.innerHTML += '<pre>' + JSON.stringify(response.result, null, 2) + '</pre>';
                            }

                            progressList.appendChild(progressDiv);
                            if ( response.count < response.total ) {
                                correctPerfectBadges(response.count);
                            }
                        });
                };
                correctPerfectBadges();
            });
            document.querySelector('#clear-retroactive-badges').addEventListener('click', () => {
                fetch(jsObject.rest_url + '/clear-retroactive-badges', {
                    headers: {
                        'Content-Type': 'application/json',
                        'X-WP-Nonce': jsObject.nonce,
                    },
                })
                    .then((response) => response.json())
                    .then((response) => {
                        const progressDiv = document.createElement('div')
                        progressDiv.innerHTML = 'Retroactive badges cleared'
                        progressList.appendChild(progressDiv)
                    })
            })


        </script>

        <?php
    }
}

new PG_Give_Badges();
