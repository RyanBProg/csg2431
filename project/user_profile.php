<?php
  require 'db_connect.php';

  if (!isset($_SESSION['username']) || !isset($_GET['username'])) {
    header('Location: album_list.php');
    exit;
  }

  $stmt = $db->prepare("SELECT username, date_of_birth, YEAR(date_of_birth) AS birth_year, access_level, email, password, profile FROM user WHERE username = ?");

  $stmt->execute( [$_GET['username']] );
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
  <?php
    if ($user['username'] === $_SESSION['username']){
      echo '<h1>My Profile</h1>';
    } else {
      echo '<h1>Viewing Profile of "' . htmlentities($user['username']) . '"</h1>';
    }
  ?>
  <a style="display: block; margin: 20px 0;" href="javascript:history.back()"><- Back</a> 

  <?php
    if ($user['username'] === $_SESSION['username']){
      echo '<p><strong>Username:</strong> ' . htmlentities($user['username']) . '</p>';
      echo '<p><strong>Email:</strong> ' . htmlentities($user['email']) . '</p>';
      echo '<p><strong>Born In:</strong> ' . htmlentities($user['date_of_birth']) . '</p>';
      echo '<p><strong>Access Level:</strong> ' . htmlentities($user['access_level']) . '</p>';
      echo '<a style="margin: 20px 0" href="update_profile.php?username=' . $_GET['username'] . '" class="button">Update Profile</a>';
    } else {
      echo '<p><strong>Born In:</strong> ' . htmlentities($user['birth_year']) . '</p>';
      echo '<p><strong>Profile:</strong> ' . htmlentities($user['profile']) . '</p>';
    }
  ?>
</main>

<?php require "footer.php"; ?>
