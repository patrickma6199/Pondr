<!-- This will be the forwarding page/landing page. Should forward users depending on session variables to their respective discussion pages once button is clicked-->

<?php
    session_start();
    $utype = $_SESSION['utype'];
    $uid = $_SESSION['uid'];

    if (isset($utype)) {
        switch ($utype) {
            case 0:
                exit(header('Location: pages/discussion_user.php'));
            case 1:
                exit(header('Location: pages/admin.php'));
            default:
                exit(header('Location: pages/landing.php'));
        }
    } else {
        exit(header('Location: pages/landing.php'));
    }
?>