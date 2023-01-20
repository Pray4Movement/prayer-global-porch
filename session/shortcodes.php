<?php

if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

add_shortcode( 'dt_firebase_login_ui', 'dt_firebase_login_ui');

function dt_firebase_login_ui( $attr ) {
        $fields = get_option( 'dt_custom_login_fields' );
        $invalid_settings = empty( $fields['firebase_api_key']['value'] ) ||
                            empty( $fields['firebase_project_id']['value'] ) ||
                            empty( $fields['firebase_app_id']['value'] ) ? 1 : 0;

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


    <div id="firebaseui-auth-container"></div>

    <div id="loader">
        <span class="loading-spinner active"></span>
    </div>

    <?php
}