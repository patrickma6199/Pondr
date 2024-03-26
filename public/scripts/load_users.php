<?php
session_start();
ini_set('display_errors', 1);
require_once 'dbconfig.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
header('Content-Type: application/json');

$query = "SELECT userId, fName, lName, uName, email, pfp FROM users";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="user-list">';
        echo '<div>';
        echo '<h3>' . $row["fName"] . " " . $row["lName"] . '<i class="fas fa-trash-alt" style="margin-left: 10px;"></i></h3>';
        echo '<p>Username: ' . $row["uName"] . '</p>';
        echo '</div>';
        echo '<img src="../img/' . $row["pfp"] . '">';
        echo '</div>';
    }
} else {
    echo "0 results";
}
$conn->close();
?>