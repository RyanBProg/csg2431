<?php
  // This file will be included at the start of all other files in the site
  
  // Setting these flags on session cookies helps to prevent them being sent in a CSRF attack
  // (Since the "compromised website" in this example is on the same server, it is of limited use)
  ini_set('session.cookie_httponly', true);
  ini_set('session.cookie_samesite', 'Strict');
  
  // Start or resume a session
  session_start();

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