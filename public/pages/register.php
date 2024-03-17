<?php
session_start();

if (isset($_SESSION['uid'])) { // if logged in user tried to access this page, forward them
    exit(header("../index.php"));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="icon" href="../img/logo.png">
</head>

<body>
    <?php require_once '../scripts/header.php'; //for dynamic header ?>
    <div class="center-container">
        <div class="form-container">
            <!-- check if enctype can be done with file and text data -->
            <form method="POST" action="../scripts/register_script.php" enctype="multipart/form-data">
                <legend>Register</legend>
                <?php
                if (isset($_SESSION['registerMessage'])) {
                    echo $_SESSION['registerMessage'];
                    unset($_SESSION['registerMessage']);
                }
                ?>
                <div class="form-item">
                    <label for="firstName">First Name: </label>
                    <input type="text" placeholder="Enter your First Name" name="firstName" required>
                </div>
                <div class="form-item">
                    <label for="lastName">Last Name: </label>
                    <input type="text" placeholder="Enter your Last Name" name="lastName" required>
                </div>
                <div class="form-item">
                    <label for="email">Email: </label>
                    <input type="text" placeholder="Enter your Email" name="email" required>
                </div>
                <div class="form-item">
                    <label for="re-email">Re-enter Email: </label>
                    <input type="text" placeholder="Enter your Last Name" name="re-email" required>
                </div>
                <div class="form-item">
                    <label for="username">Username: </label>
                    <input type="text" placeholder="Enter your username" name="username" required>
                </div>
                <div class="form-item">
                    <label for="password">Password: </label>
                    <input type="password" placeholder="Enter your password" name="password" required>
                </div>
                <div class="form-item">
                    <label for="re-password">Re-enter Password: </label>
                    <input type="password" placeholder="Re-enter your password" name="re-password" required>
                </div>
                <div class="form-item">
                    <label for="pfp">Upload your profile picture: </label>
                    <!-- Max file size for profile photo is 10MB -->
                    <input type="hidden" name="MAX_FILE_SIZE" value="10485760">
                    <input type="file"  name="pfp" accept="image/*">
                </div>
                <div class="form-item">
                    <button type="submit" class="form-button"> Register</button>
                    <button type="reset" class="form-button">Reset</button>
                </div>
                <?php
                    if (isset($_SESSION['recovery'])) {
                        echo $_SESSION['recovery'];
                        unset($_SESSION['recovery']);
                    }
                ?>
            </form>
        </div>
    </div>
</body>
</html>