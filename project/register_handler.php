<?php
  if (isset($_POST["submit"])) {
    $errors = [];

    // trim all input values
    $username = trim($_POST["uname"]) ?? "";
    $email = trim($_POST["email"]) ?? "";
    $password = trim($_POST["pword"]) ?? "";
    $conf_password = trim($_POST["pword_conf"]) ?? "";
    $profile = trim($POST["profile"]) ?? "";
    $dob = $_POST["dob"];

    // username checks
    if ($username === "") {
      $errors[] = "Username is empty.";
    }

    if (!ctype_alnum($username)) {
      $errors[] = "Username may only contain letters and numbers (no spaces or symbols).";
    }

    if (strlen($username) < 6 || strlen($username) > 20) {
      $errors[] = "Username must be between 6 and 20 characters long.";
    }

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

    if (strlen($password) < 8) {
      $errors[] = "Password must be at least 8 characters long.";
    }

    if ($conf_password === "") {
      $errors[] = "Confirm Password is empty.";
    }

    if ($conf_password !== $password) {
      $errors[] = "Password and confirm password must match.";
    }

    // date of birth checks
    if ($dob === "") {
      $errors[] = "Date of birth is empty.";
    }

    // check that the user is at least 14 years old
    $dob_date = DateTime::createFromFormat('Y-m-d', $dob);
    $today = new DateTime();
    if (!$dob_date) {
      $errors[] = "Invalid date of birth format.";
    } else {
      $age = $today->diff($dob_date)->y;
      if ($age < 14) {
        $errors[] = "You must be at least 14 years old to register.";
      }
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
      echo "Validation successful!";
    }
  } else {
    echo 'Please submit the <a href="register_form.php">form</a>.';
  }
?>