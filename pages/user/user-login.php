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
        return [];
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
                'logout_url' => esc_url( '/user_app/logout' ),
                'redirect_url' => DT_Login_Fields::get( 'redirect_url' ),
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
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/footer.php' );
        ?>
        <script>

          window.addEventListener('load', function() {
            window.getAuthUser(
              () => {
                const url = new URL(location.href)
                const redirectTo = url.searchParams.get('redirect_to') || encodeURIComponent('/user_app/profile')

                location.href = decodeURIComponent(redirectTo)
              },
              () => {
                document.getElementById('login-ui').style.display = 'block'
                document.getElementById('login-ui-loader').style.display = 'none'
              }
            )
          })

        </script>
        <?php
    }


    public function body() {
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . '/assets/nav.php' );

        $lang = pg_get_current_lang();

        $url = new DT_URL( dt_get_url_path() );

        $action = $url->query_params->has( 'action' ) ? $url->query_params->get( 'action' ) : 'login';
        $redirect_to = $url->query_params->has( 'redirect_to' ) ? urlencode( $url->query_params->get( 'redirect_to' ) ) : '';
        $icom_free_tshirt = $url->query_params->has( 'icom_free_tshirt' ) ? true : false;

        ?>

        <?php

        switch ( $action ) {
            case 'register':

                ?>

                <script>
                    window.addEventListener('DOMContentLoaded', function() {
                        window.waitForElement('.firebaseui-idp-button', () => {
                            const firebaseButtons = document.querySelectorAll('.firebaseui-idp-button')
                            const tshirtCheckBox =document.querySelector('#icom_free_tshirt')
                            const generalEmailsCheckBox =document.querySelector('#send_general_emails')
                            const lapEmailsCheckBox =document.querySelector('#send_lap_emails')

                            firebaseButtons.forEach((button) => {
                                /* TODO: this marketing info is being saved too early, if they change their options before actually registering
                                it won't save it.
                                so could add some event listers to the checkboxes, to save the data globally, instead of this way when they are clicked
                                that way they will be able to change their option at any point in the process */
                                button.addEventListener('click', function(event) {
                                    const marketingPermission = generalEmailsCheckBox.checked
                                    const lapEmailsPermission = lapEmailsCheckBox.checked
                                    const tshirtPrizeEntry = false

                                    if (tshirtCheckBox) {
                                        tshirtPrizeEntry = tshirtCheckBox.checked
                                    }

                                    window.pg_marketing_info = {
                                        marketingPermission,
                                        lapEmailsCheckBox,
                                        tshirtPrizeEntry,
                                    }
                                })
                            })
                        })
                    })
                </script>

                <section class="page-section pt-4" data-section="register" id="section-register">
                    <div class="container">
                        <div class="row justify-content-md-center text-center">
                            <div class="col-lg-7" id="pg_content">
                                <h2 class=""><?php echo esc_html__( 'Register', 'prayer-global-porch' ) ?></h2>
                                <p class="center"><?php echo esc_html__( 'Create your own free login. This will allow you to:', 'prayer-global-porch' ) ?></p>
                                <ul class="w-fit text-align-left mx-auto">
                                    <li><?php echo esc_html__( 'See your prayer history', 'prayer-global-porch' ) ?></li>
                                    <li><?php echo esc_html__( 'Create your own prayer relays', 'prayer-global-porch' ) ?></li>
                                    <li><?php echo esc_html__( 'Get badges and more', 'prayer-global-porch' ) ?></li>
                                </ul>
                                <div id="login-ui" style="display: none;">
                                    <?php echo do_shortcode( '[dt_firebase_login_ui lang_code="' . $lang . '"]' ) ?>
                                </div>
                                <div id="login-ui-loader">
                                    <span class="loading-spinner active"></span>
                                </div>
                                <div class="flow-medium">
                                    <div class="marketing-options">

                                        <?php if ( $icom_free_tshirt ) : ?>

                                            <script>
                                                window.addEventListener('DOMContentLoaded', function() {
                                                    const tshirtCheckBox =document.querySelector('#icom_free_tshirt')
                                                    const generalEmailsCheckBox =document.querySelector('#send_general_emails')
                                                    const lapEmailsCheckBox =document.querySelector('#send_lap_emails')

                                                    tshirtCheckBox.addEventListener('change', onTshirtCheckBoxChange)
                                                    toggleMarketingPreferences(true)

                                                    function onTshirtCheckBoxChange(event) {
                                                        const checked = event.target.checked

                                                        toggleMarketingPreferences(checked)
                                                    }
                                                    function toggleMarketingPreferences(checked) {
                                                        if ( checked ) {
                                                            generalEmailsCheckBox.setAttribute( 'disabled', '' )
                                                            lapEmailsCheckBox.setAttribute( 'disabled', '' )
                                                            generalEmailsCheckBox.checked = true
                                                            lapEmailsCheckBox.checked = true
                                                        } else {
                                                            generalEmailsCheckBox.removeAttribute( 'disabled' )
                                                            lapEmailsCheckBox.removeAttribute( 'disabled' )
                                                        }
                                                    }
                                                })

                                                const firebaseButtons = document.querySelectorAll('.firebaseui-idp-button')
                                                console.log(firebaseButtons)
                                                firebaseButtons.forEach((button) => {
                                                    button.addEventListener('click', function(event) {
                                                        console.log('click')
                                                    })
                                                })
                                            </script>

                                            <div class="form-check">
                                                <input class="form-check-input user-check-preferences" type="checkbox" id="icom_free_tshirt" checked>
                                                <label class="form-check-label" for="icom_free_tshirt">
                                                    Enter me in the T-Shirt Prize draw
                                                </label>
                                            </div>

                                        <?php endif; ?>

                                        <div class="form-check small">
                                            <input class="form-check-input user-check-preferences" type="checkbox" id="send_general_emails" checked>
                                            <label class="form-check-label" for="send_general_emails">
                                                <?php echo esc_html( sprintf( __( 'Send information about %1$s, %2$s, %3$s and other %4$s projects via email', 'prayer-global-porch' ), 'Prayer.Global', 'Zume', 'Pray4Movement', 'Gospel Ambition' ) ) ?>
                                            </label>
                                        </div>
                                        <div class="form-check small">
                                            <input class="form-check-input user-check-preferences" type="checkbox" id="send_lap_emails" checked>
                                            <label class="form-check-label" for="send_lap_emails">
                                                <?php echo esc_html( __( 'Send me lap challenges via email', 'prayer-global-porch' ) ) ?>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="login-links">
                                        <p>
                                            <?php echo esc_html__( 'Already got an account?', 'prayer-global-porch' ) ?>
                                            <?php
                                                $login_url = '/user_app/login';
                                                $login_url = !empty( $redirect_to ) ? $login_url . "?redirect_to=$redirect_to" : $login_url;
                                            ?>
                                            <a href="<?php echo esc_url( $login_url ) ?>"><?php echo esc_html__( 'Login', 'prayer-global-porch' ) ?></a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <?php

                break;
            case 'login':
            // intentionally fall through to default for login
            default:
                ?>

                <section class="page-section pt-4" data-section="login" id="section-login">
                    <div class="container">
                        <div class="row justify-content-md-center text-center">
                            <div class="col-lg-7" id="pg_content">
                                <h2 class=""><?php echo esc_html__( 'Login', 'prayer-global-porch' ) ?></h2>
                                <div id="login-ui" style="display: none;">
                                    <?php echo do_shortcode( '[dt_firebase_login_ui lang_code="' . $lang . '"]' ) ?>
                                </div>
                                <div id="login-ui-loader">
                                    <span class="loading-spinner active"></span>
                                </div>
                                <div class="login-links">
                                    <p>
                                        <?php echo esc_html__( 'Not got an account?', 'prayer-global-porch' ) ?>
                                        <?php
                                            $register_url = '/user_app/login?action=register';
                                            $register_url = !empty( $redirect_to ) ? $register_url . "&redirect_to=$redirect_to" : $register_url;
                                        ?>
                                        <a href="<?php echo esc_url( $register_url ) ?>"><?php echo esc_html__( 'Register', 'prayer-global-porch' ) ?></a>
                                    </p>
                                    <ul class="w-fit text-align-left mx-auto">
                                        <li><?php echo esc_html__( 'See your prayer history', 'prayer-global-porch' ) ?></li>
                                        <li><?php echo esc_html__( 'Create your own prayer relays', 'prayer-global-porch' ) ?></li>
                                        <li><?php echo esc_html__( 'Get badges and more', 'prayer-global-porch' ) ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <?php
            break;
        }

        ?>

        <script src="<?php echo esc_url( trailingslashit( plugin_dir_url( __FILE__ ) ) ) ?>user-mobile-login.js?ver=<?php echo esc_attr( fileatime( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'user-mobile-login.js' ) ) ?>" defer></script>

        <?php

    }

}
PG_User_Login_Registration::instance();