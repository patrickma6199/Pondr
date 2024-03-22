<?php
session_start();
ini_set('display_errors', 1);
require_once '../scripts/dbconfig.php';
$utype = $_SESSION['utype'];
$uid = $_SESSION['uid'];
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);



?>

<!DOCTYPE html>
<html lang="en">


    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Thread </title>
        <link rel="stylesheet" href="../css/styles.css">
        <link rel="stylesheet" href="../css/threads.css">
        <link rel="icon" href="../img/logo.png">
        <script src="../js/jquery-3.1.1.min.js"></script>
        <script src="../js/like_button.js"></script>
        <script src="../js/comment_count.js"></script>
        <script src="../js/comment_add.js"></script>

        <script src="https://kit.fontawesome.com/cfd53e539d.js" crossorigin="anonymous"></script>

    </head>

    <body>
        <?php require_once '../scripts/header.php'; ?>
        <main class="column-container margin-down">
            <div class="thread-container">
                <?php
                if (isset ($_GET['postId'])) {
                    $postId = $_GET['postId'];
                }


                $sql = "SELECT p.postId, p.userId, p.postDate, p.title, p.text, p.img, u.uName AS userName, c.name FROM posts p JOIN users u ON p.userId = u.userId JOIN categories c ON p.catId=c.catId WHERE p.postId = ?";

                $prstmt = $conn->prepare($sql);
                $prstmt->bind_param("i", $postId);
                $prstmt->execute();
                $prstmt->bind_result($postId, $userId, $postDate, $postTitle, $postText, $postImg, $userName, $category);
                if ($prstmt->fetch()) {
                    echo "<article>";
                    echo "<img src=\"$postImg\" class =\"thread-img\" >";
                    echo "<h1> $postTitle </h1>";
                    echo "<i>Posted by: <a href=\"./secondaryProfile.php\">$userName</a> on <time>$postDate</time> $category</i>";
                    echo "<p> $postText </p>";
                    echo " </article>";

                } else {
                    echo "Post Does Not Exist";
                }
                $prstmt->close();

                ?>

                <div id="icon-buttons">
                    <a href="" class="link-button" id="like-button"><i class="fa-regular fa-heart"></i> Like | <span
                            id="like-count"> 0 </span></a>
                    <a href="" class="link-button" id="add-comment" ><i class="fa-solid fa-comment" ></i> Comment | <span
                            id="comment-count"> 0 </span> </a>

                </div>
            </div>

            <?php

            $sql1 = "SELECT c.comId,u.uName,c.comDate,c.text,u.pfp,c.parentComId FROM comments c JOIN users u ON c.userId = u.userId WHERE c.postId = ? AND c.parentComId IS NULL";
            $prstmt = $conn->prepare($sql1);

            $prstmt->bind_param("i", $postId);
            $prstmt->execute();
            $prstmt->store_result();
            $prstmt->bind_result($comId, $userName, $comDate, $comText, $pfp, $parentComId);

            echo '<div class="thread-comments">';
            while ($prstmt->fetch()) {

                echo '<article class="thread-comment-container">';
                echo '<div class="thread-comment-profile">';
                echo " <img src=\"$pfp\" alt=\"profile photo\">";
                echo "<i> $userName on <time>$comDate</time></i>";
                echo "</div>";
                echo "<p class=\"thread-comment\">";
                echo "$comText";
                echo "</p>";
                echo "<div> <a href=\"\" class=\"link-button reply-icon\" id=\"reply-icon-{$comId}\" data-commentid=\"{$comId}\"><i class=\"fa-solid fa-reply\"></i> Reply </a> </div>";



                $sql2 = "SELECT c.comId, u.uName, c.comDate, c.text, u.pfp FROM comments c JOIN users u ON c.userId = u.userId WHERE c.parentComId = ?";
                $prstmt2 = $conn->prepare($sql2);
                $prstmt2->bind_param("i", $comId);
                $prstmt2->execute();
                $prstmt2->bind_result($subComId, $subUserName, $subComDate, $subComText, $subPfp);
                while ($prstmt2->fetch() &&  $subComId != NULL){
                    echo "<div class=\"thread-comment-container\">";
                    echo "<div class=\"thread-comment-profile\">";
                    echo " <img src=\"$subPfp\" alt=\"profile photo\">";
                    echo "<i> $subUserName on <time>$subComDate</time></i>";
                    echo "</div>";
                    echo "<p class=\"thread-comment\">";
                    echo "$subComText";
                    echo "</p>";
                    echo "</div>";
                }
                $prstmt2->close();
                echo "</article>";



            }
            echo "</div>";
            $prstmt->free_result();
            $prstmt->close();







            ?>



            </div>
        </main>
    </body>

</html>