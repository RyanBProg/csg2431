<?php
  require 'db_connect.php';

  if (!isset($_SESSION['username'])) {
    header('Location: list_threads.php');
    exit;
  }

  if (isset($_POST["submit"])) {
    $errors = [];

    // trim all input values
    $title = trim($_POST["title"]) ?? "";
    $content = trim($_POST["content"]) ?? "";
    $forum_id = trim($_POST["forum_id"]) ?? "";

    if ($title === "") {
      $errors[] = "Title is empty.";
    }

    if ($content === "") {
      $errors[] = "Content is empty.";
    }

    if ($forum_id === "") {
      $errors[] = "Forum is empty.";
    }

    if ($errors){
      foreach ($errors as $error) {
        echo "<p>".$error."</p>";
      }
    
      echo '<a href="javascript: window.history.back()">Return to form</a>';
    } else {
      $stmt = $db->prepare("INSERT INTO thread (username, title, content, forum_id) 
                            VALUES (?, ?, ?, ?)");
      $result = $stmt->execute( [$_SESSION['username'], $title, $content, $forum_id] );

      if ($result) {
        logEvent($db, "Post Thread", $_SESSION['username'], 'thread_id:'.$db->lastInsertId());
        header("Location: view_thread.php?id=" . $db->lastInsertId());
        exit;
      } else {
        echo "<p>Something went wrong.</p>";
        echo '<a href="javascript: window.history.back()">Return to form</a>';
        // print_r($stmt->errorInfo());
      }
    }
  } else {
    echo 'Please submit the <a href="new_thread_form.php">form</a>.';
  }
?>