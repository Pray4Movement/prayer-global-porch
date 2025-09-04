<?php

require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . '/assets/nav.php' ) ?>

<?php

$svg_manager = new SVG_Spritesheet_Manager();
$icons = [
    'pg-streak',
];
$svgs_url = $svg_manager->get_cached_spritesheet_url( $icons );

?>

<section class="hero full-height contain bg-top dark-bg" style="background-image: url(<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>assets/images/world-map-dark-background-new.png); min-height: 100vh;" id="section-home">
    <div class="container">
        <div class="row flex-column justify-content-between flex-nowrap">
            <div>
                <h1 class="heading">Prayer.Global</h1>
                <h2 class="sub-heading brand-highlight"><?php echo esc_html( __( 'Cover the World in Prayer', 'prayer-global-porch' ) ) ?></h2>
                <i class="icon pg-logo-prayer white heading__logo"></i>
            </div>
            <div class="my-4 d-flex flex-column align-items-center">
                <a class="btn btn-cta mx-2 d-inline-block" href="/newest/lap/"><?php echo esc_html( __( 'Start Praying', 'prayer-global-porch' ) ) ?></a>
                <a id="learn-more-mobile" href="#section-goal" class="mt-2 text-decoration-none">
                    <i class="icon icon-small pg-chevron-down white"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<section id="section-goal" class="container | cover py-6" style="background-image: url(<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>assets/images/map-lightblue-more-transparent.png);">
    <div class="flow-medium center | text-center">
        <h2 class="font-base font-weight-bold h2"><?php echo esc_html__( 'Want to pray globally but don’t know where to start?', 'prayer-global-porch' ) ?></h2>
        <p><?php echo esc_html__( 'Prayer.Global makes praying for the lost simple— and life-changing.', 'prayer-global-porch' ) ?></p>
        <p class="font-italic w-60ch"><?php echo esc_html__( '“With this resource, you will be saying prayers you never said before, praying for people you never knew existed, and you and the world will be changed.” -Northside CC Pastor', 'prayer-global-porch' ) ?></p>
        <p><?php echo esc_html__( 'We’ll show you how.', 'prayer-global-porch' ) ?></p>
        <p class="font-weight-bold"><?php echo esc_html__( 'Ready…Set…', 'prayer-global-porch' ) ?></p>
        <a class="btn btn-cta btn-lg mx-2 d-inline-block" href="/newest/lap/"><?php echo esc_html( __( 'Start Praying', 'prayer-global-porch' ) ) ?></a>
    </div>
</section>


<?php $width = 1024 ?>
<?php $height = 753 ?>
<?php $n = $height / $width ?>
<?php $length = 1 - $n / 2 ?>
<?php $xradius = $n / 2 ?>

<svg height="0" width="0">
    <clipPath id="clip-rounded-end" clipPathUnits="objectBoundingBox">
        <path d="<?php echo esc_attr( "M $length 1 h -$length v -1 h $length A $xradius 0.5, 0, 0 1, $length 1" ) ?>"/>
    </clipPath>
    <clipPath id="clip-rounded-start" clipPathUnits="objectBoundingBox">
        <path d="<?php echo esc_attr( "M $xradius 1 h $length v -1 h -$length A $xradius 0.5, 0, 0 0, $xradius 1" ) ?>"/>
    </clipPath>
</svg>

<section class="brand-lightest-bg blue-orange-gradient py-6">
    <div class="container">
        <div class="switcher | switcher-md align-items-center gap-4">
            <div class="flow-small | white">
                <h2 class="text-center">
                    <?php echo esc_html__( 'How it works', 'prayer-global-porch' ) ?>
                    <i class="icon icon-small pg-logo-prayer"></i>
                </h2>
                <p><?php echo esc_html__( 'Prayer.Global has broken the world down into 4,770 states based on geographical and governmental boundaries. ', 'prayer-global-porch' ) ?></p>
                <p><?php echo esc_html__( 'Pray for all 4,770…complete a “prayer lap” around the world!', 'prayer-global-porch' ) ?></p>
                <p><?php echo esc_html__( 'An interactive map tracks your prayers in real time.', 'prayer-global-porch' ) ?></p>
                <a href="/map" class="btn btn-primary-light uppercase center w-fit mx-auto px-4">
                    <?php echo esc_html__( 'View prayer map', 'prayer-global-porch' ) ?>
                </a>
            </div>
            <div class="drop-shadow">
                <img class="clip-rounded-start" src="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>assets/images/PG-Panel3.jpg" alt="">
            </div>
        </div>
    </div>
