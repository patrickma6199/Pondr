<?php
session_start();
ini_set('display_errors', 1);
require_once '../scripts/dbconfig.php';
$uid = $_SESSION['uid'] ?? null;
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$pageTitle = "My Profile";
$utype = $_SESSION['utype'] ?? null;
if (!isset ($uid)) {
    exit(header("Location: ../index.php"));
}
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
        <script src="https://kit.fontawesome.com/cfd53e539d.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <?php require_once '../scripts/header.php'; //for dynamic header  ?>
        <main class="column-container margin-down">
            <section class="profile-container">
                <?php
                $sql = "SELECT fName,lName,uName,bio,pfp FROM users WHERE userId = ?";
                try {
                    $prstmt = $conn->prepare($sql);
                    $prstmt->bind_param("i", $uid);
                    $prstmt->execute();
                    $prstmt->bind_result($fName, $lName, $uName, $bio, $pfp);
                    if ($prstmt->fetch()) {
                        echo " <div class=\"profile-img\">";
                        echo "<a href=\"$pfp\"><img src=\"$pfp\" alt=\"profile picture\"></a>";
                        echo "</div>";
                        echo "<div class=\"profile-text\">";
                        echo "<h2> $fName $lName </h2>";
                        echo "<p><b>Username:</b> $uName </p>";
                        echo "<p> <b>Bio:</b> $bio </p>";
                        echo "<p><span><b>Followers:</b>    <b>Following:</b>  </span></p>";
                        echo "<br>";
                        echo "<a href=\"my_profile_edit.php\" class=\"link-button\">Edit</a>";
                        echo "</div>";
                    } else {
                        echo "NO PROFILE INFO";
                    }
                    $prstmt->close();
                    unset($prstmt);
                } catch(mysqli_sql_exception $e) {
                    $code = $e->getCode();
                    echo "Failed to load profile. Error: $code";
                    if (isset ($prstmt)) {
                        $prstmt->close();
                    }
                }
                ?>
            </section>
            <section class="discussion-container">
                <h2>Your Threads</h2>
                <?php
                $sql1 = "SELECT p.postDate,p.title,p.text,p.img,u.uName,p.postId, c.catId, c.name, p.likes, p.comment FROM posts p JOIN users u ON p.userId = u.userId LEFT OUTER JOIN categories c ON p.catId = c.catId WHERE p.userId=? ORDER BY p.postDate DESC";
                try {
                    $prstmt = $conn->prepare($sql1);
                    $prstmt->bind_param("i", $uid);
                    $prstmt->execute();
                    $prstmt->bind_result($postDate, $title, $text, $img, $uName, $pid, $catId, $catName, $likeCount, $comCount);
                    if ($prstmt->fetch()) {
                        echo "<div class=\"mini-thread\">";
                        echo "<article>";
                        echo "<a href=\"./thread.php?postId=$pid\"><h2>$title</h2></a>";
                        echo "<i>Posted by: $uName on <time> $postDate </time>" . ((isset ($catId)) ? " under <a href=\"./discussion.php?catId=$catId\">" . htmlspecialchars($catName) . "</a>" : "") . "</i>";
                        echo "<p> $text </p>";
                         echo "<p style=\"margin-top:2em;\"><b><i class=\"fa-regular fa-heart\"></i></b> $likeCount   <b><i class=\"fa-solid fa-comment\"></i></b> $comCount</p>";
                        echo " </article>";
                        if (isset ($img)) {
                            echo "<img src=\"$img\">";
                        }
                        echo "<div id=\"icon-buttons\"> <a href=\"../scripts/delete_posts.php?postId=$pid\" class=\"link-button\" id=\"delete-post-button\" onclick=\"return confirm('Are you sure?')\"><i class=\"fa-regular fa-trash-can\"></i></a></div>";
                        echo "</div>";
                        while ($prstmt->fetch()) {
                            echo "<div class=\"mini-thread\">";
                            echo "<article>";
                            echo "<a href=\"./thread.php?postId=$pid\"><h2> $title </h2></a>";
                            echo "<i>Posted by: $uName on <time> $postDate </time>" . ((isset ($catId)) ? " under <a href=\"./discussion.php?catId=$catId\">" . htmlspecialchars($catName) . "</a>" : "") . "</i>";
                            echo "<p> $text </p>";
                             echo "<p style=\"margin-top:2em;\"><b><i class=\"fa-regular fa-heart\"></i></b> $likeCount   <b><i class=\"fa-solid fa-comment\"></i></b> $comCount</p>";
                            echo " </article>";
                            if (isset ($postImg)) {
                                echo "<img src=\"$postImg\">";
                            }
                            echo "<div id=\"icon-buttons\"> <a href=\"../scripts/delete_posts.php?postId=$pid\" class=\"link-button\" id=\"delete-post-button\" onclick=\"return confirm('Are you sure?')\"><i class=\"fa-regular fa-trash-can\"></i></a></div>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>No threads yet! Go make one!</p>";
                    }
                    $prstmt->close();
                    unset($prstmt);
                } catch (mysqli_sql_exception $e){
                    $code = $e->getCode();
                    echo "Failed to load your posts. Error: $code";
                    if (isset ($prstmt)) {
                        $prstmt->close();
                    }
                }
                $conn->close();
                ?>
            </section>
        </main>
    </body>

</html>