<?php
session_start();
ini_set('display_errors', 1);

// Stop bad navigation
if (isset($_SESSION['uid'])) {
    exit(header("../index.php"));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password?</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="icon" href="../img/logo.png">
</head>
<body>
    <?php require_once '../scripts/header.php'; //for dynamic header ?>
    <main class="center-container">
        <div class="form-container">
            <form action="../scripts/forget_password_script.php" method="POST">
                <legend>Forgot Password?</legend>
                <?php
                    if (isset($_SESSION['forgetPassMessage'])) {
                        echo $_SESSION['forgetPassMessage'];
                        unset($_SESSION['forgetPassMessage']);
                    }
                ?>
                <div class="form-item">
                    <label for="email">Email:</label>
                    <input type="text" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-item">
                    <label for="new-pass">New Password:</label>
                    <input type="password" name="new-pass" placeholder="Enter your New Password" required>
                </div>
                <div class="form-item">
                    <label for="recovery-token">Recovery Key:</label>
                    <input type="text" name="recovery-key" placeholder="Enter your Recovery Token" required>
                </div>
                <div class="form-item">
                    <button type="submit" class="form-button">Change Password</button>
                    <button type="reset" class="form-button">Reset</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>