</section>
<section class="py-6">
    <div class="container switcher | switcher-md switcher-reverse align-items-center gap-4">
        <div class="drop-shadow">
            <img class="clip-rounded-end" src="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>assets/images/PG-Panel4.jpg" alt="">
        </div>
        <div class="flow-small">
            <h2 class="text-center">
                <?php echo esc_html__( 'Prayer Fuel', 'prayer-global-porch' ) ?>
                <i class="icon icon-small pg-pray-hands-light"></i>
            </h2>
            <p><?php echo esc_html__( 'We’ll give you location specific prayer prompts, scripture and images to help guide your prayers for each of the 4,770 states.', 'prayer-global-porch' ) ?></p>
            <a href="/newest/lap/" class="btn btn-cta btn-lg uppercase center w-fit mx-auto px-4">
                <?php echo esc_html__( 'Start Praying', 'prayer-global-porch' ) ?>
            </a>
        </div>
    </div>
</section>
<section class="brand-lightest-bg blue-orange-gradient py-6">
    <div class="container">
        <div class="switcher | switcher-md align-items-center gap-4">
            <div class="flow-small white">
                <h2 class="text-center">
                    <?php echo esc_html__( 'Prayer Relays', 'prayer-global-porch' ) ?>
                    <i class="icon icon-small pg-relay"></i>
                </h2>
                <p><?php echo esc_html__( 'Team up in prayer!', 'prayer-global-porch' ) ?></p>
                <p><?php echo esc_html__( 'Create a custom prayer relay to see if you and your friends, small group or church can pray for the whole world together.', 'prayer-global-porch' ) ?></p>
                <a href="/dashboard/relays" class="btn btn-primary-light uppercase center w-fit mx-auto px-4">
                    <?php echo esc_html__( 'Get started', 'prayer-global-porch' ) ?>
                </a>
            </div>
            <div class="drop-shadow">
                <img class="clip-rounded-start" src="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>assets/images/PG-Panel5-med.jpg" alt="">
            </div>
        </div>
    </div>
</section>
<section class="py-6">
    <div class="container switcher | switcher-md switcher-reverse align-items-center gap-4">
        <div class="drop-shadow">
            <img class="clip-rounded-end" src="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>assets/images/PG-Panel6.jpg" alt="">
        </div>
        <div class="flow-small">
            <h2 class="text-center">
                <?php echo esc_html__( 'My Prayer Activity', 'prayer-global-porch' ) ?>
                <i class="icon icon-small pg-streak"></i>
            </h2>
            <div class="w-fit mx-auto">
                <p><?php echo esc_html__( 'Register for free to:', 'prayer-global-porch' ) ?></p>
                <ul data-tight>
                    <li><?php echo esc_html__( 'Create and join custom relays', 'prayer-global-porch' ) ?></li>
                    <li><?php echo esc_html__( 'Track your prayers', 'prayer-global-porch' ) ?></li>
                    <li><?php echo esc_html__( 'See what you’ve prayed for', 'prayer-global-porch' ) ?></li>
                    <li><?php echo esc_html__( 'Build a daily prayer streak', 'prayer-global-porch' ) ?></li>
                </ul>
            </div>
            <a href="/dashboard" class="btn btn-primary-light uppercase center w-fit mx-auto px-4">
                <?php echo esc_html__( 'Register now', 'prayer-global-porch' ) ?>
            </a>
        </div>
    </div>
