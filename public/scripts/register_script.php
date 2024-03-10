<?php
    session_start();
    require_once 'dbconfig.php';
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $utype = $_SESSION['utype'];
    $uid = $_SESSION['uid'];

if (!isset($utype)) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //grab form information (required fields so will already be set)
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        //gets the string representation of the pfp sent through post request using temp filename stored on server from request
        //if no pfp is provided, use the stock profile photo
        //$pfp = (isset($_FILES['pfp'])) ? file_get_contents($_FILES['pfp']['tmp_name']):file_get_contents('../img/pfp.png');

        // Check if 'pfp' file was uploaded and is not empty
        $pfp = file_get_contents('../img/pfp.png');

        //TODO: resize images to be standard size.

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
        $prstmt->bind_param('sssssbs',$firstName,$lastName,$username,$email,$hashedPass,$pfp,$newKey);

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
        }
        $prstmt->close();
        $conn->close();

        exit(header('Location: ../pages/register.php'));
    }
} else {
    //reroutes user to discussion page router if they are logged in already
    header('Location: ../index.php');
}

?>