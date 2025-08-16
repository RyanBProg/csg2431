<?php
  require "db_connect.php";

  if (isset($_SESSION['username'])) {
    header('Location: album_list.php');
    exit;
  }

  if (isset($_POST["submit"])) {
    $errors = [];
    $username = trim($_POST["uname"]) ?? "";
    $email = trim($_POST["email"]) ?? "";
    $password = trim($_POST["pword"]) ?? "";
    $conf_password = trim($_POST["pword_conf"]) ?? "";
    $profile = trim($_POST["profile"]) ?? "";
    $dob = $_POST["dob"];

    // username checks
    if (strlen($username) < 6 || strlen($username) > 20) {
      $errors[] = "Username must be between 6 and 20 characters long.";
    }
    if (!ctype_alnum($username)) {
      $errors[] = "Username may only contain letters and numbers (no spaces or symbols).";
    }

    // email checks
    if ($email === "") {
      $errors[] = "Email is empty.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors[] = "Invalid email format.";
    }

    // password checks
    if (strlen($password) < 5) {
      $errors[] = "Password must be at least 5 characters long.";
    }
    if ($conf_password !== $password) {
      $errors[] = "Password and confirm password must match.";
    }

    // date of birth checks
    if ($dob === "") {
      $errors[] = "Date of birth is empty.";
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

    if (!$errors) {
      $hash = password_hash($password, PASSWORD_DEFAULT);
      $stmt = $db->prepare("INSERT INTO user (username, password_hash, date_of_birth, profile, email) 
                            VALUES (?, ?, ?, ?, ?)");
      $result = $stmt->execute( [$username, $hash, $dob, $profile, $email] );

      if ($result) {
        $stmt2 = $db->prepare("SELECT username, access_level FROM user WHERE username = ?");
        $stmt2->execute([$username]);
        $user = $stmt2->fetch();

        if ($user) {
          $_SESSION['username'] = $user['username'];
          $_SESSION['access_level'] = $user['access_level'];
          logEvent($db, 'Member Registration', $_SESSION['username'].' registered as a member');
          header('Location: album_list.php');
          exit;
        } else {
          $errors[] = "Registration succeeded, but failed to fetch user info. Please try again";
        }
      } else if ($stmt->errorCode() === "23000") {
        $errorInfo = $stmt->errorInfo();

        if (strpos($errorInfo[2], 'PRIMARY')) {
          $errors[] = 'Username "' . htmlspecialchars($_POST['uname']) . '" is already taken.';
        } else if (strpos($errorInfo[2], 'email')) {
          $errors[] = 'Email "' . htmlspecialchars($_POST['email']) . '" is already registered.';
        } else {
          $errors[] = 'Duplicate entry found. Please use different credentials.';
        }
        // print_r($stmt->errorInfo());
      } else {
        $errors[] = 'Something went wrong';
        // print_r($stmt->errorInfo());
      }
    }
  }

  $page_title = "Register | Records";
  $page_description = "Registration Form to sign up";
  require "header.php";
?>

<main>
  <h1 class="login-register-title">Register Form</h1>
  <span class="info-link">Already have an account?
    <a href="login.php">
      Login
    </a>
  </span>
  <form
    class="form"
    name="register_form"
    method="post"
    action="register.php"
    onsubmit="return validateRegister()"
    >
    <label class="form-label">
      <span>Username<sup>*</sup>:</span>
      <?php if (isset($username)): ?>
        <input type="text" name="uname" autofocus value="<?= htmlspecialchars($username) ?>" />
      <?php else: ?>
        <input type="text" name="uname" autofocus />
      <?php endif; ?>
    </label>

    <label class="form-label">
      <span>Email<sup>*</sup>:</span>
      <?php if (isset($email)): ?>
        <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" />
      <?php else: ?>
        <input type="email" name="email" />
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

    <label class="form-label">
      <span>Confirm Password<sup>*</sup>:</span>
      <?php if (isset($conf_password)): ?>
        <input type="password" name="pword_conf" value="<?= htmlspecialchars($conf_password) ?>" />
      <?php else: ?>
        <input type="password" name="pword_conf" />
      <?php endif; ?>
    </label>

    <label class="form-label">
      <span>Date of Birth<sup>*</sup>:</span>
      <?php if (isset($dob)): ?>
        <input type="date" name="dob" value="<?= htmlspecialchars($dob) ?>" />
      <?php else: ?>
        <input type="date" name="dob" />
      <?php endif; ?>
    </label>

    <label class="form-label">
      <span>Profile:</span>
      <?php if (isset($profile)): ?>
        <textarea rows="6" name="profile"><?= nl2br(htmlspecialchars($profile)) ?></textarea>
      <?php else: ?>
        <textarea rows="6" name="profile"></textarea>
      <?php endif; ?>
    </label>

    <label>
      <?php if (isset($_POST["agree"])): ?>
        <input type="checkbox" name="agree" checked />
      <?php else: ?>
        <input type="checkbox" name="agree" />
      <?php endif; ?>
      I agree to all
      <a href="javascript: alert('Nobody reads this...')">
        terms and conditions
      </a>
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
