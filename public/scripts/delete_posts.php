<?php

session_start();
ini_set('display_errors', 1);
require_once './dbconfig.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$utype = $_SESSION['utype'] ?? null;
$uid = $_SESSION['uid'] ?? null;

if (isset ($_GET['postId'])) {
    $pid = $_GET['postId'];
    $conn->begin_transaction();
    try{
        //checking if user is permitted to delete
        $sql = "SELECT userId FROM posts WHERE postId = ?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $pid);
        $stmt->bind_result($postUid);
        $stmt->execute();
        if ($stmt->fetch()) {
            if ($uid == $postUid || $utype == 1) {
                $allowed = true;
            } else {
                $allowed = false;
            }
        } else {
            throw new Exception("Could not retrieve post uid.");
        }
        $stmt->close();
        unset($stmt);

        if ($allowed) {
            $sql = "SELECT img, catId FROM posts WHERE postId = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $pid);
            $stmt->bind_result($postImg, $catId);
            $stmt->execute();
            if ($stmt->fetch()) {
                if (isset ($postImg) && file_exists($postImg)) {
                    if (!unlink($postImg)) {
                        throw new Exception("Could not delete post image.");
                    }
                }
                $stmt->close();
                unset($stmt);
                $sql = "UPDATE categories SET count = count - 1 WHERE catId = ?;";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('s', $catId);
                $stmt->execute();
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
        } else {
            $conn->rollback();
            exit(header("Location: ../index.php")); 
        }
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
    exit(header("Location: ../pages/my_profile.php"));
} else {
    $conn->close();
    exit (header("Location: ../index.php"));
}
?>