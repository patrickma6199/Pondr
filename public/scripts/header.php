<?php
ini_set('display_errors', 1);
if (!isset ($_SESSION)) {
    session_start();
}

require_once 'dbconfig.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$catId = (isset ($_GET['catId'])) ? $_GET['catId'] : null;

$utype = $_SESSION['utype'] ?? null;
$uid = $_SESSION['uid'] ?? null;
?>


<nav id="top-bar">
    <script src="../js/jquery-3.1.1.min.js"></script>
    <link rel="stylesheet" href="../css/styles.css">

    <script>
        $(document).ready(function () {
            // Toggle dropdown on profile picture click
            $("#top-search-bar-pfp").click(function (event) {
                event.preventDefault(); // Prevent click from immediately propagating to the window
                $(".dropdown-content").toggle("show");
            });
        });
    </script>

    <a href="../index.php"><img src="../img/logo.png" alt="Pondr Logo" id="top-bar-logo"></a>
    <div id="top-search-bar">
        <form method="GET" action="discussion.php">
            <?php
            if (isset ($_GET['catId'])) {
                echo "<input type=\"hidden\" name=\"catId\" value=\"$catId\">";    //if category was selected, send category into get request to discussion.php
            }
            echo "<input type=\"text\" name=\"search\" placeholder=\"Search for Users and Threads\" value=\"" . ((isset ($search)) ? $search : "") . "\"/>";
            ?>
            <button type="submit" class="form-button">Search</button>
        </form>
    </div>
    <?php
    if (isset ($_SESSION['uid'])) {
        $sql = "SELECT pfp FROM users WHERE userid = ?;";

        $prstmt = $conn->prepare($sql);
        $prstmt->bind_param('s', $uid);
        try {
            $prstmt->execute();
            $prstmt->bind_result($pfpPath);
            if (!$prstmt->fetch()) { // if user's profile image is not set
                echo "ERROR: user does not have a profile image set.";
            }
        } catch (mysqli_sql_exception $e) {
            $pfpPath = "../img/pfp.png";    // if error occurs, use default image
        } finally {
            $prstmt->close();
        }
    }

    if (isset ($utype)) {
        switch ($utype) {
            case 0:
                echo "<div id=\"dropdown\">";
                echo "<a href=\"\"><img src=\"$pfpPath\" id=\"top-search-bar-pfp\"></a>";
                echo "<div id=\"dropdown-menu\" class=\"dropdown-content\">";
                echo "<a href=\"../pages/new_post.php\">New Post</a>";
                echo "<a href=\"../pages/create_category.php\">New Categories</a>";
                echo "<a href=\"../pages/my_profile.php\">My Profile</a>";
                echo "<a href=\"../pages/my_profile_edit.php\">Edit Profile</a>";
                echo "<a href=\"../scripts/logout.php\">Logout</a>";
                echo "</div>";
                echo "</div>";
                break;
            case 1:
                echo "<div id=\"dropdown\">";
                echo "<a href=\"\"><img src=\"$pfpPath\" id=\"top-search-bar-pfp\"></a>";
                echo "<div id=\"dropdown-menu\" class=\"dropdown-content\">";
                echo "<a href=\"../pages/admin.php\">Admin Dashboard</a>";
                echo "<a href=\"../pages/new_post.php\">New Post</a>";
                echo "<a href=\"../pages/create_category.php\">New Categories</a>";
                echo "<a href=\"../pages/my_profile.php\">My Profile</a>";
                echo "<a href=\"../pages/my_profile_edit.php\">Edit Profile</a>";
                echo "<a href=\"../scripts/logout.php\">Logout</a>";
                echo "</div>";
                echo "</div>";
                break;
            default:
                echo "<a href=\"login.php\" class=\"link-button\">Login</a>";
                echo "<a href=\"register.php\" class=\"link-button\">Sign Up</a>";
        }
    } else {
        echo "<a href=\"login.php\" class=\"link-button\">Login</a>";
        echo "<a href=\"register.php\" class=\"link-button\">Sign Up</a>";

    }
    ?>

</nav>

<?php
// for breadcrumbs
if (!isset ($_SESSION['bc_title'])) { //REMOVE means restart the breadcrumbs
    $_SESSION['bc_title'] = ['Home'];
    $_SESSION['bc_link'] = ['./landing.php'];
}

if ($pageTitle != "IGNORE") {
    echo '<ul class="breadcrumb">';
    $lastIndex = array_search($pageTitle, array_reverse($_SESSION['bc_title'], true));
    if ($lastIndex !== false) {
        $_SESSION['bc_title'] = array_slice($_SESSION['bc_title'], 0, $lastIndex + 1);
        $_SESSION['bc_link'] = array_slice($_SESSION['bc_link'], 0, $lastIndex + 1);
    } else {
        array_push($_SESSION['bc_title'],$pageTitle);
        array_push($_SESSION['bc_link'],$_SERVER['REQUEST_URI']);
    }

    for($i = 0; $i < count($_SESSION['bc_title']); $i++) {
        if ($i > 0) {
            echo '<span>&nbsp;&gt;&nbsp;</span>';
        }
        $title = $_SESSION['bc_title'][$i];
        $link = $_SESSION['bc_link'][$i];
        echo "<li><a href=\"$link\">$title</a></li>";
    }

    echo '</ul>';
}
?>

