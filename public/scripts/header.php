<?php
    session_start();
    require_once 'dbconfig.php';
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $utype = $_SESSION["utype"];
?>

<nav id="top-bar">
    <a href="./index.php"><img src="../img/logo.png" alt="Pondr Logo" id="top-bar-logo"></a>
    <div id="top-search-bar">
        <form method="GET" action="discussion.php">
            <input type="text" name="search" placeholder="Search for Users and Threads" />
            <button type="submit" class="form-button">Search</button>
        </form>
    </div>
    <?php
        if (isset($utype)) {
            switch ($utype) {
                case 0:
                case 1:
                    echo "<a href=\"profile.php\"><img src=\"../img/pfp-3.jpg\" id=\"top-search-bar-pfp\"></a>";
                    echo "<a href=\"./logout.php\" class=\"link-button\">Logout</a>";
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