<?php
  if (isset($_POST["submit"])) {
    $errors = [];

    // trim all input values
    $email = trim($_POST["email"]) ?? "";
    $password = trim($_POST["pword"]) ?? "";

    // email checks
    if ($email === "") {
      $errors[] = "Email is empty.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors[] = "Invalid email format.";
    }

    // password checks
    if ($password === "") {
      $errors[] = "Password is empty.";
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
    echo 'Please submit the <a href="register_form.php">form</a>.';
  }
?>