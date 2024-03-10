<?php

require_once('dbconfig.php');

// Assuming $db is the PDO object initialized in 'dbconfig.php'
$stmt = $db->prepare("SELECT COUNT(*) FROM comments WHERE comId = ?");
$stmt->execute([$_GET['comId']]);

// Fetch the count
$count = $stmt->fetchColumn();

// Display the comment count
echo $count;

?>