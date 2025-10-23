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
                    <button class="btn btn-primary" id="give-badges">Give Badges</button>
                    <button class="btn btn-primary" id="give-perfect-badges">Give Multiple Perfect X Badges</button>
                    <button class="btn btn-primary" id="give-streak-badges">Give 2 & 5 Week streak Badges</button>

                    <button class="btn btn-primary" id="clear-retroactive-badges">Clear Retroactive Badges</button>
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
