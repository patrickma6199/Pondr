<?php

session_start();

require_once 'public/scripts/dbconfig.php'; 

function fetchPosts($search = '') {
    global $conn; // Use the database connection from dbconfig.php

    // Basic SQL query to fetch posts
    $sql = "SELECT posts.postId, posts.userId, posts.postDate, posts.title, posts.text, posts.img, posts.link, users.uName as username FROM posts JOIN users ON posts.userId = users.userId";
    
    // Add search condition if a search term is provided
    if (!empty($search)) {
        $sql .= " WHERE posts.title LIKE ? OR posts.text LIKE ?";
    }

    $stmt = $conn->prepare($sql);

    if (!empty($search)) {
        $likeSearch = '%' . $search . '%';
        $stmt->bind_param("ss", $likeSearch, $likeSearch); // Bind the search term
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $posts = [];
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row; // Store each post in an array
    }

    $stmt->close();
    
    return $posts; // Return the array of posts
}
?>
