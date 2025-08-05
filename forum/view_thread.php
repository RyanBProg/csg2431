<?php
  require 'db_connect.php';
  
  if (!isset($_GET['id']) || !ctype_digit($_GET['id']))
  { // If there is no "id" URL data or it isn't a number
    header('Location: /csg2431/forum/list_threads.php');
    exit;
  }

  // Select details of specified thread
  // Since the user could tamper with the URL data, a prepared statement is used
  $stmt = $db->prepare("SELECT t.thread_id, t.username, t.content, t.title, UNIX_TIMESTAMP(t.post_date) AS post_date, t.forum_id, f.forum_name
            FROM thread t
            JOIN forum f ON t.forum_id = f.forum_id
            WHERE t.thread_id = ?
            ORDER BY t.post_date DESC");

  $stmt->execute( [$_GET['id']] );
  $thread = $stmt->fetch();
  
  if (!$thread)
  { // If no data (no thread with that ID in the database)
    header('Location: /csg2431/forum/list_threads.php');
    exit;  
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?php echo htmlentities($thread['title']); ?></title>
    <meta name="author" content="Ryan Bowler" />
    <meta name="description" content="View thread page of forum scenario" />
    <link rel="stylesheet" type="text/css" href="forum_stylesheet.css" />
  </head>

  <body>
    <h3>View Thread</h3>
    <p><a href="list_threads.php">List</a> | <a href="search_threads.php">Search</a></p>
		<?php
      // Display the thread's details
      echo '<h4>'.htmlentities($thread['title']).'</h4>';

      echo '<p><small><em>Posted by <a href="view_profile.php?username='.$thread['username'].'">'.$thread['username'].'</a>
      in <a href="list_threads.php?forum_id='.$thread['forum_id'].'">'.$thread['forum_name'].'</a>
      on '.date('d M Y, H:i', $thread['post_date']).'
      </small></p>';
	  
      echo '<p>'.nl2br(htmlentities($thread['content'])).'</p>';
    ?>
  </body>
</html>
