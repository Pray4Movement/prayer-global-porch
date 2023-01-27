<?php

/**
 * Check if the user is logged in for redirection purposes
 *
 * Spitting out a script if the user is using front end login feels dirty
 *
 * Switching to doing this auth check from the frontend
 * @return mixed
 */
function pg_login_redirect_if_no_auth() {
    /* Check what the login method is */
    $login_method = pg_login_field( 'login_method' );

    if ( !is_user_logged_in() && DT_Login_Methods::WORDPRESS === $login_method ) {
        $redirect_to = '/user_app/profiles';

        header( "Location: /user_app/login?redirect_to=$redirect_to" );
    }

    if ( DT_Login_Methods::MOBILE === $login_method ) {

        ?>

        <script>
            /* Check if the user has a valid token */
            const token = localStorage.getItem( 'login_token' );

            if ( !token ) {
                redirect()
            }

            fetch( '/wp-json/jwt-auth/v1/token/validate', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                }
            } )
            .then((result) => result.text())
            .then((text) => {
                const json = JSON.parse(text)

                const { data } = json
                const { status } = data

                if ( status !== 200 ) {
                    redirect()
                }
            })
            .catch((error) => {
                redirect()
            })

            function redirect() {
                const redirect_to = encodeURIComponent( window.location.href )
                window.location.href = `/user_app/login?redirect_to=${redirect_to}`
            }

        </script>

        <?php

    }
}