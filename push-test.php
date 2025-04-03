<?php

echo "hi \r\n";

require_once __DIR__ . '/../../../wp-config.php';
add_filter( 'wp_queue_default_connection', function() {
    return 'sync';
} );

if ( defined( 'PG_ONESIGNAL_STOP' ) ) {
    echo 'PG_ONESIGNAL_STOP is defined as ' . esc_html( PG_ONESIGNAL_STOP ) . "\n";
} else {
    echo "PG_ONESIGNAL_STOP is not defined \n";
}

wp_queue()->push( new PG_Notification_Handler_Job() );
