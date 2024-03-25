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
    try{
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $pid);
        $stmt->execute();
        $stmt->close();
        exit(header("Location: ../pages/my_profile.php"));
    }catch (mysqli_sql_exception $e) {
        error_log("SQL Error: ", $e->getMessage());
    } catch (Exception $e) {
        error_log("SQL Error: ", $e->getMessage());
    } finally {
        if (isset ($stmt)) {
            $stmt->close();
        }
    }
} 
else {
    exit (header("Location: ../index.php"));
}
$conn->close();
?>