<?php
// Connect to the database
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'Assignment2';

// Create the connection
$db = new mysqli($servername, $username, $password, $dbname);

// Check if the connection has any issues
if ($db->connect_error) {
    die('Connection failed: ' . $db->connect_error);
} else {
    echo 'Connection successful!!';
}
?>
