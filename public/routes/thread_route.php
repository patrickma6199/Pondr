<!-- routing for thread pages -->

<?php
    session_start();
    $utype = $_SESSION['utype'];
    $uid = $_SESSION['uid'];

    switch ($utype) {
    case 0:
        header('Location: pages/thread_user.php');
        break;
    case 1:
        header('Location: pages/thread_admin.php');
    default:
        header('Location: pages/thread.php');
    }
?>