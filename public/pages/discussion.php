<?php
session_start();
require_once '../scripts/dbconfig.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
ini_set('display_errors', 1);

$uid = $_SESSION['uid'] ?? null;

if (isset ($_GET["search"])) {              
    if ($_GET["search"] == "") {
        unset($_GET["search"]);
    }
}

if (isset ($_GET["catName"])) {              
    if ($_GET["catName"] == "") {
        unset($_GET["catName"]);
    }
}

function truncateUName($uName) {
    if (strlen($uName) > 20) {
        $uName = substr($uName, 0, 17) . "...";
    }
    return $uName;
}

$search = $_GET['search'] ?? null;
$catName = $_GET['catName'] ?? null;

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
        <script src="https://kit.fontawesome.com/cfd53e539d.js" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function () {
                let post_success = $('#post-success');

                setTimeout(function () {
                    post_success.fadeOut();
                }, 5000);

                $(".profile").on('click', function() {
                    let userId = $(this).data('userid');
                    let uid = $(this).data('uid');
                    let uName = $(this).data('uname');
                    if(userId == uid) window.location.href = "./my_profile.php";
                    else window.location.href = `./profile.php?uName=${uName}`;
                });
            });
        </script>
    </head>

    <body>
        <?php require_once '../scripts/header.php';   ?>
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
                if (isset ($uid)) {
                    echo "<a href=\"./new_post.php\"><h3>New Pond</h3></a>";
                    echo "<br> ";
                }
                echo "<a href=\"./explore.php\"><h3>Explore</h3></a>";
                ?>
            </section>

            <section class="discussion-container">
                <?php
                $searchString = (isset ($search)) ? $search : "";
                $catNameString = (isset($catName)) ? $catName : "";
                // for listing matching users by displaying profile in a block
                try{
                    $sql = "SELECT uName, fName, lName, pfp, userId, utype FROM users WHERE CASE WHEN ? = \"\" THEN FALSE ELSE uName LIKE CONCAT('%', ?, '%') OR fName LIKE CONCAT('%', ?, '%') OR lName LIKE CONCAT('%', ? , '%') OR CONCAT(fName,' ',lName) LIKE CONCAT('%',?,'%') END;";
                    $prstmt = $conn->prepare($sql);
                    $prstmt->bind_param("sssss",$searchString, $searchString, $searchString, $searchString, $searchString);
                    $prstmt->execute();
                    $prstmt->bind_result($uName, $fName, $lName, $pfp, $userId, $userType);
                    if ($prstmt->fetch()) {
                        echo "<h2>Profiles</h2>";
                        $uName = truncateUName($uName);
                        echo "<div class=\"profiles-container\">";
                        echo "<div class=\"profile\" data-uname=\"{$uName}\" data-userid=\"{$userId}\" data-uid=\"{$uid}\"><img src=\"$pfp\" alt=\"$uName's Profile Photo\"><div class=\"profile-text\"><p>$uName" . ($userType == 1 ? "<span class=\"mod\"> [MOD]</span>" : "") . "</p><p>$fName $lName</p></div></div>";
                        while ($prstmt->fetch()) {
                            $uName = truncateUName($uName);
                            echo "<div class=\"profile\" data-uname=\"{$uName}\" data-userid=\"{$userId}\" data-uid=\"{$uid}\"><img src=\"$pfp\" alt=\"$uName's Profile Photo\"><div class=\"profile-text\"><p>$uName" . ($userType == 1 ? "<span class=\"mod\"> [MOD]</span>" : "") . "</p><p>$fName $lName</p></div></div>";
                        }
                        echo "</div>";
                    }
                    $prstmt->close();
                }catch(mysqli_sql_exception $e) {
                    $code = $e->getCode();
                    if(isset($prstmt)){
                        $prstmt->close();
                    }
                    echo "<p>Error while loading discussion posts. Try again. Error: $code</p>";
                }

                echo "<h2>Ponds</h2>";
                // Block for listing posts
                $highestPostId = 0;
                $sql = "SELECT p.postId, p.title, p.postDate, p.text, u.uName, c.name, p.img, c.catId, u.userId, u.utype, p.likes, p.comment
                FROM posts as p JOIN users as u ON p.userId = u.userId 
                LEFT OUTER JOIN categories as c ON p.catId = c.catId 
                WHERE (c.name LIKE CONCAT('%',?,'%') OR CASE WHEN ? = \"\" THEN c.name IS NULL ELSE FALSE END) AND (p.title LIKE CONCAT('%',?,'%') OR p.text LIKE CONCAT('%',?,'%') OR u.uName LIKE CONCAT('%',?,'%'))
                ORDER BY p.postDate DESC;";
                $prstmt = $conn->prepare($sql);
                
                $prstmt->bind_param("sssss", $catNameString, $catNameString, $searchString, $searchString, $searchString);
                try {
                    $prstmt->execute();
                    $prstmt->bind_result($postId, $title, $postDate, $text, $uName, $catName, $postImg, $catId, $userId, $userType, $likeCount, $comCount);
                    if ($prstmt->fetch()) {
                        echo "<div class=\"mini-thread\">";
                        echo "<article>";
                        echo "<a href=\"./thread.php?postId=$postId\"><h2>" . htmlspecialchars($title) . "</h2></a>";
                        if ($userType == 1) {
                            echo "<i>Posted by: " . ($userId == $uid ? "<a href=\"./my_profile.php\">" : "<a href=\"./profile.php?uName=$uName\">") . htmlspecialchars($uName) . "</a><span class=\"mod\"> [MOD]</span> on <time>$postDate</time>" . ((isset ($catId)) ? " under <a href=\"./discussion.php?catId=$catId\">" . htmlspecialchars($catName) . "</a>" : "") . "</i>";

                        }else{
                            echo "<i>Posted by: " . ($userId == $uid ? "<a href=\"./my_profile.php\">" : "<a href=\"./profile.php?uName=$uName\">") . htmlspecialchars($uName) . "</a> on <time>$postDate</time>" . ((isset ($catId)) ? " under <a href=\"./discussion.php?catId=$catId\">" . htmlspecialchars($catName) . "</a>" : "") . "</i>";
                        }
                        $text = nl2br($text);
                        echo "<p>$text</p>";
                        echo "<p style=\"margin-top:2em;\"><b><i class=\"fa-regular fa-heart\"></i></b> $likeCount   <b><i class=\"fa-solid fa-comment\"></i></b> $comCount</p>";
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
                                echo "<i>Posted by: " . ($userId == $uid ? "<a href=\"./my_profile.php\">" : "<a href=\"./profile.php?uName=$uName\">") . htmlspecialchars($uName) . "</a><span class=\"mod\"> [MOD]</span> on <time>$postDate</time>" . ((isset ($catId)) ? " under <a href=\"./discussion.php?catId=$catId\">" . htmlspecialchars($catName) . "</a>" : "") . "</i>";

                            }else{
                                echo "<i>Posted by: " . ($userId == $uid ? "<a href=\"./my_profile.php\">" : "<a href=\"./profile.php?uName=$uName\">") . htmlspecialchars($uName) . "</a> on <time>$postDate</time>" . ((isset ($catId)) ? " under <a href=\"./discussion.php?catId=$catId\">" . htmlspecialchars($catName) . "</a>" : "") . "</i>";
                            }
                            $text = nl2br($text);
                            echo "<p>$text</p>";
                            echo "<p style=\"margin-top:2em;\"><b><i class=\"fa-regular fa-heart\"></i></b> $likeCount   <b><i class=\"fa-solid fa-comment\"></i></b> $comCount</p>";
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
                        echo "<p>Looks like theres no posts under your search parameters... Be the first to post!</p>";
                    }
                    $prstmt->close();
                    //To be accessible in the load discussions js script to check when new posts are made.
                    echo "<script>";
                    echo "var lastPostId = $highestPostId;";
                    echo "</script>";
                } catch (mysqli_sql_exception $e) {
                    $code = $e->getCode();
                    if(isset($prstmt)){
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