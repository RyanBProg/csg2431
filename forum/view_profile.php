<?php
  require 'db_connect.php';
  
  if (!isset($_GET['username'])) {
    header('Location: /csg2431/forum/list_threads.php');
    exit;
  }

  $stmt = $db->prepare("SELECT u.username, u.real_name, YEAR(u.dob) AS birth_year, COUNT(t.thread_id) AS thread_count
                        FROM user u
                        LEFT JOIN thread t ON u.username = t.username
                        WHERE u.username = ?
                        GROUP BY u.username, u.real_name, u.dob");

  $stmt->execute( [$_GET['username']] );
  $user = $stmt->fetch();
  
  if (!$user) {
    header('Location: /csg2431/forum/list_threads.php');
    exit;  
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?php echo htmlentities($user['title']); ?></title>
    <meta name="author" content="Ryan Bowler" />
    <meta name="description" content="View thread page of forum scenario" />
    <link rel="stylesheet" type="text/css" href="forum_stylesheet.css" />
  </head>

  <body>
    <?php
      echo '<h3>Viewing Profile of "'.htmlentities($user['username']).'"</h3>';
    ?>
    <p><a href="javascript:history.back()">Back</a></p>

		<?php

      if (empty($user['real_name'])) {
        echo '<p><strong>Real Name:</strong> <em>Not Disclosed</em></p>';
      } else {
        echo '<p><strong>Real Name:</strong> '.htmlentities($user['real_name']).'</p>';
      }

      echo '<p><strong>Born In:</strong> '.htmlentities($user['birth_year']).'</p>';
      echo '<p><strong>Post Count:</strong> '.htmlentities($user['thread_count']).'</p>';
    ?>
  </body>
</html>
