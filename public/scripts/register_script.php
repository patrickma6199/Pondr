<?php
    session_start();
    require_once('dbconfig.php');

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
        $pfp = (isset($_FILES['image'])) ? file_get_contents($_FILES['pfp']['tmp_name']):file_get_contents('../img/pfp.png');
        //TODO: resize images to be standard size.


        //this is the sql query using prepared statements for sanitization of requests
        $sql = "INSERT INTO users(utype, fName, lName, uName, email, pass, bio, pfp) VALUES (0, ?, ?, ?, ?, ?, 'No Bio Provided.', ?);";
        $prstmt = $conn->prepare($sql);
        $prstmt->bind_param('sssssb',$firstName,$lastName,$username,$email,$pass,$pfp);

        //if query successful
        if ($prstmt->execute()) {
            //TODO: upload was successful
        }
    }
} else {
    //reroutes user to discussion page router if they are logged in already
    header('Location: ../index.php');
}

?>