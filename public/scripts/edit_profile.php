<?php
require_once ('dbconfig.php');
session_start();
ini_set('display_errors', 1);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (isset ($_SESSION['uid'])) {
    $uid = $_SESSION['uid'];
    $updatesMade = false; 
} else {
    exit(header("Location: ../index.php")); 
}
// Handle file upload and set $newImgName if a new image is uploaded
$conn->begin_transaction();
try {
    if (isset ($_FILES['pfp'])) {
        if ($_FILES['pfp']['error'] == UPLOAD_ERR_OK) {
            $validExt = array("jpg", "jpeg", "png");
            $validMime = array("image/jpeg", "image/png");
            $filenameArray = explode(".", $_FILES['pfp']['name']);
            $extension = end($filenameArray);
            if (in_array($_FILES['pfp']['type'], $validMime) && in_array($extension, $validExt)) {
                if ($_FILES['pfp']['size'] <= 10485760) { 
                    $sql = "SELECT uName, pfp FROM users WHERE userId = ?;";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $uid);
                    $stmt->execute();
                    $stmt->bind_result($username, $oldPfp);
                    if ($stmt->fetch()) {
                        $pfp = "../img/pfps/$username." . $extension;
                        if ($oldPfp == "../img/pfps/pfp.png") {
                            $defaultPfp = true;
                        } else {
                            $defaultPfp = false;
                        }
                    } else {
                        $_SESSION['editMessage'] = "<p>There is no user with your user id. No changes have been made.</p>";
                        $conn->rollback();
                        $conn->close();
                        exit (header("Location: ../pages/my_profile_edit.php"));
                    }
                    $stmt->close();
                } else {
                    $_SESSION['editMessage'] = "<p>Your profile photo must be a maximum of 10MB in size. No changes have been made.</p>";
                    $conn->rollback();
                    $conn->close();
                    exit (header("Location: ../pages/my_profile_edit.php"));
                }
            } else {
                $_SESSION['editMessage'] = "<p>Your profile photo needs to be in jpeg or png format. No changes have been made.</p>";
                $conn->rollback();
                $conn->close();
                exit (header("Location: ../pages/my_profile_edit.php"));
            }
        } else {
            if ($_FILES['pfp']['error'] == UPLOAD_ERR_FORM_SIZE) {
                $_SESSION['editMessage'] = "<p>Your profile photo must be a maximum of 10MB in size. No changes have been made.</p>";
                $conn->rollback();
                $conn->close();
                exit (header("Location: ../pages/my_profile_edit.php"));
            } else if ($_FILES['pfp']['error'] != UPLOAD_ERR_NO_FILE) { 
                $_SESSION['editMessage'] = "<p>An error occured while trying to retrieve the profile photo from your submission. No changes have been made.</p>";
                $conn->rollback();
                $conn->close();
                exit (header("Location: ../pages/my_profile_edit.php"));
            }
        }
    }
} catch (Exception $e) {
    $_SESSION['registerMessage'] = "<p>An error occured while updating your profile photo. No changes have been made.</p>";
    if (isset ($stmt)) {
        $stmt->close();
        unset($stmt);
    }
    $conn->rollback();
    $conn->close();
    exit (header("Location: ../pages/my_profile_edit.php"));
}

