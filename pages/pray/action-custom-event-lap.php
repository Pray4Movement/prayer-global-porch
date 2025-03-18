<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

/**
 * Class PG_Custom_Prayer_App_Lap
 */
class PG_Custom_High_Volume_Prayer_App_Lap extends PG_Custom_Prayer_App {

    public $lap_title;
    public $lap_title_initials;
    private static $_instance = null;
    public $type = 'custom';
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct() {
        parent::__construct();

        // must be valid url
        $url = dt_get_url_path();
        if ( strpos( $url, $this->root . '/' . $this->type ) === false ) {
            return;
        }

        // must be valid parts
        if ( !$this->check_parts_match() ){
            return;
        }

        // has empty action, of stop
        if ( 'event' !== $this->parts['action'] ) {
            return;
        }

        // redirect to completed if not current global lap
        add_action( 'dt_blank_body', [ $this, 'body' ] );
        add_filter( 'dt_magic_url_base_allowed_css', [ $this, 'dt_magic_url_base_allowed_css' ], 10, 1 );
        add_filter( 'dt_magic_url_base_allowed_js', [ $this, 'dt_magic_url_base_allowed_js' ], 200, 1 );
        add_action( 'wp_enqueue_scripts', [ $this, 'wp_enqueue_scripts' ], 100 );

        $title = get_the_title( $this->parts['post_id'] );
        $title_words = preg_split( '/[\s\-_]+/', $title );

        $this->lap_title = $title;
        if ( strlen( $title ) < 6 ) {
            $this->lap_title = $title;
        } else if ( $title_words !== false ) {
            $little_words = [
                'of',
                'in',
                'the',
                'a',
                'it',
                'for',
            ];

            $filtered_title_words = array_filter( $title_words, function( $word ) use ( $little_words ) {
                return !in_array( strtolower( $word ), $little_words );
            });
            $title_initials = implode( array_map( function( $word ) {
                return ucfirst( substr( $word, 0, 1 ) );
            }, $filtered_title_words ) );

            $this->lap_title_initials = $title_initials;
        }
    }

    public function dt_magic_url_base_allowed_js( $allowed_js ) {
        $allowed_js = [
            'canvas-confetti',
            'global-functions',
        ];
        return $allowed_js;
    }

    public function dt_magic_url_base_allowed_css( $allowed_css ) {
        return $allowed_css;
    }

    public function wp_enqueue_scripts(){}

    public function _header() {
        $this->header_style();
        $this->header_javascript();
    }
    public function _footer(){
        $this->footer_javascript();
    }

    public function header_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/header-event.php' );

        $url = new DT_URL( dt_get_url_path() );
        $grid_id = $url->query_params->has( 'grid_id' ) ? $url->query_params->get( 'grid_id' ) : 0;

