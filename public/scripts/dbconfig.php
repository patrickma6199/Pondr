<?php
// Environment: local (XAMPP) or school server

if ($_SERVER['SERVER_NAME'] == 'localhost') {
    // Local XAMPP environment
    $dbHost = 'localhost';
    $dbUser = 'root';
    $dbPass = ''; 
    $dbName = 'pondr';
} else {
    $dbHost = 'school_server_host';
    $dbUser = 'school_db_user';
    $dbPass = 'school_db_password';
    $dbName = 'pondr'; 
}

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Use $conn for queries
// $result= $conn->query("SELECT * FROM users");

?>