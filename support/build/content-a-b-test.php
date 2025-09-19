<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

class Prayer_Global_Content_A_B_Test extends PG_Public_Page
{
    public $url_path = 'support/ab-test';
    public $page_title = 'Global Prayer - Content A B Test';
    public $rest_route = 'pg/ab-test';

    public function __construct() {
        $current_page_path_matches = parent::__construct();
        if ( !$current_page_path_matches ) {
            return;
        }
        if ( !is_user_logged_in() ){
            wp_redirect( home_url( '/login' ) );
            exit;
        }
        // if user is not an admin, redirect to dashboard
        if ( !dt_user_has_role( get_current_user_id(), 'administrator' ) ){
            wp_redirect( home_url( '/dashboard' ) );
            exit;
        }
        /**
         * Register custom hooks here
         */
    }

    public function dt_magic_url_base_allowed_js( $allowed_js ) {
        $allowed_js[] = 'global-functions';
        $allowed_js[] = 'jquery';
        $allowed_js[] = 'canvas-confetti';
        $allowed_js[] = 'global-functions';
        $allowed_js[] = 'median-permissions';
        $allowed_js[] = 'median-js';
        $allowed_js[] = 'components-js';
        $allowed_js[] = 'main-js';
        return $allowed_js;
    }

    public function dt_magic_url_base_allowed_css( $allowed_css ) {
        $allowed_css[] = 'basic-css';
        $allowed_css[] = 'bootstrap-css';
        $allowed_css[] = 'ionicons-css';
        $allowed_css[] = 'pg-styles-css';
        $allowed_css[] = 'google-fonts';

        return $allowed_css;
    }

    public function header_javascript(){
        require_once( WP_CONTENT_DIR . '/plugins/prayer-global-porch/pages/assets/header.php' );
        ?>
        <link href="https://fonts.googleapis.com/css?family=Crimson+Text:400,400i,600|Montserrat:200,300,400" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo esc_url( WP_CONTENT_URL . '/plugins/prayer-global-porch/pages/' ) ?>assets/fonts/ionicons/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo esc_url( WP_CONTENT_URL . '/plugins/prayer-global-porch/pages/' ) ?>assets/css/basic.css?ver=<?php echo esc_attr( fileatime( WP_CONTENT_DIR . '/plugins/prayer-global-porch/pages/assets/css/basic.css' ) ) ?>" type="text/css" media="all">
        <?php
    }

    public function footer_javascript(){
        require_once( WP_CONTENT_DIR . '/plugins/prayer-global-porch/pages/assets/footer.php' );
        ?>

        <script>
            function get_new_prayers(){
                return fetch(jsObject.rest_url + '/new-prayers?grid_id=<?php echo esc_attr( $grid_id ) ?>')
                    .then(response => response.json())
                    .then(data => {
                        console.log(data)
                        // remove dependency on jquery
                        document.querySelector('.section-label').innerHTML = data.section_label + ' - ' + data.category
                        document.querySelector('.first-prayer__content').innerHTML = data.first_prayer.prayer
                        document.querySelector('.second-prayer__content').innerHTML = data.second_prayer.prayer
                        document.querySelector('.first-prayer button').removeEventListener('click')
                        document.querySelector('.first-prayer button').addEventListener('click', function(){
                            prefer_prayer(data.first_prayer, data.second_prayer, data.category)
                            .then(data => {
                                console.log(data)
                                return get_new_prayers()
                            })
                        })
                        document.querySelector('.second-prayer button').removeEventListener('click')
                        document.querySelector('.second-prayer button').addEventListener('click', function(){
                            prefer_prayer(data.second_prayer, data.first_prayer, data.category)
                            .then(data => {
                                console.log(data)
                                return get_new_prayers()
                            })
                        })
                    })
                    .catch(error => {
                        console.error('Error:', error)
                    })
            }
            function prefer_prayer( prayer, unpreferred_prayer, category ){
                console.log(prayer)
                return fetch(jsObject.rest_url + '/prefer-prayer', {
                    method: 'POST',
                    body: JSON.stringify({
                        type: prayer.type,
                        content: prayer.prayer,
                        category: category,
                        unpreferred_prayer: unpreferred_prayer.prayer,
                    })
                })
            }
            window.addEventListener('load', function(){
                get_new_prayers()
            })
            document.querySelector('#country_change').addEventListener('change', function(e){
                let grid_id = document.querySelector('#country_change').value
                window.location.href = '/support/ab-test/?grid_id='+grid_id
            })
        </script>
        <?php
    }

    public function wp_enqueue_scripts() {
        wp_localize_script( 'global-functions', 'jsObject', [
            'rest_url' => esc_url( rest_url( 'pg/ab-test' ) ),
            'nonce' => wp_create_nonce( 'wp_rest' ),
            'translations' => [],
        ] );
    }

