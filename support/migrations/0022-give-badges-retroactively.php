<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

require_once( 'abstract.php' );
require_once( plugin_dir_path( __DIR__ ) . '../utilities/global-utilities.php' );
require_once( plugin_dir_path( __DIR__ ) . '../utilities/user-stats.php' );
require_once( plugin_dir_path( __DIR__ ) . '../classes/badges/pg-badges.php' );
require_once( plugin_dir_path( __DIR__ ) . '../classes/badges/pg-badge-model.php' );
require_once( plugin_dir_path( __DIR__ ) . '../classes/badges/pg-badge-manager.php' );
require_once( plugin_dir_path( __DIR__ ) . '../classes/badges/pg-badge.php' );

class Prayer_Global_Migration_0022 extends Prayer_Global_Migration {
    public function up() {
        $users = get_users();


        foreach ( $users as $user ) {
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
        }
    }

    public function down() {}

    public function test() {
        $this->test_expected_tables();
    }
}
