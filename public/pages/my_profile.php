<?php
session_start();
ini_set('display_errors', 1);
require_once '../scripts/dbconfig.php';
$utype = $_SESSION['utype'];
$uid = $_SESSION['uid'];
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
require_once '../scripts/header.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="icon" href="../img/logo.png">
</head>
<body>
    
    <main class="column-container margin-down">
        <section class="profile-container">
            <?php  

                $sql = "SELECT fName,lName,uName,bio,pfp FROM users WHERE userId = ?";
                $prstmt = $conn->prepare($sql);
                $prstmt->bind_param("i", $uid);
                $prstmt->execute();
                $prstmt->bind_result($fName,$lName,$uName,$bio,$pfp);
                if ($prstmt->fetch()) {
                    echo" <div class=\"profile-img\">";
                    echo"<a href=\"$pfp\"><img src=\"$pfp\" alt=\"profile picture\"></a>";
                    echo "</div>";
                    echo"<div class=\"profile-text\">";
                    echo "<p><b>Name:</b> $fName $lName </p> ";
                    echo "<p><b>Username:</b> $uName </p>";
                    echo "<p> <b>Bio:</b> $bio </p>";
                    echo "<p><span><b>Followers:</b>    <b>Following:</b>  </span></p>";
                    echo "<br>";
                    echo "<a href=\"my_profile_edit.php\" class=\"link-button\">Edit</a>";
                    echo "</div>";


                }
    
    
    
    ?>
            <!-- <div class="profile-img">
                <a href="../img/pfp-3.jpg"><img src="../img/pfp-3.jpg" alt="profile picture"></a>
            </div>
            <div class="profile-text">
                <p><b>Name:</b> John Doe</p> 
                <p><b>Username:</b> JohnDoe1234</p>
                <p> <b>Bio:</b> Hello! I am using Pondr</p>
                <p><span><b>Followers:</b> 100  <b>Following:</b> 200</span></p>

                <br>
                <a href="profileEdit.php" class="link-button">Edit</a>
            </div> -->
        </section>
        <section class="discussion-container">
            <h2>Your Threads</h2>

            <?php

            ?>
            <div class="mini-thread">
                <article>
                    <a href="./thread.php"><h2>Highly excited for the #Deadpool3 teaser</h2></a>
                    <i>Posted by: JohnDoe1234 on <time>January 1, 1970</time></i>
                    <p>Marvel, please don't disappoint this time ! </p>
                </article>
                <img src="../img/deadpool.jpg">
            </div>
            <div class="mini-thread">
                <article>
                    <a href="./thread.php"><h2>Sources tell me you can anticipate the #NHL DOPS to offer up some stern discipline to #LeafsForever Dman Morgan Reilly.</h2></a>
                    <i>Posted by: JohnDoe1234 on <time>January 1, 1970</time></i>
                    <p>Reilly should get suspended whatever. But for these last few weeks with blatant predatory head hits to get only phone hearings and then Reilly gets an in person is objectively wrong. It’s obviously because of the market attention and having to send a message </p>
                </article>
                <img src="../img/nhl.jpg">
            </div>
            <div class="mini-thread">
                <article>
                    <a href="./thread.php"><h2>It's incredible to think that today the world will get to see, on live television, Taylor Swift win her first Super Bowl ring</h2></a>
                    <i>Posted by: JohnDoe1234 on <time>January 1, 1970</time></i>
                    <p>An accomplishment never achieved by any other artist. This feat will forever enshrine her as the greatest musician in the history of music.</p>
                </article>
                <img src="../img/taylor.jpg">
            </div>
           
        </section>
    </main>
</body>
</html>

