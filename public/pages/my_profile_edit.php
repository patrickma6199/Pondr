<?php
session_start();
ini_set('display_errors', 1);
$pageTitle = "IGNORE";


if (!isset($_SESSION['uid'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="icon" href="../img/logo.png">
</head>
<body>
    <?php require_once '../scripts/header.php'; ?>
    <main class="center-container">
        <div class="form-container">
            <!-- <div class="profile-img">
                 <a href="../img/pfp-3.jpg"><img src="../img/pfp-3.jpg" alt="profile picture" ></a> 
            </div> -->
            <section class="form-container">
                <form action="../scripts/edit_profile.php" method="post" class="edit-container" enctype="multipart/form-data">
                    <legend>Edit Profile Info</legend>
                     <?php
                    if (isset($_SESSION['editMessage'])) {
                        echo $_SESSION['editMessage'];
                        unset($_SESSION['editMessage']);
                    }
                    ?>
                    <div class="form-item">
                        <label for="img">Enter a new Profile Picture: </label>
                        <input type="file" name="pfp" accept="image/*" >
                    </div>
                    <div class="form-item">
                        <label for="firstName">First Name: </label>
                        <input type="text" placeholder="Enter your new First Name" name="firstName" >
                    </div>
                    <div class="form-item">
                        <label for="lastName">Last Name: </label>
                        <input type="text" placeholder="Enter your new Last Name" name="lastName" >
                    </div>
                    <div class="form-item">
                        <label for="bio">Bio: </label>
                        <textarea placeholder="Enter your new Bio" name="bio" cols="40" rows="4 "></textarea>
                    </div>
                    <div class="form-item">
                        <button type="submit" class="form-button">Confirm Changes</a>
                        <button type="reset" class="form-button">Reset</button>
                        <button type="button" class="form-button" onclick="window.location.href='change_password.php';"> Change password? </button>

                    </div>
                    <p>Enter only what you wish to change</p>
                </form>
            </section>
        </div>
    </main>
    
</body>
</html>


