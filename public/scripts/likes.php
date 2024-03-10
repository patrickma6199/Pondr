<?php
require_once 'dbconfig.php'; 

if (isset($_POST['postId'])) {
    $postId = $_POST['postId'];

    // Increment the likes for the post
    $sql = "UPDATE posts SET likes = likes + 1 WHERE postId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $postId);
    $stmt->execute();

    // Retrieve the new like count to return it
    $sql = "SELECT likes FROM posts WHERE postId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $postId);
    $stmt->execute();
    $result = $stmt->get_result();
    try{

        if ($row = $result->fetch_assoc()) {
            echo $row['likes']; // Return the new like count
        }

    }
    catch(mysqli_sql_exception $e){
        echo $e
    }
    
    
    $stmt->close();
}
$conn->close();
?>

<!-- modify html : <button class="like-button" data-postid="1">Like</button> <span id="like-count-1">0</span>-->