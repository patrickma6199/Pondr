<?php require_once '../scripts/creating_category.php'; 

if (!isset ($_SESSION['uid'])) {
    exit (header("Location: ../index.php"));
}
$pageTitle = "IGNORE";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Category - Pondr</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/form.css">
    <script src="../js/char_count_category.js"></script>
    
</head>
<body>
    <?php require_once '../scripts/header.php'; ?>
    <main class="form-container center-container">
        <h2>Create New Category</h2>
        <?php if (!empty($message)): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
        <form method="post" action="">
            <div class="form-item">
                <label for="categoryName">Category Name:</label>
                <input type="text" placeholder="Enter your Category Name" id="categoryName" name="categoryName" required>
            </div>
            <div class="form-item">
                <label for="categoryDescription">Description:</label>
                <textarea id="categoryDescription" placeholder="Enter a short description!" name="categoryDescription" rows="4" required></textarea>
                <div id="char-count">
                        <span id="curr">0</span>
                        <span id="max">255</span>
                    </div>
                </div>
            </div>
            <button type="submit" class="submit-button">Create Category</button>
        </form>
        <section>
            <h3>Existing Categories</h3>
            <ul>
            <?php
                $sql = "SELECT catId, name FROM categories ORDER BY count DESC LIMIT 10;";       // for listing top 10 categories to search under
                $prstmt = $conn->prepare($sql);
                try {
                    $prstmt->execute();
                    $prstmt->bind_result($catListId,$catName);
                    if ($prstmt->fetch()) {
                        echo (isset($search)) ? "<li><a href=\"./discussion.php?catId=$catListId&search=$search\">$catName</a></li>" : "<li><a href=\"./discussion.php?catId=$catListId\">$catName</a></li>";
                        while ($prstmt->fetch()) {
                            echo (isset ($search)) ? "<li><a href=\"./discussion.php?catId=$catListId&search=$search\">$catName</a></li>" : "<li><a href=\"./discussion.php?catId=$catListId\">$catName</a></li>";
                        }
                        echo (isset ($search)) ? "<li><a href=\"./discussion.php?search=$search\">Clear Filter</a></li>" : "<li><a href=\"./discussion.php\">Clear Category</a></li>";
                    } else {
                        echo "<p>No Categories have been made yet! Try making one now!</p>";
                    }
                    $prstmt->close();
                } catch(mysqli_sql_exception $e) {
                    $code = $e->getCode();
                    echo "<p>Error occurred: pulling categories. Error: $code</p>";
                }
                ?>
            </ul>
        </section>
    </main>
    <?php
        $conn->close();
    ?>
</body>
</html>

