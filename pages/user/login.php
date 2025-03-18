<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

class PG_Login extends PG_Public_Page {
    public $url_path = 'login';
    public $page_title = 'Login';
    public $rest_route = 'pg/login';

    public function __construct() {
        $current_page_path_matches = parent::__construct();
        if ( !$current_page_path_matches ) {
            return;
        }
        /**
         * Register custom hooks here
         */
    }

    public function register_endpoints() {
        register_rest_route( $this->rest_route, '/wp-login', [
            'methods' => 'POST',
            'callback' => [ $this, 'wp_login_endpoint' ],
        ] );

        register_rest_route( $this->rest_route, '/reset-password', [
            'methods' => 'POST',
            'callback' => [ $this, 'reset_password_endpoint' ],
        ] );
    }

    /**
     * Login the user using WordPress authentication
     * @param WP_REST_Request $request
     * @return WP_REST_Response|WP_Error
     */
    public function wp_login_endpoint( WP_REST_Request $request ) {
        $body = $request->get_body();
        $body = json_decode( $body );

        if ( !isset( $body->email ) || !isset( $body->password ) ) {
            return new WP_Error( 'bad_request', 'Email and password are required', [ 'status' => 400 ] );
        }

        // Find the WordPress user by email
        $user = get_user_by( 'email', $body->email );

        if ( !$user ) {
            return new WP_Error( 'invalid_credentials', 'Invalid email or password', [ 'status' => 401 ] );
        }

        // Check the password
        $check = wp_check_password( $body->password, $user->user_pass, $user->ID );

        if ( !$check ) {
            return new WP_Error( 'invalid_credentials', 'Invalid email or password', [ 'status' => 401 ] );
        }

        // Set the auth cookie for the user
        wp_set_auth_cookie( $user->ID, true );

        return new WP_REST_Response( [
            'status' => 200,
            'message' => 'Login successful',
            'data' => [
                'user_id' => $user->ID,
                'email' => $user->user_email,
                'display_name' => $user->display_name
            ]
        ] );
    }

    /**
     * Handle password reset requests
     * @param WP_REST_Request $request
     * @return WP_REST_Response|WP_Error
     */
    public function reset_password_endpoint( WP_REST_Request $request ){
        $body = $request->get_body();
        $body = json_decode( $body );

        if ( !isset( $body->email ) ){
            return new WP_Error( 'bad_request', 'Email is required', [ 'status' => 400 ] );
        }

        $user_data = get_user_by( 'email', $body->email );

        // If the user exists, generate and send the reset email
        if ( $user_data ){
            // Generate a password reset key
            $key = get_password_reset_key( $user_data );
            if ( is_wp_error( $key ) ){
                // Don't expose the error, just log it
                error_log( 'Error generating password reset key: ' . $key->get_error_message() );
            } else {
                // Send email with reset link
                $reset_url = add_query_arg( [
                    'action' => 'rp',
                    'key' => $key,
                    'login' => rawurlencode( $user_data->user_login )
                ], wp_login_url() );

                $message = __( 'Someone has requested a password reset for the following account:', 'prayer-global-porch' ) . "\r\n\r\n";
                $message .= network_home_url( '/' ) . "\r\n\r\n";
                $message .= sprintf( __( 'Username: %s', 'prayer-global-porch' ), $user_data->user_login ) . "\r\n\r\n";
                $message .= __( 'If this was a mistake, just ignore this email and nothing will happen.', 'prayer-global-porch' ) . "\r\n\r\n";
                $message .= __( 'To reset your password, visit the following address:', 'prayer-global-porch' ) . "\r\n\r\n";
                $message .= $reset_url . "\r\n";

                $title = __( 'Password Reset Request', 'prayer-global-porch' );

                $sent = wp_mail( $user_data->user_email, $title, $message );

                if ( !$sent ){
                    // Don't expose the error, just log it
                    error_log( 'Error sending password reset email to: ' . $user_data->user_email );
                }
            }
        }

        // Always return a success message, regardless of whether the email exists
        // This prevents user enumeration by not revealing if an email exists in the system
        return new WP_REST_Response( [
            'status' => 200,
            'message' => 'If a matching account was found, a password reset email has been sent'
        ] );
    }

