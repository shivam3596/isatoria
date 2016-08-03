<?php require_once 'include/session.php'; ?>
<?php require_once 'include/functions.php'; ?>
<?php
  $_SESSION['username'] = null;
  $_SESSION['user_id'] = null;
  redirect_to('login.php');
?>
