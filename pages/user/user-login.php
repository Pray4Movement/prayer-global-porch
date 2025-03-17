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
        return $allowed_css;
    }

    public function dt_magic_url_base_allowed_js( $allowed_js ) {
        return [];
    }

    public function header_style(){
        ?>
        <style>
            .center:not(.absolute) {
                box-sizing: content-box;
                margin-left: auto;
                margin-right: auto;
                display:flex;
                flex-direction: column;
                align-items: center;
            }
            .separator {
                display: flex;
                align-items: center;
                text-align: center;
                margin: 0 2em;
            }
            .separator::before,
            .separator::after {
                content: '';
                flex: 1;
                border-bottom: 1px solid #000;
            }
            .separator:not(:empty)::before {
                margin-right: .5em;
            }
            .separator:not(:empty)::after {
                margin-left: .5em;
            }

            .login-section {
                background-color: var(--pg-brand-color);
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                max-width: 100vw;
                padding: 2em 0 5em 0;
                margin: 0;
            }
            .login-section .container {
                max-width: calc(min(25rem, 100%));
                padding: 0;
            }
            .card {
                background-color: white;
                border-radius: 10px;
            }
            .login-register-links {
                width: 100%;
                display: flex;
                justify-content: space-evenly;
                align-items: center;
                margin: 1em 0;
            }
            .login-register-links a.link-active {
                background-color: white;
                color: var(--pg-brand-color);
            }
            .login-register-links a {
                background-color: var(--pg-brand-color);
                cursor: pointer;
                text-decoration: none;
                color: white;
                border: 1px solid white;
                border-radius: 10px;
                padding: .5rem 1.5rem;
            }
            .login-section hr {
                border-top: 4px solid;
                border-color: var(--pg-secondary-color);
                max-width: 80%;
                margin: 2em auto;
            }

            #card-content {
                padding: 1em;
            }

            /*desktop view */
            @media (min-width: 768px) {
                #card-content {
                    padding: 2em 4em;
                }
                .login-section .container {
                    max-width: 40rem;
                }
            }

            .reasons-list {
                list-style: none;
                padding: 0;
                margin: 0;
                display: flex;
                flex-direction: column;
                gap: 1em;
            }
            .reasons-list li {
                display: flex;
                align-items: center;
                gap: 1em;
            }

            #extra_register_input_marketing {
                display: inline-grid;
                transform: none;
            }

            #login-buttons {
                display: flex;
                flex-direction: column;
                gap: 1em;
                margin: 1em;
            }
            #login-buttons img {
                width: 1.5em;
                height: 1.5em;
            }
            #login-buttons button {
                border-radius: 15px;
                padding: .5rem 2rem;
                display: flex;
                align-items: center;
                justify-self: center;
                width: 100%;
                justify-content: center;
            }
            .google-button {
                background-color: var(--pg-brand-color);
                color: white;
            }
            .email-button {
                background-color: white;
                color: var(--pg-brand-color);
                border: 1px solid var(--pg-brand-color);
            }
            #loginform {
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                text-align: start;
                gap: .7em;
            }
            #loginform input{
                display: block;
                width: 100%;
                border: 2px solid var(--pg-grey);
                border-radius: 10px;
                padding: 5px 10px;
                box-shadow: rgba(0,0,0,0.1) 0 3px 4px 1px;
                color: black;
            }
            .login-username, .login-password {
                width: 100%;
            }
            .form-error {
                display: none;
                font-size: 1rem;
                font-weight: 700;
            }

            .form-error, .is-invalid-label {
                color: #cc4b37;
            }
            meter{
                width:100%;
            }
            /* Webkit based browsers */
            meter[value="1"]::-webkit-meter-optimum-value { background: red; }
            meter[value="2"]::-webkit-meter-optimum-value { background: yellow; }
            meter[value="3"]::-webkit-meter-optimum-value { background: orange; }
            meter[value="4"]::-webkit-meter-optimum-value { background: green; }

            /* Gecko based browsers */
            meter[value="1"]::-moz-meter-bar { background: red; }
            meter[value="2"]::-moz-meter-bar { background: yellow; }
            meter[value="3"]::-moz-meter-bar { background: orange; }
            meter[value="4"]::-moz-meter-bar { background: green; }
        </style>
        <?php
    }

    public function wp_enqueue_scripts() {
        wp_enqueue_script( 'pass-strength', 'https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.2.0/zxcvbn.js', [], '4.2.0', true );
        wp_enqueue_script( 'user-mobile-login', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'user-mobile-login.js', [], fileatime( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'user-mobile-login.js' ), [ 'strategy' => 'defer' ] );
    }

    public function header_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/header.php' );
    }

    public function footer_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/footer.php' );
        ?>
        <script>
          //check and redirect if the user is already logged in
          window.addEventListener('load', function() {
              if (pg_global.is_logged_in) {
                const url = new URL(location.href)
                const redirectTo = url.searchParams.get('redirect_to') || encodeURIComponent('/profile')

                location.href = decodeURIComponent(redirectTo)
              }
          })
        </script>
        <script type="module">
          import { initializeApp } from 'https://www.gstatic.com/firebasejs/11.4.0/firebase-app.js'
          import { getAuth, GoogleAuthProvider, signInWithPopup, createUserWithEmailAndPassword, signInWithEmailAndPassword } from 'https://www.gstatic.com/firebasejs/11.4.0/firebase-auth.js'

          const firebaseConfig = {
            apiKey: "AIzaSyCJEy7tJL_YSQPYH4H92_n0kQBhmYcj1l8",
            authDomain: "auth.prayer.global",
            projectId: "prayer-global-dbbaa",
            storageBucket: "prayer-global-dbbaa.firebasestorage.app",
            messagingSenderId: "764994067122",
            appId: "1:764994067122:web:a8d34e86451c0d966947ab",
            measurementId: "G-HTYNN26M7X"
          };

          // Initialize Firebase
          const app = initializeApp(firebaseConfig);
          let rest_url = '<?php echo esc_url( rest_url( 'dt/v1' ) ) ?>';

          //handle sign in with Google
          document.getElementById('signin-google').addEventListener('click', () => {
            const auth = getAuth(app)
            const provider = new GoogleAuthProvider();
            signInWithPopup(auth, provider).then((result) => {
              fetch( `${rest_url}/session/login`, {
                method: 'POST',
                body: JSON.stringify(result)
              })
              .then(() => {
                location.href = '/profile'
              })
            }).catch((error) => {
              document.getElementById('login-error').innerText = error.message
              document.getElementById('login-error').style.display = 'block'
            });
          })

          if( document.getElementById('section-register') ){
              document.getElementById('register-password').addEventListener('click', () => {
                document.getElementById('register-email-password-form').style.display = 'block'
                document.getElementById('login-buttons').style.display = 'none'
              })
              document.getElementById('register-email-password-form-back').addEventListener('click', () => {
                document.getElementById('register-email-password-form').style.display = 'none'
                document.getElementById('login-buttons').style.display = 'block'
              })

              const strength = {
                0: "Worst",
                1: "Bad",
                2: "Weak",
                3: "Good",
                4: "Strong"
              }
              const minStrength = 1
              let isSubmitting = false

              const form = document.getElementById('loginform')
              const password_field = document.getElementById('password');
              const password2 = document.getElementById('password2');
              const passwordStrengthError = document.getElementById('password-error-too-weak')
              const passwordsDontMatchError = document.getElementById('password-error-2')
              const meter = document.getElementById('password-strength-meter');

                function getPasswordStrength(p) {
                    if (typeof zxcvbn !== 'function') {
                      return p.length >= 8 ? 3 : 0
                    }
                    return zxcvbn(p).score;
                }

              password_field.addEventListener('input', function() {
                const password = password_field.value;
                const password_strength = getPasswordStrength(password);
                // Update the password strength meter
                meter.value = password_strength

                if ( password_strength >= minStrength ) {
                  passwordStrengthError.style.display = 'none'
                }
              });

              form.addEventListener('submit', function(event) {
                const password = password_field.value;
                const password_strength = getPasswordStrength(password);

                if ( password_strength < minStrength ) {
                  event.preventDefault()
                  passwordStrengthError.style.display = 'block'
                  return
                }

                if (password_field.value !== password2.value) {
                  event.preventDefault()
                  passwordsDontMatchError.style.display = 'block'
                  return
                }

                if (isSubmitting) {
                  event.preventDefault()
                  return
                }
                event.preventDefault()

                const submitButtenElement = document.querySelector('#register-submit')
                submitButtenElement.querySelector('.loading-spinner').classList.add('active')
                submitButtenElement.classList.add('disabled')
                submitButtenElement.setAttribute('disabled', '')

                isSubmitting = true

                const email = event.target.email?.value
                if (email === '') {
                  event.preventDefault()
                  return
                }
                const pass = event.target.password?.value
                if (pass.value === '') {
                  event.preventDefault()
                  return
                }

                const name = event.target.name?.value || email

                const auth = getAuth(app)
                createUserWithEmailAndPassword(auth, email, pass)
                  .then((userCredential) => {
                    // Signed in
                    const user = userCredential.user;
                    user.displayName = name
                    fetch(`${rest_url}/session/login`, {
                      method: 'POST',
                      body: JSON.stringify(userCredential)
                    })
                    .then(() => {
                      location.href = '/profile'
                    })
                  })
                  .catch((error) => {
                    const errorCode = error.code;
                    const errorMessage = error.message;
                    //toggle the spinner and button
                    submitButtenElement.querySelector('.loading-spinner').classList.remove('active')
                    submitButtenElement.classList.remove('disabled')
                    submitButtenElement.removeAttribute('disabled')
                    if ( errorCode === 'auth/email-already-in-use' ) {
                      document.getElementById('login-error').innerText = '<?php echo esc_html__( 'Email already in use, please login instead.', 'prayer-global-porch' ) ?>'
                    } else {
                      document.getElementById('login-error').innerText = errorMessage
                    }
                    //show the error message
                    document.getElementById('login-error').style.display = 'block'
                    isSubmitting = false
                  });
              })
          }


          if( document.getElementById('section-login') ){
            document.getElementById('register-password').addEventListener('click', () => {
                document.getElementById('login-email-password-form').style.display = 'block'
                document.getElementById('login-buttons').style.display = 'none'
            })
            document.getElementById('login-email-password-form-back').addEventListener('click', () => {
                document.getElementById('login-email-password-form').style.display = 'none'
                document.getElementById('login-buttons').style.display = 'block'
            })

            let isSubmitting = false
            const form = document.getElementById('loginform')
            const email_field = document.getElementById('email');
            const password_field = document.getElementById('password');
            const emailError = document.getElementById('email-error')
            const passwordError = document.getElementById('password-error')

            form.addEventListener('submit', function(event) {
              if (email_field.value === '') {
                event.preventDefault()
                emailError.style.display = 'block'
                return
              }
              if (password_field.value === '') {
                event.preventDefault()
                passwordError.style.display = 'block'
                return
              }

              if (isSubmitting) {
                event.preventDefault()
                return
              }
              event.preventDefault()

              const submitButtenElement = document.querySelector('#login-submit')
              submitButtenElement.querySelector('.loading-spinner').classList.add('active')
              submitButtenElement.classList.add('disabled')
              submitButtenElement.setAttribute('disabled', '')

              isSubmitting = true
              const auth = getAuth(app)
                signInWithEmailAndPassword(auth, email_field.value, password_field.value)
                    .then((userCredential) => {
                    // Signed in
                    const user = userCredential.user;
                    fetch(`${rest_url}/session/login`, {
                        method: 'POST',
                        body: JSON.stringify(userCredential)
                    })
                    .then(() => {
                        location.href = '/profile'
                    })
                    })
                    .catch((error) => {
                    const errorCode = error.code;
                    const errorMessage = error.message;
                    //toggle the spinner and button
                    submitButtenElement.querySelector('.loading-spinner').classList.remove('active')
                    submitButtenElement.classList.remove('disabled')
                    submitButtenElement.removeAttribute('disabled')
                    if ( errorCode === 'auth/wrong-password' ) {
                        passwordError.style.display = 'block'
                        passwordError.innerText = '<?php echo esc_html__( 'Invalid password. Please try again.', 'prayer-global-porch' ) ?>'
                    } else if ( errorCode === 'auth/user-not-found' ) {
                        emailError.style.display = 'block'
                        emailError.innerText = '<?php echo esc_html__( 'Email not found. Please register.', 'prayer-global-porch' ) ?>'
                    } else {
                        document.getElementById('login-error').innerText = errorMessage
                        document.getElementById('login-error').style.display = 'block'
                    }
                    isSubmitting = false
                });
            })
        }
        </script>
        <?php
    }


    public function body() {
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . '/assets/nav.php' );

        $lang = pg_get_current_lang();

        $url = new DT_URL( dt_get_url_path() );

        $action = $url->query_params->has( 'action' ) ? $url->query_params->get( 'action' ) : 'login';
        $redirect_to = $url->query_params->has( 'redirect_to' ) ? urlencode( $url->query_params->get( 'redirect_to' ) ) : '';

        $login_url = '/user_app/login';
        $login_url = !empty( $redirect_to ) ? $login_url . "?redirect_to=$redirect_to" : $login_url;

        $register_url = '/user_app/login?action=register';
        $register_url = !empty( $redirect_to ) ? $register_url . "&redirect_to=$redirect_to" : $register_url;

        $svg_manager = new SVG_Spritesheet_Manager();
        $icons = [
            'pg-streak',
            'pg-relay',
            'pg-prayer',
            'pg-go-logo',
        ];
        $svgs_url = $svg_manager->get_cached_spritesheet_url( $icons );

        switch ( $action ) {
            case 'register':
                ?>
                <section class="login-section pt-4" data-section="register" id="section-register">
                    <div class="container center">
                        <div class="login-register-links">
                            <a href="<?php echo esc_html( $login_url ); ?>"><?php esc_html_e( 'Login', 'prayer-global-porch' ); ?></a>
                            <a class="link-active" href="<?php echo esc_html( $register_url ); ?>"><?php esc_html_e( 'Register', 'prayer-global-porch' ); ?></a>
                        </div>
                        <div class="card">
                            <div id="card-content">
                                <h2 class="pt-4 m-0"><?php echo esc_html__( 'Register', 'prayer-global-porch' ) ?></h2>
                                <hr>
                                <p class="center" style="font-size: larger"><?php echo esc_html__( 'Create your own free login', 'prayer-global-porch' ) ?></p>
                                <ul class="reasons-list w-fit text-align-left mx-auto">
                                    <li>
                                        <svg class="icon-sm"><use href="<?php echo esc_html( $svgs_url ); ?>#pg-relay"></use></svg>
                                        <?php echo esc_html__( 'Join and create custom prayer relays', 'prayer-global-porch' ) ?>
                                    </li>
                                    <li>
                                        <svg class="icon-sm"><use href="<?php echo esc_html( $svgs_url ); ?>#pg-prayer"></use></svg>
                                        <?php echo esc_html__( 'View your interactive prayer history', 'prayer-global-porch' ) ?>
                                    </li>
                                    <li>
                                        <svg class="icon-sm"><use href="<?php echo esc_html( $svgs_url ); ?>#pg-streak"></use></svg>
                                        <?php echo esc_html__( 'Prayer streaks, badges and more', 'prayer-global-porch' ) ?>
                                    </li>
                                </ul>
                                <hr>
                                <div class="flow-medium">
                                    <svg class="icon-lg"><use href="<?php echo esc_html( $svgs_url ); ?>#pg-go-logo"></use></svg>
                                    <div class="marketing-options" style="text-align: start">
                                        <div class="form-check small m-3">
                                            <label class="form-check-label" for="extra_register_input_marketing">
                                                <input type="checkbox" id="extra_register_input_marketing" checked>
                                                <?php echo esc_html( __( 'Sign up for Prayer.Global news and opportunities, and occasional communication from Prayer.Tools and GospelAmbition.org', 'prayer-global-porch' ) ) ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div id="login-buttons">
                                    <div>
                                        <button id="signin-google" class="google-button" data-provider-id="google.com">
                                            <span style="margin-right: 10px">
                                                <img alt="sign in with google"
                                                     src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg">
                                            </span>
                                            <span><?php echo esc_html__( 'Register with Google', 'prayer-global-porch' ); ?></span>
                                        </button>
                                    </div>
                                    <div class="separator"><?php echo esc_html__( 'OR', 'prayer-global-porch' ); ?></div>
                                    <div>
                                        <button id="register-password" class="email-button" data-provider-id="password">
                                            <!--<span style="margin-right: 10px">-->
                                            <!--    <img alt="sign in with google"-->
                                            <!--         src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/mail.svg">-->
                                            <!--</span>-->
                                            <span><?php echo esc_html__( 'Register with Email', 'prayer-global-porch' ); ?></span>
                                        </button>
                                    </div>
                                </div>
                                <div id="register-email-password-form" style="display: none">
                                    <button class="button btn btn-primary" id="register-email-password-form-back">
                                        <?php esc_html_e( 'Back', 'prayer-global-porch' ); ?>
                                    </button>
                                    <div class="wp_register_form">
                                        <div>
                                            <form id="loginform" action="" method="POST" data-abide>
                                                <!--name-->
                                                <div>
                                                    <label for="name">
                                                        <?php esc_html_e( 'Name', 'prayer-global-porch' ) ?>
                                                    </label>
                                                    <input class="input" type="text" name="name" id="name" value="" required>
                                                </div>
                                                <div>
                                                    <label for="email">
                                                        <?php esc_html_e( 'Email', 'prayer-global-porch' ) ?>
                                                    </label>
                                                    <input class="input" type="email" name="email" id="email" value="" aria-errormessage="email-error" required>
                                                    <span class="form-error" id="email-error">
                                                        <?php esc_html_e( 'Badly formatted email address', 'prayer-global-porch' ) ?>
                                                    </span>
                                                </div>
                                                <div>
                                                    <label for="password"><?php esc_html_e( 'Password', 'prayer-global-porch' ) ?></label>
                                                    <input class="input" type="password" id="password" name="password" aria-errormessage="password-error-too-weak" required >
                                                    <span class="form-error" id="password-error-too-weak">
                                                        <?php esc_html_e( 'Password is not strong enough', 'prayer-global-porch' ) ?>
                                                    </span>
                                                </div>
                                                <meter max="4" id="password-strength-meter" value="0"></meter>
                                                <div>
                                                    <label class="show-for-sr"><?php esc_html_e( 'Re-enter Password', 'prayer-global-porch' ) ?></label>
                                                    <input class="input" id="password2" name="password2" type="password" aria-errormessage="password-error-2" data-equalto="password" required>
                                                    <span class="form-error" id="password-error-2">
                                                    <?php esc_html_e( 'Passwords do not match. Please, try again.', 'prayer-global-porch' ) ?>
                                                </span>
                                                </div>
                                                <?php wp_nonce_field( 'login_form', 'login_form_nonce' ) ?>
                                                <div>
                                                    <button class="btn w-100 btn-secondary" id="register-submit">
                                                        <?php esc_html_e( 'Register', 'prayer-global-porch' ) ?>
                                                        <span class="loading-spinner"></span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div id="login-ui-loader">
                                    <span class="loading-spinner"></span>
                                </div>
                                <div class="error-message">
                                    <span class="form-error" id="login-error">
                                        <?php echo esc_html__( 'There was a problem with your login. Please try again.', 'prayer-global-porch' ) ?>
                                    </span>
                                </div>
                                <div class="flow-medium">
                                    <div class="login-links">
                                        <p>
                                            <?php echo esc_html__( 'Already got an account?', 'prayer-global-porch' ) ?>
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
                <section class="login-section pt-4" data-section="login" id="section-login">
                    <div class="container center">
                        <div class="login-register-links">
                            <a class="link-active" href="<?php echo esc_html( $login_url ); ?>"><?php esc_html_e( 'Login', 'prayer-global-porch' ); ?></a>
                            <a href="<?php echo esc_html( $register_url ); ?>"><?php esc_html_e( 'Register', 'prayer-global-porch' ); ?></a>
                        </div>
                        <div class="card">
                            <div id="card-content">
                                <h2 class=""><?php echo esc_html__( 'Login', 'prayer-global-porch' ) ?></h2>
                                <hr>
                                <ul class="reasons-list w-fit text-align-left mx-auto">
                                    <li>
                                        <svg class="icon-sm"><use href="<?php echo esc_html( $svgs_url ); ?>#pg-relay"></use></svg>
                                        <?php echo esc_html__( 'Join and create custom prayer relays', 'prayer-global-porch' ) ?>
                                    </li>
                                    <li>
                                        <svg class="icon-sm"><use href="<?php echo esc_html( $svgs_url ); ?>#pg-prayer"></use></svg>
                                        <?php echo esc_html__( 'View your interactive prayer history', 'prayer-global-porch' ) ?>
                                    </li>
                                    <li>
                                        <svg class="icon-sm"><use href="<?php echo esc_html( $svgs_url ); ?>#pg-streak"></use></svg>
                                        <?php echo esc_html__( 'Prayer streaks, badges and more', 'prayer-global-porch' ) ?>
                                    </li>
                                </ul>
                                <hr>
                                <div id="login-ui-loader">
                                    <span class="loading-spinner"></span>
                                </div>
                                <div id="login-buttons">
                                    <div>
                                        <button id="signin-google" class="google-button" data-provider-id="google.com">
                                            <span style="margin-right: 10px">
                                                <img alt="sign in with google"
                                                     src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg">
                                            </span>
                                            <span><?php echo esc_html__( 'Sign in with Google', 'prayer-global-porch' ); ?></span>
                                        </button>
                                    </div>
                                    <div class="separator"><?php echo esc_html__( 'OR', 'prayer-global-porch' ); ?></div>
                                    <div>
                                        <button id="register-password" class="email-button" data-provider-id="password">
                                            <span><?php echo esc_html__( 'Continue with Email', 'prayer-global-porch' ); ?></span>
                                        </button>
                                    </div>
                                </div>
                                <div id="login-email-password-form" style="display: none">
                                    <button class="button btn btn-primary" id="login-email-password-form-back">
                                        <?php esc_html_e( 'Back', 'prayer-global-porch' ); ?>
                                    </button>
                                    <div class="wp_register_form">
                                        <div>
                                            <form id="loginform" action="" method="POST" data-abide>
                                                <div>
                                                    <label for="email">
                                                        <?php esc_html_e( 'Email', 'prayer-global-porch' ) ?>
                                                    </label>
                                                    <input class="input login-username" type="email" name="email" id="email" value="" aria-errormessage="email-error" required>
                                                    <span class="form-error
                                                            <?php echo ( $url->query_params->has( 'email_error' ) ? 'is-invalid-label' : '' ) ?>"
                                                            id="email-error">
                                                            <?php esc_html_e( 'Badly formatted email address', 'prayer-global-porch' ) ?>
                                                    </span>
                                                </div>
                                                <div>
                                                    <label for="password"><?php esc_html_e( 'Password', 'prayer-global-porch' ) ?></label>
                                                    <input class="input login-password" type="password" id="password" name="password" aria-errormessage="password-error" required >
                                                    <span class="form-error
                                                            <?php echo ( $url->query_params->has( 'password_error' ) ? 'is-invalid-label' : '' ) ?>"
                                                            id="password-error">
                                                        <?php esc_html_e( 'Password is required', 'prayer-global-porch' ) ?>
                                                    </span>
                                                </div>
                                                <div data-abide-error class="form-error" id="login-error" style="display: none;">
                                                    <p><i class="fi-alert"></i><?php esc_html_e( 'There are some errors in your form.', 'prayer-global-porch' ) ?></p>
                                                </div>
                                                <?php wp_nonce_field( 'login_form', 'login_form_nonce' ) ?>

                                                <div>
                                                    <button class="btn w-100 btn-secondary" id="login-submit">
                                                        <?php esc_html_e( 'Login', 'prayer-global-porch' ) ?>
                                                        <span class="loading-spinner"></span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="login-links">
                                    <p>
                                        <?php echo esc_html__( 'Don\'t have an account?', 'prayer-global-porch' ) ?>
                                        <a href="<?php echo esc_url( $register_url ) ?>"><?php echo esc_html__( 'Register', 'prayer-global-porch' ) ?></a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <?php
            break;
        }
    }
}
PG_User_Login_Registration::instance();
