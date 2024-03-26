<?php

ini_set('display_errors', 1);
require_once 'dbconfig.php';
header('Content-Type: application/json');

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
session_start();
$uid = $_SESSION['uid'] ?? null;
$utype = $_SESSION['utype'] ?? null;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($utype == 1) {
        if (isset ($_POST['uName'])) {
            $conn->begin_transaction();
            $uName = $_POST['uName'];
            try {
                $sql = "SELECT img FROM posts p JOIN users u ON p.userId = u.userId WHERE u.uName = ?;";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $uName);
                $stmt->execute();
                $stmt->bind_result($img);
                while ($stmt->fetch()) {
                    if (isset ($img)) {
                        if (file_exists($img)) {
                            if (!unlink($img)) {
                                throw new Exception("Failed to delete post img.");
                            }
                        }
                    }
                }
                $stmt->close();
                unset($stmt);
                $sql = "SELECT pfp FROM users WHERE uName = ?;";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $uName);
                $stmt->execute();
                $stmt->bind_result($pfp);
                if ($stmt->fetch()) {
                    if (isset ($pfp)) {
                        if (file_exists($pfp)) {
                            if (!unlink($pfp)) {
                                throw new Exception("Failed to delete post img.");
                            }
                        }
                    }
                }
                $stmt->close();
                unset($stmt);
                $sql = "SELECT userId FROM users WHERE uName=?";
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
                    $conn->commit();
                    echo json_encode(['success' => "Delete was successful."]);
                } else {
                    echo json_encode(['error' => 'User not found.']);
                }
            } catch (mysqli_sql_exception $e) {
                $conn->rollback();
                echo json_encode(['error' => 'SQL Error: ' . $e->getMessage()]);
            } catch (Exception $e) {
                $conn->rollback();
                echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
            } finally {
                if (isset ($stmt)) {
                    $stmt->close();
                }
                if (isset ($stmt1)) {
                    $stmt1->close();
                }
            }
        } else {
            echo json_encode(['error' => 'uName not provided.']);
        }
    } else {
        echo json_encode(['error' => 'NOT AN ADMIN NAUGHTY NAUGHTY.']);
    }
    $conn->close();
} else {
    $conn->close();
    exit(header("Location: ../index.php"));
}
?>