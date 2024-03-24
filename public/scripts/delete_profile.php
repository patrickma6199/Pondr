<?php

ini_set('display_errors', 1);
require_once 'dbconfig.php';
header('Content-Type: application/json');

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
session_start();
$uid = $_SESSION['uid'] ?? null;

if (isset ($_POST['uName'])) {
    $uName = $_POST['uName'];

    $sql = "SELECT userId FROM users where uName=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $uName);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($uid1);
        $stmt->fetch();

        $sql1 = "DELETE FROM users WHERE userId=?";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param("i", $uid1);
        $stmt1->execute();

        if ($stmt1->execute()) {
            echo json_encode(['success' => 'User deleted successfully.']);
            (header('../pages/discussion.php'));
        } else {
            echo json_encode(['error' => 'User deletion failed.']);
        }
    } else {
        echo json_encode(['error' => 'User not found.']);
    }
} else {
    echo json_encode(['error' => 'uName not provided.']);

}
$conn->close();


?>