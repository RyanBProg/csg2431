<?php
  // This file will be included at the start of all other files in the site
  
  // Start or resume a session
  session_start();
  
  // Simulate the user being logged in as jbloggs
  $_SESSION['uname'] = 'jbloggs';

  // Connect to database server
  try
  { 
    $db = new PDO('mysql:host=localhost;port=6033;dbname=iwd_security_examples', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);	
  }
  catch (PDOException $e) 
  {
    echo 'Error connecting to database server:<br />';
    echo $e->getMessage();
    exit;
  } 
?>