<?php
session_start();
require_once '../scripts/dbconfig.php';
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
    </head>
    <body>
        <nav id="top-bar">
            <a href="./discussion.php"><img src="../img/logo.png" alt="Pondr Logo" id="top-bar-logo"></a>
            <div id="top-search-bar">
                <form method="GET" action="discussion.html">
                    <input type="text" name="search" placeholder="Search for Ponds or Threads" />
                    <button type="submit" class="form-button">Search</button>
                </form>
            </div>
            <a href="login.php" class="link-button">Login</a>
            <a href="register.php" class="link-button">Sign Up</a>
        </nav>
        <main class="center-container">
            <section class="form-container">
                <form action="../scripts/login_script.php" method="POST">
                    <legend>Login</legend>
                    <?php
                    if (isset($_SESSION['loginMessage'])) {
                        echo $_SESSION['loginMessage'];
                        unset($_SESSION['loginMessage']);
                    }
                    ?>
                    <div class="form-item">
                        <label for="username">Username: </label>
                        <input type="text" placeholder="Enter your username" name="username" required>
                    </div>
                    <div class="form-item">
                        <label for="password">Password: </label>
                        <input type="password" placeholder="Enter your password" name="password" required>
                    </div>
                    <div class="form-item">
                        <button type="submit" class="form-button">Login</button>
                        <a href="register.php" class="form-button">Register</a>
                    </div>
                    <div class="form-item">
                        <a href="forget_password.php" class="form-button">Reset Password</a>
                    </div>
                </form>
            </section>
        </main>
    </body>
</html>