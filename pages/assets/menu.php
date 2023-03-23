<?php

function pg_menu( bool $is_custom_lap = false, string $key = '' ) {

    $url = dt_get_url_path();

    if ( $is_custom_lap ) {
        $start_praying_href = "/prayer_app/custom/$key";
        $map_href = "/prayer_app/custom/$key/map";
    } else {
        $start_praying_href = '/newest/lap';
        $map_href = '/newest/map';
    }

    ?>

    <div class="offcanvas offcanvas-end pg-navmenu" data-bs-backdrop="true" data-bs-scroll="true" id="probootstrap-navbar">
        <div class="offcanvas-header">
            <div class="row" style="--bs-gutter-x: 1.5rem">

            <?php if ( ! $is_custom_lap ) : ?>

                <a href="/" class="col icon-button black three-em"><i class="ion-home black"></i></a>

            <?php endif; ?>

            <a href="/user_app/profile" class="col icon-button black three-em" id="user-profile-link" style="display: none" data-pg-is-logged-in>
                <i class="ion-person"></i>
            </a>

                <!--<h5 class="offcanvas-title" id="offcanvasNavbarDarkLabel">Prayer.Global</h5>-->
            </div>
            <button type="button" class="btn-close pe-4" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="navbar-nav justify-content-end me-3" id="nav-links">
                <a class="btn btn-outline-dark py-2 me-3 w-100 mb-4" href="<?php esc_url( $start_praying_href ) ?>">Start Praying</a>

                <a class="nav-link" href="<?php echo ( $url !== '' ) ? esc_url( trailingslashit( site_url() ) ) : '' ?>#section-lap">Status</a>
                <a class="nav-link" href="<?php echo esc_url( $map_href ) ?>">Map</a>

                <?php if ( ! $is_custom_lap ) : ?>

                    <a class="nav-link" href="/challenges/active/">Groups</a>

                <?php endif; ?>

                <a class="nav-link" href="/content_app/give_page">Give</a>

                <!-- <a href="/user_app/profile" class="nav-link" id="login-register-link" style="display: none" data-pg-is-logged-out>Login / Register</a> -->
            </div>
            <div class="nav-buttons">
                <button class="icon-button share-button" data-toggle="modal" data-target="#exampleModal">
                    <img src="<?php echo esc_html( plugin_dir_url( __DIR__ ) ) ?>assets/images/share.svg" alt="Share">
                </button>
                <a href="<?php echo esc_url( '/user_app/logout' )?>" class="icon-button black three-em" id="logout-link" style="display: none" data-pg-is-logged-in>
                    <i class="ion-log-out"></i>
                </a>
            </div>
        </div>
    </div>

    <?php

}

?>