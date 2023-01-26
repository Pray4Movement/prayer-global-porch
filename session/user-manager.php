<?php

/**
 * Login an existing user, or create and login a new one linking them to their firebase authentication
 *
 * This should only be used in the context of a verified firebase access token
 */
class DTFirebaseUserManager {

    private array $firebase_auth;

    const DEFAULT_AUTH_SERVICE_ENDPOINT = 'wp-json/jwt-auth/v1/token';

    public function __construct( array $firebase_auth ) {
        $this->firebase_auth = $firebase_auth;
        add_filter( 'dt_allow_rest_access', [ $this, 'authorize_url' ], 10, 1 );
    }

    public function authorize_url( $authorized ){

        if ( isset( $_SERVER['REQUEST_URI'] ) && strpos( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ), static::DEFAULT_AUTH_SERVICE_ENDPOINT ) !== false ) {
            $authorized = true;
        }

        return $authorized;
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
        $login_method = pg_login_field( 'login_method' );

        if ( DTLoginMethods::MOBILE === $login_method ) {
            /* If mobile app, then do a login using the mobile app plugin */
            $response = $this->mobile_login();
        } else {
            /* Default to normal Wordpress login */
            $response = $this->wordpress_login();
        }

        return $response;
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
                return [
                    'user' => $user
                ];
            }
        }

        return false;
    }

    private function mobile_login() {

        add_filter( 'authenticate', [ $this, 'allow_programmatic_login' ], 10, 3 );    // hook in earlier than other callbacks to short-circuit them

        $auth_service_endpoint = pg_login_field( 'auth_service_endpoint' );

        if ( !$auth_service_endpoint || empty( $auth_service_endpoint ) ) {
            $auth_service_endpoint = 'http://localhost:8000/' . static::DEFAULT_AUTH_SERVICE_ENDPOINT;
        }

        require_once( get_template_directory() . '/dt-core/libraries/wp-api-jwt-auth/public/class-jwt-auth-public.php' );
        //$token = Jwt_Auth_Public::generate_token_static( $this->firebase_auth['user_id'], 'logging-in-programmatically' );
        $token = Jwt_Auth_Public::generate_token_static( $this->firebase_auth['user_id'], 'dummy-password' );

        remove_filter( 'authenticate', [ $this, 'allow_programmatic_login' ], 10, 3 );

        if ( $token ) {
            return [
                'jwt' => $token,
            ];
        }

        return false;
    }

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