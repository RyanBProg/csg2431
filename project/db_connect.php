<?php
  try
  { 
    $db = new PDO('mysql:host=localhost;port=6033;dbname=records_data', 'root', '');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
  }
  catch (PDOException $e) 
  {
    echo 'Error connecting to database server:<br />';
    echo $e->getMessage();
    exit;
  } 
?>