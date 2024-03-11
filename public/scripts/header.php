<?php

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

require_once 'dbconfig.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$catId = (isset($_GET['catId'])) ? $_GET['catId'] : null;

    $utype = $_SESSION["utype"];
?>

<nav id="top-bar">
    <a href="./discussion.php"><img src="../img/logo.png" alt="Pondr Logo" id="top-bar-logo"></a>
    <div id="top-search-bar">
        <form method="GET" action="discussion.php">
            <?php
            if (isset($_GET['catId'])) {
                echo "<input type=\"hidden\" name=\"catId\" value=\"$catId\">";                     //if category was selected, send category into get request to discussion.php
            }
            echo "<input type=\"text\" name=\"search\" placeholder=\"Search for Users and Threads\" value=\"" . ((isset($search)) ? $search : "") . "\"/>";
            ?>
            <button type="submit" class="form-button">Search</button>
        </form>
    </div>
    <?php
        if (isset($utype)) {
            switch ($utype) {
                case 0:
                case 1:
                    echo "<a href=\"profile.php\"><img src=\"../img/pfp-3.jpg\" id=\"top-search-bar-pfp\"></a>";
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