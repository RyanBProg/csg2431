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
    $email = trim($_POST["email"]) ?? "";
    $profile = trim($_POST["profile"]) ?? "";

    // email checks
    if ($email === "") {
      $errors[] = "Email is empty.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors[] = "Invalid email format.";
    }

    if (!$errors) {
      $stmt = $db->prepare("UPDATE user SET email = ?, profile = ? WHERE username = ?");
      $result = $stmt->execute([$email, $profile, $_SESSION['username']]);

      if (!$result) {
        $message = '<p class="error">Something went wrong, please re-submit profile</p>';
        $link = '<a href="javascript: window.history.back()">Go Back</a>';
        //print_r($stmt->errorInfo());
      } else {
        $message = '<p class="success">Profile updated!</p>';
        $link = '<a href="user_profile.php">Go to profile</a>';
      }
    } else {
      $link = '<a href="javascript: window.history.back()">Go Back</a>';
    }
  } else {
    header('Location: update_profile.php');
    exit;
  }

  $page_title = "Update Profile | Records";
  $page_description = "Update profile page";
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