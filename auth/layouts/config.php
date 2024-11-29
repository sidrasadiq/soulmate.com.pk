<?php

#########################################   DB Credentials for local host   #########################################    

/* Database credentials. Assuming you are running MySQL Local server
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'themillionaireso_sm_panel_new_new');

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die("ERROR: Could not connect. " . $conn->connect_error);
}

#########################################   DB Credentials for Live Server   #########################################    

/* Database credentials.
/* Database credentials for live server */
// define('DB_SERVER', 'localhost');
// define('DB_USERNAME', 'themillionaireso_sm_panel');
// define('DB_PASSWORD', 'nX^B=[cJ];e;');
// define('DB_NAME', 'themillionaireso_sm_panel');

// $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// if ($conn->connect_error) {
//     die("ERROR: Could not connect. " . $conn->connect_error);
// }
#########################################   Email Credentials   #########################################    

$gmailid = ''; // YOUR gmail email
$gmailpassword = ''; // YOUR gmail password
$gmailusername = ''; // YOUR gmail User name

// Email configuration
$mailHost = 'mail.soulmate.com.pk';
$mailUsername = 'admin@soulmate.com.pk';
$mailPassword = 'nX^B=[cJ];e;';
$mailPort = 465;
