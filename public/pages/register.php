<?php
session_start();
ini_set('display_errors', 1);

if (isset($_SESSION['uid'])) { 
    exit(header("Location: ../index.php"));
}
$pageTitle = "IGNORE";
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
    <script src = "../js/jquery-3.1.1.min.js"> </script>
    <script src = "../js/register_verification.js"></script>
</head>

<body>
    <?php require_once '../scripts/header.php'; ?>
    <div class="center-container margin-down" style="margin-top:5vw;">
        <div class="form-container">
            <!-- check if enctype can be done with file and text data -->
            <form id="regform" method="POST" action="../scripts/register_script.php" enctype="multipart/form-data" >
                <legend>Register</legend>
                <?php
                if (isset($_SESSION['registerMessage'])) {
                    echo $_SESSION['registerMessage'];
                    unset($_SESSION['registerMessage']);
                }
                ?>
               <div class="form-item">
                    <label for="firstName">First Name: </label>
                    <input type="text" placeholder="Enter your First Name" name="firstName" id="firstName" >
                    <div class="error-message" id="error-firstname">Please enter your first name.</div>
                </div>
                <div class="form-item">
                    <label for="lastName">Last Name: </label>
                    <input type="text" placeholder="Enter your Last Name" name="lastName" id="lastName">
                    <div class="error-message" id="error-lastname">Please enter your last name.</div>
                </div>
                <div class="form-item">
                    <label for="email">Email: </label>
                    <input type="email" placeholder="Enter your Email" name="email" id ="email" >
                    <div class="error-message" id="error-email">Please enter your email.</div>
                </div>
                <div class="form-item">
                    <label for="re-email">Re-enter Email: </label>
                    <input type="email" placeholder="Re-enter your Email" name="re-email" id ="re-email" >
                    <div class="error-message" id="error-reemail">Please re-enter your email.</div>
                </div>
                <div class="form-item">
                    <label for="username">Username: </label>
                    <input type="text" placeholder="Enter your Username" name="username" id = "username" >
                    <div class="error-message" id="error-username">Please enter your username.</div>
                </div>
                <div class="form-item">
                    <label for="password">Password: </label>
                    <input type="password" placeholder="Enter your Password" name="password" id ="password" >
                    <div class="error-message" id="error-password">Please enter your password.</div>
                </div>
                <div class="form-item">
                    <label for="re-password">Re-enter Password: </label>
                    <input type="password" placeholder="Re-enter your Password" name="re-password" id ="re-password" >
                 <div class="error-message" id="error-repassword">Please re-enter your password.</div>
                </div>
                <div class="form-item">
                    <label for="pfp">Upload your profile picture (will be made square): </label>
                    <!-- Max file size for profile photo is 10MB -->
                    <input type="hidden" name="MAX_FILE_SIZE" value="10485760">
                    <input type="file"  name="pfp" accept="image/*">
                </div>
                <div class="form-item">
                    <button type="submit" class="form-button"> Register </button>
                    <button type="reset" class="form-button">Reset</button>
                    <button type="button" class="form-button" onclick="window.location.href='admin_register.php';"> Are you a Pondr Admin? </button>
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