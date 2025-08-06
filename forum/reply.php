<?php
  require 'db_connect.php';

  if (!isset($_SESSION['username'])) {
    header('Location: list_threads.php');
    exit;
  }

  if (isset($_POST["submit"])) {
    $errors = [];

    $reply = trim($_POST["reply"]) ?? "";
    if ($reply === "") {
      $errors[] = "Reply is empty.";
    }

    if ($errors){
      foreach ($errors as $error) {
        echo "<p>".$error."</p>";
      }
    
      echo '<a href="javascript: window.history.back()">Return to form</a>';
    } else {
      $stmt = $db->prepare("INSERT INTO reply (username, thread_id, content) 
                            VALUES (?, ?, ?)");
      $result = $stmt->execute( [$_SESSION['username'], $_POST['thread_id'], $reply] );

      if ($result) {
        header("Location: view_thread.php?id=" . $_POST['thread_id']);
        exit;
      } else {
        echo "<p>Something went wrong.</p>";
        echo '<a href="javascript: window.history.back()">Return to form</a>';
        // print_r($stmt->errorInfo());
      }
    }
  } else {
    header('Location: list_threads.php');
    exit;
  }
?>