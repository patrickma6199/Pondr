<?php
session_start();
ini_set('display_errors', 1);
require_once '../scripts/dbconfig.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
header("Content-Type: application/json");
$uid = $_SESSION['uid'] ?? null; 
$utype = $_SESSION['utype'] ?? null;

if (isset($_POST['postId']) && isset($_POST['lastComId'])) {
    $postId = $_POST['postId'];
    $lastComId = $_POST['postId'];
    $comments = array();

    $sql = "SELECT c.comId,u.uName,c.comDate,c.text,u.pfp, u.utype, u.userId FROM comments c JOIN users u ON c.userId = u.userId WHERE c.postId = ? AND c.comId > ? ORDER BY c.comDate DESC;";
    try {
        $prstmt = $conn->prepare($sql);
        $prstmt->bind_param('ss', $postId, $lastComId);
        $prstmt->execute();
        $prstmt->bind_result($comId, $userName, $comDate, $comText, $pfp, $userType, $userId);
        while ($prstmt->fetch()) {
            array_push($comments, array('comId' => $comId, 'userName' => $userName, 'comDate' => $comDate, 'comText' => $comText, 'pfp' => $pfp, 'userType' => $userType, 'userId' => $userId));
        }
        echo json_encode(['comments' => $comments]);
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