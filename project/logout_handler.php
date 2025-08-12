<?php
  session_start();
  session_destroy();
  header('Location: album_list.php')
?>