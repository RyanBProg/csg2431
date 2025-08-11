<?php
  require 'db_connect.php';

  if (!isset($_SESSION['username'])) {
    header('Location: album_list.php');
    exit;
  }

  $stmt = $db->prepare("SELECT email, profile FROM user WHERE username = ?");
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
    action="update_profile_handler.php"
    onsubmit="return validateProfileUpdate()"
    >
    <label class="form-label">
      <span>Email<sup>*</sup>:</span>
      <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" />
    </label>

    <label class="form-label">
      <span>Profile:</span>
      <textarea rows="6" name="profile"><?= nl2br(htmlspecialchars($user['profile'])) ?></textarea>
    </label>

    <input class="button submit-button" type="submit" name="submit" value="Update Details" />
  </form>

  <h2 style="margin: 40px 0 20px" class="login-register-title">Update Password</h2>

  <form class="form"
    name="update_password_form"
    method="post"
    action="update_password_handler.php"
    onsubmit="return validatePasswordUpdate()"
    >
    <label class="form-label">
      <span>Current Password<sup>*</sup>:</span>
      <input type="password" name="current" />
    </label>

    <label class="form-label">
      <span>Password<sup>*</sup>:</span>
      <input type="password" name="pword" />
    </label>

    <label class="form-label">
      <span>Confirm Password<sup>*</sup>:</span>
      <input type="password" name="pword_conf" />
    </label>

    <input class="button submit-button" type="submit" name="submit" value="Update Password" />
  </form>
</main>

<?php require "footer.php"; ?>
