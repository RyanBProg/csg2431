<?php
require 'db_connect.php';

if (!isset($_SESSION['username'])) {
  header('Location: album_list.php');
  exit;
}

// user info
$stmt = $db->prepare("
  SELECT username, date_of_birth, YEAR(date_of_birth) AS birth_year,
         access_level, email, profile,
         favourite_album_id, favourite_track_id
  FROM user
  WHERE username = ?
");
$stmt->execute([$_GET['username']]);
$user = $stmt->fetch();

if (!$user) {
  header('Location: album_list.php');
  exit;
}

// Optional: fetch favourite album details
$fav_album = null;
if (!empty($user['favourite_album_id'])) {
  $stmt = $db->prepare("SELECT title, artist, release_year, album_id FROM album WHERE album_id = ?");
  $stmt->execute([$user['favourite_album_id']]);
  $fav_album = $stmt->fetch();
}

// Optional: fetch favourite track details and its album/artist
$fav_track = null;
if (!empty($user['favourite_track_id'])) {
  $stmt = $db->prepare("
    SELECT t.title AS track_title, a.artist, t.album_id
    FROM track t
    JOIN album a ON t.album_id = a.album_id
    WHERE t.track_id = ?
  ");
  $stmt->execute([$user['favourite_track_id']]);
  $fav_track = $stmt->fetch();
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

    <?php if ($fav_album): ?>
      <p><strong>Favourite Album:</strong>
        <a href="album_details.php?id=<?= urlencode($fav_album['album_id']) ?>">
          <?= htmlspecialchars($fav_album['artist']) ?>,
          "<?= htmlspecialchars($fav_album['title']) ?>"
          (<?= htmlspecialchars($fav_album['release_year']) ?>)
        </a>
      </p>
    <?php endif; ?>

    <?php if ($fav_track): ?>
      <p><strong>Favourite Track:</strong>
        <a href="album_details.php?id=<?= urlencode($fav_track['album_id']) ?>">
          <?= htmlspecialchars($fav_track['artist']) ?>,
          "<?= htmlspecialchars($fav_track['track_title']) ?>"
        </a>
      </p>
    <?php endif; ?>

    <a style="margin: 20px 0" href="update_profile.php?username=<?= urlencode($_SESSION['username']) ?>" class="button">Update Profile</a>
  <?php else: ?>
    <p><strong>Born In:</strong> <?= htmlspecialchars($user['birth_year']) ?></p>
    
    <?php if ($fav_album): ?>
      <p><strong>Favourite Album:</strong>
        <a href="album_details.php?id=<?= urlencode($fav_album['album_id']) ?>">
          <?= htmlspecialchars($fav_album['artist']) ?>,
          "<?= htmlspecialchars($fav_album['title']) ?>"
          (<?= htmlspecialchars($fav_album['release_year']) ?>)
        </a>
      </p>
    <?php endif; ?>
    <?php if ($fav_track): ?>
      <p><strong>Favourite Track:</strong>
        <a href="album_details.php?id=<?= urlencode($fav_track['album_id']) ?>">
          <?= htmlspecialchars($fav_track['artist']) ?>,
          "<?= htmlspecialchars($fav_track['track_title']) ?>"
        </a>
      </p>
    <?php endif; ?>

    <p><strong>Profile:</strong> <?= htmlspecialchars($user['profile']) ?></p>
  <?php endif; ?>
</main>

<?php require "footer.php"; ?>
