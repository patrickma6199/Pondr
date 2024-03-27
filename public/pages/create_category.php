<?php
session_start();
if (!isset($_SESSION['uid'])) {
    exit(header("Location: ../index.php"));
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
    <link rel="icon" href="../img/logo.png">
    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../js/char_count_category.js"></script>
    
</head>
<body>
    <?php require_once '../scripts/header.php'; ?>
    <main class="center-container">
        <section class="form-container" style="width: 50%;">
            <?php if (!empty($message)): ?>
                <p><?php echo $message; ?></p>
            <?php endif; ?>
            <form method="post" action="">
                <legend>Create New Category</legend>
                <div class="form-item">
                    <label for="categoryName">Category Name:</label>
                    <input type="text" placeholder="Enter your Category Name" id="categoryName" name="categoryName" required>
                </div>
                <div class="form-item">
                    <label for="categoryDescription">Description:</label>
                    <textarea id="categoryDescription" placeholder="Enter a short description!" name="categoryDescription" rows="4" cols="50" required></textarea>
                    <div id="char-count">
                            <span id="curr">0</span>
                            <span id="max">255</span>
                        </div>
                    </div>
                </div>
                <div class="form-item">
                    <button type="submit" class="form-button">Create Category</button>
                    <button type="Reset" class="form-button">Reset</button>
                </div>
            </form>
        </section>
    </main>
    <?php
        $conn->close();
    ?>
</body>
</html>

