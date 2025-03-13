<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

class Prayer_Global_Porch_ICOM_Tshirt_Signup extends DT_Magic_Url_Base
{
    public $page_title = 'Prayer.Global';
    public $root = 'tshirt';
    public $url_token = 'tshirt';
    public $type_name = 'ICOM Tshirt prize draw';
    public $post_type = 'contacts';

    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct() {
        parent::__construct();

        $url = dt_get_url_path();

        if ( substr( $url, 0, strlen( $this->url_token ) ) !== $this->root ) {
            return;
        }

        $this->redirect();
    }

    public function redirect() {
        $link = '/user_app/login?action=register';
        wp_redirect( $link );
        exit;
    }
}
Prayer_Global_Porch_ICOM_Tshirt_Signup::instance();
class Prayer_Global_Porch_Active_Relays extends DT_Magic_Url_Base
{
    public $page_title = 'Prayer.Global';
    public $root = 'relays';
    public $url_token = 'relays';
    public $type_name = 'Active Relays';
    public $post_type = 'contacts';

    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct() {
        parent::__construct();

        $url = dt_get_url_path();

        if ( substr( $url, 0, strlen( $this->url_token ) ) !== $this->root ) {
            return;
        }

        $this->redirect();
    }

    public function redirect() {
        $link = '/challenges/active/';
        wp_redirect( $link );
        exit;
    }
}
Prayer_Global_Porch_Active_Relays::instance();

class Prayer_Global_Porch_Newest_Lap extends DT_Magic_Url_Base
{
    public $page_title = 'Prayer.Global';
    public $root = 'newest';
    public $type = 'lap';
    public $url_token = 'newest/lap';
    public $type_name = 'Newest Lap';
    public $post_type = 'contacts';

    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct() {
        parent::__construct();

        $url = dt_get_url_path();

        if ( substr( $url, 0, strlen( $this->url_token ) ) !== $this->root . '/' . $this->type ) {
            return;
        }

        $this->redirect();
    }

    public function redirect() {
        $link = '/prayer_app/global/49ba4c';
        wp_redirect( $link );
        exit;
    }
}
Prayer_Global_Porch_Newest_Lap::instance();

class Prayer_Global_Porth_ICOM_Lap extends DT_Magic_Url_Base
{
    public $page_title = 'Prayer.Global - ICOM';
    public $root = 'icom';
    public $url_token = 'icom';
    public $type_name = 'ICOM lap';
    public $post_type = 'contacts';
    public static $lap_key = 'a67715';

    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct() {
        parent::__construct();

        $url = dt_get_url_path();

        if ( substr( $url, 0, strlen( $this->url_token ) ) !== $this->root ) {
            return;
        }

        $this->redirect();
    }

    public function redirect() {
        wp_redirect( $this->map_link() );
        exit;
    }
    public static function map_link() {
        return self::link() . '/map';
    }

    public static function link() {
        $link = '/prayer_app/custom/' . self::$lap_key;
        return $link;
    }

    public static function pray_link() {
        $domain_url = new DT_URL( site_url() );
        $domain = $domain_url->parsed_url['host'];
        $domain = isset( $domain_url->parsed_url['port'] ) ? $domain . ':' . $domain_url->parsed_url['port'] : $domain;

        $link = trailingslashit( PG_API_ENDPOINT ) . '?relay='.self::$lap_key.'&domain='.$domain;
        return $link;
    }
}
Prayer_Global_Porth_ICOM_Lap::instance();

class Prayer_Global_Porch_Newest_Lap_Location extends DT_Magic_Url_Base
{
    public $page_title = 'Prayer.Global';
    public $root = 'nl';
    public $type_name = 'Newest Lap Location';
    public $post_type = 'contacts';

    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct() {
        parent::__construct();

        $url = dt_get_url_path();

        $url_parts = explode( '/', $url );

        if ( $url_parts[0] !== $this->root ) {
            return;
        }

        $grid_id = intval( $url_parts[1] );

        if ( !$grid_id ) {
            return;
        }

        $this->redirect( $grid_id );
    }

