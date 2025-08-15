<?php
  require 'db_connect.php';

  logEvent($db, "Logout", $_SESSION['username'].' logged out');

  session_destroy();
  header('Location: album_list.php')
?>