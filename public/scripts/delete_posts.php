<?php
session_start();
ini_set('display_errors', 1);
require_once './dbconfig.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$utype = isset ($_SESSION['utype']) ?? null;
$uid = $_SESSION['uid'] ?? null;
$utype = $_SESSION['utype'] ?? null;


if ($utype == 0 || $utype == 1) {
    if (isset ($_GET['postId'])) {
        $pid = $_GET['postId'];
        $uName = $_GET['uName'];

        $sql = "DELETE FROM posts WHERE postId = ?";
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $pid);
            $stmt->execute();
            exit(header("Location: ../pages/profile.php?uName=$uName"));
        } catch (mysqli_sql_exception $e) {
            error_log("SQL Error: ", $e->getMessage());
        } catch (Exception $e) {
            error_log("SQL Error: ", $e->getMessage());
        } finally {
            if (isset ($stmt)) {
                $stmt->close();
            }
        }
    } else {
        error_log("POSTID NOT SET");
    }
    $conn->close();
} else {
    exit (header("Location: ../index.php"));
}

?>