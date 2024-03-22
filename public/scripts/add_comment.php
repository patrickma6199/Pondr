<?php
require_once ('dbconfig.php');
session_start();

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

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
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisi", $userId,$postId, $commentText,$parentCommentId);
    if($stmt->execute()) {
        echo "Success";
        
    } else {
        echo "Error: " . $conn->error;
    }
    $stmt->close();

    $sql1 = "UPDATE posts SET comment=comment+1 WHERE postId=?";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("i", $postId);
    if($stmt1->execute()) {
        echo "Success";
        
    } else {
        echo "Error: " . $conn->error;
    }
     $stmt1->close();

} else {
    echo "Error: Invalid request.";
}



?>
