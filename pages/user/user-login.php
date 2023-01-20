<?php

/**
 * Displays a page for the user to login/register and recover password etc.
 *
 * Any part of the site can send the user to the login page with an encoded redirect url to get back to where they were,
 * after the login/registration.
 */
class PG_User_Login_Registration extends DT_Magic_Url_Base {

    public $page_title = 'User Login';
    public $root = 'user_app';
    public $type = 'login';
    public $post_type = 'user';

    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct() {
        parent::__construct();

        /**
         * tests if other URL
         */
        $url = dt_get_url_path();
        if ( strpos( $url, $this->root . '/' . $this->type ) === false ) {
            return;
        }
        /**
         * tests magic link parts are registered and have valid elements
         */
        if ( !$this->check_parts_match( false ) ){
            return;
        }

        // load if valid url
        add_action( 'dt_blank_body', [ $this, 'body' ] ); // body for no post key

        add_filter( 'dt_magic_url_base_allowed_css', [ $this, 'dt_magic_url_base_allowed_css' ], 10, 1 );
        add_filter( 'dt_magic_url_base_allowed_js', [ $this, 'dt_magic_url_base_allowed_js' ], 10, 1 );
        add_action( 'wp_enqueue_scripts', [ $this, 'wp_enqueue_scripts' ], 99 );
    }

    public function dt_magic_url_base_allowed_css( $allowed_css ) {
        return [];
    }

    public function dt_magic_url_base_allowed_js( $allowed_js ) {
        return array_merge( $allowed_js, [
            'jquery',
        ]);
    }

    public function wp_enqueue_scripts() {}

    public function header_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/header.php' );

        $user_id = get_current_user_id();

        ?>
        <script>
            let jsObject = [<?php echo json_encode([
                'root' => esc_url_raw( rest_url() ),
                'nonce' => wp_create_nonce( 'wp_rest' ),
                'parts' => $this->parts,
                'is_logged_in' => is_user_logged_in() ? 1 : 0,
                'logout_url' => esc_url( wp_logout_url( '/' ) )
            ]) ?>][0]
        </script>
        <script src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js?ver=3"></script>
        <style>
            #login_form input {
                padding:.5em;
            }
        </style>
        <?php
    }

    public function footer_javascript(){

        $fields = get_option( 'dt_custom_login_fields' );
        $invalid_settings = empty($fields['firebase_api_key']['value']) ||
                            empty($fields['firebase_project_id']['value']) ||
                            empty($fields['firebase_app_id']['value']) ? 1 : 0;

        ?>
        <script src="https://www.gstatic.com/firebasejs/9.15.0/firebase-app-compat.js"></script>
        <script src="https://www.gstatic.com/firebasejs/9.15.0/firebase-auth-compat.js"></script>
        <script>
            const firebaseConfig = {
                apiKey: "<?php echo esc_js( $fields['firebase_api_key']['value'] ) ?>",
                authDomain: "<?php echo esc_js( $fields['firebase_project_id']['value'] ) ?>.firebaseapp.com",
                projectId: "<?php echo esc_js( $fields['firebase_project_id']['value'] ) ?>",
                appId: "<?php echo esc_js( $fields['firebase_app_id']['value'] ) ?>",
            };

            try {
                const firebaseApp = firebase.initializeApp(firebaseConfig);
                const auth = firebaseApp.auth();
            } catch (error) {
                console.log(error)
            }
        </script>
        <script src="https://www.gstatic.com/firebasejs/ui/6.0.1/firebase-ui-auth.js"></script>
        <link type="text/css" rel="stylesheet" href="https://www.gstatic.com/firebasejs/ui/6.0.1/firebase-ui-auth.css" />

        <script>
            const ui = new firebaseui.auth.AuthUI(firebase.auth());
            const config = {
                callbacks: {
                    signInSuccessWithAuthResult: function(authResult, redirectUrl) {
                        // User successfully signed in.
                        // Return type determines whether we continue the redirect automatically
                        // or whether we leave that to developer to handle.
                        //
                        // and can perform the handshake with the PG API to

                        window.location = '/'
                        return false;
                    },
                    uiShown: function() {
                        // The widget is rendered.
                        // Hide the loader.
                        document.getElementById('loader').style.display = 'none';
                    }
                },
                // Will use popup for IDP Providers sign-in flow instead of the default, redirect.
                signInFlow: 'popup',
                // signInSuccessUrl: 'https://prayer.global',
                signInOptions: [
                    firebase.auth.GoogleAuthProvider.PROVIDER_ID,
                    firebase.auth.FacebookAuthProvider.PROVIDER_ID,
                    firebase.auth.EmailAuthProvider.PROVIDER_ID,
                ],
                tosUrl: '/content_app/tos',
                privacyPolicyUrl: '/content_app/privacy'
            }

            if ( <?php echo esc_js( $invalid_settings ) ?> === 1 ) {
                document.getElementById('loader').style.display = 'none'
                console.error('Missing firebase settings in the admin section')
            } else {
                ui.start('#firebaseui-auth-container', config);
            }

        </script>

        <?php
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/footer.php' );
    }


    public function body() {
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . '/assets/nav.php' );

        ?>

        <style>

        </style>

        <section class="page-section" data-section="login" id="section-login">
            <div class="container">
                <div class="row justify-content-md-center text-center">
                    <div class="col-lg-7 flow" id="pg_content">
                        <form id="login_form">
                            <h2 class="header-border-top">Login</h2>
                            </p>
                            <p>
                                Email<br>
                                <input type="text" id="pg_input_email"  />
                            </p>
                            <p>
                                Password<br>
                                <input type="password" id="pg_input_password" />
                            </p>
                            <p>
                                <button class="btn btn-outline-dark" type="button" id="submit_button">Submit</button>
                            </p>
                            <span class="loading-spinner"></span>

                            <div id="firebaseui-auth-container"></div>
                            <div id="loader">
                                <span class="loading-spinner active"></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>




        <?php

    }

}
PG_User_Login_Registration::instance();