</section>
<section class="brand-bg py-6">
    <div class="container | white">
        <div class="switcher | switcher-md gap-4">
            <div class="flow-small cover-section grow-3">
                <h2><?php echo esc_html__( 'Mobilize a movement of prayer', 'prayer-global-porch' ) ?></h2>
                <div><?php echo esc_html__( 'Use Prayer.Global to rally your church, conference, or group around a mission to pray a full lap around the world. Every prayer moves us closer to seeing the nations reached!', 'prayer-global-porch' ) ?></div>
                <span class="switcher">
                    <a href="/dashboard/relays" class="btn btn-primary-light uppercase">
                        <?php echo esc_html__( 'Get started', 'prayer-global-porch' ) ?>
                    </a>
                    <a href="/events" class="btn btn-outline-light uppercase">
                        <?php echo esc_html__( 'Information for leaders', 'prayer-global-porch' ) ?>
                    </a>
                </span>
            </div>
            <ul role="list" class="one-em uppercase grow-2 d-flex flex-column justify-content-between mb-0">
                <li class="d-flex align-items-center gap-3">
                    <i class="icon pg-prayer"></i>
                    <span><?php echo esc_html__( 'Churches', 'prayer-global-porch' ) ?></sp>
                </li>
                <li class="d-flex align-items-center gap-3">
                    <i class="icon pg-prayer"></i>
                    <span><?php echo esc_html__( 'Conferences', 'prayer-global-porch' ) ?></sp>
                </li>
                <li class="d-flex align-items-center gap-3">
                    <i class="icon pg-prayer"></i>
                    <span><?php echo esc_html__( 'Prayer events', 'prayer-global-porch' ) ?></sp>
                </li>
                <li class="d-flex align-items-center gap-3">
                    <i class="icon pg-prayer"></i>
                    <span><?php echo esc_html__( 'Campus ministries', 'prayer-global-porch' ) ?></sp>
                </li>
                <li class="d-flex align-items-center gap-3">
                    <i class="icon pg-prayer"></i>
                    <span><?php echo esc_html__( 'College/Universities', 'prayer-global-porch' ) ?></sp>
                </li>
                <li class="d-flex align-items-center gap-3">
                    <i class="icon pg-prayer"></i>
                    <span><?php echo esc_html__( 'Mission Organizations', 'prayer-global-porch' ) ?></sp>
                </li>
            </ul>
        </div>
    </div>
</section>
<section class="flow-medium | pt-6">
    <div class="switcher container | switcher-md align-items-center gap-4">
        <div>
            <img class="w-90" src="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>assets/images/worldmap-blue.png" alt="">
        </div>
        <h2 class="font-base h2"><?php echo esc_html__( 'Join thousands of intercessors praying daily for the nations.', 'prayer-global-porch' ) ?></h2>
    </div>
    <div class="flow-medium | grey-gradient pb-6">
        <div class="container switcher | switcher-md gap-4">
            <div class="lh-base text-center">
                <span id="global-lap-percentage" class="four-em font-title">
                    <span class="loading-spinner active"></span>
                </span>
                <p class="uppercase one-em">
                    <?php echo esc_html__( 'Current lap status', 'prayer-global-porch' ) ?>
                </p>
            </div>
            <div class="lh-base text-center">
                <span id="global-laps-completed" class="four-em font-title">
                    <span class="loading-spinner active"></span>
                </span>
                <p class="uppercase one-em">
                    <?php echo esc_html__( 'Laps completed', 'prayer-global-porch' ) ?>
                </p>
            </div>
            <div class="lh-base text-center">
                <span id="global-intercessors" class="four-em font-title">
                    <span class="loading-spinner active"></span>
                </span>
                <p class="uppercase one-em">
                    <?php echo esc_html__( 'Total intercessors', 'prayer-global-porch' ) ?>
                </p>
            </div>
        </div>
        <a href="/newest/lap/" class="btn btn-cta btn-lg uppercase center w-fit mx-auto px-4">
            <?php echo esc_html__( 'Start praying', 'prayer-global-porch' ) ?>
        </a>
    </div>
</section>
<section class="brand-lightest-bg white">
    <div class="switcher container | switcher-md">
        <div class="grow-3" style="background-image: url(<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>assets/images/PG-Panel9.jpg); background-size: cover; background-position: center;">
        </div>
        <div class="flow-medium | p-5 grow-4">
            <h2 class="font-base h2"><?php echo esc_html__( 'Gospel Ambition tools and trainings are 100% free, thanks to people like you.', 'prayer-global-porch' ) ?></h2>
            <p><?php echo esc_html__( 'We love equipping the global Church with free tools to mobilize prayer and make disciples. You can help expand this mission by becoming a monthly giver or making a one-time gift. Your support keeps these resources free and accessible to believers worldwide.', 'prayer-global-porch' ) ?></p>
            <div class="cluster justify-content-between">
                <a href="/donate" class="btn btn-outline-light uppercase center">
                    <?php echo esc_html__( 'Donate', 'prayer-global-porch' ) ?>
                </a>
                <div style="width: 150px;">
                    <img src="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>assets/images/GO-Ambition-allwhite.png" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
<section class="py-6">
    <div class="switcher container | switcher-md align-items-center gap-4">
        <div class="flow-medium">
            <h2 class="text-center"><?php echo esc_html__( 'Get the App', 'prayer-global-porch' ) ?></h2>
            <div id="pg-app-badges" class="center">

                <?php pg_app_badges(); ?>

            </div>
        </div>
        <div>
            <img src="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>assets/images/PG-2Phones-new.png" alt="">
        </div>
    </div>
</section>


<?php require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . '/assets/working-footer.php' ) ?>
