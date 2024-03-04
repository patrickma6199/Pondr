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
    <title>Profile</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="icon" href="../img/logo.png">
</head>
<body>
    <nav id="top-bar">
        <a href="./discussionLoggedIn.php"><img src="../img/logo.png" alt="Pondr Logo" id="top-bar-logo"></a>
        <div id="top-search-bar">
            <form method="GET" action="discussionLoggedIn.php">
                <input type="text" name="search" placeholder="Search for Users and Threads" />
                <button type="submit" class="form-button">Search</button>
            </form>
        </div>
        <a href="profile.php" ><img src="../img/pfp-3.jpg" id="top-search-bar-pfp"> </a>
    </nav>

    <main class="column-container margin-down">
        <section class="profile-container">
            <div class="profile-img">
                <a href="../img/pfp-3.jpg"><img src="../img/pfp-3.jpg" alt="profile picture"></a>
            </div>
            <div class="profile-text">
                <p><b>Name:</b> John Doe</p> 
                <p><b>Username:</b> JohnDoe1234</p>
                <p> <b>Bio:</b> Hello! I am using Pondr</p>
                <p><span><b>Followers:</b> 100  <b>Following:</b> 200</span></p>

                <br>
                <a href="profileEdit.php" class="link-button">Edit</a>
            </div>
        </section>
        <section class="discussion-container">
            <h2>Your Threads</h2>
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

