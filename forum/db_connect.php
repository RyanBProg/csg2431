<?php
  // start or resume a session
  session_start();

  try { 
    $db = new PDO('mysql:host=localhost;port=6033;dbname=iwd_forum', 'root', '');
	  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
    
    // Disable emulation mode to prevent multiple queries
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);    
  } catch (PDOException $e) {
    echo 'Error connecting to database server:<br />';
    echo $e->getMessage();
    exit;
  } 
?>