if (isset($pfp)) {
    try {
        $sql = "UPDATE users SET pfp = ? WHERE userId = ?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $pfp, $uid);
        $stmt->execute();

        $original = $_FILES['pfp']['tmp_name'];
        if (extension_loaded('gd')) {
            // resizing and saving image (getting to this portion of the code means that the post image was of valid size and type)
            $original = $_FILES['pfp']['tmp_name'];
            $oSize = getimagesize($original);
            if (!$oSize) {
                throw new Exception("Failed to get image size.");
            }
            $oWidth = $oSize[0];
            $oHeight = $oSize[1];
            $resizeDim = 960; 

            if ($extension == "jpeg" || $extension == "jpg") {
                $oImage = imagecreatefromjpeg($original);
                if (!$oImage) {
                    throw new Exception("Failed to create JPEG image from file.");
                }
            } else { 
                $oImage = imagecreatefrompng($original);
                if (!$oImage) {
                    throw new Exception("Failed to create PNG image from file.");
                }
            }

            $rImage = imagecreatetruecolor($resizeDim, $resizeDim);
            if (!$rImage) {
                throw new Exception("Failed to create truecolor image.");
            }

            if (!imagecopyresampled($rImage, $oImage, 0, 0, 0, 0, $resizeDim, $resizeDim, $oWidth, $oHeight)) {
                throw new Exception("Failed to resample image.");
            }
            if(!$defaultPfp){
                if (!unlink($oldPfp)) {
                    throw new Exception("Failed to delete old pfp.");
                }
            }

            if ($extension == "jpeg" || $extension == "jpg") {
                if (!imagejpeg($rImage, $pfp)) {
                    throw new Exception("Failed to save JPEG image.");
                }
            } else { 
                imagealphablending($rImage, false);
                imagesavealpha($rImage, true);
                if (!imagepng($rImage, $pfp)) {
                    throw new Exception("Failed to save PNG image.");
                }
            }
        } else {
            if (!unlink($oldPfp)) {
                throw new Exception("Failed to delete old pfp.");
            }
            if (!move_uploaded_file($_FILES['post_image']['tmp_name'], $pfp)) {
                throw new Exception("Failed to move uploaded file.");
            }
        }
        $updatesMade = true;
    } catch (Exception $e) {
        $conn->rollback();
        $conn->close();
        $_SESSION['registerMessage'] = "<p>An error occurred while updating your profile photo. No changes have been made.</p>";
        exit (header("Location: ../pages/my_profile_edit.php"));
        
    }
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
    $_SESSION['editMessage'] = "<p>Error => First Name error occurred errorMessage => " . htmlspecialchars($e->getMessage()) . ". No changes have been made.</p>";
    $conn->rollback();
    $conn->close();
    if (isset ($stmt)) {
        $stmt->close();
        unset($stmt);

    }
    exit (header("Location: ../pages/my_profile_edit.php"));
} catch (Exception $e) {
    $_SESSION['editMessage'] = "<p>Error => First Name error occurred errorMessage => " . htmlspecialchars($e->getMessage()) . ". No changes have been made.</p>";
    $conn->rollback();
    $conn->close();
    if (isset ($stmt)) {
        $stmt->close();
        unset($stmt);
    }
    exit (header("Location: ../pages/my_profile_edit.php"));
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
    $_SESSION['editMessage'] = "<p>Error => Last Name error occurred errorMessage => " . htmlspecialchars($e->getMessage()) . ". No changes have been made.</p>";
    $conn->rollback();
    $conn->close();
    if (isset ($stmt)) {
        $stmt->close();
        unset($stmt);
    }
    exit (header("Location: ../pages/my_profile_edit.php"));
} catch (Exception $e) {
    $_SESSION['editMessage'] = "<p>Error => Last Name error occurred errorMessage => " . htmlspecialchars($e->getMessage()) . ". No changes have been made.</p>";
    $conn->rollback();
    $conn->close();
    if (isset ($stmt)) {
        $stmt->close();
        unset($stmt);
    }
    exit (header("Location: ../pages/my_profile_edit.php"));
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
    $_SESSION['editMessage'] = "<p>Error => Bio error occurred errorMessage => " . htmlspecialchars($e->getMessage()) . ". No changes have been made.</p>";
    $conn->rollback();
    $conn->close();
    if (isset ($stmt)) {
        $stmt->close();
        unset($stmt);
    }
    exit (header("Location: ../pages/my_profile_edit.php"));
} catch (Exception $e) {
    $_SESSION['editMessage'] = "<p>Error => Bio error occurred errorMessage => " . htmlspecialchars($e->getMessage()) . ". No changes have been made.</p>";
    $conn->rollback();
    $conn->close();
    if (isset ($stmt)) {
        $stmt->close();
        unset($stmt);
    }
    exit (header("Location: ../pages/my_profile_edit.php"));
}

$conn->commit();
$conn->close();

if ($updatesMade) {
    exit( header('Location: ../pages/my_profile.php'));
} else {
    $_SESSION['editMessage'] = "<p>No changes were made.</p>";
    exit(header('Location: ../pages/my_profile_edit.php'));
}
?>