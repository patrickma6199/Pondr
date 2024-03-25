<?php
session_start();
ini_set('display_errors', 1);
require_once './dbconfig.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$utype = isset ($_SESSION['utype']) ?? null;
$uid = $_SESSION['uid'];
$utype = $_SESSION['utype'] ?? null;

if($utype == 0 || $utype == 1) {

if (isset ($_GET['postId'])) {
    $pid = $_GET['postId'];
    $uName = $_GET['uName'];

    $sql = "DELETE FROM posts WHERE postId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $pid);
    if($stmt->execute()){
        header("Location: ../pages/profile.php?uName=$uName");
        exit();
        
    }
    else{
        echo"Error with deleting";
        exit();
    }
    
}else{
    echo"PostId or Uname wrong";
    echo"Postid =$pid";
    echo"Uname = $uName";
}
$conn->close();
}else{
    echo json_encode(['error' => 'NOT AN ADMIN OR USER.']);
}

?>