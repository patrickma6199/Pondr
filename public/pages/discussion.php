<?php
session_start();
require_once '../scripts/dbconfig.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$utype = $_SESSION["utype"];
$uid = $_SESSION["uid"];

if (isset($_GET["search"])) {
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
            <h3>Filter by Category: </h3>
            <ul>
                <?php
                $sql = "SELECT catId, name FROM categories ORDER BY count DESC LIMIT 10;";       // for listing top 10 categories to search under
                $prstmt = $conn->prepare($sql);
                try {
                    $prstmt->execute();
                    $prstmt->bind_result($catId,$catName);
                    if ($prstmt->fetch()) {
                        echo (isset($search)) ? "<li><a href=\"./discussion.php?catId=$catId&search=$search\">$catName</a></li>" : "<li><a href=\"./discussion.php?catId=$catId\">$catName</a></li>";
                        while ($prstmt->fetch()) {
                            echo "<li><a href=\"./discussion.php?catId=$catId\">$catName</a></li>";
                        }
                    } else {
                        echo "<p>No Categories have been made yet! make some.</p>";
                    }
                    $prstmt->close();
                } catch(mysqli_sql_exception $e) {
                    echo "<p>Error occurred: pulling categories.</p>";
                }
                $conn->close();
                ?>
            </ul>
        </section>

        <section class="discussion-container">
            <div class="mini-thread">
                <?php
                
                ?>
                <article>
                    <a href="./thread.php"><h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h2></a>
                    <i>Posted by: username on <time>January 1, 1970</time></i>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae nunc sed nisl finibus imperdiet. Phasellus est tellus, sagittis quis tortor a, interdum congue massa. Praesent vitae varius nunc, sed ornar e arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                </article>
                <img src="../img/cat.jpg">
            </div>
        </section>
    </main>
</body>
</html>