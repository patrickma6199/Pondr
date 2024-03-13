<?php

require_once('dbconfig.php');

if (isset($_POST['postId'])) {
$postId = $_POST['postId'];


$sql = "SELECT COUNT(*) as comment_count FROM comments WHERE postId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $postId);
$stmt->execute();
$result = $stmt->get_result(); 
// Fetch the count
try{

if ($row = $result->fetch_assoc()) {
echo $row['comment_count']; // Return the new like count
}

}
catch(mysqli_sql_exception $e){
echo("FAILED COUNT");
echo $e;
}

// Display the comment count
$stmt->close();
}


?>