<?php
  require 'db_connect.php';

  if (isset($_POST["submit"])) {
    $errors = [];

    // trim all input values
    $username = trim($_POST["uname"]) ?? "";
    $password = trim($_POST["pword"]) ?? "";
    $conf_password = trim($_POST["pword_conf"]) ?? "";
    $real_name = trim($_POST["real_name"]) ?? "";
    $dob = $_POST["dob"];

    if (strlen($username) < 6 || strlen($username) > 20) {
      $errors[] = "Username must be between 6 and 20 characters long.";
    }

    if (!ctype_alnum($username)) {
      $errors[] = "Username may only contain letters and numbers (no spaces or symbols).";
    }

    if (strlen($password) < 8) {
      $errors[] = "Password must be at least 8 characters long.";
    }

    if ($conf_password !== $password) {
      $errors[] = "Password and confirm password must match.";
    }

    if (strtotime($_POST['dob']) === false) {
      $errors[] = 'Invalid date of birth.';
    }

    if (strtotime($_POST['dob']) > strtotime('-14 years')) {
      $errors[] = 'You must be at least 14 to register.';
    }

    if (!isset($_POST["agree"])) {
      $errors[] = "You must agree to the terms and conditions.";
    }

    if ($errors){
      foreach ($errors as $error) {
        echo "<p>".$error."</p>";
      }
    
      echo '<a href="javascript: window.history.back()">Return to form</a>';
    } else {
      $stmt = $db->prepare("INSERT INTO user (username, password, real_name, dob) 
                            VALUES (?, ?, ?, ?)");
      $result = $stmt->execute( [$username, $password, $real_name, $dob] );

      if ($result) {
        echo "<p>Registration complete!</p>";
        echo "<a href='login.php'>Log in</a>";
      } else if ($stmt->errorCode() === "23000") {
        echo '<p>Username "'.$_POST['uname'].'" already taken</p>';
        echo '<a href="javascript: window.history.back()">Return to form</a>';
        // print_r($stmt->errorInfo());
      } else {
        echo "<p>Something went wrong.</p>";
        echo '<a href="javascript: window.history.back()">Return to form</a>';
        // print_r($stmt->errorInfo());
      }
    }
  } else {
    echo 'Please submit the <a href="register_form.php">form</a>.';
  }
?>