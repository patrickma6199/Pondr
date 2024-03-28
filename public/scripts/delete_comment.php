<?php

session_start();
ini_set('display_errors', 1);
require_once './dbconfig.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$utype = $_SESSION['utype'] ?? null;
$uid = $_SESSION['uid'] ?? null;


if (isset ($_GET['postId']) && isset ($_GET['comId'])) {
    $pid = $_GET['postId'];
    $cid = $_GET['comId'];
    $conn->begin_transaction();
    try{
         $sql = "SELECT userId FROM comments WHERE comId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $cid);
        $stmt->bind_result($comUid);
        $stmt->execute();
        if ($stmt->fetch()) {
            if ($uid == $comUid || $utype == 1) {
                $allowed = true;
            } else {
                $allowed = false;
            }
        } else {
            throw new Exception("Could not retrieve comment uid.");
        }
        $stmt->close();
        unset($stmt);

        if ($allowed) {
            
            $sql = "DELETE FROM comments WHERE comId = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $cid);
            if($stmt->execute()){
                $sql = "UPDATE posts SET comment = comment - 1 WHERE postId=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $pid);
                $stmt->execute();
                $conn->commit();
            }
            $conn->commit();
        } else {
            $conn->rollback();
            exit(header("Location: ../index.php")); 
        }
    }catch (mysqli_sql_exception $e) {
        $conn->rollback();
        error_log("SQL Error: ". $e->getMessage());
    } catch (Exception $e) {
        $conn->rollback();
        error_log("Error: ". $e->getMessage());
    } finally {
        if (isset ($stmt)) {
            $stmt->close();
        }
        $conn->close();
    }
    exit(header("Location: ../pages/thread.php?postId=$pid"));
} else {
    $conn->close();
    exit (header("Location: ../index.php"));
}
?>