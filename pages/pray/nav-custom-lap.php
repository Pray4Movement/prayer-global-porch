<?php

function pg_custom_lap_nav( $key ) {

    $url = dt_get_url_path();

    $dark_nav_class = str_contains( $url, 'stats' ) || str_contains( $url, 'completed' ) ? 'navbar-dark' : '';

    ?>

    <nav class="navbar <?php echo $dark_nav_class ?> pg-navbar bg-none scrolled-light" id="pg-navbar">
        <div class="container align-items-center">
            <a class="navbar-brand me-auto" href="/">Prayer.Global</a>
            <a class="navbar__cta btn btn-outline-dark py-2 py-lg-4 me-3" href="/prayer_app/custom/<?php echo esc_attr( $key ) ?>">Start Praying</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#probootstrap-navbar" aria-controls="probootstrap-navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span><i class="ion-navicon"></i></span>
            </button>
        </div>
        <div class="offcanvas offcanvas-end pg-navmenu" data-bs-backdrop="true" data-bs-scroll="true" id="probootstrap-navbar">
            <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavbarDarkLabel">Prayer.Global</h5>
            <button type="button" class="btn-close pe-4" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="navbar-nav justify-content-end pe-3">
                    <a class="btn btn-outline-dark py-2 me-3 w-100 mb-4" href="/prayer_app/custom/<?php echo esc_attr( $key ) ?>">Start Praying</a>
                    <a class="nav-link" href="/#section-challenge">Challenge</a>
                    <a class="nav-link" href="/#section-lap">Status</a>
                    <a class="nav-link" href="/prayer_app/custom/<?php echo esc_attr( $key ) ?>/map/">Map</a>
                    <div class="nav-buttons">
                        <img class="icon-button share-button" data-toggle="modal" data-target="#exampleModal" data-white src="<?php echo esc_html( plugin_dir_url( __DIR__ ) ) ?>assets/images/share.svg" alt="Share">
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <?php
}