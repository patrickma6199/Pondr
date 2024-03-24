<?php

session_start();
ini_set('display_errors', 1);
require_once './dbconfig.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$utype = isset ($_SESSION['utype']) ?? null;
$uid = $_SESSION['uid'];

if (isset ($_GET['postId'])) {
    $pid = $_GET['postId'];

    $sql = "DELETE FROM posts WHERE postId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $pid);
    if ($stmt->execute()) {
        header("Location: ../pages/my_profile.php");
        exit();

    } else {
        echo "Error with deleting";
        exit();
    }

} else {
    echo "PostId or Uname wrong";
    echo "Postid =$pid";
}

$conn->close();

?>