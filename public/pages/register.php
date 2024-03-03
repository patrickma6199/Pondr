<?php
require_once 'public/scripts/dbconfig.php';
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
    <nav id="top-bar">
        <a href="./discussion.php"><img src="../img/logo.png" alt="Pondr Logo" id="top-bar-logo"></a>
        <div id="top-search-bar">
            <form method="GET" action="discussion.html">
                <input type="text" name="search" placeholder="Search for Users and Threads" />
                <button type="submit" class="form-button">Search</button>
            </form>
        </div>
        <a href="login.php" class="link-button">Login</a>
        <a href="register.php" class="link-button">Sign Up</a>
    </nav>
    <div class="center-container">
        <div class="form-container">
            <form action="POST">
                <legend>Register</legend>
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
                    <input type="file"  name="pfp" accept="image/*">
                </div>
                <div class="form-item">
                    <button type="submit" class="form-button"> Register</button>
                    <button type="reset" class="form-button">Reset</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>