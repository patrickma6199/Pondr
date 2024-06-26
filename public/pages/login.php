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
        <title>Login/Sign Up</title>
        <link rel="stylesheet" href="../css/styles.css">
        <link rel="stylesheet" href="../css/form.css">
        <link rel="icon" href="../img/logo.png">
        <script src="../js/jquery-3.1.1.min.js"></script>
        <script src = "../js/login_verification.js"></script>
    </head>
    <body>
        <?php require_once '../scripts/header.php';  ?>
        <main class="center-container">
            <section class="form-container">
                <form id = "loginform" action="../scripts/login_script.php" method="POST">
                    <legend>Login</legend>
                    <?php
                    if (isset($_SESSION['loginMessage'])) {
                        echo $_SESSION['loginMessage'];
                        unset($_SESSION['loginMessage']);
                    }
                    ?>
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
                        <button type="submit" class="form-button">Login</button>
                        <a href="register.php" class="form-button">Register</a>
                    </div>
                    <div class="form-item">
                        <a href="forget_password.php" class="form-button">Forgot Password?</a>
                    </div>
                </form>
            </section>
        </main>
    </body>
</html>