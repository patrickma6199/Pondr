<?php
session_start();
ini_set('display_errors', 1);
require_once '../scripts/dbconfig.php';
$uid = $_SESSION['uid'] ?? null;
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
                $uName = $_GET['uName'] ;
                

                $sql = "SELECT fName,lName,bio,pfp FROM users WHERE uName = ?";
                $prstmt = $conn->prepare($sql);
                $prstmt->bind_param("i", $uName);
                $prstmt->execute();
                $prstmt->bind_result($fName, $lName, $bio, $pfp);
                if ($prstmt->fetch()) {
                    echo " <div class=\"profile-img\">";
                    echo "<a href=\"$pfp\"><img src=\"$pfp\" alt=\"profile picture\"></a>";
                    echo "</div>";
                    echo "<div class=\"profile-text\">";
                    echo "<p><b>Name:</b> $fName $lName </p> ";
                    echo "<p><b>Username:</b> $uName </p>";
                    echo "<p> <b>Bio:</b> $bio </p>";
                    echo "<p><span><b>Followers:</b>    <b>Following:</b>  </span></p>";
                    echo "<br>";
                    echo "</div>";


                } else {
                    echo "NO PROFILE INFO";
                }
                $prstmt->close();
                ?>

            </section>
            <section class="discussion-container">
                <h2>Your Threads</h2>

                <?php
                $sql1 = "SELECT p.postDate,p.title,p.text,p.img,p.postId FROM posts p JOIN users u ON p.userId = u.userId WHERE u.uName=?";
                $prstmt = $conn->prepare($sql1);
                $prstmt->bind_param("i", $uName);
                $prstmt->execute();
                $prstmt->bind_result($postDate, $title, $text, $img,$pid);
                if ($prstmt->fetch()) {
                    echo "<div class=\"mini-thread\">";
                    echo "<article>";
                    echo "<a href=\"./thread.php?postId=$pid\"><h2> $title </h2></a>";
                    echo "<i>Posted by: $uName on <time> $postDate </time> <a href=\"./discussion.php?catId=$catId\">$category</a></i>";
                    echo "<p> $text </p>";
                    echo " </article>";
                    echo "<img src=\"$img \">";
                    echo "</div>";


                } else {
                    echo "No threads";
                }
                $prstmt->close();

                ?>
               

            </section>
        </main>
    </body>

</html>