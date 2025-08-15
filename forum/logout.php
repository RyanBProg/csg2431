<?php
  require 'db_connect.php';

  logEvent($db, "Logout", $_SESSION['username'], null);

  session_destroy();
  header('Location: list_threads.php')
?>