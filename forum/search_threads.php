<?php
  require 'db_connect.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Search Threads</title>
    <meta name="author" content="Ryan Bowler" />
    <meta name="description" content="Search threads page of forum scenario" />
    <link rel="stylesheet" type="text/css" href="forum_stylesheet.css" />
  </head>

  <body>
    <h3>Search Threads</h3>

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

    <!-- nav -->
    <?php
      echo '<div style="margin: 20px 0 30px"><a href="list_threads.php">List</a>';

      if (isset($_SESSION['username'])) {
        echo ' | <a href="new_thread_form.php">New Thread</a> | 
        <a href="change_access_level_form.php">Change Access Level</a>
        </div>';
      } else {
        echo '</div>';
      }
    ?>

    <form name="search_threads" method="get" action="search_threads.php" >
      <p>Search: <input type="text" name="search_term" placeholder="Enter search term..." autofocus /> <input type="submit" value="Submit" /></p>
    </form>
    
    <?php
      // Execute a query if there's a search term in the URL data
      if (isset($_GET['search_term']))
      {
        echo '<h4>Search results for "'.$_GET['search_term'].'"</h4>';
        
        // Put wildcard characters on each end of the search term
        $search_term = '%'.$_GET['search_term'].'%';
        
        $stmt = $db->prepare("SELECT t.thread_id, t.username, t.title, UNIX_TIMESTAMP(t.post_date) AS post_date, t.forum_id, f.forum_name
                  FROM thread t
                  JOIN forum f ON t.forum_id = f.forum_id
                  WHERE t.title LIKE ? OR t.content LIKE ?
                  ORDER BY t.post_date DESC");

        // Provide the same value for both placeholders to search the title and content columns
        $stmt->execute( [$search_term, $search_term] );
        
        
        // Fetch all of the results as an array
        $result_data = $stmt->fetchAll();
        
        // Display results or a "no results" message as appropriate
        if (count($result_data) > 0)
        {          
          $thread_count = count($result_data);
          $thread_word = $thread_count === 1 ? 'thread' : 'threads';
          echo "<p>There " . ($thread_count === 1 ? "is" : "are") . " $thread_count $thread_word.</p>";

          // Loop through results to display links to threads
          foreach($result_data as $row)
          {
            echo '<p><a href="view_thread.php?id='.$row['thread_id'].'">'.$row['title'].'</a><br />';
            echo '<small>Posted by <a href="view_profile.php?username='.$row['username'].'">'.$row['username'].'</a> 
            in <a href="list_threads.php?forum_id='.$row['forum_id'].'">'.$row['forum_name'].'</a>
            on '.date('d M Y, H:i', $row['post_date']).'</small></p>';
          }
        }
        else
        {
          echo '<p>No results found.</p>';
        }
      }
    ?>
  </body>
</html>