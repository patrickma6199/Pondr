<?php
// Environment: local (XAMPP) or school server

if ($_SERVER['SERVER_NAME'] == 'localhost') {
    // Local XAMPP environment
    $dbHost = 'localhost';
    $dbUser = 'root'; // Default XAMPP user
    $dbPass = ''; // Default XAMPP password (none)
    $dbName = 'pondr'; // Database name
} else {
    $dbHost = 'school_server_host';
    $dbUser = 'school_db_user';
    $dbPass = 'school_db_password';
    $dbName = 'pondr'; // Database name, assuming it remains the same
}

// Create connection
$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Use $conn for queries
// $result= $conn->query("SELECT * FROM users");

?>