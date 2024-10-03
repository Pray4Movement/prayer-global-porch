<?php
//this stops wp-settings from load everything
define( 'SHORTINIT', true );

echo time();

$servername = "localhost";
$username = "xjhaqcngrf";
$password = "MZRfmc9UtZ";
$database = "xjhaqcngrf";

$conn = new mysqli( $servername, $username, $password, $database );

if ($conn->connect_error) {
  die( "Connection failed: " . $conn->connect_error );
}

echo "Connected successfully";