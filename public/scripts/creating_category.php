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

$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);
?>
