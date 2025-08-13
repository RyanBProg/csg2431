<?php
  // This file will be included at the start of all other files in the site
  
  // Generate a random "nonce" value - think of it as a one-time password
  // (In order to run a script, you must have this password)
  $nonce = bin2hex(random_bytes(10));
  
  // Setting this header makes it so that the page will not allow scripts
  // (Unless they specify the current nonce value)
  header("Content-Security-Policy: script-src 'self' 'nonce-".$nonce."'");
  
  // Setting these flags on session cookies helps to prevent them being compromised via XSS
  // They can also help to prevent CSRF attacks
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