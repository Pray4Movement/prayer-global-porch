<?php

/**
 * Login an existing user, or create and login a new one linking them to their firebase authentication
 *
 * This should only be used in the context of a verified firebase access token
 */
class DTFirebaseUserManager {

    private array $firebase_auth;

    public function __construct( array $firebase_auth ) {
        $this->firebase_auth = $firebase_auth;
    }

    /**
     * Login the user, creating them if needed
     * @return mixed
     */
    public function login() {
        if ( !$this->user_exists() ) {
            $this->create_user();
        }

        /* Login the user using the desired method. */
        $login_method = dt_custom_login_field( 'login_method' );

        if ( DTLoginMethods::MOBILE === $login_method ) {
            /* If mobile app, then do a login using the mobile app plugin */
            $user = $this->mobile_login();
        } else {
            /* Default to normal Wordpress login */
            $user = $this->wordpress_login();
        }

        return $user;
    }

    private function user_exists() {
        $user = get_user_by( 'email', $this->firebase_auth['email'] );

        return $user ? true : false;
    }

    private function create_user() {
        $uid = $this->firebase_auth['user_id'];
        $email = $this->firebase_auth['email'];
        $display_name = $this->firebase_auth['name'];
        $password = wp_generate_password();

        $identities = (array) $this->firebase_auth['firebase']->identities;

        $userdata = [
            'user_email' => $email,
            'user_login' => $uid,
            'user_pass' => $password,
            'display_name' => $display_name,
            'nickname' => $display_name,
        ];

        /* setup roles */

        $user_id = wp_insert_user( $userdata );

        add_user_meta( $user_id, 'firebase_uid', $uid );
        add_user_meta( $user_id, 'firebase_identities', $identities );
    }

    /**
     * Login the user using default wordpress method
     * @return mixed
     */
    private function wordpress_login() {
        if ( is_user_logged_in() ) {
            wp_logout();
        }

        add_filter( 'authenticate', [ $this, 'allow_programmatic_login' ], 10, 3 );    // hook in earlier than other callbacks to short-circuit them

        $user = wp_signon( array( 'user_login' => $this->firebase_auth['user_id'] ) );

        remove_filter( 'authenticate', [ $this, 'allow_programmatic_login' ], 10, 3 );

        if ( is_a( $user, 'WP_User' ) ) {
            wp_set_current_user( $user->ID, $user->user_login );

            if ( is_user_logged_in() ) {
                return $user;
            }
        }

        return false;
    }

    private function mobile_login() : WP_User {}

    /**
     * An 'authenticate' filter callback that authenticates the user using only     the username.
     *
     * To avoid potential security vulnerabilities, this should only be used in     the context of a programmatic login,
     * and unhooked immediately after it fires.
     *
     * @param WP_User $user
     * @param string $username
     * @param string $password
     * @return bool|WP_User a WP_User object if the username matched an existing user, or false if it didn't
     */
    public function allow_programmatic_login( $user, $username, $password ) {
        $user = get_user_by( 'login', $username );
        return $user;
    }


}