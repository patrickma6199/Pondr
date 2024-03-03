<!-- This will be the forwarding page/landing page. Should forward users depending on session variables to their respective discussion pages once button is clicked-->

<?php
    session_start();
    $utype = $_SESSION['utype'];
    $uid = $_SESSION['uid'];

    switch ($utype) {
    case 0:
        header('Location: pages/discussion_user.php');
        break;
    case 1:
        header('Location: pages/discussion_admin.php');
    default:
        header('Location: pages/index.php');
    }
?>