<?php
  // This page is used to switch between examples
  // It destroys any session variables before redirecting to avoid issues
  
  session_start();
  session_destroy();
  
  if (isset($_GET['to']))
  {
    header('Location: '.$_GET['to']); 
  }
  else
  {    
    header('Location: index.php'); 
  }
?>