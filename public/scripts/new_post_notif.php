<?php
session_start();
ini_set('display_errors', 1);
require_once 'dbconfig.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
header('Content-Type: application/json');
// query depends on if catId is set and if search string is empty (return all discussion posts)
if (isset($_POST['search']) && isset($_POST['catName']) && isset($_POST['lastPost'])) {
    $search = $_POST['search'];
    $catName = $_POST['catName'];
    $lastPost = $_POST['lastPost'];
    $sql = "SELECT p.postId
    FROM posts as p JOIN users as u ON p.userId = u.userId 
    LEFT OUTER JOIN categories as c ON p.catId = c.catId 
    WHERE (c.name LIKE CONCAT('%',?,'%') OR CASE WHEN ? = \"\" THEN c.name IS NULL ELSE FALSE END) AND (p.title LIKE CONCAT('%',?,'%') OR p.text LIKE CONCAT('%',?,'%') OR u.uName LIKE CONCAT('%',?,'%')) AND p.postId > ?;";
    try {
        $prstmt = $conn->prepare($sql);
        $prstmt->bind_param("ssssss", $catName, $catName, $search, $search, $search, $lastPost);
        $prstmt->execute();
        $prstmt->bind_result($postId);
        if($prstmt->fetch()){
            echo json_encode(['new' => true, 'message' => 'There\'s a new post waiting for you! Refresh your page to see the update!', 'newPID' => $postId]);
        } else {
            echo json_encode(['new' => false]);
        }
        $prstmt->close();
    } catch (mysqli_sql_exception $e) {
        $code = $e->getCode();
        echo json_encode(['error' => "Error while loading new discussion posts. Error: $code"]);
    }
    $conn->close();
} else {
    $conn->close();
    exit (header("Location: ../index.php"));
}
?>