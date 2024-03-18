<?php
    ini_set('display_errors', 1);
    session_start();
    require_once 'dbconfig.php';
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $email = $_POST['email'];
        $newPass = $_POST['new-pass'];
        $recovery = $_POST['recovery-key'];

        $sql = "SELECT recoveryKey FROM users WHERE email = ?";
        $prstmt = $conn->prepare($sql);
        $prstmt->bind_param('s',$email);
        try {
            $prstmt->execute();
            $prstmt->bind_result($recoveryDB);
            if ($prstmt->fetch()) {
                if ($recovery == $recoveryDB) {
                    $prstmt->close();
                    $sql = "UPDATE users SET pass = ? WHERE email = ?;";
                    $prstmt = $conn->prepare($sql);
                    $hashPass = password_hash($newPass,PASSWORD_DEFAULT);
                    $prstmt->bind_param('ss',$hashPass,$email);
                    try {
                        $prstmt->execute();
                        $_SESSION['forgetPassMessage'] = "<p>Password successfully updated. Enjoy your Pondr journey!</p>";
                    } catch(mysqli_sql_exception $e) {
                        $_SESSION['forgetPassMessage'] = "<p>Error attempting to change your password. Please try again.</p>";
                    }
                } else {
                    $_SESSION['forgetPassMessage'] = "<p>Incorrect email or recovery token.</p>";
                }
            } else {
                $_SESSION['forgetPassMessage'] = "<p>Incorrect email or recovery token.</p>";
            }
        }catch(mysqli_sql_exception $e){
            $_SESSION['forgetPassMessage'] = "<p>Error attempting to change your password. Please try again.</p>";
        }

        $prstmt->close();
        $conn->close();

        exit(header("Location: ../pages/forget_password.php"));
    }

?>