    public function wp_enqueue_scripts() {
        wp_enqueue_script( 'user-mobile-login', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'user-mobile-login.js', [], fileatime( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'user-mobile-login.js' ), [ 'strategy' => 'defer' ] );
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
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/header.php' );
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

            .login-buttons {
                display: flex;
                flex-direction: column;
                gap: 1em;
                margin: 1em;
            }
            .login-buttons img {
                width: 1.5em;
                height: 1.5em;
            }
            .login-buttons button {
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
            .loginform {
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                text-align: start;
                gap: .7em;
            }
            .loginform label {
               width: 100%;
            }
            .loginform input{
                display: block;
                width: 100%;
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

            .login-modal {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 100%;
                height: 100%;
                background-color: rgba(0,0,0,0.5);
                align-items: center;
                justify-content: center;
                z-index: 1000;
                display: none;
            }
            .login-modal-content {
                background-color: #fff;
                padding: 20px;
                border-radius: 5px;
                max-width: 500px;
                width: 90%;
            }

            .login-links {
                text-align: center;
                margin-top: 1em;
            }
            .login-links p {
                margin-bottom: 0.5em;
            }
            
            #reset-password-form {
                display: none;
                margin-top: 1em;
                max-width: 20rem;
            }
            
            .reset-success-message {
                color: green;
                font-weight: bold;
                display: none;
                margin-top: 1em;
                text-align: center;
            }

            #reset-password-back {
                margin-bottom: 1.5em;
            }
        </style>
        <?php
    }

