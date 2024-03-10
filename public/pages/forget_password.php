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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password?</title>
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