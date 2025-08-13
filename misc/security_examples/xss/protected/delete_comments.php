<?php
  require 'db_connect.php';
    
  if (!isset($_GET['id']) || !ctype_digit($_GET['id']))
  { // If there is no "id" URL data or it isn't a number
    echo '<p>Invalid article ID.</p>';
    exit;
  }
  
  // Delete all comments on this article
  $stmt = $db->prepare("DELETE FROM xss_comment WHERE article_id = ?");
  $result = $stmt->execute( [$_GET['id']] );
  
  if ($result)
  { // DELETE was successful
  
    echo '<p>'.$stmt->rowCount().' comment(s) deleted!<br />';
    echo '<a href="view_article.php?id='.$_GET['id'].'">Return to article</a></p>';

  }
  else
  { // Error deleting data      
    echo '<p>Something went wrong.</p>';      
  }	
?>