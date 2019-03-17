<?php

$dbhost = 'db';
$dbuser = 'root';
$dbpass = 'root';
$dbname = 'armbook';
$mysqli = new mysqli('db', $dbuser, $dbpass, $dbname);
if ($mysqli->connect_errno) {
    echo "Error: Failed to make a MySQL connection, here is why: \n";
    echo "Errno: " . $mysqli->connect_errno . "\n";
    echo "Error: " . $mysqli->connect_error . "\n";
    die( "Sorry, this website is experiencing problems.");
}
# Disables showing warnings, if you want these enable them -- however it may mess with the app in the end if using later php (PHP7)
error_reporting(0);

?>
