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

        <h5 class="border border-brand-light offcanvas-title px-3 rounded navbar__title"><a href="/" class="brand-light navbar__title-link">Prayer.Global</a></h5>

        <div class="d-flex justify-content-end align-items-center">
            <div class="d-flex justify-content-end align-items-center mx-2">
                <div class="dropdown dt-magic-link-language-selector">
                    <button class="btn btn-secondary btn-small dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <svg color="currentColor" height='100px' width='100px' fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" x="0px" y="0px"><g><path fill="currentColor" stroke="currentColor" d="M55.63,22.25H39.44V11.06a6.82,6.82,0,0,0-6.81-6.81H8.37a6.82,6.82,0,0,0-6.81,6.81V26.23A6.73,6.73,0,0,0,2.71,30c2.4,4.62,13.47,11.45,13.59,11.52a1.56,1.56,0,0,0,.78.22,1.49,1.49,0,0,0,1.39-2.06A41.78,41.78,0,0,1,16.61,33h8v11.2A6.81,6.81,0,0,0,31.37,51h16a41.78,41.78,0,0,1-1.86,6.66,1.49,1.49,0,0,0,1.39,2.06,1.56,1.56,0,0,0,.78-.22c.12-.07,11.19-6.9,13.59-11.52a6.73,6.73,0,0,0,1.15-3.78V29.06A6.82,6.82,0,0,0,55.63,22.25ZM21.49,30H14.81a1.54,1.54,0,0,0-1.14.53,1.49,1.49,0,0,0-.34,1.2c0,.14.36,2.31,1,4.89-3.36-2.34-7.78-5.74-9-8a1.51,1.51,0,0,0-.15-.28,3.65,3.65,0,0,1-.68-2.16V11.06A3.82,3.82,0,0,1,8.37,7.25H32.63a3.82,3.82,0,0,1,3.81,3.81V22.25H31.37a6.81,6.81,0,0,0-5.12,2.33,8.73,8.73,0,0,1-3.09-.67A13,13,0,0,0,25.93,17h.81a1.5,1.5,0,1,0,0-3H22V11.33a1.5,1.5,0,1,0-3,0V14H14.33a1.5,1.5,0,1,0,0,3h8.58a9.88,9.88,0,0,1-2.2,5.2,10.13,10.13,0,0,1-2-3.34,1.5,1.5,0,1,0-2.8,1.08,13.48,13.48,0,0,0,2.34,4,9.83,9.83,0,0,1-3.87.71h0a1.5,1.5,0,1,0,0,3h0A12.07,12.07,0,0,0,20.71,26a10.61,10.61,0,0,0,4.05,1.45,6.55,6.55,0,0,0-.2,1.6v1Zm38,14.2a3.65,3.65,0,0,1-.68,2.16,1.43,1.43,0,0,0-.15.27c-1.18,2.24-5.61,5.65-9,8,.67-2.58,1-4.75,1-4.89a1.49,1.49,0,0,0-.34-1.2A1.52,1.52,0,0,0,49.19,48H31.37a3.81,3.81,0,0,1-3.81-3.8V29.06a3.82,3.82,0,0,1,3.81-3.81H55.63a3.82,3.82,0,0,1,3.81,3.81ZM48.92,38.64h0l-4-10h0a.8.8,0,0,0-.08-.16l-.06-.1a.64.64,0,0,0-.1-.13l-.08-.1-.11-.09L44.37,28a.39.39,0,0,0-.11-.06l-.15-.08h0a.35.35,0,0,0-.11,0l-.15-.05-.15,0h-.14l-.16,0h-.13l-.17.05a.38.38,0,0,0-.1,0h0l-.15.08L42.7,28a.87.87,0,0,0-.11.09l-.11.09-.09.1a1.47,1.47,0,0,0-.1.13l0,.1-.09.16h0l-4,10h0l-2,5a1.5,1.5,0,0,0,.84,2,1.36,1.36,0,0,0,.56.11,1.51,1.51,0,0,0,1.39-.94l1.62-4.06h6l1.62,4.06a1.52,1.52,0,0,0,1.4.94,1.35,1.35,0,0,0,.55-.11,1.5,1.5,0,0,0,.84-2Zm-7.17-.92,1.79-4.46,1.78,4.46Z"></path></g></svg>
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
