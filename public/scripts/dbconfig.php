<?php
ini_set('display_errors', 1);
// Environment: local (XAMPP) or school server

if ($_SERVER['SERVER_NAME'] == 'localhost') {
    // Local XAMPP environment
    $dbHost = 'localhost';
    $dbUser = 'root';
    $dbPass = ''; 
    $dbName = 'pondr';
} else {
    $dbHost = 'cosc360.ok.ubc.ca';
    $dbUser = '68504364';
    $dbPass = '68504364';
    $dbName = 'pondr'; 
}

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Use $conn for queries
// $result= $conn->query("SELECT * FROM users");

?>