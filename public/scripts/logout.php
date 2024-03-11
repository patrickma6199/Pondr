<?php
session_start();

// will unset if already set to remove session variables
// if already unset, nothing will happen
unset($_SESSION['utype']);
unset($_SESSION['uid']);

exit(header("Location: ../index.php"));

?>