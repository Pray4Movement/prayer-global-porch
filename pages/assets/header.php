<?php
global $wp;
$current_url = dt_get_url_path( false, true );
?>
<meta name="apple-mobile-web-app-title" content="Prayer.Global">

<link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ); ?>assets/images/favicons/apple-touch-icon.png">

<link rel="icon" type="image/png" sizes="512x512" href="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ); ?>assets/images/favicons/android-chrome-512x512.png">
<link rel="icon" type="image/png" sizes="192x192" href="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ); ?>assets/images/favicons/android-chrome-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ); ?>assets/images/favicons/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ); ?>assets/images/favicons/favicon-16x16.png">

<link rel="mask-icon" href="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ); ?>assets/images/favicons/safari-pinned-tab.svg" color="#fff">
<link rel="shortcut icon" href="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ); ?>assets/images/favicons/favicon.ico">

<meta name="msapplication-square512x512logo" content="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ); ?>assets/images/favicons/android-chrome-512x512.png">
<meta name="msapplication-square192x192logo" content="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ); ?>assets/images/favicons/android-chrome-192x192.png">

<meta name="theme-color" content="#fff">

<link rel="manifest" href="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ); ?>assets/images/favicons/site.webmanifest">

<?php pg_og_tags( [ 'url' => $current_url ] ) ?>
