<!-- This will be the forwarding page/landing page. Should forward users depending on session variables to their respective discussion pages once button is clicked-->

<?php
    session_start();
    $utype = (isset($_SESSION['utype'])) ? $_SESSION['utype'] : null;
    $uid = (isset($_SESSION['uid'])) ? $_SESSION['uid'] : null;

    if (isset($utype)) {
        switch ($utype) {
            case 0:
                exit(header('Location: pages/discussion.php'));
            case 1:
                exit(header('Location: pages/admin.php'));
            default:
                exit(header('Location: pages/landing.php'));
        }
    } else {
        exit(header('Location: pages/landing.php'));
    }
?>