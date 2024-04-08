<?php
session_start();
ini_set('display_errors', 1);
require_once '../scripts/dbconfig.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
header("Content-Type: application/json");
$uid = $_SESSION['uid'] ?? null; 
$utype = $_SESSION['utype'] ?? null;

if (isset($_POST['comId'])) { // checks if request method is post and request has a comId and a postId parameter
    $comId = $_POST['comId'];
    $sql = "SELECT c.comId, u.uName, c.comDate, c.text, u.pfp, u.utype, u.userId FROM comments c JOIN users u ON c.userId = u.userId WHERE c.parentComId = ? ORDER BY c.comDate ASC;";
    try {
        $subcomments = array();
        $prstmt = $conn->prepare($sql);
        $prstmt->bind_param("s", $comId);
        $prstmt->execute();
        $prstmt->bind_result($comId, $userName, $comDate, $comText, $pfp, $userType, $userId);
        while ($prstmt->fetch()) {
            array_push($subcomments, array('comId' => $comId, 'userName' => $userName, 'comDate' => $comDate, 'comText' => $comText, 'pfp' => $pfp, 'userType' => $userType, 'userId' => $userId));
        }
        echo json_encode(['subcomments' => $subcomments]);
        $prstmt->close();
    } catch (mysqli_sql_exception $e) {
        $code = $e->getCode();
        echo json_encode(['error' => "Failed to fetch subcomments for comment #$comId.\n Error: $code."]);
        if(isset($prstmt)){
            $prstmt->close();
        }
    } catch (Exception $e) {
        $message = $e->getMessage();
        echo json_encode(['error' => "Failed to fetch subcomments for comment #$comId.\n Error: $message."]);
        if(isset($prstmt)){
            $prstmt->close();
        }
    } finally {
        $conn->close();   
    }
} else {
    exit(header("Location: index.php")); // for bad navigation
}

?>