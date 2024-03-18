<?php
session_start();
require_once '../scripts/dbconfig.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$utype = (isset($_SESSION["utype"]))? $_SESSION["utype"] : null;
$uid = (isset($_SESSION["uid"]))? $_SESSION["uid"] : null;

if (isset($_GET["search"])) {               //remove search if searched value is empty
    if ($_GET["search"] == "") {
        unset($_GET["search"]);
    }
}
$search = (isset($_GET["search"])) ? $_GET["search"] : null;
$catId = (isset($_GET["catId"])) ? $_GET["catId"] : null;
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
</head>
<body>
    <?php require_once '../scripts/header.php'; //for dynamic header ?>
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
                        echo (isset($search)) ? "<li><a href=\"./discussion.php?catId=$catListId&search=$search\">$catName</a></li>" : "<li><a href=\"./discussion.php?catId=$catListId\">$catName</a></li>";
                        while ($prstmt->fetch()) {
                            echo (isset ($search)) ? "<li><a href=\"./discussion.php?catId=$catListId&search=$search\">$catName</a></li>" : "<li><a href=\"./discussion.php?catId=$catListId\">$catName</a></li>";
                        }
                        echo (isset ($search)) ? "<li><a href=\"./discussion.php?search=$search\">Clear Filter</a></li>" : "<li><a href=\"./discussion.php\">Clear Category</a></li>";
                    } else {
                        echo "<p>No Categories have been made yet! make some.</p>";
                    }
                    $prstmt->close();
                } catch(mysqli_sql_exception $e) {
                    echo "<p>Error occurred: pulling categories.</p>";
                }
                ?>
            </ul>
        </section>

        <section class="discussion-container">
                <?php
                // query depends on if catId is set and if search string is empty (return all discussion posts)
                $sql = "SELECT p.postId, p.title, p.postDate, p.text, u.uName, c.name, p.img 
                FROM posts as p JOIN users as u ON p.userId = u.userId 
                JOIN categories as c ON p.catId = c.catId 
                WHERE" . (isset($catId) ? " p.catId = ? AND ":" ") . "CASE WHEN ? = \"\" THEN TRUE ELSE (p.title LIKE CONCAT('%',?,'%') OR p.text LIKE CONCAT('%',?,'%') OR u.uName LIKE CONCAT('%',?,'%')) END;";
                $prstmt = $conn->prepare($sql);
                $searchString = (isset($search)) ? $search : "";
                if (isset($catId)) {
                    $prstmt->bind_param("sssss",$catId,$searchString,$searchString,$searchString,$searchString);
                } else {
                    $prstmt->bind_param("ssss",$searchString,$searchString,$searchString,$searchString);
                }
                try {
                    $prstmt->execute();
                    $prstmt->bind_result($postId, $title, $postDate, $text, $uName, $catName, $postImg);
                    if($prstmt->fetch()){
                        echo "<div class=\"mini-thread\">";
                        echo "<article>";
                        echo "<a href=\"./thread.php?pid=$postId\"><h2>$title</h2></a>";
                        echo "<i>Posted by: $uName on <time>$postDate</time></i>";
                        echo "<p>$text</p>";
                        echo "</article>";
                        if (isset($postImg)) { echo "<img src=\"$postImg\">";}
                        echo "</div>";
                        while ($prstmt->fetch()) {
                            echo "<div class=\"mini-thread\">";
                            echo "<article>";
                            echo "<a href=\"./thread.php?pid=$postId\"><h2>$title</h2></a>";
                            echo "<i>Posted by: $uName on <time>$postDate</time></i>";
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
                    echo "<p>Error while loading discussion posts. Try again.</p>";
                }
                $conn->close();
                ?>
        </section>
    </main>
</body>
</html>