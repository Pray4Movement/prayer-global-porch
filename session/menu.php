<?php
if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

if ( is_admin() ) {
    DT_Custom_Login_JWT_Menu::instance();
}
class DT_Custom_Login_JWT_Menu {

    public $token = 'disciple_tools_custom_login_jwt';
    public $tab_title = 'Custom Login';
    public $tabs;

    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        add_action( "admin_menu", array( $this, "register_menu" ) );
        $this->tabs = [
            'general' => [
                'class' => 'DT_Custom_Login_JWT_Tab_General',
                'label' => 'General'
            ],
            'firebase' => [
                'class' => 'DT_Custom_Login_JWT_Tab_Firebase',
                'label' => 'Firebase'
            ],
            'captcha' => [
                'class' => 'DT_Custom_Login_JWT_Tab_Captcha',
                'label' => 'Captcha'
            ],
            'help' => [
                'class' => 'DT_Custom_Login_JWT_Tab_Help',
                'label' => 'Help'
            ]
        ];
    }

    public function register_menu() {
        if ( class_exists( 'Disciple_Tools' ) ) {
            add_submenu_page( 'dt_extensions', $this->tab_title, $this->tab_title, 'manage_dt', $this->token, [ $this, 'content' ] );
        } else {
            add_menu_page( $this->tab_title, $this->tab_title, 'manage_options', $this->token, [ $this, 'content' ] );
        }
    }

    /**
     * Menu stub. Replaced when Disciple.Tools Theme fully loads.
     */
    public function extensions_menu() {}

    /**
     * Builds page contents
     * @since 0.1
     */
    public function content() {

        if ( !current_user_can( 'manage_options' ) ) {
            wp_die( 'You do not have sufficient permissions to access this page.' );
        }

//        $tabs = $this->tabs;
        $link = 'admin.php?page='.$this->token.'&tab=';

        if ( isset( $_GET["tab"] ) ) {
            $tab = sanitize_key( wp_unslash( $_GET["tab"] ) );
        } else {
            $tab = 'general';
        }

        $vars = $this->process_postback();
        $is_dt = class_exists( 'Disciple_Tools' );
        $tabs = [];
        foreach ( $vars as $val ) {
            if ( $is_dt === $val['requires_dt'] ) {
                $tabs[$val['tab']] = ucwords( $val['tab'] );
            }
            elseif ( ! $val['requires_dt'] ) {
                $tabs[$val['tab']] = ucwords( $val['tab'] );
            }
        }
        ?>
        <div class="wrap">
            <h2><?php echo esc_html( $this->tab_title ) ?></h2>
            <h2 class="nav-tab-wrapper">
                <?php
                foreach ( $tabs as $key => $value ) {
                    ?>
                    <a href="<?php echo esc_attr( $link ) . $key ?>"
                       class="nav-tab <?php echo esc_html( ( $tab == $key ) ? 'nav-tab-active' : '' ); ?>"><?php echo esc_html( $value ) ?></a>
                    <?php
                }
                ?>
            </h2>
            <div class="wrap">
                <div id="poststuff">
                    <div id="post-body" class="metabox-holder">
                        <div id="post-body-content">
                            <!-- Box -->
                            <form method="post">
                                <?php wp_nonce_field( $this->token.get_current_user_id(), $this->token . '_nonce' ) ?>
                                <table class="widefat striped">
                                    <tbody>
                                    <?php
                                    if ( ! empty( $vars ) ) {
                                        foreach ( $vars as $key => $value ) {
                                            if ( $tab === $value['tab'] ) {
                                                if ( $is_dt === $value['requires_dt'] ) {
                                                    $this->template( $value );
                                                }
                                                elseif ( ! $value['requires_dt'] ) {
                                                    $this->template( $value );
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="2">
                                            <button class="button" type="submit">Save</button> <button class="button" type="submit" style="float:right;" name="delete" value="1">Reset</button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </form>
                            <br>
                            <!-- End Main Column -->
                        </div><!-- end post-body-content -->
                    </div><!-- post-body meta box container -->
                </div><!--poststuff end -->
            </div><!-- wrap end -->
        </div><!-- End wrap -->
        <?php
    }

    public function template( $args ) {
        switch ( $args['type'] ) {
            case 'text':
                ?>
                <tr>
                    <td style="width:10%; white-space:nowrap;">
                       <strong><?php echo esc_html( $args['label'] ) ?></strong>
                    </td>
                    <td>
                        <input type="text" name="<?php echo esc_attr( $args['key'] ) ?>" value="<?php echo esc_attr( $args['value'] ) ?>" /> <?php echo esc_attr($args['description']) ?>
                    </td>
                </tr>
                <?php
                break;
            case 'select':
                ?>
                <tr>
                    <td style="width:10%; white-space:nowrap;">
                       <strong><?php echo esc_html( $args['label'] ) ?></strong>
                    </td>
                    <td>
                        <select name="<?php echo esc_attr( $args['key'] ) ?>">
                            <option></option>
                            <?php
                            foreach ( $args['default'] as $item_key => $item_value ) {
                                ?>
                                <option value="<?php echo esc_attr( $item_key ) ?>" <?php echo ( $item_key === $args['value'] ) ? 'selected' : '' ?>><?php echo $item_value ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <?php echo esc_html( $args['description'] ) ?>
                    </td>
                </tr>
                <?php
                break;
            case 'label':
                ?>
                <tr>
                    <td style="width:10%; white-space:nowrap;">
                       <strong><?php echo esc_html( $args['label'] ) ?></strong>
                    </td>
                    <td>
                        <?php echo esc_html( $args['description'] ) ?>
                        <?php echo ( isset( $args['description_2'] ) && ! empty( $args['description_2'] ) ) ? '<p>' . esc_html( $args['description_2'] ) . '</p>' : '' ?>
                    </td>
                </tr>
                <?php
                break;
            default:
                break;
        }
    }

    public function process_postback(){
        $vars = dt_custom_login_fields();

        // process POST
        if ( isset( $_POST[$this->token.'_nonce'] )
            && wp_verify_nonce( sanitize_key( wp_unslash( $_POST[$this->token.'_nonce'] ) ), $this->token . get_current_user_id() ) ) {
            $params = $_POST;

            foreach ( $params as $key => $param ) {
                if ( isset( $vars[$key]['value'] ) ) {
                    $vars[$key]['value'] = $param;
                }
            }

            if ( isset( $params['delete'] ) ) {
                delete_option( 'dt_custom_login_fields' );
            } else {
                update_option( 'dt_custom_login_fields', $vars, true );
            }
        }

        return $vars;
    }
}
function dt_custom_login_fields() {
    $defaults = [

        // general
        'general_label' => [
            'tab' => 'general',
            'key' => 'general_label',
            'label' => 'GENERAL',
            'description' => '',
            'value' => '',
            'type' => 'label',
            'requires_dt' => false
        ],


        // pages
        'pages_label' => [
            'tab' => 'pages',
            'key' => 'pages_label',
            'label' => 'PAGES',
            'description' => '',
            'value' => '',
            'type' => 'label',
            'requires_dt' => true,
        ],
        'login_page' => [
            'tab' => 'pages',
            'key' => 'login_page',
            'label' => 'Login Page',
            'description' => 'Enables the Login Page (<a href="'.site_url().'/login-registration" target="_blank">'.site_url().'/login-registration</a>)',
            'default' => [
                'enabled' => 'Enabled',
                'disabled' => 'Disabled',
            ],
            'value' => 'enabled',
            'type' => 'select',
            'requires_dt' => true,
        ],
        'privacy_policy_page' => [
            'tab' => 'pages',
            'key' => 'privacy_policy_page',
            'label' => 'Privacy Policy',
            'description' => 'Enables the Privacy Policy (<a href="'.site_url().'/privacy-policy" target="_blank">'.site_url().'/privacy-policy</a>)',
            'default' => [
                'enabled' => 'Enabled',
                'disabled' => 'Disabled',
            ],
            'value' => 'enabled',
            'type' => 'select',
            'requires_dt' => true,
        ],
        'terms_of_service_page' => [
            'tab' => 'pages',
            'key' => 'terms_of_service_page',
            'label' => 'Terms of Service Page',
            'description' => 'Enables the Terms of Service Page (<a href="'.site_url().'/terms-of-service" target="_blank">'.site_url().'/terms-of-service</a>)',
            'default' => [
                'enabled' => 'Enabled',
                'disabled' => 'Disabled',
            ],
            'value' => 'enabled',
            'type' => 'select',
            'requires_dt' => true,
        ],
        'user_profile_page' => [
            'tab' => 'pages',
            'key' => 'user_profile_page',
            'label' => 'User Profile',
            'description' => 'Enables the User Profile (<a href="'.site_url().'/user-profile" target="_blank">'.site_url().'/user-profile</a>)',
            'default' => [
                'enabled' => 'Enabled',
                'disabled' => 'Disabled',
            ],
            'value' => 'enabled',
            'type' => 'select',
            'requires_dt' => true
        ],
        'registration_hold_page' => [
            'tab' => 'pages',
            'key' => 'registration_hold_page',
            'label' => 'Registration Hold Page',
            'description' => 'Enables the Registration Hold (<a href="'.site_url().'/registration-holding" target="_blank">'.site_url().'/registration-holding</a>)',
            'default' => [
                'enabled' => 'Enabled',
                'disabled' => 'Disabled',
            ],
            'value' => 'enabled',
            'type' => 'select',
            'requires_dt' => true
        ],

        // shortcode
        'shortcode_modal' => [
            'tab' => 'shortcodes',
            'key' => 'shortcode_modal',
            'label' => 'Modal Shortcode',
            'description' => '[zume_footer_logon_modal]',
            'description_2' => 'Use this shortcode in the footer of a page to add the full modal and login functions.',
            'value' => '',
            'type' => 'label',
            'requires_dt' => false
        ],
        'shortcode_zume_logon_button' => [
            'tab' => 'shortcodes',
            'key' => 'shortcode_zume_logon_button',
            'label' => 'Logon Button',
            'description' => '[zume_logon_button]',
            'description_2' => '',
            'value' => '',
            'type' => 'label',
            'requires_dt' => false
        ],
        'shortcode_zume_logon_button_with_name' => [
            'tab' => 'shortcodes',
            'key' => 'shortcode_zume_logon_button_with_name',
            'label' => 'Logon Button with Name',
            'description' => '[zume_logon_button_with_name]',
            'description_2' => '',
            'value' => '',
            'type' => 'label',
            'requires_dt' => false
        ],

        // firebase
        'firebase_api_key' => [
            'tab' => 'firebase',
            'key' => 'firebase_api_key',
            'label' => 'Firebase API Key',
            'description' => '',
            'value' => '',
            'type' => 'text',
            'requires_dt' => false
        ],
        'firebase_project_id' => [
            'tab' => 'firebase',
            'key' => 'firebase_project_id',
            'label' => 'Firebase Project ID',
            'description' => 'firebase description',
            'value' => '',
            'type' => 'text',
            'requires_dt' => false
        ],
        'firebase_app_id' => [
            'tab' => 'firebase',
            'key' => 'firebase_app_id',
            'label' => 'Firebase App ID',
            'description' => 'firebase description',
            'value' => '',
            'type' => 'text',
            'requires_dt' => false
        ],

        // captcha
        'captcha_key' => [
            'tab' => 'captcha',
            'key' => 'captcha_key',
            'label' => 'Captcha Key',
            'description' => 'captcha description',
            'value' => '',
            'type' => 'text',
            'requires_dt' => false
        ],
    ];

    $defaults_count = count( $defaults );

    $saved_fields = get_option( 'dt_custom_login_fields', [] );
    $saved_count = count( $saved_fields );

    $fields = wp_parse_args( $saved_fields, $defaults );

    if ( $defaults_count !== $saved_count ) {
        update_option( 'dt_custom_login_fields', $fields, true );
    }

    return $fields;
}