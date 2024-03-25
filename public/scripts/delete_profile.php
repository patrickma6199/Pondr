<?php

ini_set('display_errors', 1);
require_once 'dbconfig.php';
header('Content-Type: application/json');

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
session_start();
$uid = $_SESSION['uid'] ?? null;
$utype = $_SESSION['utype'] ?? null;

try {
    if ($utype == 1) {
        try {
            if (isset ($_POST['uName'])) {
                $uName = $_POST['uName'];
                try {
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
                } catch (mysqli_sql_exception $e) {
                   echo json_encode(['error' => "SQL ERROR not set", 'errorMessage' => $e->getMessage()]);
                } catch (Exception $e) {
                    echo json_encode(['error' => "SQL ERROR not set", 'errorMessage' => $e->getMessage()]);
                }
            } else {
                echo json_encode(['error' => 'uName not provided.']);

            }
        } catch (mysqli_sql_exception $e) {
            echo json_encode(['error' => "UNAME not set", 'errorMessage' => $e->getMessage()]);

        } catch (Exception $e) {
            echo json_encode(['error' => "UNAME not set", 'errorMessage' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'NOT AN ADMIN NAUGHTY NAUGHTY.']);
    }
} catch (mysqli_sql_exception $e) {
    echo json_encode(['error' => "UTYPE not set", 'errorMessage' => $e->getMessage()]);

} catch (Exception $e) {
    echo json_encode(['error' => "UTYPE not set", 'errorMessage' => $e->getMessage()]);
}
$conn->close();


?>