<?php
  require 'db_connect.php';

  // Delete all data from the the tables
  $db->query("TRUNCATE TABLE `csrf_transaction`;");
  $db->query("DELETE FROM `csrf_account`;");
  
  // Insert the data
  $insert = "INSERT INTO `csrf_account` (`acc_num`, `username`, `balance`) VALUES
             (111111111, 'victim1', '10000.00'),
             (111111112, 'victim2', '25000.00'),
             (123456789, 'hackerman', '0.00');";
  $result = $db->query($insert);
  
?>

<!DOCTYPE html>
<html>
  <head>
  <title>CSRF Example - Data Reset</title>
  <meta name="author" content="Greg Baatard" />
  <meta name="description" content="Reset page for CSRF example" />
  <link rel="stylesheet" type="text/css" href="../example_stylesheet.css" />
  </head>

  <body>
    <h3>Data reset!</h3>
    <a href="index.php">Back to index page</a>
  </body>
</html>