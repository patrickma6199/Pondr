<?php
    session_start();
    require_once('dbconfig.php');

    $utype = $_SESSION['utype'];
    $uid = $_SESSION['uid'];

if (!isset($utype)) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //grab form information
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        //this is the sql query using prepared statements for sanitization of requests
        $sql = "SELECT userId, utype, pass FROM users WHERE uName = ?";
        $prstmt = $conn->prepare($sql);
        $prstmt->bind_param('s',$username);
        $prstmt->execute();

        $prstmt->bind_result($uid, $utype, $pass);

        //if query only returns one user and user's password matches entered password
        if ($prstmt->num_rows == 1 && $password == $pass) {
            //fetch() next available row
            $prstmt->fetch();

            //assign session variables
            $_SESSION['utype'] = $utype;
            $_SESSION['uid'] = $uid;

            $prstmt->close();
            $conn->close();

            //redirect to discussions router
            header('Location: ../index.php');
        }
    }
} else {
    //reroutes user to discussion page router if they are logged in already
    header('Location: ../index.php');
}

?>