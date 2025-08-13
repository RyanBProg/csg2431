<?php
  require 'db_connect.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <title>XSS Example - News Website</title>
    <meta name="author" content="Greg Baatard" />
    <meta name="description" content="Article list for XSS example" />
    <link rel="stylesheet" type="text/css" href="../../example_stylesheet.css" />
  </head>
  <body>
    <h3>Breaking News (Protected Version)</h3>
    <a href="../../">Security Example Index</a> | <a href="../">Go to Insecure Version</a>
    <br /><br />
    <?php  
      // Select article details
      $result = $db->query("SELECT article_id, title, post_date FROM xss_article ORDER BY post_date DESC");

      // Loop through results to display links to threads
      foreach ($result as $row)
      {
        echo '<p><a href="view_article.php?id='.$row['article_id'].'">'.$row['title'].'</a><br />';
        echo '<small>Posted on '.$row['post_date'].'</a> ';

        echo '</small></p>';
      }
    ?>
  </body>
</html>