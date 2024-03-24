<?php
require_once('dbconfig.php'); // Ensure this file sets up $conn properly
session_start();
ini_set('display_errors', 1);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (isset($_SESSION['uid'])) {
    $uid = $_SESSION['uid'];
    $updatesMade = false; // Flag to check if any updates were made

    

    // Handle file upload and set $newImgName if a new image is uploaded
    $newImgName = ''; 
    if (isset($_FILES['img']) && $_FILES['img']['error'] == UPLOAD_ERR_OK) {
        $imgName = $_FILES['img']['name'];
        $imgTmpName = $_FILES['img']['tmp_name'];
        $imgSize = $_FILES['img']['size'];
        $imgError = $_FILES['img']['error'];
        $imgType = $_FILES['img']['type'];

        $imgExtension = strtolower(end(explode('.', $imgName)));
        $allowed = array('jpg', 'jpeg', 'png', 'gif');

        if (in_array($imgExtension, $allowed)) {
            $newImgName = uniqid('', true) . '.' . $imgExtension;
            $imgDestination = '../uploads/' . $newImgName;

            if (move_uploaded_file($imgTmpName, $imgDestination)) {
                $updatesMade = true; // Image uploaded, set flag to true
            } else {
                echo "Error uploading the file.";
                exit; // Exit if file upload fails
            }
        } else {
            echo "File type not allowed.";
            exit; // Exit if file type is not allowed
        }
    }

    // Update firstName if provided
    if (!empty($_POST['firstName'])) {
        $sql = "UPDATE users SET fName=? WHERE userId=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $_POST['firstName'], $uid);
        $stmt->execute();
        $stmt->close();
        $updatesMade = true;
    }

    // Update lastName if provided
    if (!empty($_POST['lastName'])) {
        $sql = "UPDATE users SET lName=? WHERE userId=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $_POST['lastName'], $uid);
        $stmt->execute();
        $stmt->close();
        $updatesMade = true;
    }

    // Update bio if provided
    if (!empty($_POST['bio'])) {
        $sql = "UPDATE users SET bio=? WHERE userId=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $_POST['bio'], $uid);
        $stmt->execute();
        $stmt->close();
        $updatesMade = true;
    }

    // Update uName if provided
    if (!empty($_POST['uName'])) {
        $sql = "UPDATE users SET uName=? WHERE userId=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $_POST['uName'], $uid);
        $stmt->execute();
        $stmt->close();
        $updatesMade = true;
    }

    // Update the profile picture if a new image was uploaded
    if (!empty($newImgName)) {
        $sql = "UPDATE users SET pfp=? WHERE userId=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $newImgName, $uid);
        $stmt->execute();
        $stmt->close();
    }

    // Redirect only once after attempting all updates
    if ($updatesMade) {
        header('Location: ../pages/my_profile.php'); // Adjust the path as needed
        exit();
    } else {
        // Optional: Handle the case where no updates were made
        echo 'No updates were provided or changes made.';
        header('Location: ../pages/my_profile.php'); // Redirect back to the edit profile page or another appropriate page
        exit();
    }
} else {
    echo 'User ID not set.';
    // Redirect to the login page or another appropriate action
     header('Location: ../pages/my_profile.php');// Adjust as necessary
    exit();
}
?>
