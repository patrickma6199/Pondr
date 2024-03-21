<?php
ini_set('display_errors', 1);
require_once ('dbconfig.php');
header('Content-Type: application/json');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
session_start();

if (isset ($_POST['postId'])) { //implied request method is POST
    $postId = $_POST['postId'];


    $sql = "SELECT comment FROM posts WHERE postId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $postId);
    $stmt->execute();
    $result = $stmt->get_result();
    // Fetch the count
    try {

        if ($row = $result->fetch_assoc()) {
            echo json_encode(['count' => $row['comment']]); // Return the new like count
        }

    } catch (mysqli_sql_exception $e) {
        echo ("FAILED COUNT");
        // echo $e;
    }

    // Display the comment count
    $stmt->close();
} else {
    exit (header("Location: ../index.php"));
}
?>