<?php
  require "db_connect.php";

  if (!isset($_SESSION['username'])) {
    header('Location: list_threads.php');
    exit;
  }

  if (!isset($_SESSION['access_level']) && $_SESSION['access_level'] !== 'admin') {
    header('Location: list_threads.php');
    exit;
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Change Access Level</title>
    <meta name="author" content="Ryan Bowler" />
    <meta name="description" content="Change the access levels of the users" />
    <link rel="stylesheet" type="text/css" href="forum_stylesheet.css" />
  </head>
  <body>
    <h3>Change Access Level</h3>
    <div style="margin: 20px 0 30px"><a href="list_threads.php">List</a> | <a href="search_threads.php">Search</a></div>

    <ul style="display: grid; gap: 10px;">
      <?php  
        $result = $db->query("SELECT * FROM user");
        foreach($result as $row) {
          if ($_SESSION['username'] === $row['username']) {
            echo '<li>
            <span>' . htmlspecialchars($row['username']) . ' (' . htmlspecialchars($row['access_level']) . ')</span> - 
            <span>Can\'t change your own access level</span>
            </li>';
          } else if ($row['access_level'] === "member") {
            echo '<li>
            <span>' . htmlspecialchars($row['username']) . ' (' . htmlspecialchars($row['access_level']) . ')</span> - 
            <a href="change_access_level.php?username=' . htmlspecialchars($row['username']) . '">Promote</a>
            </li>';
          } else {
            echo '<li>
            <span>' . htmlspecialchars($row['username']) . ' (' . htmlspecialchars($row['access_level']) . ')</span> - 
            <a href="change_access_level.php?username=' . htmlspecialchars($row['username']) . '">Demote</a>
            </li>';
          }
        }
      ?>
    </ul>
  </body>
</html>