
<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

class PG_Events extends PG_Public_Page {
    public $url_path = 'events';
    public $page_title = 'Events';
    public $rest_route = 'pg/events';

    public function __construct() {
        $current_page_path_matches = parent::__construct();
        if ( !$current_page_path_matches ) {
            return;
        }
        /**
         * Register custom hooks here
         */
    }

    public function register_endpoints() {}

    public function wp_enqueue_scripts() {
        wp_enqueue_style( 'pg-login-style', plugin_dir_url( __FILE__ ) . 'login.css', array(), filemtime( plugin_dir_path( __FILE__ ) . 'login.css' ) );

        wp_localize_script( 'global-functions', 'jsObject', [
            'rest_url' => esc_url( rest_url( 'dt/v1' ) ),
            'translations' => [],
        ] );
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
    }

    /**
     * Print scripts to footer
     */
    public function footer_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/footer.php' );
        ?>

        <?php
    }
    /**
     * Print body
     */
    public function body(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . '/assets/nav.php' );

        $svg_manager = new SVG_Spritesheet_Manager();
        $icons = [
            'pg-relay',
            'pg-chevron-down',
        ];
        $svgs_url = $svg_manager->get_cached_spritesheet_url( $icons );
        ?>

        <div class="page">
            <section class="container py-5">
                <div class="row justify-content-md-center mb-5 stack-md">
                    <h1 class="text-center"><?php echo esc_html__( 'Using Prayer.Global at your Event', 'prayer-global-porch' ) ?></h1>
                    <p class="text-center font-weight-bold font-italic f-sm"><?php echo esc_html__( 'Prayer.Global has been used by churches and conferences with great success! ', 'prayer-global-porch' ) ?></p>
                    <div class="switcher switcher-md">
                        <div>
                            <div class="video">
                                <iframe src="https://player.vimeo.com/video/913555379?h=b79d3f9229&title=0&byline=0&portrait=0" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                            </div>
                            <script src="https://player.vimeo.com/api/player.js"></script>
                            <p class="text-center font-title f-sm"><?php echo esc_html__( 'Conference Testimony', 'prayer-global-porch' ) ?></p>
                        </div>
                        <div>
                            <div class="video">
                                <iframe src="https://player.vimeo.com/video/1058608038?h=b79d3f9229&title=0&byline=0&portrait=0" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                            </div>
                            <script src="https://player.vimeo.com/api/player.js"></script>
                            <p class="text-center font-title f-sm"><?php echo esc_html__( 'Event Testimony', 'prayer-global-porch' ) ?></p>
                        </div>
                    </div>
                    <div class="switcher switcher-lg row-gap-sm mx-auto justify-content-around">
                        <a href="#pre-event" class="btn btn-outline-primary py-1"><?php echo esc_html__( 'Pre-Event Setup', 'prayer-global-porch' ) ?></a>
                        <a href="#promotion" class="btn btn-outline-primary py-1"><?php echo esc_html__( 'Promotion', 'prayer-global-porch' ) ?></a>
                        <a href="#facilitate" class="btn btn-outline-primary py-1"><?php echo esc_html__( 'Facilitate the Event', 'prayer-global-porch' ) ?></a>
                        <a href="#after-event" class="btn btn-outline-primary py-1"><?php echo esc_html__( 'After the Event', 'prayer-global-porch' ) ?></a>
                    </div>
                    <a class="d-block text-decoration-none brand-light text-center" href="#what-is-prayer-global"><i class="icon pg-chevron-down icon-small"></i></a>
                </div>
            </section>
            <section class="container flow-medium | py-5">
                <h2><?php echo esc_html__( 'What is Prayer.Global?', 'prayer-global-porch' ) ?></h2>
                <p><?php echo esc_html__( 'Prayer.Global is a powerful tool designed to mobilize strategic, Scripture-based prayer for the fulfillment of the Great Commission. It equips individuals, churches, and conferences to engage in extraordinary prayer—a key mark of disciple-making movements. With Prayer.Global, you and your community can take part in God’s mission to cover the world in prayer.', 'prayer-global-porch' ) ?></p>
            </section>
            <section class="container | py-5">
                <h2><?php echo esc_html__( 'How It Works', 'prayer-global-porch' ) ?></h2>
                <ul>
                    <li><?php echo esc_html__( 'Prayer.Global has divided the world into 4,770 “states” based on geographical and governmental boundaries.', 'prayer-global-porch' ) ?></li>
                    <li><?php echo esc_html__( 'Click ‘Start Praying’ to initiate a one-minute timer with a specific state to pray for.', 'prayer-global-porch' ) ?></li>
                    <li><?php echo esc_html__( 'You’ll be provided with specific prayer prompts, scripture and pictures to guide your prayers.', 'prayer-global-porch' ) ?></li>
                    <li><?php echo esc_html__( 'Watch your progress on the LIVE prayer map as you work together to pray a lap around the world.', 'prayer-global-porch' ) ?></li>
                </ul>
            </section>

            <section class="parallax">
                <div class="parallax__layer parallax__layer--back" style="background-image: url('<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>assets/images/PG-Panel5.jpeg');">
                </div>
                <div class="parallax__layer--base">
                    <div class="flex-1 brand-transparent-gradient">
                        <div class="container | text-center white font-italic font-weight-bold f-md py-5">
                            <p><?php echo esc_html__( 'At a recent conference, participants prayed several laps around the world over the course of a few days.', 'prayer-global-porch' ) ?></p>
                            <p><?php echo esc_html__( 'On one Sunday morning, a church of 1200 prayed for the entire world in less that 10 minutes!', 'prayer-global-porch' ) ?></p>
                            <p><?php echo esc_html__( 'Over the course of a month, a campus ministry was able to pray for every location on the globe.', 'prayer-global-porch' ) ?></p>
                        </div>
                    </div>
                </div>
            </section>
            <section class="container | py-5">
                <h2 class="with-floating-anchor">
                    <?php echo esc_html__( 'Pre-Event Setup', 'prayer-global-porch' ) ?>
                    <span class="anchor" id="pre-event"></span>
                </h2>
                <p class="font-weight-bold"><?php echo esc_html__( 'We’ve done the hard work to make it easy for you.', 'prayer-global-porch' ) ?></p>
                <ul>
                    <li><strong><?php echo esc_html__( 'Register and create a free account', 'prayer-global-porch' ) ?>:</strong> <?php echo esc_html__( 'Gain access to your personal Prayer Global dashboard.', 'prayer-global-porch' ) ?></li>
                    <li><strong><?php echo esc_html__( 'Create a custom group prayer relay', 'prayer-global-porch' ) ?>:</strong> <?php echo esc_html__( 'Choose a name and decide if it’s public (anyone can join) or private (accessible only through the URL or QR code).', 'prayer-global-porch' ) ?></li>
                    <li><strong><?php echo esc_html__( 'Access free promotional resources', 'prayer-global-porch' ) ?>:</strong> <?php echo esc_html__( 'Easily promote your event with customizable materials for your church or conference.', 'prayer-global-porch' ) ?></li>
                    <li><strong><?php echo esc_html__( 'Cast Vision', 'prayer-global-porch' ) ?>:</strong> <?php echo esc_html__( 'Share the importance of prayer in fulfilling the Great Commission. Lay a foundation for the Prayer.Global experience by casting a vision - the “why” - and setting a goal for your event.', 'prayer-global-porch' ) ?></li>
                    <li><strong><?php echo esc_html__( 'Set a Goal', 'prayer-global-porch' ) ?>:</strong> <?php echo esc_html__( 'Choose a prayer target based on your event size and timeframe.', 'prayer-global-porch' ) ?></li>
                </ul>
            </section>
            <section class="light-grey-bg py-5">
                <div class="container flow-medium">
                    <h4 class="text-center text-transform-none font-base font-weight-bold"><?php echo esc_html__( 'Sample Goals', 'prayer-global-porch' ) ?></h4>
                    <ul class="star-bullet">
                        <li><strong><?php echo esc_html__( 'Collectively complete one prayer lap around the world in each event session (covering all 4,770 states in prayer)', 'prayer-global-porch' ) ?></strong> - <?php echo esc_html__( 'Each individual would pray for multiple regions, depending on the amount of time allotted, each time the activity is offered. For reference, on average ten minutes would allow each person to cover about seven states in prayer.', 'prayer-global-porch' ) ?></li>
                        <li><strong><?php echo esc_html__( 'Collectively complete one prayer lap around the world in the course of the event  (covering all 4,770 states in prayer)', 'prayer-global-porch' ) ?></strong> - <?php echo esc_html__( 'ach individual would pray for one region, roughly one minute, each time the activity is offered.', 'prayer-global-porch' ) ?></li>
                    </ul>
                </div>
            </section>
            <section class="brand-lightest-bg white py-5">
                <div class="container flow-medium">
                    <h2 class="with-floating-anchor">
                        <?php echo esc_html__( 'Customizable Promotional Resources', 'prayer-global-porch' ) ?>
                        <span class="anchor" id="promotion"></span>
                    </h2>
                    <div class="switcher">
                        <ul data-tight>
                            <li><?php echo esc_html__( 'Download the custom QR code from the Prayer.Global website once your lap is set up.', 'prayer-global-porch' ) ?></li>
                            <li><?php echo esc_html__( 'Customizable sample emails', 'prayer-global-porch' ) ?></li>
                            <li><?php echo esc_html__( 'Mobile templates', 'prayer-global-porch' ) ?></li>
                            <li><?php echo esc_html__( 'Banners', 'prayer-global-porch' ) ?></li>
                            <li><?php echo esc_html__( '3x5 Card', 'prayer-global-porch' ) ?></li>
                            <li><?php echo esc_html__( 'Presenter slide templates', 'prayer-global-porch' ) ?></li>
                            <li><?php echo esc_html__( 'Event poster', 'prayer-global-porch' ) ?></li>
                        </ul>
                        <div class="d-flex align-items-center">
                            <img src="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>assets/images/3X5Mockup-PGonly-crop2.png" alt="">
                        </div>
                    </div>
                    <a class="btn btn-outline-light d-block w-fit mx-auto py-1" href="#promotion"><?php echo esc_html__( 'Promo resources', 'prayer-global-porch' ) ?></a>
                </div>
            </section>
            <section class="container flow-medium | py-5">
                <h2><?php echo esc_html__( 'Promote in advance of your event', 'prayer-global-porch' ) ?></h2>
                <p><?php echo esc_html__( 'Give your attendees advance notice of the upcoming Prayer.Global event to encourage their participation and to help them be prepared to pray on the day of your event. Here is a proposed timeline for promotion.', 'prayer-global-porch' ) ?></p>
                <div class="switcher">
                    <ul class="flex-2">
                        <li><?php echo esc_html__( 'Make an announcement in your event materials, encourage people to bring a device with them.', 'prayer-global-porch' ) ?></li>
                        <li><?php echo esc_html__( 'Send an email at least 3 days before to cast vision and to encourage your event attendees to download the Prayer.Global app. Include links to both app stores.', 'prayer-global-porch' ) ?></li>
                        <li><?php echo esc_html__( 'Send a text the day before the event with a link to Prayer.Global, if you have a texting service.', 'prayer-global-porch' ) ?></li>
                        <li><?php echo esc_html__( 'Provide postcards in seat pockets and at exits to provide more information.', 'prayer-global-porch' ) ?></li>
                    </ul>
                    <div class="d-flex align-items-center justify-content-center">
                        <img class="h-22" src="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>assets/images/SingleBanner-Mockup-crop.png" alt="">
                    </div>
                </div>
                <p class="font-italic">
                    <?php echo esc_html__( 'In pre-event promotion, we recommend only promoting the Prayer.Global website and the links for downloading the app. We don’t recommend sharing your custom group URL until the day of the event. This helps ensure better tracking of how many people prayed with you during the event.', 'prayer-global-porch' ) ?>
                </p>
            </section>
            <section class="parallax | narrow-parallax">
                <div class="parallax__layer parallax__layer--back" style="background-image: url('<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>assets/images/LargeEvent-Mockup2.jpg');"></div>
            </section>
            <section class="py-5">
                <div class="container flow-xmedium">
                    <h2 class="with-floating-anchor">
                        <?php echo esc_html__( 'Hosting your Prayer.Global event', 'prayer-global-porch' ) ?>
                        <span class="anchor" id="facilitate"></span>
                    </h2>
                    <p><?php echo esc_html__( 'It is important to give the Prayer.Global challenge prominence. We have broken this goal down into three essential keys for success:', 'prayer-global-porch' ) ?></p>
                    <ol class="large-numbers | flow-xmedium">
                        <li>
                            <h3><?php echo esc_html__( 'Getting people connected to your group’s prayer lap (5 minutes)', 'prayer-global-porch' ) ?></h3>
                            <p><?php echo esc_html__( 'Here are some suggested methods of facilitating attendee connection:', 'prayer-global-porch' ) ?></p>
                            <ul>
                                <li><?php echo esc_html__( 'Provide seat cards with the custom lap QR code along with steps for navigating to the website', 'prayer-global-porch' ) ?></li>
                                <li><?php echo esc_html__( 'Display the QR code on your venue’s projection screens or TVs', 'prayer-global-porch' ) ?></li>
                                <li><?php echo esc_html__( 'Add a link – like a ‘Pray Now’ button – to your website or other online resources you are using in the course of your event', 'prayer-global-porch' ) ?></li>
                            </ul>
                        </li>
                        <li>
                            <h3><?php echo esc_html__( 'Facilitating the group prayer time (5-10 minutes)', 'prayer-global-porch' ) ?></h3>
                            <p><?php echo esc_html__( 'Here are some best practices for how to facilitate group prayer time:', 'prayer-global-porch' ) ?></p>
                            <ul>
                                <li><?php echo esc_html__( 'Transition into your prayer time by casting vision about what is about to happen.', 'prayer-global-porch' ) ?></li>
                                <li><?php echo esc_html__( 'Show how the Prayer.Global tool works by walking people through a prayer prompt using a screen share, presentation computer or through a video. Take the full minute to scroll through the prompts, demonstrating how to use the different pieces of information to guide your prayers.', 'prayer-global-porch' ) ?></li>
                                <li><?php echo esc_html__( 'Provide time for people to get out their devices, scan the codes and to be ready to go. Give the go ahead to start praying and start the countdown timer.', 'prayer-global-porch' ) ?></li>
                                <li><?php echo esc_html__( 'Close the time with a verbal prayer to give people time to finish the state they are praying over.', 'prayer-global-porch' ) ?></li>
                                <li><?php echo esc_html__( 'If possible, provide an update about how many states your group prayed for during that time. You can use the display map to showcase this or provide that information to a host or worship minister to share when they come on stage.', 'prayer-global-porch' ) ?></li>
                            </ul>
                        </li>
                        <li>
                            <h3><?php echo esc_html__( 'Provide next steps (5 minutes)', 'prayer-global-porch' ) ?></h3>
                            <p><?php echo esc_html__( 'How do you encourage continued prayer for the nations? Help people brainstorm ways they can use the Prayer.Global app moving forward.', 'prayer-global-porch' ) ?></p>
                            <p><?php echo esc_html__( 'Some ideas include:', 'prayer-global-porch' ) ?></p>
                            <ul>
                                <li><?php echo esc_html__( 'Encourage everyone to register on the Prayer.Global site or app.', 'prayer-global-porch' ) ?></li>
                                <li><?php echo esc_html__( 'Complete 1 or 2 prayers before going to bed or putting your kids to bed', 'prayer-global-porch' ) ?></li>
                                <li><?php echo esc_html__( 'Finish your Bible reading time with 1 or 2 prayers', 'prayer-global-porch' ) ?></li>
                                <li><?php echo esc_html__( 'Incorporate 1 or 2 prayers into your weekly small group meeting', 'prayer-global-porch' ) ?></li>
                                <li><?php echo esc_html__( 'Invite someone to pray with you by sharing about the app', 'prayer-global-porch' ) ?></li>
                            </ul>
                        </li>
                    </ol>
                </div>
            </section>
            <section class="container | py-5">
                <div class="switcher | triple-image">
                    <div class="d-flex align-items-center justify-content-center">
                        <img class="circle-image" src="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>assets/images/iphonemockup-invite.jpg" alt="">
                    </div>
                    <div class="d-flex align-items-center justify-content-center flex-1_5">
                        <img class="circle-image" src="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>assets/images/iphonemockup-invite.jpg" alt="">
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <img class="circle-image" src="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>assets/images/iphonemockup-invite.jpg" alt="">
                    </div>
                </div>
            </section>
            <section class="brand-lightest-bg | py-5 white">
                <div class="container">
                    <h2 class="with-floating-anchor">
                        <?php echo esc_html__( 'Helpful Tips', 'prayer-global-porch' ) ?>
                        <span class="anchor" id="helpful-tips"></span>
                    </h2>
                    <div class="switcher">
                        <ul class="flex-1_5">
                            <li><?php echo esc_html__( 'Personally use Prayer.Global before promoting it. Consider initiating leadership, ushers, and volunteers with a Prayer.Global experience before the event, as well.', 'prayer-global-porch' ) ?></li>
                            <li><?php echo esc_html__( 'Set a specific amount of time for prayer. For reference, setting aside 10 minutes will result in each person praying for about 7 states.', 'prayer-global-porch' ) ?></li>
                            <li><?php echo esc_html__( 'Recruit a few technology helpers to be positioned around the room when your prayer time begins. They can help people troubleshoot any issues with their device or access the correct prayer relay.', 'prayer-global-porch' ) ?></li>
                            <li><?php echo esc_html__( 'Encourage people to pray out loud. Model this from the stage and play some soft music during the prayer time. This will help the room not feel empty while also encouraging participation.', 'prayer-global-porch' ) ?></li>
                            <li><?php echo esc_html__( 'Show a prayer prompt session on the main screens so those without devices can pray along, too.', 'prayer-global-porch' ) ?></li>
                        </ul>
                        <div class="d-flex align-items-center justify-content-center">
                            <img src="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) ) ?>assets/images/PG-2Phones-new.png" alt="">
                        </div>
                    </div>
                </div>
            </section>
            <section class="container | mt-5">
                <h2 class="with-floating-anchor">
                    <?php echo esc_html__( 'After the event & Beyond', 'prayer-global-porch' ) ?>
                    <span class="anchor" id="after-event"></span>
                </h2>
                <p><?php echo esc_html__( 'Based on how your Prayer.Global event experience goes, provide follow up information, texts or emails to encourage people to keep praying and to celebrate once your lap is complete, if not completed during the event.  Keep the vision and goal of daily prayer for the nations in front of them.', 'prayer-global-porch' ) ?></p>
            </section>
            <section class="container | mt-5">
                <h2><?php echo esc_html__( 'Thank you for Partnering with us', 'prayer-global-porch' ) ?></h2>
                <p><?php echo esc_html__( 'Thank you for taking the time to explore how to host a Prayer.Global event. By following these steps, you are creating a powerful opportunity for your conference attendees to unite in prayer for the nations. As you guide others in lifting their voices to God, may you see hearts ignited with a passion to pray boldly and consistently — not just during your event, but far beyond it.', 'prayer-global-porch' ) ?></p>
                <p><?php echo esc_html__( 'May the Lord bless your efforts, multiplying the impact of every prayer offered. May your gathering inspire a movement of extraordinary prayer warriors who will stand in the gap for the lost and see God’s kingdom expand to all nations and people groups.', 'prayer-global-porch' ) ?></p>
                <p><?php echo esc_html__( 'We are grateful for your partnership and excited to see how God moves through your leadership.', 'prayer-global-porch' ) ?></p>
                <p class="font-weight-bold"><?php echo esc_html__( 'Let’s mobilize prayer and watch God move!', 'prayer-global-porch' ) ?></p>
            </section>
            <section class="container flow-small center | mt-5">
                <p class="font-weight-bold"><?php echo esc_html__( 'Ready...Set...', 'prayer-global-porch' ) ?></p>
                <a class="btn btn-primary-light uppercase" href="/dashboard/relays"><?php echo esc_html__( 'Create Group Relay', 'prayer-global-porch' ) ?></a>
                <svg class="icon-xxlg"><use href="<?php echo esc_html( $svgs_url ); ?>#pg-relay"></use></svg>
            </section>
        </div>

                <script>
        // One-time calculation of parallax element position + scroll offset
        const parallaxElements = document.querySelectorAll('.parallax');

        window.addEventListener('scroll', () => {
            parallaxElements.forEach(element => {
                const elementOffset = element.offsetTop - element.offsetHeight;
                const scrollProgress = Math.max(0, window.pageYOffset - elementOffset);
                element.style.setProperty('--element-scroll', scrollProgress);
            });
        });
        </script>

        <?php

        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/working-footer.php' );
    }
}

new PG_Events();

