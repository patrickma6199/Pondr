<?php
session_start();
ini_set('display_errors', 1);
require_once './dbconfig.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$utype = isset ($_SESSION['utype']) ?? null;


if ($utype == '1') { //  '1' = admin user
    if (isset($_POST['postId'])) {
        $postId = $_POST['postId'];

        // SQL to delete post
        $sql = "DELETE FROM posts WHERE postId = ?;";
        $prstmt = $conn->prepare($sql);
        $prstmt->bind_param("s", $postId);

        try {
            $prstmt->execute();
            $_SESSION['deletePostMessage'] = "<p>Post successfully deleted!</p>";
        } catch (mysqli_sql_exception $e) {
            $_SESSION['deletePostMessage'] = "<p>An error occurred while trying to delete the post. Please try again.</p>";
        }

        $prstmt->close();
        $conn->close();
        exit(header('Location: ../pages/admin.php')); // redirect to admin dashboard page
    } else {
        $_SESSION['deletePostMessage'] = "<p>Invalid request. No post specified for deletion.</p>";
        exit(header('Location: ../pages/admin.php'));
    }
} else {
    // redirect normal users
    $_SESSION['deletePostMessage'] = "<p>You do not have permission to perform this action.</p>";
    exit(header('Location: ../index.php'));
}
?>