    /**
     * Print scripts to footer
     */
    public function footer_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/footer.php' );
        ?>
        <script>
          //check and redirect if the user is already logged in
          window.addEventListener('load', function() {
            if (pg_global.is_logged_in) {
              const url = new URL(location.href)
              const redirectTo = url.searchParams.get('redirect_to') || encodeURIComponent('/dashboard')

              location.href = decodeURIComponent(redirectTo)
            }
          })
        </script>
        <script type="module">
          import { initializeApp } from 'https://www.gstatic.com/firebasejs/11.4.0/firebase-app.js'
          import { getAuth, GoogleAuthProvider, signInWithPopup, signInWithEmailAndPassword, getAdditionalUserInfo, sendPasswordResetEmail } from 'https://www.gstatic.com/firebasejs/11.4.0/firebase-auth.js'

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
            signInWithPopup(auth, provider).then((userCredential) => {
                const AdditionalUserInfo = getAdditionalUserInfo(userCredential)
                const is_new_user = AdditionalUserInfo.isNewUser;
                if ( is_new_user ) {
                    // Show modal asking about news signup
                    const modal = document.getElementById('modal-news-signup')
                    modal.style.display = 'flex';

                    // Handle modal responses
                    document.getElementById('modal-yes').addEventListener('click', () => {
                      const marketing = true;
                      completeLogin(userCredential, marketing);
                      modal.style.display = 'none';
                    });
                    document.getElementById('modal-no').addEventListener('click', () => {
                      const marketing = false;
                      completeLogin(userCredential, marketing);
                      modal.style.display = 'none';
                    });
                } else {
                    completeLogin(userCredential, false);
                }
                // Function to complete the login process
                function completeLogin(userCredential, marketing) {
                  userCredential.extraData = {
                    marketing: marketing
                  }
                  fetch(`${rest_url}/session/login`, {
                    method: 'POST',
                    body: JSON.stringify(userCredential)
                  })
                  .then(() => {
                    location.href = '/dashboard';
                  });
                }
            }).catch((error) => {
              document.getElementById('login-error').innerText = error.message
              document.getElementById('login-error').style.display = 'block'
            });
          })

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

              // First try WordPress authentication
              fetch(`${window.pg_global.root}pg/login/wp-login`, {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                  email: email_field.value,
                  password: password_field.value
                })
              })
              .then((response) => {
                if (!response.ok) {
                  return Promise.reject(response);
                }
                return response.json();
              })
              .then((data) => {
                // WordPress authentication successful
                console.log("WordPress authentication successful");
                location.href = '/dashboard';
              })
              .catch((error) => {
                // If WordPress auth fails, try Firebase (legacy users)
                console.log("WordPress authentication failed, trying Firebase...");

                let wordpressErrorMessage = "";

                // Try to parse the error response if it exists
                if (error.json) {
                  error.json().then((errorData) => {
                    console.log("WordPress auth error:", errorData);
                    wordpressErrorMessage = errorData.message;
                    // If the error is from WordPress auth, we'll continue to Firebase fallback
                    // but store the error in case Firebase also fails
                  }).catch(() => {
                    // JSON parsing error, continue to Firebase silently
                  });
                }

                const auth = getAuth(app)
                signInWithEmailAndPassword(auth, email_field.value, password_field.value)
                .then((userCredential) => {
                  // Signed in with Firebase
                  console.log("Firebase authentication successful (legacy account)");
                  const user = userCredential.user;
                  fetch(`${rest_url}/session/login`, {
                    method: 'POST',
                    body: JSON.stringify(userCredential)
                  })
                  .then(() => {
                    location.href = '/dashboard'
                  })
                  .catch((fetchError) => {
                    // Failed to make the login request after Firebase auth
                    console.error("Firebase token validation error:", fetchError);
                    handleAuthError({ code: 'fetch_error', message: 'Error validating credentials' });
                  });
                })
                .catch((firebaseError) => {
                  // Both WordPress and Firebase auth failed
                  console.error("All authentication methods failed:", firebaseError);

                  // If WordPress returned an "invalid_credentials" error, prioritize that message
                  // instead of showing the Firebase-specific error
                  if (wordpressErrorMessage && wordpressErrorMessage.includes("Invalid email or password")) {
                    handleAuthError({
                      code: 'invalid_credentials',
                      message: wordpressErrorMessage || 'Invalid email or password'
                    });
                  } else {
                    handleAuthError(firebaseError);
                  }
                });
              });
            })

            // Helper function to handle authentication errors
            function handleAuthError(error) {
              const errorCode = error.code;
              const errorMessage = error.message;

              // Toggle the spinner and button
              document.querySelector('#login-submit .loading-spinner').classList.remove('active')
              document.querySelector('#login-submit').classList.remove('disabled')
              document.querySelector('#login-submit').removeAttribute('disabled')
              isSubmitting = false;

              // Show specific error messages based on the error code
              if (errorCode === 'auth/wrong-password' || errorCode === 'invalid_credentials') {
                // Use a generic error message for both WordPress and Firebase invalid credential errors
                document.getElementById('login-error').innerText = '<?php echo esc_html__( 'Invalid email or password. Please try again.', 'prayer-global-porch' ) ?>'
                document.getElementById('login-error').style.display = 'block'
              } else if (errorCode === 'auth/user-not-found') {
                emailError.style.display = 'block'
                emailError.innerText = '<?php echo esc_html__( 'Email not found. Please register.', 'prayer-global-porch' ) ?>'
              } else {
                document.getElementById('login-error').innerText = errorMessage || '<?php echo esc_html__( 'Authentication failed. Please try again or register for an account.', 'prayer-global-porch' ) ?>'
                document.getElementById('login-error').style.display = 'block'
              }
            }

            // Password reset handlers
            const forgotPasswordLink = document.getElementById('forgot-password-link');
            const resetPasswordContainer = document.getElementById('reset-password-form');
            const resetPasswordForm = document.getElementById('reset-password-form-element');
            const resetPasswordBackButton = document.getElementById('reset-password-back');
            const resetPasswordSubmit = document.getElementById('reset-password-submit');
            const resetEmail = document.getElementById('reset-email');
            const resetEmailError = document.getElementById('reset-email-error');
            const resetSuccessMessage = document.getElementById('reset-success-message');
            
            if (forgotPasswordLink) {
              forgotPasswordLink.addEventListener('click', (e) => {
                e.preventDefault();
                document.getElementById('login-email-password-form').style.display = 'none';
                document.getElementById('login-buttons').style.display = 'none';
                resetPasswordContainer.style.display = 'block';
              });
            }
            
            if (resetPasswordBackButton) {
              resetPasswordBackButton.addEventListener('click', () => {
                resetPasswordContainer.style.display = 'none';
                document.getElementById('login-email-password-form').style.display = 'block';
                resetSuccessMessage.style.display = 'none';
                resetEmailError.style.display = 'none';
              });
            }
            
            if (resetPasswordForm) {
              resetPasswordForm.addEventListener('submit', function(event) {
                event.preventDefault();
                
                if (resetEmail.value === '') {
                  resetEmailError.style.display = 'block';
                  resetEmailError.innerText = '<?php echo esc_html__( 'Email is required', 'prayer-global-porch' ) ?>';
                  return;
                }
                
                resetPasswordSubmit.querySelector('.loading-spinner').classList.add('active');
                resetPasswordSubmit.classList.add('disabled');
                resetPasswordSubmit.setAttribute('disabled', '');
                resetEmailError.style.display = 'none';
                
                // Try WordPress password reset first
                fetch(`${window.pg_global.root}pg/login/reset-password`, {
                  method: 'POST',
                  headers: {
                    'Content-Type': 'application/json',
                  },
                  body: JSON.stringify({
                    email: resetEmail.value
                  })
                })
                .then(response => {
                  if (!response.ok) {
                    return Promise.reject(response);
                  }
                  return response.json();
                })
                .then(data => {
                  // WordPress reset successful
                  console.log("WordPress password reset email sent");
                  resetSuccessMessage.style.display = 'block';
                  resetPasswordSubmit.querySelector('.loading-spinner').classList.remove('active');
                  resetPasswordSubmit.classList.remove('disabled');
                  resetPasswordSubmit.removeAttribute('disabled');
                })
                .catch(error => {
                  // If WordPress reset fails, try Firebase (legacy users)
                  console.log("WordPress reset failed, trying Firebase...");
                  
                  const auth = getAuth(app);
                  sendPasswordResetEmail(auth, resetEmail.value)
                    .then(() => {
                      // Firebase reset email sent
                      console.log("Firebase password reset email sent");
                      resetSuccessMessage.style.display = 'block';
                    })
                    .catch((firebaseError) => {
                      // Both reset methods failed
                      console.error("All password reset methods failed:", firebaseError);
                      
                      resetEmailError.innerText = '<?php echo esc_html__( 'No account found with that email address', 'prayer-global-porch' ) ?>';
                      resetEmailError.style.display = 'block';
                    })
                    .finally(() => {
                      resetPasswordSubmit.querySelector('.loading-spinner').classList.remove('active');
                      resetPasswordSubmit.classList.remove('disabled');
                      resetPasswordSubmit.removeAttribute('disabled');
                    });
                });
              });
            }
          }
        </script>
        <?php
    }
    /**
     * Print body
     */
    public function body(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . '/assets/nav.php' );

        $url = new DT_URL( dt_get_url_path() );

        $redirect_to = $url->query_params->has( 'redirect_to' ) ? urlencode( $url->query_params->get( 'redirect_to' ) ) : '';

        $register_url = '/register';
        $register_url = !empty( $redirect_to ) ? $register_url . "&redirect_to=$redirect_to" : $register_url;

        $svg_manager = new SVG_Spritesheet_Manager();
        $icons = [
            'pg-streak',
            'pg-relay',
            'pg-prayer',
            'pg-go-logo',
        ];
        $svgs_url = $svg_manager->get_cached_spritesheet_url( $icons );
        ?>

        <div class="login-modal" id="modal-news-signup">
            <div class="login-modal-content">
                <h3 class="d-flex align-items-center gap-2">
                    <?php echo esc_html__( 'Stay Updated', 'prayer-global-porch' ) ?>
                    <svg class="icon-md"><use href="<?php echo esc_html( $svgs_url ); ?>#pg-go-logo"></use></svg>
                </h3>
                <p>

                    <?php echo esc_html__( 'Sign up for Prayer.Global news and opportunities, and occasional communication from Prayer.Tools and GospelAmbition.org', 'prayer-global-porch' ) ?>?
                </p>
                <div style="display: flex; justify-content: space-between; margin-top: 20px; gap: 1rem;">
                    <button id="modal-no" class="btn btn-outline-primary btn-small"><?php echo esc_html__( 'No Thanks', 'prayer-global-porch' ) ?></button>
                    <button id="modal-yes" class="btn btn-primary btn-small"><?php echo esc_html__( 'Yes, Sign Me Up', 'prayer-global-porch' ) ?></button>
                </div>
            </div>
        </div>

        <section class="login-section pt-4" data-section="login" id="section-login">
            <div class="container center">
                <div class="login-register-links">
                    <a class="link-active" href="#"><?php esc_html_e( 'Login', 'prayer-global-porch' ); ?></a>
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
                        <div id="login-buttons" class="login-buttons">
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
                                    <form id="loginform" class="loginform" action="" method="POST" data-abide>
                                        <div>
                                            <label for="email">
                                                <?php esc_html_e( 'Email', 'prayer-global-porch' ) ?>
                                                <input class="input login-username" type="email" name="email" id="email" value="" aria-errormessage="email-error" required>
                                            </label>
                                            <span class="form-error
                                                    <?php echo ( $url->query_params->has( 'email_error' ) ? 'is-invalid-label' : '' ) ?>"
                                                  id="email-error">
                                                    <?php esc_html_e( 'Badly formatted email address', 'prayer-global-porch' ) ?>
                                            </span>
                                        </div>
                                        <div>
                                            <label for="password"><?php esc_html_e( 'Password', 'prayer-global-porch' ) ?>
                                                <input class="input login-password" type="password" id="password" name="password" aria-errormessage="password-error" required >

                                            </label>
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
                        
                        <!-- Password Reset Form -->
                        <div id="reset-password-form">
                            <button class="button btn btn-primary" id="reset-password-back">
                                <?php esc_html_e( 'Back to Login', 'prayer-global-porch' ); ?>
                            </button>
                            <h4><?php esc_html_e( 'Reset Password', 'prayer-global-porch' ); ?></h4>
                            <p><?php esc_html_e( 'Enter your email address and we\'ll send you a link to reset your password.', 'prayer-global-porch' ); ?></p>
                            <form id="reset-password-form-element" class="loginform" action="" method="POST" data-abide>
                                <div>
                                    <label for="reset-email">
                                        <?php esc_html_e( 'Email', 'prayer-global-porch' ) ?>
                                        <input class="input" type="email" name="reset-email" id="reset-email" value="" aria-errormessage="reset-email-error" required>
                                    </label>
                                    <span class="form-error" id="reset-email-error">
                                        <?php esc_html_e( 'Please enter a valid email address', 'prayer-global-porch' ) ?>
                                    </span>
                                </div>
                                <div>
                                    <button class="btn w-100 btn-secondary" id="reset-password-submit">
                                        <?php esc_html_e( 'Send Reset Link', 'prayer-global-porch' ) ?>
                                        <span class="loading-spinner"></span>
                                    </button>
                                </div>
                            </form>
                            <div class="reset-success-message" id="reset-success-message">
                                <?php esc_html_e( 'Password reset link has been sent to your email address.', 'prayer-global-porch' ) ?>
                            </div>
                        </div>
                        
                        <div class="login-links">
                            <p>
                                <?php echo esc_html__( 'Don\'t have an account?', 'prayer-global-porch' ) ?>
                                <a href="<?php echo esc_url( $register_url ) ?>"><?php echo esc_html__( 'Register', 'prayer-global-porch' ) ?></a>
                            </p>
                            <p>
                                <a href="#" id="forgot-password-link"><?php echo esc_html__( 'Forgot Password?', 'prayer-global-porch' ) ?></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}

new PG_Login();
