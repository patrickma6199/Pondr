<?php
session_start();
require_once '../scripts/dbconfig.php'; 
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
ini_set('display_errors', 1);

// check if user is logged in
$uid = $_SESSION['uid'] ?? null;
if (!$uid) {
    $_SESSION['message'] = "You must be logged in to create a category.";
    header("Location: login.php"); 
    exit;
}

$categoryName = $_POST['categoryName'] ?? null;

// create category if form is submitted
if ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($categoryName)) {
    //check for duplicate category
    $checkSql = "SELECT * FROM categories WHERE name = ?";
    $stmt = $conn->prepare($checkSql);
    $stmt->bind_param("s", $categoryName);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $_SESSION['message'] = "Category already exists.";
    } else {
        $sql = "INSERT INTO categories (userId, name) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $uid, $categoryName);
    
        try {
            $stmt->execute();
            $_SESSION['message'] = "Category created successfully.";
        } catch (mysqli_sql_exception $e) {
            $_SESSION['message'] = "Error creating category: " . $e->getMessage();
        }
    }
    $stmt->close();
    header("Location: create_category.php"); //redirect back to the category page
    exit;
}

$conn->close();


$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Category - Pondr</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/form.css">
</head>
<body>
    <?php require_once '../scripts/header.php'; ?>
    <main class="center-container">
    <h2>Create New Category</h2>
    <?php if (!empty($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    <form method="post" action="">
        <label for="categoryName">Category Name:</label>
        <input type="text" id="categoryName" name="categoryName" required>
        <button type="submit">Create Category</button>
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
</body>
</html>
