<?php
ini_set('display_errors', 1);
require_once 'dbconfig.php';
header('Content-Type: application/json');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
session_start();
$uid = $_SESSION['uid'] ?? null;

if (isset ($_POST['postId'])) {
    $postId = $_POST['postId'];
    $action = $_POST['action'] ?? '';
    try {
        $conn->begin_transaction();

        if ($action == 'fetch') {
            // Existing fetching logic
            $sql = "SELECT likes FROM posts WHERE postId = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $postId);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                echo json_encode(['likes' => $row['likes']]);
            } else {
                echo json_encode(['error' => 'Post not found']);
            }
        } else {
            // Check if like already exists for the user and post
            $checkSql = "SELECT likesId FROM likes WHERE userId = ? AND postId = ?";
            $checkStmt = $conn->prepare($checkSql);
            $checkStmt->bind_param("ii", $uid, $postId);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();
            if ($checkResult->num_rows == 0) {
                // Insert like since it doesn't exist
                $sql = "INSERT INTO likes (userId, postId) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ii", $uid, $postId);
                $stmt->execute();

                // Increment the likes for the post
                $sql = "UPDATE posts SET likes = likes + 1 WHERE postId = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $postId);
                $stmt->execute();

                $sql = "SELECT likes FROM posts WHERE postId = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $postId);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($row = $result->fetch_assoc()) {
                    echo json_encode(['likes' => $row['likes']]); // Return the new like count
                }
            } else {
                echo json_encode(['error' => 'User already liked this post']);
            }

            // Retrieve the new like count to return it

        }

        $conn->commit();
    } catch (mysqli_sql_exception $e) {
        $conn->rollback();
        error_log($e->getMessage()); // Log error to server log
        echo 'error An error occurred';
    } finally {
        if (isset ($stmt)) {
            $stmt->close();
        }
        if (isset ($checkStmt)) {
            $checkStmt->close();
        }
        $conn->close();
    }
} else {
    exit (header("Location: ../index.php"));
}
?>