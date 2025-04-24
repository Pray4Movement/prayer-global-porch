<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

class PG_Relay_Tools extends PG_Public_Page {
    public $url_path = 'tools';
    public $page_title = 'Prayer Lap Tools';
    public $root = 'pray';
    public $type = 'tools';
    public $parts = [];
    private $url_parts;
    private $custom_relay = false;
    private $relay_key = '49ba4c';
    private $relay_id = 2128;

    public function __construct() {
        $url_path = dt_get_url_path( true );
        $this->url_parts = explode( '/', $url_path );
        $this->custom_relay = isset( $this->url_parts[0] ) && $this->url_parts[0] !== $this->relay_key && $this->url_parts[0] !== 'tools';

        if ( $url_path !== 'tools' && ( !isset( $this->url_parts[1] ) || $this->url_parts[1] !== 'tools' ) ) {
            return;
        }
        $this->url_path = $url_path;

        parent::__construct();
        if ( $this->custom_relay ) {
            $this->relay_key = $this->url_parts[0];
            $this->custom_relay = true;
            $this->relay_id = pg_get_relay_id( $this->relay_key );
            $this->page_title = get_the_title( $this->relay_id );
        }
    }

    public function dt_magic_url_base_allowed_js( $allowed_js ) {
        $allowed_js[] = 'clipboard';
        return $allowed_js;
    }

    public function dt_magic_url_base_allowed_css( $allowed_css ) {
        return $allowed_css;
    }

    public function header_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/header.php' );
    }

    public function footer_javascript(){
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . 'assets/footer.php' );
        ?>
        <script type="application/javascript">
          window.addEventListener('load', function() {
            var clipboard = new ClipboardJS('#copy-button');
            clipboard.on('success', function(e) {
              console.info('Action:', e.action);
              console.info('Text:', e.text);
              console.info('Trigger:', e.trigger);
              jQuery('#copy-button').text('Copied')
              e.clearSelection();
            });


            var clipboard_qrapp = new ClipboardJS('#copy-button-qrapp');
            clipboard_qrapp.on('success', function(e) {
              console.info('Action:', e.action);
              console.info('Text:', e.text);
              console.info('Trigger:', e.trigger);
              jQuery('#copy-button-qrapp').text('Copied')
              e.clearSelection();
            });



            var clipboard_display = new ClipboardJS('#copy-button-display');
            clipboard_display.on('success', function(e) {
              console.info('Action:', e.action);
              console.info('Text:', e.text);
              console.info('Trigger:', e.trigger);
              jQuery('#copy-button-display').text('Copied')
              e.clearSelection();
            });


          });
        </script>
        <?php
    }

    public function body(){
        $lap_stats = Prayer_Stats::get_relay_current_lap_stats( $this->relay_key, $this->relay_id );
        require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . '/assets/nav.php' );
        ?>
        <section class="page">
            <div class="container pb-4">
                <div class="row">
                    <div class="col-md text-center">
                        <h2><?php echo esc_html( sprintf( __( '%s Relay Tools', 'prayer-global-porch' ), $lap_stats['title'] ) ) ?></h2>
                    </div>
                </div>
            </div>
            <div class="container" id="content">

                <div class="row ">
                    <div class="col text-center">
                        <hr>
                    </div>
                </div>
                <div class="row ">
                    <div class="col text-center p-3">
                        <h3><?php echo esc_html( sprintf( __( '%s Relay Map', 'prayer-global-porch' ), $lap_stats['title'] ) ) ?></h3>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col col-6 col-md-4 col-lg-3 text-center">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=1000x1000&amp;data=<?php echo esc_url( get_site_url() ) ?>/<?php echo esc_html( $lap_stats['key'] ) ?>/map" style="width: 100%;max-width:400px;"><br><br>
                    </div>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control copy-input"
                           value="<?php echo esc_url( get_site_url() ) ?>/<?php echo esc_html( $lap_stats['key'] ) ?>/map" placeholder="Some path" id="copy-input">
                    <button class="btn btn-secondary copy-button input-group-btn" type="button" id="copy-button"
                              data-bs-toggle="tooltip" data-placement="button"
                              title="<?php esc_attr( __( 'Copy to Clipboard', 'prayer-global-porch' ) ) ?>" data-clipboard-action="copy" data-clipboard-target="#copy-input">
                        <?php echo esc_html( __( 'Copy', 'prayer-global-porch' ) ) ?>
                    </button>
                </div>


                <div class="row ">
                    <div class="col text-center">
                        <hr>
                    </div>
                </div>
                <div class="row ">
                    <div class="col text-center p-3">
                        <h3><?php echo esc_html__( 'Display Map (60 Second Refresh)', 'prayer-global-porch' ) ?></h3>
                    </div>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control copy-display"
                           value="<?php echo esc_url( get_site_url() ) ?>/<?php echo esc_html( $lap_stats['key'] ) ?>/display" placeholder="Some path" id="copy-display-input">
                      <button class="btn btn-secondary copy-button input-group-btn" type="button" id="copy-button-display"
                              data-bs-toggle="tooltip" data-placement="button"
                              title="<?php esc_attr( __( 'Copy to Clipboard', 'prayer-global-porch' ) ) ?>" data-clipboard-action="copy" data-clipboard-target="#copy-display-input">
                        <?php echo esc_html( __( 'Copy', 'prayer-global-porch' ) ) ?>
                      </button>
                </div>


                <div class="row ">
                    <div class="col text-center">
                        <hr>
                    </div>
                </div>
                <div class="row ">
                    <div class="col text-center p-3">
                        <h3><?php echo esc_html( sprintf( __( 'App Stores: %s App', 'prayer-global-porch' ), 'Prayer.Global' ) ) ?></h3>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col col-6 col-md-4 col-lg-3 text-center">
                        <img src="<?php echo esc_url( trailingslashit( plugin_dir_url( __DIR__ ) ) . 'assets/images/prayer.global.app.png' ) ?>" style="width: 100%;max-width:400px;"><br><br>
                    </div>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control copy-input"
                           value="<?php echo esc_url( get_site_url() ) ?>/qr/app" placeholder="Some path" id="copy-input-qrapp">
                  <button class="btn btn-secondary copy-button input-group-btn" type="button" id="copy-button-qrapp"
                          data-bs-toggle="tooltip" data-placement="button"
                          title="<?php esc_attr( __( 'Copy to Clipboard', 'prayer-global-porch' ) ) ?>" data-clipboard-action="copy" data-clipboard-target="#copy-input-qrapp">
                    <?php echo esc_html( __( 'Copy', 'prayer-global-porch' ) ) ?>
                  </button>
                </div>


            </div>

        </section>
        <div style="height:300px;"></div>
        <!-- END section -->
        <?php require_once( trailingslashit( plugin_dir_path( __DIR__ ) ) . '/assets/working-footer.php' ) ?>
        <?php // end html
    }

    public function wp_enqueue_scripts(){
        wp_enqueue_script( 'clipboard', plugin_dir_url( __DIR__ ) . 'assets/js/clipboard.min.js', [], filemtime( plugin_dir_path( __DIR__ ) . 'assets/js/clipboard.min.js' ), true );
    }
}

new PG_Relay_Tools();