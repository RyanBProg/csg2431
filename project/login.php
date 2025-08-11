<?php
  require "db_connect.php";

  if (isset($_SESSION['username'])) {
    header('Location: album_list.php');
    exit;
  }

  if (isset($_POST['submit'])) {
    $errors = [];
    $username = trim($_POST["username"]) ?? "";
    $password = trim($_POST["pword"]) ?? "";

    if ($username === "") {
      $errors[] = "Username is empty";
    }

    if ($password === "") {
      $errors[] = "Password is empty";
    }

    if (!$errors) {
      $stmt = $db->prepare("SELECT * FROM user WHERE username = ? AND password = ?");
      $stmt->execute([$username, $password]);
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
      <span>Username<sup>*</sup>:</span>
      <?php if (isset($username)): ?>
        <input type="text" name="username" autofocus value="<?= htmlspecialchars($username) ?>" />
      <?php else: ?>
        <input type="text" name="username" autofocus />
      <?php endif; ?>
    </label>
    
    <label class="form-label">
      <span>Password<sup>*</sup>:</span>
      <?php if (isset($password)): ?>
        <input type="password" name="pword" value="<?= htmlspecialchars($password) ?>" />
      <?php else: ?>
        <input type="password" name="pword" />
      <?php endif; ?>
    </label>

    <?php if (isset($errors)): ?>
      <?php foreach ($errors as $error): ?>
        <p class='error'><?= $error ?></p>
      <?php endforeach; ?>
    <?php endif; ?>

    <input class="button submit-button" type="submit" name="submit" value="Submit" />
  </form>
</main>

<?php
  require "footer.php"
?>