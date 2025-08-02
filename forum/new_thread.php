<?php
  if (isset($_POST["submit"])) {
    $errors = [];

    // trim all input values
    $title = trim($_POST["title"]) ?? "";
    $content = trim($_POST["content"]) ?? "";
    $forum = trim($_POST["forum"]) ?? "";

    if ($title === "") {
      $errors[] = "Title is empty.";
    }

    if ($content === "") {
      $errors[] = "Content is empty.";
    }

    if ($forum === "") {
      $errors[] = "Forum is empty.";
    }

    if ($errors){
      foreach ($errors as $error) {
        echo "<p>".$error."</p>";
      }
    
      echo '<a href="javascript: window.history.back()">Return to form</a>';
    } else {
      echo "Validation successful!";
    }
  } else {
    echo 'Please submit the <a href="new_thread_form.php">form</a>.';
  }
?>