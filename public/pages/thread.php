<?php
session_start();
ini_set('display_errors', 1);
require_once '../scripts/dbconfig.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$utype = $_SESSION['utype'] ?? null;
$uid = $_SESSION['uid'] ?? null;

if (isset ($_GET['postId'])) {
    $postId = $_GET['postId'];
} else {
    exit (header("Location: ../index.php"));
}

// for likes script
if (isset ($_SESSION['uid'])) {
    echo "<script>let loggedIn = true;</script>";
} else {
    echo "<script>let loggedIn = false;</script>";
}

// for breadcrumbs
$sql = "SELECT title FROM posts WHERE postId = ?;";

try {
    $prstmt = $conn->prepare($sql);
    $prstmt->bind_param('s', $postId);
    $prstmt->bind_result($title);
    $prstmt->execute();
    if ($prstmt->fetch()) {
        $pageTitle = $title;
    } else {
        $pageTitle = "Post";
    }
    $prstmt->close();
} catch (mysqli_sql_exception $e) {
    $pageTitle = "Post";
}
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
        <script src="../js/load_comments.js"></script>

        <script src="https://kit.fontawesome.com/cfd53e539d.js" crossorigin="anonymous"></script>
        <script>

            function showLoginAlert(e) {
                e.preventDefault();
                alert("Please log in to use this feature.");
            }

        </script>
    </head>

    <body>
        <?php require_once '../scripts/header.php'; ?>
        <main class="column-container margin-down">
            <div class="thread-container">
                <?php

                $sql = "SELECT p.postId, p.userId, p.postDate, p.title, p.text, p.img, u.uName AS userName, c.name, c.catId, p.link, u.utype FROM posts p JOIN users u ON p.userId = u.userId LEFT OUTER JOIN categories c ON p.catId=c.catId WHERE p.postId = ?";

                try {
                    $prstmt = $conn->prepare($sql);
                    $prstmt->bind_param("i", $postId);
                    $prstmt->execute();
                    $prstmt->bind_result($postId, $userId, $postDate, $postTitle, $postText, $postImg, $userName, $category, $catId, $link, $userType);
                    if ($prstmt->fetch()) {
                        echo "<article>";
                        echo "<img src=\"$postImg\" class =\"thread-img\" >";
                        echo "<h1> $postTitle </h1>";
                            if ($userType == 1) {
                                echo "<i>Posted by: " . ($userId == $uid ? "<a href=\"./my_profile.php\">" : "<a href=\"./profile.php?uName=$userName\">") . htmlspecialchars($userName) . "</a><span class=\"mod\"> [MOD]</span> on <time>$postDate</time>" . ((isset ($catId)) ? " under <a href=\"./discussion.php?catId=$catId\">" . htmlspecialchars($category) . "</a>" : "") . "</i>";

                        } else {
                            echo "<i>Posted by: " . ($userId == $uid ? "<a href=\"./my_profile.php\">" : "<a href=\"./profile.php?uName=$userName\">") . htmlspecialchars($userName) . "</a> on <time>$postDate</time>" . ((isset($catId)) ? " under <a href=\"./discussion.php?catId=$catId\">" . htmlspecialchars($category) . "</a>" : "") . "</i>";
                        }
                        echo "<p> $postText </p>";
                        echo " </article>";
                        echo "<a href=\"$link\" target=\"_blank\"> $link </a>";

                    } else {
                        $pageTitle = 'Post';
                        require_once '../scripts/header.php';
                        echo "Post Does Not Exist";
                    }
                    $prstmt->close();
                } catch (mysqli_sql_exception $e) {
                    error_log("Thread error", $e->getMessage());

                } catch (Exception $e) {
                    error_log("Thread error", $e->getMessage());
                }

                ?>
                <?php
                try {
                    if ($utype === 0 || $utype === 1) {
                        echo "<div id=\"icon-buttons\">
                    <a href=\"\" class=\"link-button\" id=\"like-button\"><i class=\"fa-regular fa-heart\"></i> Like | <span
                            id=\"like-count\"> 0 </span></a>
                    <a href=\"\" class=\"link-button\" id=\"add-comment\" ><i class=\"fa-solid fa-comment\" ></i> Comment | <span
                            id=\"comment-count\"> 0 </span> </a> </div>";
                    } else {
                        echo "<div id=\"icon-buttons\">
                    <a href=\"#\" class=\"link-button\" onclick=\"showLoginAlert(event)\"><i class=\"fa-regular fa-heart\"></i> Like | <span id=\"like-count\"> 0 </span></a>
                    <a href=\"#\" class=\"link-button\" onclick=\"showLoginAlert(event)\"><i class=\"fa-solid fa-comment\"></i> Comment | <span id=\"comment-count\"> 0 </span></a> </div>";
                    }
                } catch (mysqli_sql_exception $e) {
                    error_log("like or Comment icon error", $e->getMessage());

                } catch (Exception $e) {
                    error_log("Tlike or Comment icon error", $e->getMessage());
                }
                ?>
            </div>
             <!-- for loading comments from load_comments.js -->
            <div class="thread-comments"></div>
        </main>
    </body>

</html>