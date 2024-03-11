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
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="icon" href="../img/logo.png">
</head>
<body>
    <?php require_once '../scripts/header.php'; //for dynamic header ?>

    <main class="center-container">
        <div class="form-container">
            <div class="profile-img">
                <a href="../img/pfp-3.jpg"><img src="../img/pfp-3.jpg" alt="profile picture" ></a>
            </div>
            <section class="form-container">
                <form action="POST" class="edit-container">
                    <legend>Edit Profile Info</legend>
                        <div class="form-item">
                            <label for="img">Enter a new Profile Picture: </label>
                            <input type="file" name="img" accept="image/*" required>
                        </div>
                        <div class="form-item">
                            <label for="firstName">First Name: </label>
                            <input type="text" placeholder="Enter your new First Name" name="firstName" required>
                        </div>
                        <div class="form-item">
                            <label for="lastName">Last Name: </label>
                            <input type="text" placeholder="Enter your new Last Name" name="lastName" required>
                        </div>
                        <div class="form-item">
                            <label for="bio">Bio: </label>
                            <textarea placeholder="Enter your new Bio" name="bio" cols="40" rows="4 "></textarea>
                        </div>
                        <div class="form-item">
                            <button type="submit" class="form-button">Confirm Changes</a>
                            <button type="reset" class="form-button">Reset</button>
                        </div>
                </form>
            </section>
        </div>
    </main>
    
</body>
</html>


