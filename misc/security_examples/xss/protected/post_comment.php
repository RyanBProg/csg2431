<?php
  require 'db_connect.php';
  
  if (isset($_POST['submit']))
  { // If new comment form submitted...
    
	  $stmt = $db->prepare("INSERT INTO xss_comment (content, name, article_id) VALUES (?, ?, ?)");
    $result = $stmt->execute( [$_POST['content'], $_POST['name'], $_POST['article_id']] );

    if ($result)
    { // INSERT was successful
    
      echo '<p>Comment posted!<br />';
      echo '<a href="view_article.php?id='.$_POST['article_id'].'">Return to article</a></p>';

    }
    else
    { // Error inserting data
        
      echo '<p>Something went wrong.</p>';
        
    }	
  }
?>
