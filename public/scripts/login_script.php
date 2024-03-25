<?php
    session_start();
    ini_set('display_errors', 1);
    require_once 'dbconfig.php';
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    if (isset ($_POST['username']) && isset ($_POST['password'])) {
        //if the user is not logged in, verify theyre credentials and log them in if valid by setting session variables
        $username = $_POST['username'];
        $password = $_POST['password'];


        //this is the sql query using prepared statements for sanitization of requests
        $sql = "SELECT userId, utype, pass FROM users WHERE uName = ?;";
        try{
            $prstmt = $conn->prepare($sql);
            $prstmt->bind_param('s',$username);
            $prstmt->execute();
            $prstmt->bind_result($uid, $utype, $pass);
            if ($prstmt->fetch()) {
                //if query only returns one user and user's password hashed matches entered password hashed
                if (password_verify($password, $pass)){

                    //assign session variables
                    $_SESSION['utype'] = $utype;
                    $_SESSION['uid'] = $uid;

                    //redirect to discussions router
                    exit(header('Location: ../index.php'));
                } else {
                    //if password doesn't match
                    //set up message to inform user of incorrect login info
                    $_SESSION['loginMessage'] = "<p>Invalid username or password.</p>";
                }
            } else {
                $_SESSION['loginMessage'] = "<p>Invalid username or password.</p>";
            }

        } catch (mysqli_sql_exception $e) {
            $_SESSION['loginMessage'] = '<p>Error occurred in the login process. Please try again.</p>';
        }
        $prstmt->close();
        $conn->close();
        exit(header('Location: ../pages/login.php'));

    } else {
        $conn->close();
        exit (header("Location: ../index.php"));
    }

?>