    public function redirect( $grid_id ) {
        $link = '/prayer_app/global/49ba4c/location?grid_id=' . $grid_id;
        wp_redirect( $link );
        exit;
    }
}
Prayer_Global_Porch_Newest_Lap_Location::instance();


class Prayer_Global_Porch_Newest_Lap_Map extends DT_Magic_Url_Base
{
    public $page_title = 'Prayer.Global';
    public $root = 'newest';
    public $type = 'map';
    public $url_token = 'newest/map';
    public $type_name = 'Newest Lap Map';
    public $post_type = 'laps';

    private static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct() {
        parent::__construct();

        $url = dt_get_url_path();

        if ( substr( $url, 0, strlen( $this->url_token ) ) === $this->root . '/' . $this->type ) {
            $this->redirect();
        }

        if ( $url === 'map' ) {
            $this->redirect();
        }
    }

    public function redirect() {
        $link = '/prayer_app/global/49ba4c/map';
        wp_redirect( $link );
        exit;
    }
}
Prayer_Global_Porch_Newest_Lap_Map::instance();

//class Prayer_Global_Give_Redirect extends DT_Magic_Url_Base
//{
//    public $page_title = 'Global Prayer - Give';
//    public $root = 'content_app';
//    public $type = 'give_page';
//    public $type_name = 'Global Prayer - Give';
//    public static $token = 'content_app_give';
//    public $post_type = 'laps';
//
//    private static $_instance = null;
//
//    public static function instance() {
//        if (is_null( self::$_instance )) {
//            self::$_instance = new self();
//        }
//        return self::$_instance;
//    } // End instance()
//
//    public function __construct() {
//        parent::__construct();
//
//        $url = dt_get_url_path();
//
//        $url_token = $this->root . '/' . $this->type;
//        if (substr( $url, 0, strlen( $url_token ) ) === $url_token ) {
//            $this->redirect();
//        }
//
//    }
//
//    public function redirect() {
//        $link = 'https://give.prayer.global/';
//        wp_redirect( $link );
//        exit;
//    }
//}
//Prayer_Global_Give_Redirect::instance();

class Prayer_Global_Porch_App_Store_Redirect extends DT_Magic_Url_Base
{
    public $page_title = 'Prayer.Global -  QR Redirect';
    public $root = 'qr';
    public $type = 'app';
    public $url_token = 'qr/app';
    public $type_name = 'App Store Redirect';
    public $post_type = 'laps';

    private static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct() {
        parent::__construct();

        $url = dt_get_url_path();

        if ( substr( $url, 0, strlen( $this->url_token ) ) === $this->root . '/' . $this->type ) {
            $this->redirect();
        }
    }

    public function redirect() {
        ?>
        <script>
            var isMobile = {
                Android: function() {
                    return navigator.userAgent.match(/Android/i);
                },
                BlackBerry: function() {
                    return navigator.userAgent.match(/BlackBerry/i);
                },
                iOS: function() {
                    return navigator.userAgent.match(/iPhone|iPad|iPod/i);
                },
                Opera: function() {
                    return navigator.userAgent.match(/Opera Mini/i);
                },
                Windows: function() {
                    return navigator.userAgent.match(/IEMobile/i);
                },
                any: function() {
                    return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
                }
            };

            if ( isMobile.Android() ) {
                document.location.href = "https://play.google.com/store/apps/details?id=app.global.prayer";
            }
            else if(isMobile.iOS())
            {
                document.location.href = "https://apps.apple.com/us/app/prayer-global/id1636889534?uo=4";
            } else {
                document.location.href = "https://play.google.com/store/apps/details?id=app.global.prayer";
            }
        </script>
        <?php
    }
}
Prayer_Global_Porch_App_Store_Redirect::instance();

