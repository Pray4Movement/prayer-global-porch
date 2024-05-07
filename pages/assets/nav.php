<?php
$url = dt_get_url_path( true );

/**
 * Nav for Home Page
 */
$nav_class = 'white-bg brand';
if ( '' === $url ) {
    $nav_class = 'navbar-home navbar-dark';
} else if ( str_contains( $url, 'stats' ) ||
            str_contains( $url, 'completed' ) ||
            str_contains( $url, 'about' ) ||
            str_contains( $url, 'stats' ) ||
            str_contains( $url, 'login' ) ||
            str_contains( $url, 'profile' )
) {
    $nav_class = 'navbar-dark';
}
$hide_cta_class = str_contains( $url, 'challenges' ) || str_contains( $url, 'user_app' ) ? 'd-none' : '';
$parent_langs = dt_get_available_languages( true, false, [ 'en', 'fr' ] );
$langs = dt_get_available_languages( true, false, [ 'en_US', 'fr_FR' ] );
$lang = pg_get_current_lang();

?>
<nav class="pg-navbar navbar p-0 d-block <?php echo esc_html( $nav_class ) ?>" id="pg-navbar">
    <div class="container d-flex align-items-center justify-content-between container py-3 flex-nowrap">
        <button class="p-0 icon-button share-button two-rem d-flex" data-toggle="modal" data-target="#exampleModal">
            <i class="icon pg-share"></i>
        </button>

        <h5 class="border border-brand-light offcanvas-title px-3 rounded"><a href="/" class="brand-light navbar__title">Prayer.Global</a></h5>

        <div class="d-flex justify-content-end align-items-center">
            <div class="d-flex justify-content-end align-items-center">
                <div class="dropdown dt-magic-link-language-selector">
                    <button class="btn btn-secondary btn-small dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img class="dt-icon dt-white-icon" src="<?php echo esc_html( get_template_directory_uri() . '/dt-assets/images/languages.svg' ) ?>"/>
                    </button>
                    <ul class="dropdown-menu">

                        <?php foreach ( $langs as $code => $language ) : ?>

                            <?php if ( isset( $language['native_name'] ) ) :
                                $name = $language['native_name'];
                                if ( str_contains( $code, '_' ) ) {
                                    $parent_code = explode( '_', $code )[0];
                                    $name = isset( $parent_langs[$parent_code]['native_name'] ) ? $parent_langs[$parent_code]['native_name'] : $name;
                                }
                                $selected_class = $lang === $code ? 'active' : '';
                                ?>
                                <li>
                                    <a class="dropdown-item <?php echo esc_html( $selected_class ); ?>"
                                       data-value="<?php echo esc_html( $code ); ?>"
                                       aria-current="<?php echo $lang === $code ? 'true' : 'false' ?>">
                                    <?php echo esc_html( $language['flag'] ?? '' ); ?> <?php echo esc_html( $name ); ?>
                                    </a>
                                </li>
                            <?php endif; ?>

                        <?php endforeach; ?>

                    </ul>
                </div>
            </div>
            <a href="/user_app/profile" class="icon-button mx-2 two-rem d-flex align-items-center" title="Profile" id="user-profile-link">
                <i class="icon pg-profile"></i>
            </a>
            <button class="icon-button navbar-toggler mx-2 two-rem d-flex align-items-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#probootstrap-navbar" aria-controls="probootstrap-navbar" aria-expanded="false" aria-label="Toggle navigation">
                <i class="icon pg-menu"></i>
            </button>
        </div>
    </div>

    <?php pg_menu(); ?>

</nav>
