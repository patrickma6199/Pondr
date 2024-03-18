<?php
session_start();
require_once 'dbconfig.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$utype = (isset($_SESSION['utype'])) ? $_SESSION['utype'] : null;
$uid = (isset($_SESSION['uid'])) ? $_SESSION['uid'] : null;

if (!isset($utype)) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //grab form information (required fields so will already be set)
        if (isset ($_POST['firstName']) && isset ($_POST['lastName']) && isset ($_POST['email']) && isset ($_POST['username']) && isset ($_POST['password'])) {
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $email = $_POST['email'];
            $username = $_POST['username'];
            $password = $_POST['password'];
        } else {
            $_SESSION['registerMessage'] = "<p>Missing required information to complete registration process.</p>";
            exit (header('Location: ../pages/register.php'));
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
                    } else {
                        $_SESSION['registerMessage'] = "<p>Your profile photo must be a maximum of 10MB in size.</p>";
                        exit(header("Location: ../pages/register.php"));
                    }
                } else {
                    $_SESSION['registerMessage'] = "<p>Your profile photo needs to be in jpeg or png format.</p>";
                    exit(header("Location: ../pages/register.php"));
                }
            } else {
                if ($_FILES['pfp']['error'] == UPLOAD_ERR_FORM_SIZE) {
                    $_SESSION['registerMessage'] = "<p>Your profile photo must be a maximum of 10MB in size.</p>";
                    exit(header("Location: ../pages/register.php"));
                }
                $_SESSION['registerMessage'] = "<p>An error occured while trying to retrieve the profile photo from your submission. Please try again.</p>";
                exit(header("Location: ../pages/register.php"));
            }
        } else {
            $pfp = "../img/pfp.png";
        }

        //Generates recovery key
        $newKey = bin2hex(random_bytes(16));
        $unique = false;

        while(!$unique) {
            //check if key exists already for another user
            $sql = "SELECT * FROM users WHERE recoveryKey = ?;";
            $prstmt = $conn->prepare($sql);
            $prstmt->bind_param("s",$newKey);
            
            try{
                $prstmt->execute();
                // if already used, regenerate
                if ($prstmt->fetch()) {
                    $newKey = bin2hex(random_bytes(16));
                } else {
                    $prstmt->close();
                    $unique = true;
                }
            } catch(mysqli_sql_exception $e){
                $_SESSION['registerMessage'] = "<p>An error occurred while trying to generate your recovery key. Please try again.</p>";
                $prstmt->close();
                $conn->close();
                exit(header("Location: ../pages/register.php"));
            }
        }


        //this is the sql query using prepared statements for sanitization of requests
        $sql = "INSERT INTO users(utype, fName, lName, uName, email, pass, bio, pfp, recoveryKey) VALUES (0, ?, ?, ?, ?, ?, 'No Bio Provided.', ?, ?);";
        $prstmt = $conn->prepare($sql);
        $hashedPass = password_hash($password, PASSWORD_DEFAULT);
        $prstmt->bind_param('sssssss',$firstName,$lastName,$username,$email,$hashedPass,$pfp,$newKey);

        //if query successful
        try {
            $prstmt->execute();
            $_SESSION['registerMessage'] = "<p>Registration Successful! Login to start your Pondr journey!</p>";
            $_SESSION['recovery'] = "<p>Here is your recovery key: $newKey</p>";
                
        } catch (mysqli_sql_exception $e) {
            if($e->getCode() == 1062){      #duplicate values for unique fields (email or username)
                $_SESSION['registerMessage'] = "<p>Email or Username is already taken.</p>";
            } else {
                $_SESSION['registerMessage'] = "<p>An error occurred in the registration process. Please try again.</p>";
            }
            $prstmt->close();
            $conn->close();
            exit(header('Location: ../pages/register.php'));
        }
        $prstmt->close();
        $conn->close();

        // resizing and saving image (getting to this portion of the code means that the pfp was of valid size and type)
        $original = $_FILES['pfp']['tmp_name'];
        $oSize = getimagesize($original);
        $oWidth = $oSize[0];
        $oHeight = $oSize[1];
        $resizeDim = 960; //to make it into a square (960pxx960px)

        if ($extension == "jpeg" || $extension == "jpg") {
            $oImage = imagecreatefromjpeg($original);
            $rImage = imagecreatetruecolor($resizeDim, $resizeDim);
            imagecopyresampled($rImage,$oImage, 0, 0, 0, 0, $resizeDim, $resizeDim, $oWidth,$oHeight);
            imagejpeg($rImage, $pfp);
        } else { // must be a png if not jpg
            $oImage = imagecreatefrompng($original);
            $rImage = imagecreatetruecolor($resizeDim, $resizeDim);
            imagealphablending($rImage, false);
            imagesavealpha($rImage, true);
            imagecopyresampled($rImage,$oImage, 0, 0, 0, 0, $resizeDim, $resizeDim, $oWidth,$oHeight);
            imagepng($rImage,$pfp);
        }

        exit(header('Location: ../pages/register.php'));
    }
} else {
    //reroutes user to discussion page router if they are logged in already
    exit(header('Location: ../index.php'));
}

?>