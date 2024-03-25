<?php
require_once ('dbconfig.php');
session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
header('Content-Type: application/json');

$uid = $_SESSION['uid'];

if(isset($_POST['postId']) && isset($_POST['commentText']) && isset($_SESSION['uid'])) {
    $postId = $_POST['postId'];
    $commentText = $_POST['commentText'];
    $userId = $_SESSION['uid'];
    if(isset($_POST['parentComId'])) {
   $parentCommentId = $_POST['parentComId'];
    }else {
        $parentCommentId = null;
    }

    $sql = "INSERT INTO comments (userId, postId, text,comDate,parentComId) VALUES (?,?,?,NOW(),?)";
    $conn->begin_transaction();
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisi", $userId, $postId, $commentText, $parentCommentId);
        $stmt->execute();
        $stmt->close();

        $sql1 = "UPDATE posts SET comment=comment+1 WHERE postId=?";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param("i", $postId);
        $stmt1->execute();
        $stmt1->close();
        $conn->commit();
    } catch (mysqli_sql_exception $e) {
        $conn->rollback();
        if (isset ($stmt)) {
            $stmt->close();
        }
        if (isset ($stmt1)) {
            $stmt1->close();
        }
        $code = $e->getCode();
        echo json_encode(['error' => "SQL Error: $code"]);
    }
} else {
    echo json_encode(['error' => "Error: Invalid request."]);
}
?>
