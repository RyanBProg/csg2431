<?php
  require 'db_connect.php';

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
      $PLACEHOLDER = "jbloggs";
      $stmt = $db->prepare("UPDATE thread
                            SET title = ?, content = ?, forum_id = ?
                            WHERE thread_id = ? AND username = ?");
      $result = $stmt->execute( [$title, $content, $forum_id, $_POST["thread_id"], $PLACEHOLDER] );

      if ($result) {
        header("Location: /csg2431/forum/view_thread.php?id=" . $_POST["thread_id"]);
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