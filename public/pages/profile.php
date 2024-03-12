<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head><!-- Other users profile -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="icon" href="../img/logo.png">
</head>
<body>
    <?php require_once '../scripts/header.php'; //for dynamic header ?>
    <main class="column-container margin-down">
        <section class="profile-container">
            <div class="profile-img">
                <a href="../img/pfp-2.jpg"><img src="../img/pfp-2.png" alt="profile picture"></a>
            </div>
            <div class="profile-text">
                <p><b>Name:</b> Egg Fella</p> 
                <p><b>Username:</b> EggFella1234</p>
                <p> <b>Bio:</b> Hello! I am EggFella1234</p>
                <p><span><b>Followers:</b> 1000  <b>Following:</b> 20</span></p>
            </div>
        </section>
        <section class="discussion-container">
            <h2>Their Threads</h2>
            <div class="mini-thread">
                <article>
                    <a href="./thread.php"><h2>I love eating eggs!</h2></a>
                    <i>Posted by: EggFella1234 on <time>January 1, 1970</time></i>
                    <p>Eggs are so nutritious, and tasty I just want to eat eggs for every meal. </p>
                </article>
                <img src="../img/egg-1.jpg">
            </div>
           
            <div class="mini-thread">
                <article>
                    <a href="./thread.php"><h2>Have y'all ever noticed how eggs are the perfect shape?</h2></a>
                    <i>Posted by: EggFella1234 on <time>January 1, 1970</time></i>
                    <p>Eggs just are the most perfect shape, I love how nice and smooth an egg feels on my hand!! It's just so cute and round.</p>
                </article>
                <img src="../img/egg-2.jpg">
            </div>
            
            
        </section>
    </main>

    
    
</body>
</html>