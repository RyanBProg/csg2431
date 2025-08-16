<?php
  require 'db_connect.php';

  if (!isset($_SESSION['username']) || !isset($_SESSION['access_level']) || $_SESSION['access_level'] !== "admin") {
    header('Location: list_threads.php');
    exit;
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>View Logs</title>
    <meta name="author" content="Ryan Bowler" />
    <meta name="description" content="View the list of logs" />
    <link rel="stylesheet" type="text/css" href="forum_stylesheet.css" />
  </head>

  <body>
    <h3>View Event Logs</h3>

    <!-- auth -->
    <?php
      if (isset($_SESSION['username']) && isset($_SESSION['access_level'])) {
        echo '<p style="display: inline; margin-right: 10px;">Welcome, ' . $_SESSION['username'] . ' (' . $_SESSION['access_level'] . ')</p>
        <a href="logout.php">Logout</a>';
      } else {
        echo '<p style="display: inline; margin-right: 5px;">You are not logged in</p>
        <a href="login.php">Login</a> | 
        <a href="register_form.php">Register</a>';
      }
    ?>

    <p><a href="list_threads.php">List</a> | <a href="search_threads.php">Search</a></p>

    <table>
      <tr>
        <th>Date</th>
        <th>Event Type</th>
        <th>Username & IP Address</th>
        <th>Event Details</th>
      </tr>

      <?php  
        $result = $db->query("SELECT * FROM event_log ORDER BY log_date DESC");

        foreach($result as $row) {
          echo '<tr>
                  <td>' . htmlentities($row['log_date'] ?? '-') . '</td>
                  <td>' . htmlentities($row['event_type'] ?? '-') . '</td>
                  <td>' . htmlentities($row['ip_address'] ?? '-') . '</td>
                  <td>' . htmlentities($row['event_details'] ?? '-') . '</td>
                </tr>';
        }
      ?>
    </table>
  </body>
</html>