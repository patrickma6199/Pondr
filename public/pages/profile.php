<?php
session_start();
ini_set('display_errors', 1);
require_once '../scripts/dbconfig.php';
$uid = $_SESSION['uid'] ?? null;
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$pageTitle = $_GET['uName'] ?? "Profile";
$utype = $_SESSION['utype'] ?? null;
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
        <?php require_once '../scripts/header.php'; //for dynamic header  ?>
        <?php require_once '../scripts/breadcrumbs.php'; ?>
        <main class="column-container margin-down">
            <section class="profile-container">
                <?php
                $uName = $_GET['uName'] ?? null;
                if (!isset ($uName)) {
                    exit (header("Location: ../index.php"));
                }

                $sql = "SELECT fName,lName,bio,pfp,utype FROM users WHERE uName = ?";
                try {
                    $prstmt = $conn->prepare($sql);
                    $prstmt->bind_param("i", $uName);
                    $prstmt->execute();
                    $prstmt->bind_result($fName, $lName, $bio, $pfp, $userType);
                    if ($prstmt->fetch()) {
                        echo "<div class=\"profile-img\">";
                        echo "<a href=\"$pfp\"><img src=\"$pfp\" alt=\"profile picture\"></a>";
                        echo "</div>";
                        echo "<div class=\"profile-text\">";
                        echo "<p><b>Name:</b> $fName $lName </p> ";
                        if ($userType == 1) {
                            echo "<p><b>Username:</b> $uName" . "[MOD]</p>";
                        } else {
                            echo "<p><b>Username:</b> $uName </p>";
                        }
                        echo "<p> <b>Bio:</b> $bio </p>";
                        echo "<p><span><b>Followers:</b>    <b>Following:</b>  </span></p>";
                        echo "<br>";
                        echo "</div>";
                    } else {
                        echo "NO PROFILE INFO";
                    }
                    $prstmt->close();
                } catch(mysqli_sql_exception $e) {
                    $code = $e->getCode();
                    echo "Failed to load profile. Error: $code";
                    if (isset ($prstmt)) {
                        $prstmt->close();
                    }
                }
                if ($utype === 1) {
                    echo "<div id=\"icon-buttons\">
                    <a href=\"\" class=\"link-button\" id=\"delete-profile-button\" onclick=\"return confirm('Are you sure?')\"><i
                            class=\"fa-regular fa-trash-can\"></i></a>
                </div>";
                }
                ?>

            </section>
            <section class="discussion-container">
                <h2>Threads</h2>

                <?php
                $sql1 = "SELECT p.postDate,p.title,p.text,p.img,u.uName,p.postId, c.catId, c.name, u.utype FROM posts p JOIN users u ON p.userId = u.userId LEFT OUTER JOIN categories c ON p.catId = c.catId WHERE u.uName=? ORDER BY p.postDate DESC";
                try{
                  $prstmt = $conn->prepare($sql1);
                  $prstmt->bind_param("s", $uName);
                  $prstmt->execute();
                  $prstmt->bind_result($postDate, $title, $text, $img, $pid, $userId, $catId, $catName, $userType);
                  if ($prstmt->fetch()) {
                      echo "<div class=\"mini-thread\">";
                      echo "<article>";
                      echo "<a href=\"./thread.php?postId=$pid\"><h2>$title</h2></a>";
                      if ($userType == 1) {
                          echo "<i>Posted by: $uName"."[MOD] on <time> $postDate </time>" . ((isset ($catId)) ? " under <a href=\"./discussion.php?catId=$catId\">" . htmlspecialchars($catName) . "</a>" : "") . "</i>";
                      } else {
                          echo "<i>Posted by: $uName on <time> $postDate </time>" . ((isset ($catId)) ? " under <a href=\"./discussion.php?catId=$catId\">" . htmlspecialchars($catName) . "</a>" : "") . "</i>";
                      }
                      echo "<p> $text </p>";
                      echo " </article>";
                      if (isset ($postImg)) {
                          echo "<img src=\"$postImg\">";
                      }
                      if (($utype === 0 && $uid == $userId) || $utype === 1) {
                          echo "<div id=\"icon-buttons\"> <a href=\"../scripts/delete_my_posts.php?postId=$pid\" class=\"link-button\" id=\"delete-post-button\" onclick=\"return confirm('Are you sure?')\"><i class=\"fa-regular fa-trash-can\"></i></a></div>";
                      }
                      echo "</div>";
                      while ($prstmt->fetch()) {
                          echo "<div class=\"mini-thread\">";
                          echo "<article>";
                          echo "<a href=\"./thread.php?postId=$pid\"><h2> $title </h2></a>";
                          if ($userType == 1) {
                              echo "<i>Posted by: $uName"."[MOD] on <time> $postDate </time>" . ((isset ($catId)) ? " under <a href=\"./discussion.php?catId=$catId\">" . htmlspecialchars($catName) . "</a>" : "") . "</i>";
                          } else {
                              echo "<i>Posted by: $uName on <time> $postDate </time>" . ((isset ($catId)) ? " under <a href=\"./discussion.php?catId=$catId\">" . htmlspecialchars($catName) . "</a>" : "") . "</i>";
                          }
                        echo "<p> $text </p>";
                        echo " </article>";
                        if (isset($postImg)) { echo "<img src=\"$postImg\">";}
                        if (($utype === 0 && $uid == $userId) || $utype === 1) {
                            echo "<div id=\"icon-buttons\"> <a href=\"../scripts/delete_my_posts.php?postId=$pid\" class=\"link-button\" id=\"delete-post-button\" onclick=\"return confirm('Are you sure?')\"><i class=\"fa-regular fa-trash-can\"></i></a></div>";
                        }
                        echo "</div>";
                        }
                    } else {
                        echo "This user has not posted yet...";
                    }
                    $prstmt->close();
                } catch (mysqli_sql_exception $e){
                    $code = $e->getCode();
                    echo "Failed to load user's posts. Error: $code";
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