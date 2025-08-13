<?php
  require 'db_connect.php';

  // Delete the table (if it doesn't exist, this will fail but not cause any problems)
  $db->query("DROP TABLE `sqli_transaction`;");
  
  // Create the table
  $create = "CREATE TABLE `sqli_transaction` (
             `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
             `pay_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
             `amount` decimal(13,2) NOT NULL,
             `description` varchar(100) NOT NULL,
             `sent_by` varchar(20) NOT NULL,
             `sent_to` varchar(20) NOT NULL
             ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";    
  $result = $db->query($create);
  
  // Insert the data
  $insert = "INSERT INTO `sqli_transaction` (`pay_date`, `amount`, `description`, `sent_by`, `sent_to`) VALUES
             ('2021-01-12 00:32:19', '25.00', 'tennis', 'jbloggs', 'bsmith'),
             ('2021-02-16 01:17:23', '47.00', 'dinner', 'bsmith', 'lwoods'),
             ('2021-01-24 03:11:39', '100.00', 'netflix', 'bsmith', 'jbloggs'),
             ('2021-01-30 03:23:44', '41.00', 'wine', 'jbloggs', 'mjones'),
             ('2021-02-16 01:16:11', '25.00', 'tennis', 'mjones', 'bsmith'),
             ('2021-02-16 00:27:35', '25.00', 'tennis', 'jbloggs', 'bsmith');";
  $result = $db->query($insert);  
?>

<!DOCTYPE html>
<html>
  <head>
  <title>SQL Injection Example</title>
  <meta name="author" content="Greg Baatard" />
  <meta name="description" content="Reset page for SQL Injection example" />
  <link rel="stylesheet" type="text/css" href="../example_stylesheet.css" />
  </head>

  <body>
    <h3>Data reset!</h3>
    <a href="index.php">Back to index page</a>
  </body>
</html>