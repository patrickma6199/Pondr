<?php
session_start();
require_once '../scripts/dbconfig.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
ini_set('display_errors', 1);

$uid = $_SESSION['uid'] ?? null;

if (isset($_GET["search"])) {               //remove search if searched value is empty
    if ($_GET["search"] == "") {
        unset($_GET["search"]);
    }
}
$search = $_GET['search'] ?? null;
$catId = $_GET['catId'] ?? null;
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
    <script>
        $(document).ready(function() {
            // Select the element you want to fade out
            let fading_message = $('#fading-message');

            // Use setTimeout to trigger the fadeOut after 5 seconds
            setTimeout(function() {
                fading_message.fadeOut();
            }, 5000); // 5000 milliseconds = 5 seconds
        });
    </script>
</head>
<body>
    <?php require_once '../scripts/header.php'; //for dynamic header ?>
    <?php
    if(isset($_SESSION['discussionMessage'])) {
        echo $_SESSION['discussionMessage'];
        unset($_SESSION['discussionMessage']);
    }
    ?>
    <main class="center-container margin-down">
        <section class="side-container">
            <?php
            // if logged in, add button for new posts
            if (isset ($uid)) {
                echo "<a href=\"./new_post.php\"><h3>New Post</h3></a>";
            }
            ?>
            <h3>Filter by Category: </h3>
            <ul>
                <?php
                $sql = "SELECT catId, name FROM categories ORDER BY count DESC LIMIT 10;";       // for listing top 10 categories to search under
                $prstmt = $conn->prepare($sql);
                try {
                    $prstmt->execute();
                    $prstmt->bind_result($catListId,$catName);
                    if ($prstmt->fetch()) {
                        echo (isset($search)) ? "<li><a href=\"./discussion.php?catId=$catListId&search=$search\">" . htmlspecialchars($catName) . "</a></li>" : "<li><a href=\"./discussion.php?catId=$catListId\">" . htmlspecialchars($catName) . "</a></li>";
                        while ($prstmt->fetch()) {
                            echo (isset ($search)) ? "<li><a href=\"./discussion.php?catId=$catListId&search=$search\">" . htmlspecialchars($catName) . "</a></li>" : "<li><a href=\"./discussion.php?catId=$catListId\">" . htmlspecialchars($catName) . "</a></li>";
                        }
                        echo (isset ($search)) ? "<li><a href=\"./discussion.php?search=$search\">Clear Filter</a></li>" : "<li><a href=\"./discussion.php\">Clear Category</a></li>";
                    } else {
                        echo "<p>No Categories have been made yet! Try making one now!</p>";
                    }
                    $prstmt->close();
                } catch(mysqli_sql_exception $e) {
                    $code = $e->getCode();
                    echo "<p>Error occurred: pulling categories. Error: $code</p>";
                }
                ?>
            </ul>
        </section>

        <section class="discussion-container">
                <?php
                // query depends on if catId is set and if search string is empty (return all discussion posts)
                $sql = "SELECT p.postId, p.title, p.postDate, p.text, u.uName, c.name, p.img, c.catId
                FROM posts as p JOIN users as u ON p.userId = u.userId 
                LEFT OUTER JOIN categories as c ON p.catId = c.catId 
                WHERE" . (isset($catId) ? " p.catId = ? AND ":" ") . "CASE WHEN ? = \"\" THEN TRUE ELSE (p.title LIKE CONCAT('%',?,'%') OR p.text LIKE CONCAT('%',?,'%') OR u.uName LIKE CONCAT('%',?,'%')) END
                ORDER BY p.postDate DESC;";
                $prstmt = $conn->prepare($sql);
                $searchString = (isset($search)) ? $search : "";
                if (isset($catId)) {
                    $prstmt->bind_param("sssss",$catId,$searchString,$searchString,$searchString,$searchString);
                } else {
                    $prstmt->bind_param("ssss",$searchString,$searchString,$searchString,$searchString);
                }
                try {
                    $prstmt->execute();
                    $prstmt->bind_result($postId, $title, $postDate, $text, $uName, $catName, $postImg, $catId);
                    if($prstmt->fetch()){
                        echo "<div class=\"mini-thread\">";
                        echo "<article>";
                        echo "<a href=\"./thread.php?postId=$postId\"><h2>". htmlspecialchars($title) ."</h2></a>";
                        echo "<i>Posted by: <a href=\"./profile.php?uName=$uName\">" . htmlspecialchars($uName) . "</a> on <time>$postDate</time> under <a href=\"./discussion.php?catId=$catId\">" . htmlspecialchars($catName) . "</a></i>";
                        echo "<p>$text</p>";
                        echo "</article>";
                        if (isset($postImg)) { echo "<img src=\"$postImg\">";}
                        echo "</div>";
                        while ($prstmt->fetch()) {
                            echo "<div class=\"mini-thread\">";
                            echo "<article>";
                            echo "<a href=\"./thread.php?postId=$postId\"><h2>" . htmlspecialchars($title) . "</h2></a>";
                            echo "<i>Posted by: <a href=\"./profile.php?uName=$uName\">" . htmlspecialchars($uName) . "</a> on <time>$postDate</time> under <a href=\"./discussion.php?catId=$catId\">" . htmlspecialchars($catName) . "</a></i>";
                            echo "<p>$text</p>";
                            echo "</article>";
                            if (isset($postImg)) { echo "<img src=\"$postImg\">";}
                            echo "</div>";
                        }
                    } else {
                        echo "<p>Looks like theres no posts currently in Pondr. Be the first to post!</p>";
                    }
                    $prstmt->close();
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