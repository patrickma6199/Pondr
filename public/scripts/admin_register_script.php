<?php
session_start();
ini_set('display_errors', 1);
require_once 'dbconfig.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$hashedMasterPassword = '$2y$10$TatMDSVNoez84Y0Stn0gPuudmXkXCUwYez2pQiuucsAy8OG5faGee'; 

if (isset($_SESSION['uid'])) {
    // If already logged in, redirect to the index page
    exit(header("Location: ../index.php"));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Extract form data
    $firstName = $_POST['firstName'] ?? null;
    $lastName = $_POST['lastName'] ?? null;
    $email = $_POST['email'] ?? null;
    $username = $_POST['username'] ?? null;
    $password = $_POST['password'] ?? null;
    $masterPassword = $_POST['master-password'] ?? null;

    // Verify required fields
    if (!$firstName || !$lastName || !$email || !$username || !$password || !$masterPassword) {
        $_SESSION['registerMessage'] = "<p>Missing required information to complete registration process.</p>";
        exit(header('Location: ../pages/admin_register.php'));
    }

    //Master password for admins
    //$masterPassword = '1738imlikeheywhatsupHello?';

    // Verify master password
    if (!password_verify($masterPassword, $hashedMasterPassword)) {
        $_SESSION['registerMessage'] = "<p>Invalid master password.</p>";
        exit(header('Location: ../pages/admin_register.php'));
    }

    //resizes image to standard size then adds it to the local directory and stores path to be put into database
        //if no pfp is provided, use the stock profile photo
        if (isset ($_FILES['pfp'])) {
            if ($_FILES['pfp']['error'] == UPLOAD_ERR_OK) {
                $validExt = array("jpg", "jpeg", "png");
                $validMime = array("image/jpeg", "image/png");
                $filenameArray = explode(".", $_FILES['pfp']['name']);
                $extension = end($filenameArray);
                if (in_array($_FILES['pfp']['type'], $validMime) && in_array($extension,$validExt)) {
                    if ($_FILES['pfp']['size'] <= 10485760) { // if they bypass the hidden form item
                        $pfp = "../img/pfps/$username.".$extension;
                        $imageSet = true;
                    } else {
                        $_SESSION['registerMessage'] = "<p>Your profile photo must be a maximum of 10MB in size.</p>";
                        exit(header("Location: ../pages/admin_register.php"));
                    }
                } else {
                    $_SESSION['registerMessage'] = "<p>Your profile photo needs to be in jpeg or png format.</p>";
                    exit(header("Location: ../pages/admin_register.php"));
                }
            } else {
                if ($_FILES['pfp']['error'] == UPLOAD_ERR_FORM_SIZE) {
                    $_SESSION['registerMessage'] = "<p>Your profile photo must be a maximum of 10MB in size.</p>";
                    exit(header("Location: ../pages/admin_register.php"));
                } else if ($_FILES['pfp']['error'] == UPLOAD_ERR_NO_FILE) {
                    $pfp = "../img/pfps/pfp.png";
                    $imageSet = false;
                } else {
                    $_SESSION['registerMessage'] = "<p>An error occured while trying to retrieve the profile photo from your submission. Please try again.</p>";
                    exit(header("Location: ../pages/admin_register.php"));
                }

            }
        } else {
            $pfp = "../img/pfps/pfp.png";
            $imageSet = false;
        }
        try{
            // For generating new unique recovery keys
            do {
                // Gen. key
                $newKey = bin2hex(random_bytes(32));

                // Prepare and execute query to check if the key already exists
                $query = "SELECT recoveryKey FROM users;";
                $prstmt = $conn->prepare($query);
                $prstmt->execute();
                $prstmt->bind_result($currKey);

                $unique = true;

                while ($prstmt->fetch()) {
                    if (password_verify($newKey, $currKey)) {
                        $unique = false;
                        break;
                    }
                }

                $prstmt->close();

            } while (!$unique);
        } catch (mysqli_sql_exception $e) {
            $_SESSION['registerMessage'] = "<p>An error occurred while generating your recovery key. Please try again.</p>";
            $prstmt->close();
            $conn->close();
            exit(header('Location: ../pages/admin_register.php'));
        }
    // Prepare SQL statement to insert new admin
    $sql = "INSERT INTO users(utype, fName, lName, uName, email, pass, bio, pfp, recoveryKey) VALUES (1, ?, ?, ?, ?, ?, 'No Bio Provided.', ?, ?);";
    $prstmt = $conn->prepare($sql);
    $hashedPass = password_hash($password, PASSWORD_DEFAULT);
    $hashedRKey = password_hash($newKey, PASSWORD_DEFAULT); // assuming $newKey is generated above
    $userType = 1;
    $prstmt->bind_param('sssssss', $firstName, $lastName, $username, $email, $hashedPass, $pfp, $hashedRKey);
    
    try {
        $prstmt->execute();
        $_SESSION['registerMessage'] = "<p>Admin registration successful! Please login.</p>";
        $_SESSION['recovery'] = "<p>Here is your recovery key: $newKey</p>";
    } catch (mysqli_sql_exception $e) {
        // Handle SQL errors
        if($e->getCode() == 1062){      #duplicate values for unique fields (email or username)
            $_SESSION['registerMessage'] = "<p>Email or Username is already taken.</p>";
        } else {
            $_SESSION['registerMessage'] = "<p>An error occurred in the registration process. Please try again.</p>";
        }
    } finally {
        $prstmt->close();
        $conn->close();
    }

    // resizing and saving image (getting to this portion of the code means that the pfp was of valid size and type)
    if ($imageSet) {
        $original = $_FILES['pfp']['tmp_name'];
        if (extension_loaded('gd')) {
            $oSize = getimagesize($original);
            $oWidth = $oSize[0];
            $oHeight = $oSize[1];
            $resizeDim = 960; //to make it into a square (960pxx960px)
            if ($extension == "jpeg" || $extension == "jpg") {
                $oImage = imagecreatefromjpeg($original);
                $rImage = imagecreatetruecolor($resizeDim, $resizeDim);
                imagecopyresampled($rImage, $oImage, 0, 0, 0, 0, $resizeDim, $resizeDim, $oWidth, $oHeight);
                imagejpeg($rImage, $pfp);
            } else { // must be a png if not jpg
                $oImage = imagecreatefrompng($original);
                $rImage = imagecreatetruecolor($resizeDim, $resizeDim);
                imagealphablending($rImage, false);
                imagesavealpha($rImage, true);
                imagecopyresampled($rImage, $oImage, 0, 0, 0, 0, $resizeDim, $resizeDim, $oWidth, $oHeight);
                imagepng($rImage, $pfp);
            }
        } else {
            move_uploaded_file($original, $pfp);
        }
    }
    // Redirect to the login page or admin dashboard
    exit(header('Location: ../pages/admin_register.php'));
} else {
    exit(header("Location: ../pages/admin_register.php"));
}
?>
