<?php require_once '../scripts/creating_category.php'; 

if (!isset ($_SESSION['uid'])) {
    exit (header("Location: ../index.php"));
}
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
                $sql = "SELECT name FROM categories";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<li>" . htmlspecialchars($row['name']) . "</li>";
                    }
                } else {
                    echo "<li>No categories found</li>";
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

