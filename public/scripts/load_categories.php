<?php
session_start();
ini_set('display_errors', 1);
require_once 'dbconfig.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $sql = "SELECT catId, name, count FROM categories ORDER BY count DESC LIMIT 10;";       
    $prstmt = $conn->prepare($sql);
    try {
        $prstmt->execute();
        $prstmt->bind_result($catListId,$catName, $catCount);
        $categories = array();
        while ($prstmt->fetch()) {
            array_push($categories,array('catId' => $catListId, 'catName' => $catName, 'catCount' => $catCount));
        }
        echo json_encode(['categories' => $categories]);
        $prstmt->close();
    } catch(mysqli_sql_exception $e) {
        $code = $e->getCode();
        echo json_encode(['error' => "Error occurred: pulling categories. Error: $code"]);
    }
    $conn->close();
} else {
    $conn->close();
    exit(header('Location: ../index.php'));
}


?>