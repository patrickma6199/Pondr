<?php
session_start();
ini_set('display_errors', 1);
require_once '../scripts/dbconfig.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
header("Content-Type: application/json");

if (isset($_POST['catName'])) {
    $catName = $_POST['catName'];
    $sql = "SELECT name FROM categories WHERE name LIKE CONCAT('%',?,'%') LIMIT 10;";
    try{
        $catNames = array();
        $prstmt = $conn->prepare($sql);
        $prstmt->bind_param("s", $catName);
        $prstmt->execute();
        $prstmt->bind_result($name);
        while ($prstmt->fetch()) {
            array_push($catNames, $name);
        }
        echo json_encode(['catNames' => $catNames]);
    } catch (mysqli_sql_exception $e) {
        $code = $e->getMessage();
        echo json_encode(['error' => "SQL ERROR: $message"]);
    } catch(Exception $e) {
        $message = $e->getMessage();
        echo json_encode(['error' => "ERROR: $message"]);
    } finally {
        if (isset($prstmt))
            $prstmt->close();
        $conn->close();
    }
} else {
    exit(header("../index.php")); // bad navigation
}


?>