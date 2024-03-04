<!-- routing for thread pages -->

<?php
    session_start();
    $utype = $_SESSION['utype'];
    $uid = $_SESSION['uid'];

    if (isset($utype)) {
        switch ($utype) {
            case 0:
                exit(header('Location: pages/thread_user.php'));
            case 1:
                exit(header('Location: pages/thread_admin.php'));
            default:
                exit(header('Location: pages/landing.php'));
        }
    } else {
        exit(header('Location: pages/landing.php'));
    }
?>