<?php
//Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'creative_app');

//Connect to mySQL

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

//Check Connection

if($conn->connect_error) {
    die("Connection failed:" .$conn->connect_error);

}

//start session for login tracking

session_start();
?>