<?php
session_start();
require_once '../scripts/dbconfig.php'; 
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
ini_set('display_errors', 1);

// check if user is logged in
$uid = $_SESSION['uid'] ?? null;
if (!$uid) {
    $_SESSION['loginMessage'] = "You must be logged in to create a category.";
    header("Location: login.php"); 
    exit;
}

$categoryName = $_POST['categoryName'] ?? null;

// create category if form is submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset ($categoryName) && !empty ($categoryName)) {
        //check for duplicate category
        $checkSql = "SELECT * FROM categories WHERE name = ?";
        try {
            $stmt = $conn->prepare($checkSql);
            $stmt->bind_param("s", $categoryName);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            if ($result->num_rows > 0) {
                $_SESSION['message'] = "Category already exists.";
            } else {
                $sql = "INSERT INTO categories (userId, name) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("is", $uid, $categoryName);
                $stmt->execute();
                $_SESSION['message'] = "Category created successfully.";
                $stmt->close();
            }
        } catch (mysqli_sql_exception $e) {
            $_SESSION['message'] = "Error creating category: " . $e->getMessage();
            if (isset ($stmt)) {
                $stmt->close();
            }
        }
        $conn->close();
        exit (header("Location: create_category.php")); //redirect back to the category page
    } else {
        $_SESSION['message'] = "Category Name not Provided.";
        $conn->close();
        exit (header("Location: create_category.php")); 
    }
} else {
    $conn->close();
    exit (header("Location: ../index.php"));
}
?>
