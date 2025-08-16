<?php
  require 'db_connect.php';

  if (!isset($_SESSION['username'])) {
    header('Location: album_list.php');
    exit;
  }

  if (isset($_POST["submit"])) {
    $errors = [];
    $message = '';
    $link = '';
    $cur_password = trim($_POST["current"]) ?? "";
    $password = trim($_POST["pword"]) ?? "";
    $conf_password = trim($_POST["pword_conf"]) ?? "";

    // password checks
    if ($cur_password === "") {
      $errors[] = "Please provide a current password.";
    }
    if (strlen($password) < 5) {
      $errors[] = "Password must be at least 5 characters long.";
    }
    if ($conf_password !== $password) {
      $errors[] = "Password and confirm password must match.";
    }

    if (!$errors) {
      // look up user and check password
      $stmt = $db->prepare("SELECT password_hash FROM user WHERE username = ?");
      $stmt->execute( [$_SESSION['username']] );
      $user = $stmt->fetch();
      
      if (!$user) {
        header('Location: album_list.php');
        exit;  
      }

      if (!password_verify($cur_password, $user['password_hash'])) {
        $message = '<p class="error">Incorrect current password</p>';
        $link = '<a href="javascript: window.history.back()">Go Back</a>';
      } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt2 = $db->prepare("UPDATE user SET password_hash = ? WHERE username = ?");
        $result = $stmt2->execute([$hash, $_SESSION['username']]);

        if (!$result) {
          $message = '<p class="error">Something went wrong, please re-submit password</p>';
          $link = '<a href="javascript: window.history.back()">Go Back</a>';
          //print_r($stmt2->errorInfo());
        } else {
            $message = '<p class="success">Password updated!</p>';
            $link = '<a href="user_profile.php?username=' . urlencode($_SESSION['username']) . '">Go to profile</a>';
        }
      }
    } else {
      $link = '<a href="javascript: window.history.back()">Go Back</a>';
    }
  } else {
    header('Location: update_profile.php');
    exit;
  }

  $page_title = "Update Password | Records";
  $page_description = "Update password page";
  require "header.php";
?>

<main>
  <?php if($errors): ?>
    <?php foreach ($errors as $error): ?>
      <p class="error"><?= $error ?></p>
    <?php endforeach; ?>
  <?php else: ?>
    <?= $message ?>
  <?php endif; ?>
  <?= $link ?>
</main>

<?php require "footer.php"; ?>