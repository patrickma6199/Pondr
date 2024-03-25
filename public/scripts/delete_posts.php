<?php
session_start();
ini_set('display_errors', 1);
require_once './dbconfig.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$utype = isset ($_SESSION['utype']) ?? null;
$uid = $_SESSION['uid'];
$utype = $_SESSION['utype'] ?? null;

try {
    if ($utype == 0 || $utype == 1) {

        try {
            if (isset ($_GET['postId'])) {
                $pid = $_GET['postId'];
                $uName = $_GET['uName'];


                $sql = "DELETE FROM posts WHERE postId = ?";
                try {
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $pid);
                    if ($stmt->execute()) {
                        header("Location: ../pages/profile.php?uName=$uName");
                        exit();

                    } else {
                        echo json_encode(['error' => 'ERROR WITH DELETING NOT SET']);

                        exit();
                    }
                } catch (mysqli_sql_exception $e) {
                    error_log("SQL not set", $e->getMessage());

                } catch (Exception $e) {
                    error_log("SQL not set", $e->getMessage());
                }

            } else {
                echo json_encode(['error' => 'POSTID NOT SET']);
            }
            $conn->close();
        } catch (mysqli_sql_exception $e) {
            error_log("PostId not set", $e->getMessage());

        } catch (Exception $e) {
            error_log("PostId not set", $e->getMessage());
        }
    } else {
        echo json_encode(['error' => 'NOT AN ADMIN OR USER.']);
    }
} catch (mysqli_sql_exception $e) {
    error_log("UTYPE not set", $e->getMessage());

} catch (Exception $e) {
    error_log("UTYPE not set", $e->getMessage());
}

?>