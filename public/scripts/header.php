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
            case 1:
                echo "<a href=\"my_profile.php\"><img src=\"$pfpPath\" id=\"top-search-bar-pfp\"></a>";
                echo "<a href=\"../scripts/logout.php\" class=\"link-button\">Logout</a>";
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
    
echo '<ul class="breadcrumb">';
$path = $_SERVER["PHP_SELF"];
$parts = explode('/', $path);


$pages = array_search('pages', $parts);
$isHomePage = (end($parts) === 'landing.php');
if ($isHomePage) {
    echo '<li class="breadcrumb-item">Home</li>'; 
} else {
    echo '<li class="breadcrumb-item"><a href="/Pondr/public/pages/landing.php">Home</a></li>';
}


for ($i = $pages + 1; $i < count($parts); $i++) {
    if (!strstr($parts[$i], ".")) {
        
        $url = "";
        for ($j = 0; $j <= $i; $j++) {
            $url .= $parts[$j] . "/";
        }
        echo "<li class=\"breadcrumb-item\"><a href=\"/ $url\"> $parts[$i] </a></li>";
    } else {
        // For files
        $str = $parts[$i];
        $pos = strrpos($str, ".");
        $parts[$i] = substr($str, 0, $pos);
        if ($i === count($parts) - 1) {
            // No link for the last breadcrumb
            echo "<li class=\"breadcrumb-item\"> $parts[$i]  </li>";
        } else {
            $url = "";
            for ($j = 0; $j <= $i; $j++) {
                $url .= $parts[$j] . "/";
            }
            echo "<li class=\"breadcrumb-item\"><a href=\"/ $url \"> $parts[$i] </a></li>";
        }
    }
}
echo '</ul>';
?>

   
