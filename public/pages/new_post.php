<?php
session_start();
require_once '../scripts/dbconfig.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
ini_set('display_errors', 1);


if (!isset ($_SESSION['uid'])) {
    exit (header("Location: ../index.php"));
}
$pageTitle = "IGNORE";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Post</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="icon" href="../img/logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery-3.1.1.min.js"> </script>
    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../js/char_count.js"></script>
    <script src="../js/new_post_verification.js"></script>
</head>
<body>
    <?php require_once '../scripts/header.php';  ?>
    <main class="center-container">
        <section class="form-container" style="width: 60%;">
            <form action="../scripts/new_post_script.php" method="POST" enctype="multipart/form-data" id="post-form">
                <legend>New Post</legend>
                <?php
                if (isset ($_SESSION['newPostMessage'])) {
                    echo $_SESSION['newPostMessage'];
                    unset($_SESSION['newPostMessage']);
                }
                ?>
                <div class="form-item">
                    <label for="post_title">Post Title</label>
                    <input type="text" placeholder="Enter your Post Title" name="post_title" required>
                </div>
                <div class="form-item">
                    <label for="post_text">Post Text</label>
                    <textarea name="post_text" cols="30" rows="10" required placeholder="Enter Post Text Here"></textarea>
                    <div id="char-count">
                        <span id="curr">0</span>
                        <span id="max">3000</span>
                    </div>
                </div>
                <div class="form-item">
                    <label for="post_link">Any link? (Optional)</label>
                    <input type="text" name="post_link" placeholder="Enter Link Here"/>
                     <div class="error-message" id="error-postLink">URL is invalid. Please follow this format: https://AAAAAA.AAA/AAA/AAA/</div>
                </div>
                <div class="form-item">
                    <label for="post_image">Any Images to your post? (Optional)</label>
                    <!-- Max image size is 10MB -->
                    <input type="hidden" name="MAX_FILE_SIZE" value="10485760">
                    <input type="file" name="post_image" accept="image/*" >
                </div>
                <div class="form-item">
                    <label for="category">Choose a Category:</label>
                    <select name="category">
                        <option value="none">None</option>
                        <?php
                        $sql = "SELECT catId, name FROM categories;";
                        try{
                            $result = $conn->query($sql);
                            while($row = $result->fetch_assoc()) {
                                $catId = $row["catId"];
                                $name = $row["name"];
                                echo "<option value=\"$catId\">$name</option>";
                            }
                            $result->close();
                        } catch(mysqli_sql_exception $e) {
                            echo "<p>Error: loading categories</p>";
                        } finally {
                            $conn->close();
                        }

                        ?>
                        
                    </select>
                </div>
                <div class="form-item">
                    <button type="submit" class="form-button">Post</button>
                    <button type="reset" class="form-button">Reset</button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>