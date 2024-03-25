<?php
session_start();
ini_set('display_errors', 1);
require_once '../scripts/dbconfig.php';
$uid = $_SESSION['uid'] ?? null;
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$pageTitle = $_GET['uName'] ?? "Profile";
$utype = $_SESSION['utype'] ?? null;
$uid = $_SESSION['uid'] ?? null;
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
        <script src="../js/jquery-3.1.1.min.js"></script>
        <script src="../js/delete_profile.js"></script>
    </head>

    <body>
        <?php require_once '../scripts/header.php'; //for dynamic header ?>
        <?php require_once '../scripts/breadcrumbs.php'; ?>
        <main class="column-container margin-down">
            <section class="profile-container">
                <?php
                $uName = $_GET['uName'];
                $sql = "SELECT fName,lName,bio,pfp FROM users WHERE uName = ?";
                $prstmt = $conn->prepare($sql);
                $prstmt->bind_param("i", $uName);
                $prstmt->execute();
                $prstmt->bind_result($fName, $lName, $bio, $pfp);
                if ($prstmt->fetch()) {
                    echo "<div class=\"profile-img\">";
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
                <?php
                if($utype === 1){
                    echo "<div id=\"icon-buttons\">
                    <a href=\"\" class=\"link-button\" id=\"delete-profile-button\"><i
                            class=\"fa-regular fa-trash-can\"></i></a>
                </div>";
                
                }
                ?>

            </section>
            <section class="discussion-container">
                <h2>Your Threads</h2>

                <?php
                $sql1 = "SELECT p.postDate,p.title,p.text,p.img,p.postId, u.userId FROM posts p JOIN users u ON p.userId = u.userId WHERE u.uName=?";
                $prstmt = $conn->prepare($sql1);
                $prstmt->bind_param("s", $uName);
                $prstmt->execute();
                $prstmt->bind_result($postDate, $title, $text, $img, $pid, $userId);
                if ($prstmt->fetch()) {
                    echo "<div class=\"mini-thread\">";
                    echo "<article>";
                    echo "<a href=\"./thread.php?postId=$pid\"><h2>$title</h2></a>";
                    echo "<i>Posted by: $uName on <time> $postDate </time></i>";
                    echo "<p> $text </p>";
                    echo " </article>";
                    if (isset($postImg)) { echo "<img src=\"$postImg\">";}
                    if (($utype === 0 && $uid == $userId) || $utype === 1) {
                        echo "<div id=\"icon-buttons\"> <a href=\"../scripts/delete_my_posts.php?postId=$pid\" class=\"link-button\" id=\"delete-post-button\"><i class=\"fa-regular fa-trash-can\"></i></a></div>";
                    }
                    echo "</div>";
                    while ($prstmt->fetch()) {
                        echo "<div class=\"mini-thread\">";
                        echo "<article>";
                        echo "<a href=\"./thread.php?postId=$pid\"><h2> $title </h2></a>";
                        echo "<i>Posted by: $uName on <time> $postDate </time></i>";
                        echo "<p> $text </p>";
                        echo " </article>";
                        if (isset($postImg)) { echo "<img src=\"$postImg\">";}
                        if (($utype === 0 && $uid == $userId) || $utype === 1) {
                            echo "<div id=\"icon-buttons\"> <a href=\"../scripts/delete_my_posts.php?postId=$pid\" class=\"link-button\" id=\"delete-post-button\"><i class=\"fa-regular fa-trash-can\"></i></a></div>";
                        }
                        echo "</div>";
                    }
                } else {
                    echo "This user has not posted yet...";
                }
                $prstmt->close();

                ?>



            </section>
        </main>
    </body>

</html>