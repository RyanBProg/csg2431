<?php
  require "db_connect.php";

  if (isset($_SESSION['username'])) {
    header('Location: list_threads.php');
    exit;
  }

  if (isset($_POST['submit'])) {
    $errors = [];

    // trim all input values
    $username = trim($_POST["uname"]) ?? "";
    $password = trim($_POST["pword"]) ?? "";

    if ($username === "") {
      $errors[] = "Username is empty";
    }

    if ($password === "") {
      $errors[] = "Password is empty";
    }

    if (!$errors) {
      $stmt = $db->prepare("SELECT * FROM user WHERE username = ?");
      $stmt->execute([$username]);
      $user = $stmt->fetch();

      if ($user) {
        if (password_verify($password, $user['password'])) {
          $_SESSION['username'] = $user['username'];
          $_SESSION['access_level'] = $user['access_level'];
          logEvent($db, "Login (Successful)", $_SESSION['username'], null);
          header('Location: list_threads.php');
          exit;
        } else {
          echo 'Invalid password. Try Again.';
          logEvent($db, "Login (Failed)", null, "username: ".$username);
        }
      } else {
        echo 'Invalid username. Try Again.';
        logEvent($db, "Login (Failed)", null, "username: ".$username);
      }
    }
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Login Form</title>
    <meta name="author" content="Ryan Bowler" />
    <meta name="description" content="Login Form" />
    <link rel="stylesheet" type="text/css" href="forum_stylesheet.css" />
    <script defer>
      function validateForm() {
        const form = document.login_form;
        const errors = [];

        form.uname.style.borderColor = '';
        form.pword.style.borderColor = '';

        // trim all input values and update the input fields with the trimmed values
        form.uname.value = form.uname.value.trim();
        form.pword.value = form.pword.value.trim();

        if (form.uname.value === "") {
          errors.push('Username is empty.');
          form.uname.style.borderColor = 'red';
        }

        if (form.pword.value === "") {
          errors.push('Password is empty.');
          form.pword.style.borderColor = 'red';
        }

        if (errors.length > 0) {
          alert("Form Errors:\n" + errors.join('\n'));
          return false;
        }
      }
    </script>
  </head>
  <body>
    <h3>Login</h3>
    <p><a href="list_threads.php">List</a> | <a href="search_threads.php">Search</a></p>

    <form name="login_form" method="post" action="login.php" onsubmit="return validateForm()">
      <fieldset>
        <legend>Log In Form</legend>
        <label><span>Username<sup>*</sup>:</span><input type="text" name="uname" autofocus /></label>
        <label><span>Password<sup>*</sup>:</span><input type="password" name="pword" /></label>
        <input type="submit" name="submit" value="Log In" class="middle" />
      </fieldset>
    </form>

    <?php if (isset($errors)): ?>
      <?php foreach ($errors as $error): ?>
        <p class='error'><?= $error ?></p>
      <?php endforeach; ?>
    <?php endif; ?>
  </body>
</html>