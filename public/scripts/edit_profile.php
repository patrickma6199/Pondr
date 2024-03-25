<?php
require_once ('dbconfig.php'); // Ensure this file sets up $conn properly
session_start();
ini_set('display_errors', 1);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    if (isset ($_SESSION['uid'])) {
        $uid = $_SESSION['uid'];
        $updatesMade = false; // Flag to check if any updates were made
    }



    // Handle file upload and set $newImgName if a new image is uploaded

    $newImgName = '';
    try {
        if (isset ($_FILES['img']) && $_FILES['img']['error'] == UPLOAD_ERR_OK) {
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
    } catch (mysqli_sql_exception $e) {
       $_SESSION['editMessage'] = "<p>Error => IMAGE UPDATE error occurred errorMessage => " . htmlspecialchars($e->getMessage()) . "</p>";

    } catch (Exception $e) {
        $_SESSION['editMessage'] = "<p>Error => Database error occurred errorMessage => " . htmlspecialchars($e->getMessage()) . "</p>";
    }


    try{
    if (!empty ($_POST['firstName'])) {
        $sql = "UPDATE users SET fName=? WHERE userId=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $_POST['firstName'], $uid);
        $stmt->execute();
        $stmt->close();
        $updatesMade = true;
    }
    }catch (mysqli_sql_exception $e) {
      $_SESSION['editMessage'] = "<p>Error => First Name error occurred errorMessage => " . htmlspecialchars($e->getMessage()) . "</p>";
      if (isset ($stmt)) {
                $stmt->close();
            }
    } catch (Exception $e) {
       $_SESSION['editMessage'] = "<p>Error => First Name error occurred errorMessage => " . htmlspecialchars($e->getMessage()) . "</p>";
        if (isset ($stmt)) {
                $stmt->close();
            }
    }

    try{
    if (!empty ($_POST['lastName'])) {
        $sql = "UPDATE users SET lName=? WHERE userId=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $_POST['lastName'], $uid);
        $stmt->execute();
        $stmt->close();
        $updatesMade = true;
    }
    } catch (mysqli_sql_exception $e) {
        $_SESSION['editMessage'] = "<p>Error => Last Name error occurred errorMessage => " . htmlspecialchars($e->getMessage()) . "</p>";
         if (isset ($stmt)) {
                $stmt->close();
            }
    } catch (Exception $e) {
        $_SESSION['editMessage'] = "<p>Error => Last Name error occurred errorMessage => " . htmlspecialchars($e->getMessage()) . "</p>";
         if (isset ($stmt)) {
                $stmt->close();
            }
    }

    try{
    if (!empty ($_POST['bio'])) {
        $sql = "UPDATE users SET bio=? WHERE userId=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $_POST['bio'], $uid);
        $stmt->execute();
        $stmt->close();
        $updatesMade = true;
    }
    }catch (mysqli_sql_exception $e) {
         $_SESSION['editMessage'] = "<p>Error => Bio error occurred errorMessage => " . htmlspecialchars($e->getMessage()) . "</p>";
          if (isset ($stmt)) {
                $stmt->close();
            }

    } catch (Exception $e) {
        $_SESSION['editMessage'] = "<p>Error => Bio Name error occurred errorMessage => " . htmlspecialchars($e->getMessage()) . "</p>";
         if (isset ($stmt)) {
                $stmt->close();
            }
    }

    try{
    if (!empty ($_POST['uName'])) {
        $sql = "UPDATE users SET uName=? WHERE userId=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $_POST['uName'], $uid);
        $stmt->execute();
        $stmt->close();
        $updatesMade = true;
    }
    }catch (mysqli_sql_exception $e) {
        $_SESSION['editMessage'] = "<p>Error => UNAME UPDATEerror occurred errorMessage => " . htmlspecialchars($e->getMessage()) . "</p>";
         if (isset ($stmt)) {
                $stmt->close();
            }

    } catch (Exception $e) {
        $_SESSION['editMessage'] = "<p>Error => UNAME UPDATEerror occurred errorMessage => " . htmlspecialchars($e->getMessage()) . "</p>";
         if (isset ($stmt)) {
                $stmt->close();
            }
    }

    try{
    if (!empty ($newImgName)) {
        $sql = "UPDATE users SET pfp=? WHERE userId=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $newImgName, $uid);
        $stmt->execute();
        $stmt->close();
    }
    }catch (mysqli_sql_exception $e) {
        $_SESSION['editMessage'] ="<p>error => Error updating profile picture errorMessage => $e </p>";
         if (isset ($stmt)) {
                $stmt->close();
            }

    } catch (Exception $e) {
      $_SESSION['editMessage'] ="<p>error => Error updating profile picture errorMessage => $e </p>";
       if (isset ($stmt)) {
                $stmt->close();
            }
    }

    // Redirect only once after attempting all updates
    if ($updatesMade) {
         $_SESSION['editMessage'] ="<p>UPDATES ARE A SUCCESSS</p>";
       exit( header('Location: ../pages/my_profile.php')); // Adjust the path as needed
      
        
    } else {
        // Optional: Handle the case where no updates were made
        echo 'No updates were provided or changes made.';
        exit(header('Location: ../pages/my_profile.php')); // Redirect back to the edit profile page or another appropriate page
        
    }
} catch (mysqli_sql_exception $e) {
   $_SESSION['editMessage'] ="<p>error => UID UPDATE errorMessage => $e </p>";
   
} catch (Exception $e) {
   $_SESSION['editMessage'] ="<p>error => UID UPDATE errorMessage => $e </p>";
}


?>