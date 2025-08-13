<?php
  require 'db_connect.php';

  if (!isset($_SESSION['username'])) {
    header('Location: album_list.php');
    exit;
  }

  $stmt = $db->prepare("SELECT username, date_of_birth, YEAR(date_of_birth) AS birth_year, access_level, email, profile FROM user WHERE username = ?");
  $stmt->execute( [$_SESSION['username']] );
  $user = $stmt->fetch();
  
  if (!$user) {
    header('Location: album_list.php');
    exit;  
  }

  $page_title = "User Details | Records";
  $page_description = "User details page";
  require "header.php";
?>

<main>
  <?php if ($user['username'] === $_SESSION['username']): ?>
    <h1>My Profile</h1>
  <?php else: ?>
    <h1>Viewing Profile of "<?= htmlspecialchars($user['username']) ?>"</h1>
  <?php endif; ?>

  <?php if ($user['username'] === $_SESSION['username']): ?>
    <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    <p><strong>Born In:</strong> <?= htmlspecialchars($user['date_of_birth']) ?></p>
    <p><strong>Access Level:</strong> <?= htmlspecialchars($user['access_level']) ?></p>
    <p><strong>Profile:</strong> <?= htmlspecialchars($user['profile']) ?></p>
    <a style="margin: 20px 0" href="update_profile.php?username=<?= urlencode($_SESSION['username']) ?>" class="button">Update Profile</a>
  <?php else: ?>
    <p><strong>Born In:</strong> <?= htmlspecialchars($user['birth_year']) ?></p>
    <p><strong>Profile:</strong> <?= htmlspecialchars($user['profile']) ?></p>
  <?php endif; ?>
</main>

<?php require "footer.php"; ?>
