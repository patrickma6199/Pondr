<?php
require_once('dbconfig.php'); 
session_start();
ini_set('display_errors', 1);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (isset($_SESSION['uid'])) {
    $uid = $_SESSION['uid'];
} else {
    exit(header("Location: ../index.php")); 
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];

    $conn->begin_transaction();
    try {
        
        $sql = "SELECT pass FROM users WHERE userId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $uid);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            if (password_verify($oldPassword, $user['pass'])) {
                $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

                $sql = "UPDATE users SET pass = ? WHERE userId = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ss', $newPasswordHash, $uid);
                $stmt->execute();
                $stmt->close();

                $conn->commit();
                $conn->close();

                $_SESSION['passwordMessage'] = "<p>Your password has been successfully updated.</p>";
                exit(header("Location: ../pages/my_profile.php"));
            } else {
                throw new Exception("The current password is incorrect.");
            }
        } else {
            throw new Exception("User not found.");
        }
    } catch (mysqli_sql_exception $e) {
        $_SESSION['passwordMessage'] = "<p>Error => A database error occurred: " . htmlspecialchars($e->getMessage()) . "</p>";
        $conn->rollback();
        $conn->close();
        exit(header("Location: ../pages/change_password.php"));
    } catch (Exception $e) {
        $_SESSION['passwordMessage'] = "<p>Error => " . htmlspecialchars($e->getMessage()) . "</p>";
        $conn->rollback();
        $conn->close();
        exit(header("Location: ../pages/change_password.php"));
    }
} else {
    $_SESSION['passwordMessage'] = "<p>Invalid request method.</p>";
    exit(header("Location: ../pages/change_password.php"));
}
?>
