<?php
session_start();
ini_set('display_errors', 1);
require_once '../scripts/dbconfig.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
header("Content-Type: application/json");

if(isset($_POST['comId'])) {
    $comId = $_POST['comId'];

    $sql = "SELECT * FROM comments WHERE comId = ?;";
    try {
        $exists = false;
        $prstmt = $conn->prepare($sql);
        $prstmt->bind_param('s', $comId);
        $prstmt->execute();
        if ($prstmt->fetch()) {
            $exists = true;
        }
        echo json_encode(['com_exists' => $exists]);
        $prstmt->close();
    } catch (mysqli_sql_exception $e) {
        $code = $e->getCode();
        echo json_encode(['error' => "Failed to fetch comments for post #$postId.\n Error: $code."]);
        if(isset($prstmt)){
            $prstmt->close();
        }
    } catch (Exception $e) {
        $message = $e->getMessage();
        echo json_encode(['error' => "Failed to fetch comments for post #$postId.\n Error: $message."]);
        if(isset($prstmt)){
            $prstmt->close();
        }
    } finally {
        $conn->close();   
    }
}
?>