<?php
  require 'db_connect.php';

  if (!isset($_SESSION['username']) || !isset($_GET['username'])) {
    header('Location: album_list.php');
    exit;
  }

  if ($_SESSION['username'] !== $_GET['username']) {
    header('Location: album_list.php');
    exit;
  }

  if (isset($_POST["submit"])) {
    $errors = [];
    $email = trim($_POST["email"]) ?? "";
    $password = trim($_POST["pword"]) ?? "";
    $conf_password = trim($_POST["pword_conf"]) ?? "";
    $profile = trim($_POST["profile"]) ?? "";

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

    if (!$errors) {
      $stmt = $db->prepare("UPDATE user 
                            SET email = ?, password = ?, profile = ? 
                            WHERE username = ?");
      $result = $stmt->execute([$email, $password, $profile, $_SESSION['username']]);

      if ($result === false) {
        $errorCode = $stmt->errorCode();

        if ($errorCode === "23000") {
          $errorInfo = $stmt->errorInfo();

          if (strpos($errorInfo[2], 'email') !== false) {
            $errors[] = 'Email "' . htmlspecialchars($_POST['email']) . '" is already registered';
          } else {
            $errors[] = 'Duplicate entry found. Please use different credentials';
          }
        } else {
          $errors[] = 'Something went wrong, try again!';
        }
      } else {
        $success = "Profile updated!";
      }
    }
  }

  $stmt = $db->prepare("SELECT username, email, password, profile FROM user WHERE username = ?");

  $stmt->execute( [$_SESSION['username']] );
  $user = $stmt->fetch();
  
  if (!$user) {
    header('Location: album_list.php');
    exit;  
  }

  $page_title = "Update Details | Records";
  $page_description = "Update details page";
  require "header.php";
?>

<main>
  <h1 class="login-register-title">Update Details</h1>

  <form class="form"
    name="update_profile_form"
    method="post"
    action="update_profile.php?username=<?= $_SESSION['username'] ?>"
    onSubmit="return validateProfileUpdate()"
    >
    <label class="form-label">
      <span>Email<sup>*</sup>:</span>
      <input type="email" name="email" value="<?= $user['email'] ?>" />
    </label>

    <label class="form-label">
      <span>Password<sup>*</sup>:</span>
      <input type="password" name="pword" value="<?= $user['password'] ?>" />
    </label>

    <label class="form-label">
      <span>Confirm Password<sup>*</sup>:</span>
      <input type="password" name="pword_conf" value="<?= $user['password'] ?>" />
    </label>

    <label class="form-label">
      <span>Profile:</span>
      <textarea rows="6" name="profile"><?= nl2br(htmlentities($user['profile'])) ?></textarea>
    </label>

    <?php if (isset($errors)): ?>
      <?php foreach ($errors as $error): ?>
        <p class='error'><?= $error ?></p>
      <?php endforeach; ?>
    <?php endif; ?>

    <?php if (isset($success)): ?>
      <p class='success'><?= $success ?></p>
    <?php endif; ?>

    <input class="button submit-button" type="submit" name="submit" value="Submit" />
  </form>
</main>

<?php require "footer.php"; ?>
