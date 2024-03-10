<?php



require_once('dbconfig.php');

$stmt = $db->prepare("SELECT COUNT(*) FROM comments WHERE comId = ?");
$stmt->execute([$_GET['comId']]);

// Fetch the count
$count = $stmt->fetchColumn();


?>
