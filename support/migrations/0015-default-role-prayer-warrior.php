<?php
declare(strict_types=1);

if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly


require_once( 'abstract.php' );

class Prayer_Global_Migration_0015 extends Prayer_Global_Migration {

    /**
     * @throws \Exception  Got error when creating table $name.
     */
    public function up() {
        global $wpdb;

        // update the default roles in dt_sso_login_fields
        $dt_sso_login_fields = get_option( 'dt_sso_login_fields' );
        $dt_sso_login_fields['default_role'] = 'prayer_warrior';
        update_option( 'dt_sso_login_fields', $dt_sso_login_fields );

        //update all multipliers to prayer_warrior in the user_meta table
        $wpdb->query("
            UPDATE $wpdb->usermeta
            SET meta_value = 'a:1:{s:14:\"prayer_warrior\";b:1;}'
            WHERE meta_key = 'wp_capabilities'
            AND meta_value = 'a:1:{s:10:\"multiplier\";b:1;}'
        ");
    }

    /**
     * @throws \Exception  Got error when dropping table $name.
     */
    public function down() {}

    /**
     * @return array
     */
    public function get_expected_tables(): array {
        return [];
    }

    /**
     * Test function
     */
    public function test() {
        $this->test_expected_tables();
    }
}
