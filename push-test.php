<?php

echo 'hi';
DEFINE( 'SHORTINIT', true );
require_once __DIR__ . '/../../../wp-config.php';
require_once __DIR__ . '/utilities/pg-onesignal.php';

$result =PG_Onesignal::send_to_user( 'nathinabob+1234@gmail.com', 'Test message' );

var_dump( $result );
