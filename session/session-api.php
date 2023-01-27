<?php

if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

class PG_Session_API {
    public $root = 'pg-api';

    public $type = 'session';

    public $version = 1;

    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()


    public function __construct() {
        add_filter( 'dt_allow_rest_access', [ $this, 'authorize_url' ], 10, 1 );
        if ( dt_is_rest() ) {
            add_action( 'rest_api_init', [ $this, 'add_endpoints' ] );
        }
    }

    /**
     * Register REST Endpoints
     * @link https://github.com/DiscipleTools/disciple-tools-theme/wiki/Site-to-Site-Link for outside of wordpress authentication
     */
    public function add_endpoints() {
        $namespace = $this->root . '/v' . $this->version;

        Route::post( $namespace, "/$this->type/login", [ $this, 'login' ] );
        Route::post( $namespace, "/$this->type/check_auth", [ $this, 'check_auth' ] );
    }

    public function authorize_url( $authorized ){

        if ( isset( $_SERVER['REQUEST_URI'] ) && strpos( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ), $this->root . '/v' . $this->version . '/'.$this->type ) !== false ) {
            $authorized = true;
        }

        return $authorized;
    }

    /**
     * Login the user using a firebase access token
     * @param WP_REST_Request $request
     * @return WP_REST_Response|WP_Error
     */
    public function login( WP_REST_Request $request ) {
        $body = $request->get_body();
        $body = json_decode( $body );

        $token = $body->user->stsTokenManager->accessToken;

        try {
            $payload = $this->verify_firebase_token( $token );
        } catch (\Throwable $th) {
            return new WP_Error( 'bad_token', $th->getMessage(), [ 'status' => 401 ] );
        }

        $user_manager = new DTFirebaseUserManager( $payload );

        try {
            $response = $user_manager->login();
        } catch (\Throwable $th) {
            return new WP_Error( $th->getCode(), $th->getMessage(), [ 'status' => 401 ] );
        }

        if ( is_wp_error( $response ) ) {
            return $response;
        }
        if ( !$response ) {
            return new WP_Error( 'login_error', 'Something went wrong with the login', [ 'status' => 401 ] );
        }

        return new WP_REST_Response( [
            'status' => 200,
            'body' => $response,
        ] );
    }

    /**
     * Check whether the user is authenticated either via wordpress cookie or by JWT token
     * @param WP_REST_Request $request
     * @return WP_Error|WP_REST_Response
     */
    public function check_auth( WP_REST_Request $request ) {

        $login_method = pg_login_field( 'login_method' );

        if ( DT_Login_Methods::WORDPRESS === $login_method && is_user_logged_in() ) {
            return new WP_REST_Response( [
                'data' => [
                    'status' => 200,
                ],
            ] );
        }

        if ( DT_Login_Methods::MOBILE === $login_method ) {
            require_once( get_template_directory() . '/dt-core/libraries/wp-api-jwt-auth/public/class-jwt-auth-public.php' );
            $response = Jwt_Auth_Public::validate_token( $request );

            return $response;
        }

        return new WP_Error(
            'pg_login_not_logged_in',
            'User is not authenticated',
            [
                'status' => 401,
            ]
        );
    }

    /**
     * Verify the firebase token against the project id
     * @param string $token
     * @return array
     */
    private function verify_firebase_token( string $token ) {
        $project_id = pg_login_field( 'firebase_project_id' );

        $payload = ( new DTFirebaseToken( $token ) )->verify( $project_id );

        return $payload;
    }

}
PG_Session_API::instance();