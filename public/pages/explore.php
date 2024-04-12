<?php
session_start();
require_once '../scripts/dbconfig.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
ini_set('display_errors', 1);

$uid = $_SESSION['uid'] ?? null;

if (isset($_GET["search"])) {
    if ($_GET["search"] == "") {
        unset($_GET["search"]);
    }
}
$search = $_GET['search'] ?? null;
$catId = $_GET['catId'] ?? null;

$pageTitle = "Explore";
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/styles.css">
        <link rel="stylesheet" href="../css/explore.css">
        <link rel="stylesheet" href="../css/slick.min.css">

        <link rel="icon" href="../img/logo.png">
        <title>Pondr</title>
        <script src="../js/jquery-3.1.1.min.js"></script>
        <script src="../js/load_categories.js"></script>
        <script src="../js/slick.min.js"></script>

        <script src="https://kit.fontawesome.com/cfd53e539d.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <?php require_once '../scripts/header.php'; ?>


        <main class="center-container margin-down">


            <section class="side-container">

                <h3 class="trending-title">TRENDING CATEGORIES <br> <br> </h3>
                <ul id="cat-list"></ul>
            </section>

            <section class="discussion-container">
                <h3> FOR YOU </h3>

                <div class="image-carousel">
                    
                    <?php

                    $sql = "SELECT p.title, u.uName, p.img, u.utype, p.postId
                FROM posts as p JOIN users as u ON p.userId = u.userId 
                LEFT OUTER JOIN categories as c ON p.catId = c.catId 
                WHERE p.postDate >= DATE_SUB(NOW(), INTERVAL 1 WEEK) AND p.img IS NOT NULL
                ORDER BY ((p.likes * 5) + (p.comment * 2) + (c.count * 7)) DESC
                LIMIT 20;";
                    $prstmt = $conn->prepare($sql);
                    try {
                        $prstmt->execute();
                        $prstmt->bind_result($ImageTitle, $ImageUsername, $Image, $UserType, $ImagePostId);
                        while ($prstmt->fetch()) {
                            echo "<div class='carousel-item'>";
                            echo "<a href=\"./thread.php?postId=$ImagePostId\"><img src='{$Image}' alt='an iamge for {$ImageTitle}'></a>";
                            echo "<div class='carousel-caption'>";
                            echo "<h3>{$ImageTitle}</h3><br>";
                            echo "</div>";
                            echo "</div>";
                        }
                    } catch (mysqli_sql_exception $e) {
                        $code = $e->getCode();
                        if (isset($prstmt)) {
                            $prstmt->close();
                        }
                        echo "<p>Error while loading discussion posts. Try again. Error: $code</p>";
                    }
                    ?>
                </div>
                <h3> TRENDING PONDS </h3>
                <?php

                // Block for listing posts
                $sql = "SELECT p.postId, p.title, p.postDate, p.text, u.uName, c.name, p.img, c.catId, u.userId, u.utype, p.likes, p.comment
                FROM posts as p JOIN users as u ON p.userId = u.userId 
                LEFT OUTER JOIN categories as c ON p.catId = c.catId
                WHERE p.postDate >= DATE_SUB(NOW(), INTERVAL 1 WEEK)
                ORDER BY ((p.likes * 5) + (p.comment * 2) + (c.count * 2)) DESC
                LIMIT 20;";
                $prstmt = $conn->prepare($sql);
                try {
                    $prstmt->execute();
                    $prstmt->bind_result($postId, $title, $postDate, $text, $uName, $catName, $postImg, $catId, $userId, $userType, $likeCount, $comCount);
                    if ($prstmt->fetch()) {
                        echo "<div class=\"mini-thread\">";
                        echo "<article>";
                        echo "<a href=\"./thread.php?postId=$postId\"><h2>" . htmlspecialchars($title) . "</h2></a>";
                        if ($userType == 1) {
                            echo "<i>Posted by: " . ($userId == $uid ? "<a href=\"./my_profile.php\">" : "<a href=\"./profile.php?uName=$uName\">") . htmlspecialchars($uName) . "</a><span class=\"mod\"> [MOD]</span> on <time>$postDate</time>" . ((isset($catId)) ? " under <a href=\"./discussion.php?catId=$catId\">" . htmlspecialchars($catName) . "</a>" : "") . "</i>";

                        } else {
                            echo "<i>Posted by: " . ($userId == $uid ? "<a href=\"./my_profile.php\">" : "<a href=\"./profile.php?uName=$uName\">") . htmlspecialchars($uName) . "</a> on <time>$postDate</time>" . ((isset($catId)) ? " under <a href=\"./discussion.php?catId=$catId\">" . htmlspecialchars($catName) . "</a>" : "") . "</i>";
                        }
                        echo "<p>$text</p>";
                        echo "<p style=\"margin-top:2em;\"><b><i class=\"fa-regular fa-heart\"></i></b> $likeCount   <b><i class=\"fa-solid fa-comment\"></i></b> $comCount</p>";
                        echo "</article>";
                        if (isset($postImg)) {
                            echo "<img src=\"$postImg\">";
                        }
                        echo "</div>";
                        while ($prstmt->fetch()) {
                            echo "<div class=\"mini-thread\">";
                            echo "<article>";
                            echo "<a href=\"./thread.php?postId=$postId\"><h2>" . htmlspecialchars($title) . "</h2></a>";
                            if ($userType == 1) {
                                echo "<i>Posted by: " . ($userId == $uid ? "<a href=\"./my_profile.php\">" : "<a href=\"./profile.php?uName=$uName\">") . htmlspecialchars($uName) . "</a><span class=\"mod\"> [MOD]</span> on <time>$postDate</time>" . ((isset($catId)) ? " under <a href=\"./discussion.php?catId=$catId\">" . htmlspecialchars($catName) . "</a>" : "") . "</i>";

                            } else {
                                echo "<i>Posted by: " . ($userId == $uid ? "<a href=\"./my_profile.php\">" : "<a href=\"./profile.php?uName=$uName\">") . htmlspecialchars($uName) . "</a> on <time>$postDate</time>" . ((isset($catId)) ? " under <a href=\"./discussion.php?catId=$catId\">" . htmlspecialchars($catName) . "</a>" : "") . "</i>";
                            }
                            echo "<p>$text</p>";
                            echo "<p style=\"margin-top:2em;\"><b><i class=\"fa-regular fa-heart\"></i></b> $likeCount   <b><i class=\"fa-solid fa-comment\"></i></b> $comCount</p>";
                            echo "</article>";
                            if (isset($postImg)) {
                                echo "<img src=\"$postImg\">";
                            }
                            echo "</div>";
                        }
                    } else {
                        echo "<p>Looks like theres no posts under your search parameters... Be the first to post!</p>";
                    }
                    $prstmt->close();
                } catch (mysqli_sql_exception $e) {
                    $code = $e->getCode();
                    if (isset($prstmt)) {
                        $prstmt->close();
                    }
                    echo "<p>Error while loading discussion posts. Try again. Error: $code</p>";
                }
                $conn->close();
                ?>
            </section>
        </main>
    </body>

</html>