        $current_lap = Prayer_Stats::get_relay_current_lap( $this->parts['public_key'], $this->parts['post_id'], true );
        $current_url = trailingslashit( site_url() ) . $this->parts['root'] . '/' . $this->parts['type'] . '/' . $this->parts['public_key'] . '/';
        if ( (int) $current_lap['post_id'] === (int) $this->parts['post_id'] ) {

            ?>
            <!-- Resources -->
            <script>
                let jsObject = [<?php echo json_encode([
                    'parts' => $this->parts,
                    'translations' => [
                        'state_of_location' => _x( '%1$s of %2$s', 'state of California', 'prayer-global-porch' ),
                        'keep_praying' => __( 'Keep Praying...', 'prayer-global-porch' ),
                        "Don't Know Jesus" => __( "Don't Know Jesus", 'prayer-global-porch' ),
                        'Know About Jesus' => __( 'Know About Jesus', 'prayer-global-porch' ),
                        'Know Jesus' => __( 'Know Jesus', 'prayer-global-porch' ),
                        'praying_paused' => __( 'Praying Paused', 'prayer-global-porch' ),
                        'Prayer Added!' => __( 'Prayer Added!', 'prayer-global-porch' ),
                    ],
                    'nope' => plugin_dir_url( __DIR__ ) . 'assets/images/anon.jpeg',
                    'cache_url' => 'https://s3.prayer.global/',
                    'images_url' => pg_grid_image_url(),
                    'image_folder' => plugin_dir_url( __DIR__ ) . 'assets/images/',
                    'json_folder' => plugin_dir_url( __DIR__ ) . 'assets/json/',
                    'current_url' => $current_url,
                    'map_url' => $current_url . 'map',
                    'api_url' => PG_API_ENDPOINT,
                    'is_custom' => ( 'custom' === $this->parts['type'] ),
                    'is_cta_feature_on' => !$current_lap['ctas_off'],
                ]) ?>][0]
            </script>

            <link rel="preload" href="https://s3.prayer.global/maps/<?php echo esc_attr( $grid_id ) ?>.jpg" >

            <?php
        }
    }

    public function header_style() {
        ?>

        <style>
            :root {
                --pg-dark: #11224e;
                --pg-light: #2c599d;
                --pg-orange: #f2944a;
                --pg-grey: #acabab;

                font-size: 18px;
                scroll-behavior: smooth;
            }


            @font-face {
                font-family: 'Europa';
                src: url('../assets/fonts/Europa/Europa-Regular.eot');
                src: url('../assets/fonts/Europa/Europa-Regular.eot?#iefix') format('embedded-opentype'),
                    url('../assets/fonts/Europa/Europa-Regular.woff2') format('woff2'),
                    url('../assets/fonts/Europa/Europa-Regular.woff') format('woff'),
                    url('../assets/fonts/Europa/Europa-Regular.ttf') format('truetype'),
                    url('../assets/fonts/Europa/Europa-Regular.svg#Europa-Regular') format('svg');
                font-weight: normal;
                font-style: normal;
                font-display: swap;
            }

            @font-face {
                font-family: 'Europa';
                src: url('../assets/fonts/Europa/Europa-Bold.eot');
                src: url('../assets/fonts/Europa/Europa-Bold.eot?#iefix') format('embedded-opentype'),
                    url('../assets/fonts/Europa/Europa-Bold.woff2') format('woff2'),
                    url('../assets/fonts/Europa/Europa-Bold.woff') format('woff'),
                    url('../assets/fonts/Europa/Europa-Bold.ttf') format('truetype'),
                    url('../assets/fonts/Europa/Europa-Bold.svg#Europa-Bold') format('svg');
                font-weight: bold;
                font-style: normal;
                font-display: swap;
            }

            body {
                font-family: Europa, sans-serif;
                color: var(--pg-dark);
                margin: 0;
                line-height: 1.5;
            }

            h5 {
                font-size: 1.25rem;
                font-weight: 400;
            }

            button {
                background: none;
                border: none;
                outline: none;
                cursor: pointer;
            }

            hr {
                margin-top: 3em;
                margin-bottom: 3em;
                border-top: 1px solid var(--pg-orange);
                width: 100%;
            }

            .img-fluid,
            img {
                max-width: 100%;
                height: auto;
                border-radius: 10px;
            }
            .bg-img {
                width:200px;
                height:200px;
                background-size: cover;
                background-repeat: no-repeat;
            }

            /* Composition */
            .container {
                width: 90%;
                max-width: 1200px;
                margin-left: auto;
                margin-right: auto;
                margin-bottom: 0.5em;
            }
            .flow {
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            .flow > * {
                margin-top: 0;
                margin-bottom: 0;
            }
            .flow > * + * {
                margin-top: var(--space, 1rem);
            }
            .flow.sm {
                --space: 0.5rem;
            }
            .flow.md {
                --space: 1.5rem;
            }
            .flow.lg {
                --space: 2rem;
            }

            .center {
                margin-left: auto;
                margin-right: auto;
            }

            .switcher {
                display: flex;
                flex-wrap: wrap;
                gap: 1rem;
                justify-content: center;
            }
            .switcher > * {
                flex: 1;
                flex-basis: calc( ( var(--switcher-max-width, 30rem) - 100% ) * 1000 );
            }
            .grow0 {
                flex-grow: 0;
            }

            .with-icon {
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }
            .icon {
                width: 0.75em;
                width: 1cap;
                height: 0.75em;
                height: 1cap;
            }

            /* Blocks */
            #decision-panel {
                display: none;
            }
            #question-panel {
                display: none;
            }
            #celebrate-panel {
                display: none;
            }
            #content-anchor {
                position: absolute;
                top: -8rem;
            }

            .celebrate-panel {
                display: none;
                position: fixed;
                z-index: 1000;
                left: 0;
                right: 0;
                top: 0;
                bottom: 0;
                background-color: var(--pg-dark);
                color: white;
            }
            .celebrate-panel h2 {
                margin-top: 2rem;
                font-size: 2em;
            }

            /* ## Buttons */
            .btn {
                text-transform: uppercase;
                border-radius: 6px;
                box-shadow: var(--small-box-shadow);
                border: 1px solid transparent;
                background: var(--pg-light);
                color: white;
                font-size: 1rem;
                font-family: inherit;
                padding: 0.5rem 0.75rem;
                transition: all 120ms linear;
            }
            .btn:hover {
                background: #1a3b70;
            }
            .btn.bg-orange:hover {
                background: #d28041;
            }
            .btn.outline {
                background-color: white;
                color: var(--pg-dark);
                border: 1px solid var(--pg-dark);
                text-transform: none;
            }
            .btn.outline:hover {
                background-color: var(--pg-dark);
                color: white;
            }
            .btn.simple {
                background-color: white;
                color: var(--pg-dark);
                text-transform: none;
            }
            .btn.simple:hover {
                border-color: var(--pg-dark);
            }
            .btn-group {
                display: flex;
                width: 100%;
                gap: 8px;
            }
            .btn-group.question .btn {
                line-height: 1.25;
            }
            .btn-group > * {
                flex: 1;
            }
            .flex-2 {
                flex: 2;
            }

            /* ## Prayer navbar buttons */
            .prayer-navbar {
                position: sticky;
                top: 0;
                left: 0;
                right: 0;
                z-index: 1000;

                border-bottom: 1px solid lightgrey;
                box-shadow: 0 1px 10px -2px rgb(0 0 0 / 15%);
                background: white;
                padding-top: 8px;
            }

            .praying-button-group {
                display: flex;
                gap: 8px;
            }

            .prayer-odometer {
                display: flex;
                align-items: center;
                gap: 8px;

                opacity: 1;
                color: #f7fbff;
                background-color: var(--pg-light);
            }

            .btn-praying {
                padding: 0.3rem 0.5rem;
                line-height: 0.8;
                font-size: 1.8em;
            }

            .praying-timer {
                width: 100%;
                background: var(--pg-grey);
                color: #ffffff;
                position: relative;
                overflow: hidden;
                padding: 8px;
            }
            #praying__continue_button {
                display:none;
            }
            .praying__progress {
                position: absolute;
                height: 100%;
                width: 0%;
                top: 0;
                left: 0;
                background: var(--pg-orange);
                transition: width 0.3s;
                box-shadow: 0 10px 0 -2px rgb(0 0 0 / 15%);
                border-radius: 6px;
            }
            .praying__text {
                position: relative;
                line-height: 1;
            }
            .prayer-content {
                margin-top: 2rem;
                margin-bottom: 8rem;
            }

            /* ## Modal */
            .modal {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: #00000055;
                z-index: 1000;

                opacity: 0;
                display: none;
            }
            .modal.show {
                display: block;
                opacity: 1;
            }
            .modal-dialog {
                max-width: 500px;
                margin: 1rem auto;
                width: auto;
                pointer-events: none;
            }
            .modal-content {
                pointer-events: auto;
                background-color: white;
                border-radius: 10px;
                display: flex;
                flex-direction: column;
                width: 100%;
            }
            .modal-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 1rem;
                border-bottom: 1px solid var(--pg-grey);
            }
            .modal-title {
                line-height: 1;
                margin: 0;
            }
            .modal-body {
                padding: 1rem;
            }
            .modal-footer {
                padding: 1rem;
                display: flex;
                justify-content: flex-end;
                gap: 1rem;
            }

            /* ## see more button */
            #see-more-button {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                z-index: 10;
                margin-bottom: 0.2rem;
                animation: bounce 1s;

                text-decoration: none;
                display: flex;
                flex-direction: column;
                align-items: center;
                margin-left: auto;
                margin-right: auto;
                width: fit-content;

                padding: 0.5rem 0.75rem;
                line-height: 1.25;
            }
            #see-more-button.hide {
                display: none;
            }
            @keyframes bounce {
                0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
                40% {transform: translateY(-1.5rem);}
                60% {transform: translateY(-0.75rem);}
            }
            #more_prayer_fuel {
                display: flex;
                align-items: center;
                gap: 8px;
                margin-left: auto;
                margin-right: auto;
            }
            /* ## Population info */
            .population-info {
                padding-top: 1rem;
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 0.5rem;
                font-size: 0.8rem;
            }
            .population-info > * {
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }
            .population-info .icon {
                height: 1rem;
                width: 1rem;
            }
            /* Map */
            .location-map {
                padding-bottom: 60%;
                padding-bottom: min(500px, 75%);
                background-size: cover;
                background-position: center;
                border-radius: 10px;
                background-size: auto 100%;
                transition: background-size 1500ms ease-in-out;
            }
            .location-map.zoom {
                background-size: auto 120%;
            }

            /* ## skeleton */
            .skeleton {
                animation: skeleton-loading 1s ease-in infinite alternate;
                margin-left: auto;
                margin-right: auto;
                border-radius: 5px;
            }
            .skeleton[data-map] {
                width: 100%;
                height: 500px;
            }
            .skeleton[data-title] {
                width: 30%;
                height: 1rem;
            }
            .skeleton[data-text] {
                height: 1rem;
                width: 70%;
            }
            .skeleton[data-number] {
                width: 2rem;
                height: 1rem;
            }

            @keyframes skeleton-loading {
                0% {
                    background-color: #acabab90;
                }
                100% {
                    background-color: #acabab20;
                }
            }

            /* ## Prayer Blocks */
            .block {
                text-align: center;
                width: 100%;
                margin-left: auto;
                margin-right: auto;
            }
            .block .content {
                width: 70%;
                line-height: 1.25;
                max-width: 30ch;
                margin-left: auto;
                margin-right: auto;
            }
            .block > * {
                margin-top: 0;
                margin-bottom: 0;
            }
            .block > * + * {
                margin-top: 1.2rem;
            }
            .block h5 {
                text-transform: uppercase;
            }
            .block__verse {
                font-style: italic;
            }
            .block .switcher {
                margin-left: auto;
                margin-right: auto;
                max-width: unset;
                width: 70%;
            }
            .block.hidden + hr {
                display: none;
            }
            .icon-block {
                line-height: 1.1;
                display: flex;
                flex-wrap: wrap;
                align-items: center;
            }
            .icon-xlg {
                height: 6rem;
                width: 6rem;
                line-height: 1.1;
            }
            .pie {
                --w: 150px;
                width: var(--w);
                aspect-ratio: 1;
                position: relative;
                display: inline-grid;
                place-content: center;
                font-size: 25px;
                font-weight: bold;
                font-family: sans-serif;
            }
            .pie:before {
                content: "";
                position: absolute;
                border-radius: 50%;
                inset: 0;
                background: conic-gradient(var(--c) calc(var(--p)* 1%), #F6F6F6 0);
                -webkit-mask: radial-gradient(farthest-side, #0000 calc(99% - var(--b)), #000 calc(100% - var(--b)));
                mask: radial-gradient(farthest-side, #0000 calc(99% - var(--b)), #000 calc(100% - var(--b)));
            }

            /* Utility */
            .dark {
                color: var(--pg-dark);
                fill: var(--pg-dark);
            }
            .light {
                color: var(--pg-light);
                fill: var(--pg-light);
            }
            .orange {
                color: var(--pg-orange);
                fill: var(--pg-orange);
            }
            .bg-dark {
                background: var(--pg-dark);
            }
            .bg-light {
                background: var(--pg-light);
            }
            .bg-orange {
                background: var(--pg-orange);
            }
            .bold {
                font-weight: bold;
            }
            .uc {
                text-transform: uppercase;
            }
            .f-xxlg {
                font-size: 2.5rem;
            }
            .f-xlg {
                font-size: 1.8rem;
            }
            .f-lg {
                font-size: 1.4rem;
            }
            .f-md {
                font-size: 1.2rem;
            }
            .f-normal {
                font-size: 1rem;
            }
            .f-sm {
                font-size: 0.8rem;
            }
            .text-center {
                text-align: center;
            }
            .w-75 {
                width: 75%;
            }
            .lh-1 {
                line-height: 1;
            }
            .relative {
                position: relative;
            }
            .hidden {
                display: none;
            }

        </style>

        <?php
    }

    public function footer_javascript(){
        ?>

            <script>

                window.seconds = 60
                window.items = 7

                CELEBRATION_TIMEOUT = 3000

                const contentElement = document.querySelector('#content')
                const mapElement = document.querySelector('#location-map')
                const mapSkeleton = mapElement.querySelector('.skeleton')

                const prayingText = document.querySelector('.praying__text')
                const locationName = document.querySelector('#location-name')
                const prayingButton = document.querySelector('#praying-button')
                const prayingPauseButton = document.querySelector('#praying__pause_button')
                const prayingContinueButton = document.querySelector('#praying__continue_button')
                const prayingProgress = document.querySelector('.praying__progress')
                const tutorial = document.querySelector('#tutorial-location')

                const prayerNavbar = document.querySelector('.prayer-navbar')
                const prayingPanel = document.querySelector('#praying-panel')
                const decisionPanel = document.querySelector('#decision-panel')
                const questionPanel = document.querySelector('#question-panel')
                const decisionLeaveModal = document.querySelector('#decision_leave_modal')

                const leaveHomeButton = decisionPanel.querySelector('#decision__home')
                const leaveModalButton = decisionLeaveModal.querySelector('#decision__leave')
                const stayModalButton = decisionLeaveModal.querySelector('#decision__keep_praying')
                const closeModalButton = decisionLeaveModal.querySelector('#decision__close')
                const doneButton = questionPanel.querySelector('#question__yes_done')
                const nextButton = questionPanel.querySelector('#question__yes_next')

                const populationInfoNo = document.querySelector('.population-info .no')
                const populationInfoNeutral = document.querySelector('.population-info .neutral')
                const populationInfoYes = document.querySelector('.population-info .yes')

                const morePrayerFuelButton = document.querySelector('#more_prayer_fuel')
                const celebratePanel = document.querySelector('#celebrate-panel')

                checkForLocationAndLoad(init)

                function init(location) {
                    window.paused = false
                    window.finishedPraying = false
                    window.alreadyLogged = false
                    window.time = 0
                    window.randomLogSeconds = 30 + 30 * Math.random()

                    console.log(window.randomLogSeconds)

                    renderContent(location)
                    renderMap(location)

                    toggleTimer(false)

                    setupListeners()
                }

                function setupListeners() {
                    prayingButton.addEventListener('click', () => toggleTimer())
                    prayingPauseButton.addEventListener('click', () => toggleTimer(true))
                    prayingContinueButton.addEventListener('click', () => toggleTimer(false))
                    morePrayerFuelButton.addEventListener('click', showMorePrayerFuel)

                    leaveHomeButton.addEventListener('click', openLeaveModal)

                    stayModalButton.addEventListener('click', keepPraying)
                    closeModalButton.addEventListener('click', keepPraying)
                    leaveModalButton.addEventListener('click', leavePraying)

                    doneButton.addEventListener('click', celebrateAndDone)
                    nextButton.addEventListener('click', celebrateAndNext)
                }

                function celebrateAndNext() {
                    const url = new URL(jsObject.api_url)
                    const siteOrigin = (new URL(location.href)).host
                    url.searchParams.append('relay', jsObject.parts.public_key)
                    url.searchParams.append('domain', siteOrigin)

                    celebrateAndNavigateTo(url.href)
                }
                function celebrateAndDone() {
                    celebrateAndNavigateTo(getHomeUrl())
                }

                function celebrateAndNavigateTo(href) {
                    /* Fire off the celebrations and open the celebrate panel */
                    window.celebrationFireworks()
                    show(celebratePanel)

                    setTimeout(() => {
                        location.href = href
                    }, CELEBRATION_TIMEOUT)
                }

                function openLeaveModal() {
                    decisionLeaveModal.classList.add('show')
                }

                function keepPraying() {
                    decisionLeaveModal.classList.remove('show')
                    toggleTimer()
                }
                function leavePraying() {
                    window.location = getHomeUrl()
                }

                function getHomeUrl() {
                    return '/congratulations'
                }
                function getMapUrl() {
                    if (jsObject.is_cta_feature_on === true) {
                        return jsObject.map_url + '?show_cta'
                    } else {
                        return jsObject.map_url
                    }
                }

                function showMorePrayerFuel() {
                    const hiddenBlocks = contentElement.querySelectorAll('.block.hidden')
                    hiddenBlocks.forEach((block) => {
                        block.classList.remove('hidden')
                        hide(morePrayerFuelButton)
                    })
                }

                function toggleTimer(pause) {
                    let pauseTimer = false

                    if (typeof pause === 'undefined') {
                        pauseTimer = !window.paused
                    } else {
                        pauseTimer = pause
                    }
                    window.paused = pauseTimer

                    if (pauseTimer) {
                        prayingText.innerHTML = escapeHTML(jsObject.translations.praying_paused)

                        /* Show and hide the neccessary UI */
                        hide(prayingPauseButton)
                        show(prayingContinueButton)

                        show(decisionPanel)

                        /* clear the interval */
                        clearInterval(window.pgInterval)
                    } else {
                        prayingText.innerHTML = escapeHTML(jsObject.translations.keep_praying)

                        /* Show and hide the necessary UI */
                        show(prayingPauseButton)
                        hide(prayingContinueButton)

                        hide(decisionPanel)

                        /* Restart the interval */
                        startTimer(window.time)
                    }
                }

                function startTimer(time) {
                    if (!time) {
                        window.time = 0
                    }

                    window.pgInterval = setInterval(() => {
                        window.time = window.time + 0.1

                        if (window.time > window.randomLogSeconds && !window.alreadyLogged) {
                            /* send log */
                            const url = `${jsObject.api_url}update?location=${jsObject.current_content.location.location.grid_id}&relay=${jsObject.parts.public_key}`
                            fetch(url, {
                                method: 'POST',
                            })
                                .then((res) => {
                                    if (!res.ok) {
                                        throw Error(res.status + ': ' + res.statusText)
                                    }
                                })
                                .catch((error) => {
                                    console.log(error)
                                })

                            window.alreadyLogged = true
                        }

                        if (window.time < window.seconds) {

                            let percentage = window.time / window.seconds * 100

                            if (percentage > 100) {
                                percentage = 100
                            }

                            prayingProgress.style.width = `${percentage}%`

                        }
                        else if (!window.finishedPraying) {
                            window.finishedPraying = true

                            show(questionPanel)
                            hide(prayingPanel)

                            prayingProgress.style.width = 0
                        }

                    }, 100)

                }

                function hide(element) {
                    if (!element.dataset.display) {
                        element.dataset.display = element.style.display !== 'none' ? element.style.display : 'block'
                    }
                    element.style.display = 'none'
                }
                function show(element) {
                    element.style.display = element.dataset.display || 'block'
                }

                function escapeHTML(str) {
                    if (typeof str === 'undefined') return '';
                    if (typeof str !== 'string') return str;
                    return str
                        .replace(/&/g, '&amp;')
                        .replace(/</g, '&lt;')
                        .replace(/>/g, '&gt;')
                        .replace(/"/g, '&quot;')
                        .replace(/'/g, '&apos;');
                }

                /* Fly away the see more button after a little bit of scroll */
                const seeMoreButton = document.querySelector('#see-more-button')
                console.log(window.scrollY)
                if (window.scrollY < 100) {
                    seeMoreButton.style.display = ''
                    window.addEventListener('scroll', removeSeeMoreButton)
                }
                function removeSeeMoreButton() {
                    const scrollTop = window.scrollY

                    if (scrollTop > 100) {
                        seeMoreButton.style.opacity = `${(250 - scrollTop) / 150}`
                    }

                    if (scrollTop > 250) {
                        seeMoreButton.style.display = 'none'
                        window.removeEventListener('scroll', removeSeeMoreButton)
                    }
                }


                /* We need to check and keep checking that the location object is ready to use */
                function checkForLocationAndLoad(callback) {
                    let checkingInterval

                    if (jsObject.current_content && jsObject.current_content.location) {
                        callback(jsObject.current_content.location)
                        return
                    }

                    checkingInterval = setInterval(() => {
                        if (jsObject.current_content && jsObject.current_content.location) {
                            clearInterval(checkingInterval)

                            callback(jsObject.current_content.location)
                        }
                    }, 50)
                }

                function clearTutorial() {
                    setTimeout(() => {
                        tutorial.style.display = 'none'
                    }, 3000)
                }

                function renderContent(content) {
                    if (!content) {
                        return
                    }

                    const { location, list, parts } = content

                    locationName.innerHTML = escapeHTML(jsObject.translations.state_of_location.replace('%1$s', location.admin_level_name_cap).replace('%2$s', location.full_name))

                    /* Render the content */
                    const arrayList = Array.isArray(list) ? list : Object.values(list)
                    const blockTemplates = arrayList.map((block) => getBlockTemplate(block))

                    contentElement.innerHTML = `
                    <div id="content-anchor"></div>
                    <hr />

                    ${blockTemplates.join('<hr>')}

                    <hr />
                    `

                    const blocks = contentElement.querySelectorAll('.block')
                    blocks.forEach((block, i) => {
                        if (i > window.items) {
                            block.classList.add('hidden')
                        }
                    })

                    clearTutorial()
                    populationInfoNo.innerHTML = location.non_christians
                    populationInfoNeutral.innerHTML = location.christian_adherents
                    populationInfoYes.innerHTML = location.believers
                }
                function renderMap(content) {
                    const { location } = content

                    const imageSrc = jsObject.cache_url + 'maps/' + location.grid_id + '.jpg'
                    const bgImg = new Image()
                    bgImg.onload = function(){
                        mapSkeleton.style.display = 'none'
                        mapElement.style.backgroundImage = 'url(' + bgImg.src + ')'

                        setTimeout(() => {
                            mapElement.classList.add('zoom')
                        }, 500)
                    }
                    bgImg.src = imageSrc
                }

                function getBlockTemplate(block) {
                    switch (block.type) {
                        case '4_fact_blocks':
                            return _template_4_fact_blocks(block.data)
                        case 'percent_3_circles':
                            return _template_percent_3_circles(block.data)
                        case '100_bodies_chart':
                            return _template_100_bodies_chart(block.data)
                        case '100_bodies_3_chart':
                            return _template_100_bodies_3_chart(block.data)
                        case 'population_change_icon_block':
                            return _template_population_change_icon_block(block.data)
                        case 'people_groups_list':
                            return _template_people_groups_list(block.data)
                        case 'least_reached_block':
                            return _template_least_reached_block(block.data)
                        case 'content_block':
                            return _template_content_block(block.data)
                        case 'photo_block':
                            return _template_photo_block(block.data)
                        case 'basic_block':
                            return _template_basic_block(block.data)
                        case 'lost_per_believer':
                            return _template_lost_per_believer_block(block.data)
                        default:
                            return ''
                    }
                }
                function _template_percent_3_circles(data) {
                    return `
                    <div class="block percent-3-circles-block">
                        <h5>${data.section_label}</h5>
                        <div class="switcher">
                            <div class="flow sm">
                                <p class="bold f-md">${data.label_1}</p>
                                <div class="pie" style="--p:${data.percent_1};--b:10px;--c:var(--pg-dark);">${data.percent_1}%</div>
                                <p class="f-lg">${data.population_1}</p>
                            </div>
                            <div class="flow sm">
                                <p class="bold f-md">${data.label_2}</p>
                                <div class="pie" style="--p:${data.percent_2};--b:10px;--c:var(--pg-light);">${data.percent_2}%</div>
                                <p class="f-lg">${data.population_2}</p>
                            </div>
                            <div class="flow sm">
                                <p class="bold f-md">${data.label_3}</p>
                                <div class="pie" style="--p:${data.percent_3};--b:10px;--c:var(--pg-orange);">${data.percent_3}%</div>
                                <p class="f-lg">${data.population_3}</p>
                            </div>
                        </div>
                    </div>`

                }
                function _template_100_bodies_chart(data) {
                    let bodies = ''
                    let i = 0
                    i = 0
                    while (i < data.percent_1) {
                        bodies += BodyIcon('bad');
                        i++;
                    }
                    i = 0
                    while (i < data.percent_2) {
                        bodies += BodyIcon('neutral');
                        i++;
                    }
                    i = 0
                    while (i < data.percent_3) {
                        bodies += BodyIcon('good');
                        i++;
                    }
                    return `
                        <div class="block 100-bodies-chart-block">
                            <h5>${data.section_label}</h5>
                            <div class="content">
                                <p class="f-xlg">
                                    ${bodies}
                                </p>
                            </div>
                            <p>${data.section_summary}</p>
                        </div>
                    `
                }
                function _template_100_bodies_3_chart(data) {
                    let bodies_1 = ''
                    let bodies_2 = ''
                    let bodies_3 = ''
                    i = 0
                    while (i < data.percent_1) {
                        bodies_1 += BodyIcon('bad');
                        i++;
                    }
                    i = 0
                    while (i < data.percent_2) {
                        bodies_2 += BodyIcon('neutral');
                        i++;
                    }
                    i = 0
                    while (i < data.percent_3) {
                        bodies_3 += BodyIcon('good');
                        i++;
                    }
                    return `
                        <div class="block 100-bodies-3-chart-block">
                            <h5>${data.section_label}</h5>
                            <div class="switcher">
                                <div class="flow sm">
                                    <p class="bold">${data.label_1}</p>
                                    <p class="f-xlg">
                                        ${bodies_1}
                                    </p>
                                    <p class="f-lg">${data.population_1}</p>
                                </div>
                                <div class="flow sm">
                                    <p class="bold">${data.label_2}</p>
                                    <p class="f-xlg">
                                        ${bodies_2}
                                    </p>
                                    <p class="f-lg">${data.population_2}</p>
                                </div>
                                <div class="flow sm">
                                    <p class="bold">${data.label_3}</p>
                                    <p class="f-xlg">
                                        ${bodies_3}
                                    </p>
                                    <p class="f-lg">${data.population_3}</p>
                                </div>
                            </div>
                        </div>
                    `
                }
                function _template_population_change_icon_block(data) {
                    if (data.count === '0' || data.count.length > 3) {
                        return
                    }

                    // icon types
                    let icons = ''
                    if ('deaths' === data.type) {
                        icons = ['ion-sad']
                    } else {
                        icons = ['ion-happy']
                    }
                    let icon = icons[Math.floor(Math.random() * icons.length)]

                    // icon color
                    let icon_color = 'dark'
                    if ('christian_adherents' === data.group) {
                        icon_color = 'light'
                    }
                    if ('believers' === data.group) {
                        icon_color = 'orange'
                    }

                    // icon size
                    let font_size = 'f-xlg'
                    if (2 === data.size) {
                        font_size = 'f-lg'
                    }

                    if (data.count > 1000) {
                        font_size = 'f-lg'
                    } else if (data.count < 20) {
                        font_size = 'f-xxlg'
                    }

                    // build icon list
                    let icon_list = ''
                    i = 0
                    while (i < data.count) {
                        icon_list += `
                            <svg height="1em" width="1em" viewBox="0 0 512 512" class="${icon_color} ${font_size}">
                                <use href="#${icon}"></use>
                            </svg>
                        `
                        i++;
                    }
                    return `
                        <div class="block population-change-block">
                            <h5>${data.section_label}</h5>
                            <div class="content flow f-xlg">
                                <p>${data.section_summary}</p>
                                <div class="${font_size} icon-block">
                                    ${icon_list} <span style="font-size:.5em;vertical-align:middle;">(${data.count})</span>
                                </div>
                                <p>${data.prayer}</p>
                            </div>
                        </div>
                    `
                }
                function _template_4_fact_blocks(data) {
                    return `
                        <div class="block four-facts-block">
                            <h5>${data.section_label}</h5>
                            <p class="f-xlg">${data.focus_label}</p>
                            <div class="switcher">
                                <div class="flow sm">
                                    <p class="bold">${data.label_1}</p>
                                    <p class="f-xlg">${data.value_1}</p>
                                </div>
                                <div class="flow sm">
                                    <p class="bold">${data.label_2}</p>
                                    <p class="f-xlg">${data.value_2}</p>
                                </div>
                                <div class="flow sm">
                                    <p class="bold">${data.label_3}</p>
                                    <p class="f-xlg">${data.value_3}</p>
                                </div>
                                <div class="flow sm">
                                    <p class="bold">${data.label_4}</p>
                                    <p class="f-xlg">${data.value_4}</p>
                                </div>
                            </div>
                        </div>
                    `
                }
                function _template_people_groups_list(data) {
                    let values_list = ''
                    let image = ''
                    Object.values(data.values).forEach(function (v) {
                        if (v.image_url) {
                            image = `<div style="background-image:url(${v.image_url}); " class="bg-img img-fluid"></div>`
                        } else {
                            image = `
                                <div style=" height:200px;">
                                    <img class="img-fluid" src="${jsObject.nope}" alt="" />
                                </div>`
                        }
                        values_list += `
                            <div class="flow grow0">
                                <p class="mb-2 text-center">${image}</p>
                                <div>
                                    <img src="${v.progress_image_url}" class="img-fluid" alt="" />
                                </div>
                                <p>${v.description}</p>
                            </div>
                        `
                    })
                    return `
                        <div class="block people-groups-list-block">
                            <h5>${data.section_label}</h5>
                            <div class="content switcher">
                                ${values_list}
                            </div>
                        </div>
                    `
                }
                function _template_least_reached_block(data) {
                    let image
                    if (data.image_url) {
                        image = `<div><img src="${data.image_url}" class="img-fluid rounded-3" alt="" /></div>`
                    } else {
                        image = `<div><img class="img-fluid" src="${jsObject.nope}" alt="" /></div>`
                    }
                    return `
                        <div class="block least-reached-block">
                            <div class="flow sm">
                                <h5>${data.section_label}</h5>
                                <p class="f-xlg">${data.focus_label}</p>
                                ${data.diaspora_label !== '' ? `<p class="f-sm">(${data.diaspora_label})</p>` : ''}
                            </div>
                            ${image}
                            <div class="content f-xlg">
                                ${data.prayer}
                            </div>
                    </div>`
                }
                function _template_content_block(data) {
                    let icon = ''
                    if (typeof data.icon !== 'undefined') {
                        let iclass = 'ion-android-warning'
                        if (data.icon) {
                            iclass = data.icon
                        }
                        let icolor = 'dark'
                        if (data.color === 'brand-lighter') {
                            icolor = 'light'
                        } else {
                            icolor = data.color
                        }
                        icon = `
                            <svg class="icon-xlg ${icolor}" width="1em" height="1em" viewBox="0 0 512 512">
                                <use href="#${iclass}" ></use>
                            </svg>
                        `
                    }
                    return `
                        <div class="block flow content-block">
                            <h5>${data.section_label}</h5>
                            <p class="f-xlg">${data.focus_label}</p>
                            ${icon}
                            <div class="w-75 center">
                                <p class="f-lg">${data.section_summary}</p>
                                <p class="f-xlg">${data.prayer}</p>
                            </div>
                    </div>`
                }
                function _template_lost_per_believer_block(data) {
                    let bodies_1 = ''
                    i = 0
                    while (i < data.lost_per_believer) {
                        bodies_1 += BodyIcon('bad');
                        i++;
                    }
                    let font_size = 'f-xlg'
                    if (data.lost_per_believer > 1000) {
                        font_size = 'f-lg'
                    } else if (data.lost_per_believer < 20) {
                        font_size = 'f-xxlg'
                    }
                    return `
                        <div class="block lost-per-believer-block">
                            <h5>${data.section_label}</h5>
                            <div class="content flow">
                                <p class="bold f-xlg">${data.label_1}</p>
                                <p class="f-xxlg">
                                    ${BodyIcon('good')}
                                </p>
                                <p class="${font_size}">
                                    ${bodies_1}
                                </p>
                            </div>
                            <div class="content">
                                ${data.prayer}
                            </div>
                        </div>
                    `
                }
                function _template_photo_block(data) {
                    return `
                    <div class="block photo-block">
                        <h5>${data.section_label}</h5>
                        <div>
                            <img src="${data.url}" class="img-fluid rounded-3" alt="prayer photo" style="max-height:700px" />
                        </div>
                        <div class="content flow">
                            <p class="f-md">${data.section_summary}</p>
                            ${data.prayer ? `<p class="mt-3 mb-3 font-weight-normal one-em">${data.prayer}</p>` : ''}
                        </div>
                    </div>
                    `
                }
                function _template_basic_block(data) {
                    const reference = data.reference ? `
                            <button type="button" class="btn simple id-${data.id} with-icon" onclick="document.querySelector('#id-${data.id}').style.display = 'block';document.querySelector('.id-${data.id}').style.display = 'none';" >
                                <span>${data.reference} </span> <svg width="1em" height="1em" viewBox="0 0 33 33"><use href="#pg-chevron-down"></use></svg>
                            </button>
                            <div class="flow sm" id="id-${data.id}" style="display: none" >
                                <p class="block__verse">${data.verse}</p>
                                <p class="f-normal">${data.reference}</p>
                            </div>
                        ` : ''
                    const icon = data.icon ? `
                            <p>
                                <i class="${data.icon} six-em"></i>
                            </p>
                        ` : ''
                    return `
                        <div class="block basic-block">
                            <h5>${data.section_label}</h5>
                            ${icon}
                            <div class="content f-xlg flow">
                                <p>${data.prayer}</p>
                                ${reference}
                            </div>
                        </div>
                        `
                }


                function BodyIcon(color) {
                    const iconColors = {
                        bad: 'dark',
                        neutral: 'light',
                        good: 'orange',
                    }
                    const defaultColor = iconColors.orange

                    const iconColor = color && iconColors.hasOwnProperty(color) ? iconColors[color] : defaultColor

                    return `
                        <svg class="${iconColor}" width="1em" height="1em" viewBox="0 0 512 512">
                            <use href="#ion-ios-body"></use>
                        </svg>
                    `
                }

            </script>

        <?php
    }

    public function body(){

        ?>

        <script>
            const url = new URL(location.href)
            const gridId = url.searchParams.get('grid_id')

            if (gridId) {
                //const jsonUrl = jsObject.json_folder + '100000002' + '.json'
                //const jsonUrl = jsObject.json_folder + '100000003' + '.json'
                const jsonUrl = jsObject.cache_url + 'json/' + gridId + '.json'

                fetch(jsonUrl)
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error("Failed to fetch JSON", response.status)
                        }
                        return response.json()
                    })
                    .then((json) => {
                        jsObject.current_content = {
                            location: json
                        }
                    })
                    .catch((error) => {
                        console.error(error)
                    })
            } else {
                console.log('no grid_id found')
            }
        </script>

        <?php //phpcs:ignore ?>
        <?php echo file_get_contents( plugin_dir_path( __DIR__ ) . '/assets/images/ionicon-subset.svg' ); ?>
        <?php //phpcs:ignore ?>
        <?php echo file_get_contents( plugin_dir_path( __DIR__ ) . '/assets/images/pgicon-subset.svg' ); ?>

        <!-- navigation & widget -->
        <nav class="prayer-navbar">
            <div class="container praying-button-group" id="praying-panel" role="group" aria-label="Praying Button">
                <div class="btn btn-praying prayer-odometer">
                    <svg fill="currentColor" width="1em" height="1em" viewBox="0 0 33 33">
                        <use href="#pg-prayer"></use>
                    </svg>
                    <span class="location-count">0</span>
                </div>
                <button type="button" class="btn praying-timer" id="praying-button" data-percent="0" data-seconds="0">
                    <div class="praying__progress"></div>
                    <span class="praying__text uppercase font-weight-normal"></span>
                </button>
                <button type="button" class="btn btn-praying bg-dark" data-display="flex" id="praying__pause_button">
                    <svg fill="currentColor" width="1em" height="1em" viewBox="0 0 33 33">
                        <use href="#pg-pause"></use>
                    </svg>
                </button>
                <button type="button" class="btn btn-praying bg-dark" data-display="flex" id="praying__continue_button">
                    <svg height="1em" width="1em" viewBox="0 0 33 33" fill="currentColor" >
                        <use href="<?php echo esc_url( plugin_dir_url( __DIR__ ) . 'assets/images/start.svg#pg-icon' ) ?>"></use>
                    </svg>
                </button>
            </div>
            <div class="container" id="question-panel">
                <div class="btn-group question" role="group" aria-label="Praying Button">
                    <button type="button" class="btn btn-praying lh-sm bg-dark" id="question__yes_done"><?php echo esc_html( __( 'Done', 'prayer-global-porch' ) ) ?></button>
                    <button type="button" class="btn btn-praying lh-sm bg-orange" id="question__yes_next"><?php echo esc_html( __( 'Next', 'prayer-global-porch' ) ) ?></button>
                </div>
            </div>
            <div class="w-100" ></div>
            <div class="container" id="decision-panel">
                <div class="btn-group decision" role="group" aria-label="Decision Button">
                    <button type="button" class="btn btn-praying bg-dark" id="decision__home">
                        <svg height="1em" width="1em" viewBox="0 0 33 33" fill="currentColor" >
                            <use href="<?php echo esc_url( plugin_dir_url( __DIR__ ) . 'assets/images/home.svg#pg-icon' ) ?>"></use>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="w-100" ></div>
            <div class="container flow sm text-center">
                <p class="tutorial uc f-xlg lh-1" id="tutorial-location"><?php echo esc_html__( 'Pray for', 'prayer-global-porch' ) ?></p>
                <h2 class="lh-1 center bold w-75 f-md" id="location-name">
                    <div class="skeleton" data-title></div>
                </h2>
                <p class="f-sm">
                    <?php echo sprintf( esc_html__( 'In Prayer Relay %s', 'prayer-global-porch' ), esc_html( $this->lap_title ) ) ?>
                </p>
            </div>
        </nav>

        <div class="celebrate-panel text-center" id="celebrate-panel">
            <div class="container">
                <h2>
                    <?php echo esc_html__( 'Great Job!', 'prayer-global-porch' ) ?>
                    <br />
                    <?php echo esc_html__( 'Prayer Added!', 'prayer-global-porch' ) ?>
                </h2>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="decision_leave_modal" tabindex="-1" role="dialog" aria-labelledby="option_filter_label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="option_filter_label"><?php echo esc_html__( 'Are you sure you want to leave?', 'prayer-global-porch' ) ?></h5>
                        <button type="button" id="decision__close" aria-label="<?php esc_attr( __( 'Close', 'prayer-global-porch' ) ) ?>">
                            <svg class="f-xlg" height="1em" width="1em" viewBox="0 0 33 33" fill="currentColor" >
                                <use href="<?php echo esc_url( plugin_dir_url( __DIR__ ) . 'assets/images/close.svg#pg-icon' ) ?>"></use>
                            </svg>
                        </button>
                    </div>
                    <p class="modal-body">
                        <?php echo esc_html__( "If you leave now, this place won't have been prayed for." ) ?>
                    </p>
                    <div class="modal-footer">
                        <button type="button" class="btn outline" id="decision__keep_praying" data-bs-dismiss="modal"><?php echo esc_html__( 'Keep Praying', 'prayer-global-porch' ) ?></button>
                        <button type="button" class="btn bg-dark" id="decision__leave" data-bs-dismiss="modal"><?php echo esc_html__( 'Leave', 'prayer-global-porch' ) ?></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- content section -->
        <section class="prayer-content flow lg">
            <div class="container" id="map">
                <div class="text-md-center location-map" id="location-map">
                    <div class="skeleton" data-map></div>
                </div>
                <div class="population-info">
                    <div>
                        <svg class="icon dark" width="0.75em" height="0.75em" viewBox="0 0 512 512">
                            <use href="#ion-ios-body"></use>
                        </svg>
                        <span class="no">
                            <div class="skeleton" data-number></div>
                        </span>
                    </div>
                    <div>
                        <svg class="icon light" width="0.75em" height="0.75em" viewBox="0 0 512 512">
                            <use href="#ion-ios-body"></use>
                        </svg>
                        <span class="neutral">
                            <div class="skeleton" data-number></div>
                        </span>
                    </div>
                    <div>
                        <svg class="icon orange" width="0.75em" height="0.75em" viewBox="0 0 512 512">
                            <use href="#ion-ios-body"></use>
                        </svg>
                        <span class="yes">
                            <div class="skeleton" data-number></div>
                        </span>
                    </div>
                </div>
            </div>
            <a href="#content-anchor" class="btn bg-orange" id="see-more-button" style="display: none">
                <?php echo esc_html__( 'See more', 'prayer-global-porch' ) ?>
                <svg viewBox="0 0 33 33" width="1em" height="1em" fill="currentColor">
                    <use href="#pg-chevron-down"></use>
                </svg>
            </a>
            <div class="container flow md relative" id="content">

                <hr />

                <div class="block basic-block text-center">
                    <div class="block__header">
                        <h5 class="mb-0 uc">
                            <div class="skeleton" data-title></div>
                        </h5>
                    </div>
                    <div class="block__content">
                        <p class="skeleton" data-text></p>
                        <p class="skeleton" data-text></p>
                    </div>
                </div>

                <hr />


                <div class="block basic-block text-center">
                    <div class="block__header">
                        <h5 class="mb-0 uc">
                            <div class="skeleton" data-title></div>
                        </h5>
                    </div>
                    <div class="block__content">
                        <p class="skeleton" data-text></p>
                        <p class="skeleton" data-text></p>
                    </div>
                </div>

                <hr>
            </div>
            <div class="container">
                <div class="flow text-center">
                    <svg class="f-xxlg" height="1em" width="1em" viewBox="0 0 33 33" fill="currentColor" >
                        <use href="<?php echo esc_url( plugin_dir_url( __DIR__ ) . 'assets/images/pray-hands-dark.svg#pg-icon' ) ?>"></use>
                    </svg>
                    <button type="button" class="btn outline" id="more_prayer_fuel"><?php echo esc_html__( 'Show More Guided Prayers', 'prayer-global-porch' ) ?><i class="icon pg-chevron-down"></i></button>
                </div>
            </div>
        </section>

        <?php
    }
}
PG_Custom_High_Volume_Prayer_App_Lap::instance();

