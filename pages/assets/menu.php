<?php

function pg_menu( bool $is_custom_lap = false, string $key = '' ) {

    $url = dt_get_url_path();

    if ( $is_custom_lap ) {
        $start_praying_href = "/$key/pray";
        $map_href = "/$key/map";
    } else {
        $start_praying_href = '/newest/lap';
        $map_href = '/newest/map';
    }

    ?>

    <div class="offcanvas offcanvas-end pg-navmenu" data-bs-backdrop="true" data-bs-scroll="true" id="probootstrap-navbar">
        <div class="offcanvas-header blue-bg white p-3">
            <a href="/?internal" class="icon-button two-rem d-flex align-items-center mx-2" title="Home">
                <i class="icon pg-home"></i>
            </a>
            <div class="d-flex">
                <a href="/dashboard" class="icon-button mx-2 two-rem d-flex align-items-center" title="Profile" id="user-profile-link">

                    <?php if ( is_user_logged_in() ) : ?>

                        <?php //phpcs:ignore ?>
                        <?php echo pg_profile_icon(); ?>

                    <?php else : ?>

                        <span class="one-rem"><?php echo esc_html__( 'Login', 'prayer-global-porch' ); ?></span>

                    <?php endif; ?>

                </a>

                <?php if ( !is_user_logged_in() ) : ?>

                    <div class="d-flex justify-content-end align-items-center mx-2">

                        <?php require( __DIR__ . '/language-menu.php' ) ?>

                    </div>

                <?php endif; ?>

                <button type="button" class="icon-button p-0 two-rem d-flex ms-2" data-bs-dismiss="offcanvas" aria-label="Close">
                    <i class="icon pg-close"></i>
                </button>
            </div>
        </div>
        <div class="offcanvas-body">
            <div class="navbar-nav justify-content-end text-center uppercase brand-light" id="nav-links">

                <a class="nav-link" href="<?php echo ( $url !== '' ) ? esc_url( trailingslashit( site_url() ) ) : '' ?>#section-lap">
                    <div class="nav-link__inner">
                        <i class="icon pg-status"></i>
                        <span><?php echo esc_html( __( 'Status', 'prayer-global-porch' ) ) ?></span>
                    </div>
                </a>
                <a class="nav-link" href="<?php echo esc_url( $map_href ) ?>">
                    <div class="nav-link__inner">
                        <i class="icon pg-world-light"></i>
                        <span><?php echo esc_html( __( 'Map', 'prayer-global-porch' ) ) ?></span>
                    </div>
                </a>

                <?php if ( ! $is_custom_lap ) : ?>

                    <a class="nav-link" href="/challenges/active/">
                        <div class="nav-link__inner">
                            <i class="icon pg-relay"></i>
                            <span><?php echo esc_html( __( 'Prayer Relays', 'prayer-global-porch' ) ) ?></span>
                        </div>
                    </a>

                <?php endif; ?>

                <a class="nav-link" href="/give">
                    <div class="nav-link__inner">
                        <i class="icon pg-give"></i>
                        <span><?php echo esc_html( __( 'Donate', 'prayer-global-porch' ) ) ?></span>
                    </div>
                </a>

                <a class="nav-link" href="/content_app/about_page">
                    <div class="nav-link__inner">
                        <i class="icon pg-question-dark"></i>
                        <span><?php echo esc_html( __( 'About', 'prayer-global-porch' ) ) ?></span>
                    </div>
                </a>

                <div class="mt-2"><a class="btn btn-cta mx-2 two-rem" href="/newest/lap/"><?php echo esc_html( __( 'Start Praying', 'prayer-global-porch' ) ) ?></a></div>

            </div>
        </div>
    </div>

    <?php
}

?>
