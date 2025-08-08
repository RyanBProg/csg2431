<?php
  require "db_connect.php";

  if (isset($_SESSION['username'])) {
    header('Location: album_list.php');
    exit;
  }

  if (isset($_POST['submit'])) {
    $errors = [];

    // trim all input values
    $email = trim($_POST["email"]) ?? "";
    $password = trim($_POST["pword"]) ?? "";

    // email checks
    if ($email === "") {
      $errors[] = "Email is empty";
    }

    // password checks
    if ($password === "") {
      $errors[] = "Password is empty";
    }

    if (!$errors) {
      $stmt = $db->prepare("SELECT * FROM user WHERE email = ? AND password = ?");
      $stmt->execute([$email, $password]);
      $user = $stmt->fetch();

      if ($user) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['access_level'] = $user['access_level'];
        header('Location: album_list.php');
        exit;
      } else {
        $errors[] = 'Invalid credentials, try again!';
      }
    }
  }

  $page_title = "Login | Records";
  $page_description = "Login Form for users";
  require "header.php";
?>

<main>
  <h1 class="login-register-title">Login Form</h1>
  <span class="info-link">Don't have an account?
    <a href="register.php">
      Register
    </a>
  </span>
  <form
    class="form"
    name="login_form"
    method="post"
    action="login.php"
    onsubmit="return validateLogin()">
    <label class="form-label">
      <span>Email<sup>*</sup>:</span>
      <input type="email" name="email" autofocus />
    </label>
    <label class="form-label">
      <span>Password<sup>*</sup>:</span>
      <input type="password" name="pword" />
    </label>

    <?php
      if ($errors){
        foreach ($errors as $error) {
          echo "<p class='error'>".$error."</p>";
        }
      }
    ?>

    <input class="button submit-button" type="submit" name="submit" value="Submit" />
  </form>
</main>

<?php
  require "footer.php"
?>