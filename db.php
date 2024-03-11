<?php

    // Connect to the database
    $servername   = 'localhost'; 
    $username     = 'root';
    $password     = '';
    $dbname       = 'Assignment2';

   // create the connection
$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

// check if connection has any issues
if (!$pdo) {
    die('Oops, unsuccessful!');
}
?>