<?php

session_start();
ini_set('display_errors', 1);
require_once './dbconfig.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$utype = isset ($_SESSION['utype']) ?? null;
$uid = $_SESSION['uid'];

try{
if (isset ($_GET['postId'])) {
    $pid = $_GET['postId'];

    $sql = "DELETE FROM posts WHERE postId = ?";
    try{
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $pid);
    if ($stmt->execute()) {
        header("Location: ../pages/my_profile.php");
        exit();

    } else {
        echo json_encode(['error' => 'SQL DELETE ERROR.']);
        exit();
    }
    }catch (mysqli_sql_exception $e) {
    error_log("SQL not set", $e->getMessage());

} catch (Exception $e) {
    error_log("SQL not set", $e->getMessage());
}

} 
else {
     echo json_encode(['error' => 'POSTID NOT SET.']);
}



$conn->close();
}catch (mysqli_sql_exception $e) {
    error_log("PostId not set", $e->getMessage());

} catch (Exception $e) {
    error_log("PostId not set", $e->getMessage());
}

?>