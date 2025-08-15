<?php
  // start or resume a session
  session_start();

  // log an event to the database
  function logEvent($db, $eventType, $eventDetails) {
    $ipAddress = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $log_stmt = $db->prepare("INSERT INTO log (ip_address, event_type, event_details) VALUES (?, ?, ?)");
    $log_stmt->execute([$ipAddress, $eventType, $eventDetails]);
  }
  
  try { 
    $db = new PDO('mysql:host=localhost;port=6033;dbname=records_data', 'root', '');
	  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);

    // Disable emulation mode to prevent multiple queries
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);    
  } catch (PDOException $e) {
    echo 'Error connecting to database server:<br />';
    echo $e->getMessage();
    exit;
  } 
?>