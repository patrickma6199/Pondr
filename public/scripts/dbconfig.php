<?php
ini_set('display_errors', 1);
// Environment: local (XAMPP) or school server

$deployed = false;
if (!$deployed) {
    // Local XAMPP environment
    $dbHost = 'localhost';
    $dbUser = 'root';
    $dbPass = ''; 
    $dbName = 'pondr';
} else {
    $dbHost = 'cosc360.ok.ubc.ca';
    $dbUser = '68504364';
    $dbPass = '68504364';
    $dbName = 'db_68504364'; 
}

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Use $conn for queries
// $result= $conn->query("SELECT * FROM users");

?>