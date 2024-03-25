<?php

session_start();
ini_set('display_errors', 1);
require_once './dbconfig.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$utype = isset ($_SESSION['utype']) ?? null;
$uid = $_SESSION['uid'];

if (isset ($_GET['postId'])) {
    $conn->begin_transaction();
    try{
        $pid = $_GET['postId'];

        $sql = "SELECT img FROM posts WHERE postId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $pid);
        $stmt->bind_result($postImg);
        $stmt->execute();
        if ($stmt->fetch()) {
            if (isset ($postImg)) {
                if (!unlink($postImg)) {
                    throw new Exception("Could not delete post image.");
                }
            }
        } else {
            throw new Exception("Could not retrieve post image.");
        }
        $stmt->close();
        unset($stmt);
        $sql = "DELETE FROM posts WHERE postId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $pid);
        $stmt->execute();
        $conn->commit();
        exit(header("Location: ../pages/my_profile.php"));
    }catch (mysqli_sql_exception $e) {
        $conn->rollback();
        error_log("SQL Error: ", $e->getMessage());
    } catch (Exception $e) {
        $conn->rollback();
        error_log("Error: ", $e->getMessage());
    } finally {
        if (isset ($stmt)) {
            $stmt->close();
        }
        $conn->close();
    }
} 
else {
    $conn->close();
    exit (header("Location: ../index.php"));
}
?>