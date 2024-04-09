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
        <script src="../js/load_discussions.js"></script>
        <script src="../js/slick.min.js"></script>

        <script src="https://kit.fontawesome.com/cfd53e539d.js" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function () {
                $('.image-carousel').slick({
                    autoplay: true,
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    dots: false,
                    infinite: true,
                    arrows: true
                });

                function adjustCarouselHeight() {
                    // Get the height of the current slide
                    var slideHeight = $('.image-carousel .slick-current img').height();
                    // Set the height of the carousel to match the current slide
                    $('.image-carousel').height(slideHeight);
                }

                // Run once to set initial height, and whenever the slide changes
                adjustCarouselHeight(); // Adjust on load
                $('.image-carousel').on('afterChange', function () {
                    adjustCarouselHeight(); // Adjust whenever the slide changes
                });
            });
        </script>
    </head>

    <body>
        <?php require_once '../scripts/header.php'; ?>


        <main class="center-container margin-down">


            <section class="side-container">

                <h3 class="trending-title">TRENDING CATEGORIES <br> <br> </h3>
                <ul id="cat-list"></ul>
            </section>

            <section class="discussion-container">

                <div class="image-carousel">
                    <?php

                    $sql = "SELECT p.title, u.uName, p.img, u.utype, p.postId
                FROM posts as p JOIN users as u ON p.userId = u.userId 
                LEFT OUTER JOIN categories as c ON p.catId = c.catId 
                WHERE p.postDate > DATE_SUB(NOW(), INTERVAL 1 DAY)
                ORDER BY ((p.likes * 5) + (p.comment * 2) + (c.count * 7)) DESC
                LIMIT 20;";
                    $prstmt = $conn->prepare($sql);
                    try {
                        $prstmt->execute();
                        $prstmt->bind_result($ImageTitle, $ImageUsername, $Image, $UserType, $ImagePostId);
                        while ($prstmt->fetch()) {
                            echo "<div class='carousel-item'>";
                            echo "<a href=\"./thread.php?postId=$ImagePostId\"><img src='{$Image}' alt='{$ImageTitle}'></a>";
                            echo "<div class='carousel-caption'>";
                            echo "<h3>{$ImageTitle}</a></h3>";
                            echo "<p><a href=\"./profile.php?uName=$ImageUsername\">{$ImageUsername}</a></p>";
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
                <h3> TRENDING THREADS </h3>
                <?php

                $searchString = (isset($search)) ? $search : "";
                // for listing matching users by displaying profile in a block
                try {
                    $sql = "SELECT uName, fName, lName, pfp, userId FROM users WHERE CASE WHEN ? = \"\" THEN FALSE ELSE uName LIKE CONCAT('%', ?, '%') OR fName LIKE CONCAT('%', ?, '%') OR lName LIKE CONCAT('%', ? , '%') OR CONCAT(fName,' ',lName) LIKE CONCAT('%',?,'%') END;";
                    $prstmt = $conn->prepare($sql);
                    $prstmt->bind_param("sssss", $searchString, $searchString, $searchString, $searchString, $searchString);
                    $prstmt->execute();
                    $prstmt->bind_result($uName, $fName, $lName, $pfp, $userId);
                    if ($prstmt->fetch()) {
                        echo "<div class =\"profiles-container\">";
                        echo "<div class =\"profile\" data-uname=\"{$uName}\" data-userid=\"{$userId}\" data-uid=\"{$uid}\"><img src=\"$pfp\" alt=\"$uName's Profile Photo\"><p>$uName</p><p>$fName $lName</p></div>";
                        while ($prstmt->fetch()) {
                            echo "<div class =\"profile\" data-uname=\"{$uName}\" data-userid=\"{$userId}\" data-uid=\"{$uid}\"><img src=\"$pfp\" alt=\"$uName's Profile Photo\"><p>$uName</p><p>$fName $lName</p></div>";
                        }
                        echo "</div>";
                    }
                    $prstmt->close();
                } catch (mysqli_sql_exception $e) {
                    $code = $e->getCode();
                    if (isset($prstmt)) {
                        $prstmt->close();
                    }
                    echo "<p>Error while loading discussion posts. Try again. Error: $code</p>";
                }


                // Block for listing posts
                $highestPostId = 0;
                $sql = "SELECT p.postId, p.title, p.postDate, p.text, u.uName, c.name, p.img, c.catId, u.userId, u.utype, p.likes, p.comment
                FROM posts as p JOIN users as u ON p.userId = u.userId 
                LEFT OUTER JOIN categories as c ON p.catId = c.catId 
                WHERE p.postDate > DATE_SUB(NOW(), INTERVAL 1 DAY)
                ORDER BY ((p.likes * 5) + (p.comment * 2) + (c.count * 2)) DESC
                LIMIT 20;";
                $prstmt = $conn->prepare($sql);

                // if (isset($catId)) {
                //     $prstmt->bind_param("ssss", $catId, $searchString, $searchString, $searchString);
                // } else {
                //     $prstmt->bind_param("sss", $searchString, $searchString, $searchString);
                // }
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
                        if ($postId > $highestPostId) {
                            $highestPostId = $postId;
                        }
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
                            if ($postId > $highestPostId) {
                                $highestPostId = $postId;
                            }
                        }
                    } else {
                        echo "<p>Looks like theres no posts under your search parameters... Be the first to post!</p>";
                    }
                    $prstmt->close();
                    //To be accessible in the load discussions js script to check when new posts are made.
                    echo "<script>";
                    echo "var lastPostId = $highestPostId;";
                    echo "</script>";
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