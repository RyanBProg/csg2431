<?php
  require 'db_connect.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <title>List Threads</title>
    <meta name="author" content="Ryan Bowler" />
    <meta name="description" content="List threads page of forum scenario" />
    <link rel="stylesheet" type="text/css" href="forum_stylesheet.css" />
  </head>

  <body>
    <h3>List Threads</h3>

    <!-- auth -->
    <?php
      if (isset($_SESSION['username']) && isset($_SESSION['access_level'])) {
        echo '<p style="display: inline; margin-right: 10px;">Welcome, ' . htmlspecialchars($_SESSION['username']) . ' (' . htmlspecialchars($_SESSION['access_level']) . ')</p>
        <a href="logout.php">Logout</a>';
      } else {
        echo '<p style="display: inline; margin-right: 5px;">You are not logged in</p>
        <a href="login.php">Login</a> | 
        <a href="register_form.php">Register</a>';
      }
    ?>

    <!-- nav -->
    <?php
      echo '<div style="margin: 20px 0 30px"><a href="search_threads.php">Search</a>';

      if (isset($_SESSION['username']) && isset($_SESSION['access_level']) && $_SESSION['access_level'] === "admin") {
        echo ' | <a href="new_thread_form.php">New Thread</a> | 
        <a href="change_access_level_form.php">Change Access Level</a> | 
        <a href="view_logs.php">View Logs</a>
        </div>';
      } else if (isset($_SESSION['username'])) {
        echo ' | <a href="new_thread_form.php">New Thread</a></div>';
      } else {
        echo '</div>';
      }
    ?>

    <form name="list_threads" method="get" action="list_threads.php" >
      <p><input type="button" value="Show All Threads" onclick="window.location.href = 'list_threads.php'" /> or filter to
        <select name="forum_id">
          <option value="" selected disabled>Select a forum</option>
          <?php  
            $result = $db->query("SELECT * FROM forum ORDER BY forum_id");
      
            foreach($result as $row) {
              echo '<option value="'.htmlspecialchars($row['forum_id']).'">'.htmlspecialchars($row['forum_name']).'</option>';
      
              if (isset($_GET['forum_id']) && $_GET['forum_id'] == $row['forum_id']) {
                $current_forum_name = $row['forum_name'];
              }
            }
          ?>
        </select> <input type="submit" value="Filter" />
      </p>
    </form>
    
    <?php
      if (isset($_GET['forum_id'])) {
        echo '<h4>'.htmlspecialchars($current_forum_name).' Threads</h4>';

        $stmt = $db->prepare("SELECT t.thread_id, t.username, t.title, UNIX_TIMESTAMP(t.post_date) AS post_date, t.forum_id, f.forum_name
                  FROM thread t
                  JOIN forum f ON t.forum_id = f.forum_id
                  WHERE t.forum_id = ?
                  ORDER BY t.post_date DESC");

        $stmt->execute( [$_GET['forum_id']] );
      } else {
        echo '<h4>All Threads</h4>';

        $stmt = $db->prepare("SELECT t.thread_id, t.username, t.title, UNIX_TIMESTAMP(t.post_date) AS post_date, t.forum_id, f.forum_name
                  FROM thread t
                  JOIN forum f ON t.forum_id = f.forum_id
                  ORDER BY t.post_date DESC");
                              
        $stmt->execute();
      }
      
      $result_data = $stmt->fetchAll();
      
      if (count($result_data) > 0) {      
        $thread_count = count($result_data);
        $thread_word = $thread_count === 1 ? 'thread' : 'threads';
        echo "<p>There " . ($thread_count === 1 ? "is" : "are") . " $thread_count $thread_word.</p>";

        foreach($result_data as $row) {
          echo '<p><a href="view_thread.php?id='.urlencode($row['thread_id']).'">'.htmlspecialchars($row['title']).'</a><br />';
          echo '<small>Posted by <a href="view_profile.php?username='.urlencode($row['username']).'">'.htmlspecialchars($row['username']).'</a>
          in <a href="list_threads.php?forum_id='.urlencode($row['forum_id']).'">'.htmlspecialchars($row['forum_name']).'</a>
          on '.date('d M Y, H:i', htmlspecialchars($row['post_date'])).'
          </small></p>';
        }
      } else {
        echo '<p>No threads posted.</p>';
      }
    ?>
  </body>
</html>