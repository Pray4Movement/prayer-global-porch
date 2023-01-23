<?php

if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

class PG_Session_API {
    public $root = 'pg-api';

    public $type = 'session';

    public $actions = [
        'verify_firebase_token',
    ];

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

        Route::post( $namespace, "/$this->type/verify_firebase_token", [ $this, 'verify_firebase_token' ] );
    }

    public function authorize_url( $authorized ){

        foreach ( $this->actions as $action ) {
            if ( isset( $_SERVER['REQUEST_URI'] ) && strpos( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ), $this->root . '/v' . $this->version . '/'.$this->type . '/' . $action ) !== false ) {
                $authorized = true;
            }
        }

        return $authorized;
    }

    public function verify_firebase_token( WP_REST_Request $request ) {
        $body = $request->get_body();
        $body = json_decode( $body );

        $token = $body->user->stsTokenManager->accessToken;

        $fields = dt_custom_login_fields();
        $project_id = $fields['firebase_project_id']['value'];

        $payload = ( new FirebaseToken( $token ) )->verify( $project_id );

        return new WP_REST_Response( [
            'status' => 200,
            'response' => $payload,
        ] );
    }

}
PG_Session_API::instance();