<?php
session_start();
require_once '../scripts/dbconfig.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
ini_set('display_errors', 1);

$uid = $_SESSION['uid'] ?? null;

if (isset ($_GET["search"])) {               //remove search if searched value is empty
    if ($_GET["search"] == "") {
        unset($_GET["search"]);
    }
}
$search = $_GET['search'] ?? null;
$catId = $_GET['catId'] ?? null;

$pageTitle = "Discussions";
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/styles.css">
        <link rel="stylesheet" href="../css/discussion.css">
        <link rel="icon" href="../img/logo.png">
        <title>Pondr</title>
        <script src="../js/jquery-3.1.1.min.js"></script>
        <script src="../js/load_discussions.js"></script>
        <script>
            $(document).ready(function () {
                let post_success = $('#post-success');

                setTimeout(function () {
                    post_success.fadeOut();
                }, 5000);
            });
        </script>
    </head>

    <body>
        <?php require_once '../scripts/header.php'; //for dynamic header  ?>
        <?php
        if (isset ($_SESSION['discussionMessage'])) {
            echo $_SESSION['discussionMessage'];
            unset($_SESSION['discussionMessage']);
        }
        ?>
        <p class="fading-message" id="new-post" style="display:none;"></p>
        <main class="center-container margin-down">
            <section class="side-container">
                <?php
                // if logged in, add button for new posts and joining a community
                if (isset ($uid)) {
                    echo "<a href=\"./new_post.php\"><h3>New Post</h3></a>";
                }
                ?>
                <h3>Trending Categories</h3>
                <ul id="cat-list"></ul>
            </section>

            <section class="discussion-container">
                <?php
                $highestPostId = 0;
                // query depends on if catId is set and if search string is empty (return all discussion posts)
                $sql = "SELECT p.postId, p.title, p.postDate, p.text, u.uName, c.name, p.img, c.catId, u.userId, u.utype
                FROM posts as p JOIN users as u ON p.userId = u.userId 
                LEFT OUTER JOIN categories as c ON p.catId = c.catId 
                WHERE" . (isset ($catId) ? " p.catId = ? AND " : " ") . "CASE WHEN ? = \"\" THEN TRUE ELSE (p.title LIKE CONCAT('%',?,'%') OR p.text LIKE CONCAT('%',?,'%') OR u.uName LIKE CONCAT('%',?,'%')) END
                ORDER BY p.postDate DESC;";
                $prstmt = $conn->prepare($sql);
                $searchString = (isset ($search)) ? $search : "";
                if (isset ($catId)) {
                    $prstmt->bind_param("sssss", $catId, $searchString, $searchString, $searchString, $searchString);
                } else {
                    $prstmt->bind_param("ssss", $searchString, $searchString, $searchString, $searchString);
                }
                try {
                    $prstmt->execute();
                    $prstmt->bind_result($postId, $title, $postDate, $text, $uName, $catName, $postImg, $catId, $userId, $userType);
                    if ($prstmt->fetch()) {
                        echo "<div class=\"mini-thread\">";
                        echo "<article>";
                        echo "<a href=\"./thread.php?postId=$postId\"><h2>" . htmlspecialchars($title) . "</h2></a>";
                        if ($userType == 1) {
                            echo "<i>Posted by: " . ($userId == $uid ? "<a href=\"./my_profile.php\">" : "<a href=\"./profile.php?uName=$uName\">") . htmlspecialchars($uName) . "[MOD] </a> on <time>$postDate</time>" . ((isset ($catId)) ? " under <a href=\"./discussion.php?catId=$catId\">" . htmlspecialchars($catName) . "</a>" : "") . "</i>";

                        }else{
                            echo "<i>Posted by: " . ($userId == $uid ? "<a href=\"./my_profile.php\">" : "<a href=\"./profile.php?uName=$uName\">") . htmlspecialchars($uName) . "</a> on <time>$postDate</time>" . ((isset ($catId)) ? " under <a href=\"./discussion.php?catId=$catId\">" . htmlspecialchars($catName) . "</a>" : "") . "</i>";
                        }
                        echo "<p>$text</p>";
                        echo "</article>";
                        if (isset ($postImg)) {
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
                                echo "<i>Posted by: " . ($userId == $uid ? "<a href=\"./my_profile.php\">" : "<a href=\"./profile.php?uName=$uName\">") . htmlspecialchars($uName) . "[MOD] </a> on <time>$postDate</time>" . ((isset ($catId)) ? " under <a href=\"./discussion.php?catId=$catId\">" . htmlspecialchars($catName) . "</a>" : "") . "</i>";

                            }else{
                                echo "<i>Posted by: " . ($userId == $uid ? "<a href=\"./my_profile.php\">" : "<a href=\"./profile.php?uName=$uName\">") . htmlspecialchars($uName) . "</a> on <time>$postDate</time>" . ((isset ($catId)) ? " under <a href=\"./discussion.php?catId=$catId\">" . htmlspecialchars($catName) . "</a>" : "") . "</i>";
                            }
                            echo "<p>$text</p>";
                            echo "</article>";
                            if (isset ($postImg)) {
                                echo "<img src=\"$postImg\">";
                            }
                            echo "</div>";
                            if ($postId > $highestPostId) {
                                $highestPostId = $postId;
                            }
                        }
                    } else {
                        echo "<p>Looks like theres no posts currently in Pondr. Be the first to post!</p>";
                    }
                    $prstmt->close();
                    echo "<script>";
                    echo "var lastPostId = $highestPostId;";
                    echo "</script>";
                } catch (mysqli_sql_exception $e) {
                    $code = $e->getCode();
                    echo "<p>Error while loading discussion posts. Try again. Error: $code</p>";
                }
                $conn->close();
                ?>
            </section>
        </main>
    </body>

</html>