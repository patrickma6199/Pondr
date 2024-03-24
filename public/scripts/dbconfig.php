<?php
ini_set('display_errors', 1);
// Environment

$deployed = false;
if (!$deployed) {
    // Local XAMPP environment
    $dbHost = 'localhost';
    $dbUser = 'root';
    $dbPass = ''; 
    $dbName = 'pondr';
} else {
    // School server
    $dbHost = 'cosc360.ok.ubc.ca';
    $dbUser = '68504364';
    $dbPass = '68504364';
    $dbName = 'db_68504364'; 
}

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>