    public function register_endpoints() {
        register_rest_route( $this->rest_route, '/new-prayers', [
            'methods' => 'GET',
            'callback' => [ $this, 'new_prayers' ],
            'permission_callback' => '__return_true',
        ] );
        register_rest_route( $this->rest_route, '/prefer-prayer', [
            'methods' => 'POST',
            'callback' => [ $this, 'prefer_prayer' ],
            'permission_callback' => '__return_true',
        ] );
    }

    public function new_prayers( WP_REST_Request $request ) {
        $grid_id = $request->get_param( 'grid_id' );

        $ai_prayers = $this->get_prayers_by_type( $grid_id, 'ai' );
        $current_prayers = $this->get_prayers_by_type( $grid_id, 'current' );

        $random_category = array_rand( $ai_prayers );

        $random_prayer = $ai_prayers[$random_category][0];
        $random_prayer['type'] = 'ai';

        $random_current_prayer = $current_prayers[$random_category][0];
        $random_current_prayer['type'] = 'current';

        $prayers = [ $random_prayer, $random_current_prayer ];
        shuffle( $prayers );

        return [
            'first_prayer' => $prayers[0],
            'second_prayer' => $prayers[1],
            'category' => $random_category,
            'section_label' => $prayers[0]['section_label'],
        ];
    }

    public function get_prayers_by_type( $grid_id, $type = 'current' ) {

        if ( !isset( $grid_id ) || empty( $grid_id ) ) {
            $grid_id = '100000003';
        }

        $lists = [];

        if ( $type === 'current' ) {
            $include_ai = false;
            $include_current = true;
        } else if ( $type === 'ai' ) {
            $include_ai = true;
            $include_current = false;
        } else if ( $type === 'both' ) {
            $include_ai = true;
            $include_current = true;
        }

        $stack = PG_Stacker::_stack_query( $grid_id );

        $empty_array = [];
        $lists['_for_intentional_movement_strategy'] = PG_Stacker_Text::_for_intentional_movement_strategy( $empty_array, $stack, false, $include_ai, $include_current );

        $empty_array = [];
        $lists['_for_abundant_gospel_sowing'] = PG_Stacker_Text::_for_abundant_gospel_sowing( $empty_array, $stack, false, $include_ai, $include_current );

        $empty_array = [];
        $lists['_for_prioritizing_priesthood_of_believers'] = PG_Stacker_Text::_for_prioritizing_priesthood_of_believers( $empty_array, $stack, false, $include_ai, $include_current );

        $empty_array = [];
        $lists['_for_unleashing_simple_churches'] = PG_Stacker_Text::_for_unleashing_simple_churches( $empty_array, $stack, false, $include_ai, $include_current );

        $empty_array = [];
        $lists['_for_bible_access'] = PG_Stacker_Text::_for_bible_access( $empty_array, $stack, false, $include_ai, $include_current );

        $empty_array = [];
        $lists['_for_internet_gospel_access'] = PG_Stacker_Text::_for_internet_gospel_access( $empty_array, $stack, false, $include_ai, $include_current );

        $empty_array = [];
        $lists['_for_safety'] = PG_Stacker_Text::_for_safety( $empty_array, $stack, false, $include_ai, $include_current );

        $empty_array = [];
        $lists['_for_demographic_feature_total_population'] = PG_Stacker_Text::_for_demographic_feature_total_population( $empty_array, $stack, false, $include_ai, $include_current );

        $empty_array = [];
        $lists['_for_demographic_feature_population_non_christians'] = PG_Stacker_Text::_for_demographic_feature_population_non_christians( $empty_array, $stack, false, $include_ai, $include_current );

        $empty_array = [];
        $lists['_for_demographic_feature_population_christian_adherents'] = PG_Stacker_Text::_for_demographic_feature_population_christian_adherents( $empty_array, $stack, false, $include_ai, $include_current );

        $empty_array = [];
        $lists['_for_demographic_feature_population_believers'] = PG_Stacker_Text::_for_demographic_feature_population_believers( $empty_array, $stack, false, $include_ai, $include_current );

        $empty_array = [];
        $lists['_for_demographic_feature_primary_language'] = PG_Stacker_Text::_for_demographic_feature_primary_language( $empty_array, $stack, false, $include_ai, $include_current );

        $empty_array = [];
        $lists['_for_local_leadership'] = PG_Stacker_Text::_for_local_leadership( $empty_array, $stack, false, $include_ai, $include_current ); // convert these to the next series below

        $empty_array = [];
        $lists['_for_apostolic_pioneering_leadership'] = PG_Stacker_Text::_for_apostolic_pioneering_leadership( $empty_array, $stack, false, $include_ai, $include_current );

        $empty_array = [];
        $lists['_for_evangelistic_leadership'] = PG_Stacker_Text::_for_evangelistic_leadership( $empty_array, $stack, false, $include_ai, $include_current );

        $empty_array = [];
        $lists['_for_shepherding_leadership'] = PG_Stacker_Text::_for_shepherding_leadership( $empty_array, $stack, false, $include_ai, $include_current );

        $empty_array = [];
        $lists['_for_teaching_leadership'] = PG_Stacker_Text::_for_teaching_leadership( $empty_array, $stack, false, $include_ai, $include_current );

        $empty_array = [];
        $lists['_for_biblical_authority'] = PG_Stacker_Text::_for_biblical_authority( $empty_array, $stack, false, $include_ai, $include_current );

        $empty_array = [];
        $lists['_for_obedience'] = PG_Stacker_Text::_for_obedience( $empty_array, $stack, false, $include_ai, $include_current );

        $empty_array = [];
        $lists['_for_reliance_on_god'] = PG_Stacker_Text::_for_reliance_on_god( $empty_array, $stack, false, $include_ai, $include_current );

        $empty_array = [];
        $lists['_for_faithfulness'] = PG_Stacker_Text::_for_faithfulness( $empty_array, $stack, false, $include_ai, $include_current );

        $empty_array = [];
        $lists['_for_love_and_generosity'] = PG_Stacker_Text::_for_love_and_generosity( $empty_array, $stack, false, $include_ai, $include_current );

        $empty_array = [];
        $lists['_for_kingdom_urgency'] = PG_Stacker_Text::_for_kingdom_urgency( $empty_array, $stack, false, $include_ai, $include_current );

        $empty_array = [];
        $lists['_for_suffering'] = PG_Stacker_Text::_for_suffering( $empty_array, $stack, false, $include_ai, $include_current );

        return $lists;
    }

