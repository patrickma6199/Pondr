<?php
session_start();
ini_set('display_errors', 1);


if (!isset($_SESSION['uid'])) {
    header("Location: login.php");
    exit();
}
$pageTitle = "IGNORE";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="icon" href="../img/logo.png">
</head>
<body>
    <?php require_once '../scripts/header.php'; ?>
    <main class="center-container">
        <div class="form-container" >
            <form id = "changePassword" action="../scripts/change_password_script.php" method="POST">
                <legend>Change Password</legend>
                <?php
                    if (isset($_SESSION['passwordMessage'])) {
                        echo $_SESSION['passwordMessage'];
                        unset($_SESSION['passwordMessage']);
                    }
                    ?>
                    <div class="form-item">
                        <label for="oldPassword">Current Password:</label>
                        <input type="password" name="oldPassword" required>
                    </div>
                    <div class="form-item">
                        <label for="newPassword">New Password:</label>
                        <input type="password" name="newPassword" required>
                    </div>
                    <div class="form-item">
                        <label for="confirmNewPassword">Re-enter Password:</label>
                        <input type="password" name="confirmNewPassword" required>
                    </div>
                    <div class="form-item">
                        <button type="submit" class="form-button">Change Password</button>
                        <button type="reset" class="form-button">Reset</button>
                    </div>
                </form>
                </div>
        </div>
    </main>
</body>
</html>
