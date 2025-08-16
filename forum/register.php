<?php
  require 'db_connect.php';

  if (isset($_SESSION['username'])) {
    header('Location: list_threads.php');
    exit;
  }

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
      $hash = password_hash($password, PASSWORD_DEFAULT);
      $stmt = $db->prepare("INSERT INTO user (username, password, real_name, dob) 
                            VALUES (?, ?, ?, ?)");
      $result = $stmt->execute( [$username, $hash, $real_name, $dob] );

      if ($result) {
        $stmt2 = $db->prepare("SELECT username, access_level, dob, real_name FROM user WHERE username = ?");
        $stmt2->execute([$username]);
        $user = $stmt2->fetch();

        if ($user) {
          $_SESSION['username'] = $user['username'];
          $_SESSION['access_level'] = $user['access_level'];

          logEvent($db, "Register Account", $_SESSION['username'], 'real_name: '.$user['real_name'].' | dob: '.$user['dob']);
          header('Location: list_threads.php');
          exit;
        } else {
          echo "<p>Registration succeeded, but failed to fetch user info.</p>";
        }
      } else if ($stmt->errorCode() === "23000") {
        echo '<p>Username "'.htmlspecialchars($_POST['uname']).'" already taken</p>';
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