    public function prefer_prayer( WP_REST_Request $request ) {
        global $wpdb;
        $body_params = $request->get_body();
        $body_params = json_decode( $body_params, true );
        $type = $body_params['type'];
        $content = $body_params['content'];
        $category = $body_params['category'];
        $unpreferred_prayer = $body_params['unpreferred_prayer'];

        $wpdb->insert( $wpdb->dt_reports, [
            'type' => 'content_a_b_test',
            'subtype' => $type,
            'payload' => serialize( [
                'content' => $content,
                'category' => $category,
                'unpreferred_prayer' => $unpreferred_prayer,
            ] ),
            'timestamp' => time(),
        ] );
    }

    public function body(){

        require_once( WP_CONTENT_DIR . '/plugins/prayer-global-porch/pages/assets/nav.php' ) ?>

        <section class="page-section mt-5" >
            <div class="container">
                <div class="row justify-content-md-center text-center mb-5">
                    <div class="col-lg-7 flow-medium">
                        <h1>Prayer Content A B test</h1>
                        <select id="country_change">
                            <option></option>
                            <option value="100219450">Bhagalpur, Bihar, India</option>
                            <option value="100241389">Kauno, Lithuania</option>
                            <option value="100219618">Lohardaga, Jharkhand, India</option>
                            <option value="100385116">Mashonaland West, Zimbabwe</option>
                            <option value="100235211">Otdar Mean Chey, Cambodia</option>
                            <option value="100363330">Ternopil‘, Ukraine</option>
                            <option value="100000003">Badghis, Afghanistan</option>
                        </select>
                        <!-- Show 2 prayers side by side. One from AI and one current prayer, but not always in the same order -->
                        <h2 class="section-label h5"></h2>
                        <div class="d-flex gap-5">
                            <div class="first-prayer flow-small">
                                <div class="first-prayer__content"></div>
                                <button class="btn btn-primary">Prefer</button>
                            </div>
                            <div class="second-prayer flow-small">
                                <div class="second-prayer__content"></div>
                                <button class="btn btn-primary">Prefer</button>
                            </div>
                        </div>
                        <button id="finish-button" class="btn btn-primary">Finish</button>
                        <!-- under each there will be a button to say which one they prefer -->
                        <!-- The button will send a post request to the server with the content of the prayer they preferred, and whether it was AI or current content -->
                        <!-- In the button event click callback it will also send a GET request for the next prayer -->
                        <!-- It will also store both prayers viewed in different lists locally and which they preferred -->
                        <!-- When they click on the finish button, show them the lists of prayers they viewed and which they preferred -->
                        <!-- And show them the total they preferred from each -->
                    </div>
                </div>
            </div>
        </section>

        <!-- END section -->

        <?php require_once( WP_CONTENT_DIR . '/plugins/prayer-global-porch/pages/assets/working-footer.php' ) ?>
        <?php
    }
}
new Prayer_Global_Content_A_B_Test();
