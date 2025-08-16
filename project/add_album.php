<?php
  require "db_connect.php";

  if (!isset($_SESSION['access_level']) || $_SESSION['access_level'] !== 'admin') {
    header('Location: album_list.php');
    exit;
  }

  if (isset($_POST['submit'])) {
    $errors = [];
    $title = trim($_POST['title']) ?? '';
    $artist = trim($_POST['artist']) ?? '';
    $label = trim($_POST['label']) ?? '';
    $release_year = $_POST['release_year'] ?? '';
    $tracks = $_POST['tracks'] ?? [];

    // validate album fields
    if ($title === '') $errors[] = "Album title is required.";
    if ($artist === '') $errors[] = "Artist name is required.";
    if ($label === '') $errors[] = "Label is required.";

    // validate year
    $currentYear = (int)date('Y');
    if (!filter_var($release_year, FILTER_VALIDATE_INT) || $release_year < 1940 || $release_year > $currentYear) {
        $errors[] = "Release year must be a valid integer between 1940 and $currentYear.";
    }

    // validate tracks
    $valid_tracks = [];
    foreach ($tracks as $index => $track) {
      $track_title = trim($track['title'] ?? '');
      $track_no = (int)($track['track_no'] ?? 0);
      $duration = (int)($track['duration'] ?? 0);

      if ($track_title !== '' && $track_no > 0 && $duration > 0 && $duration <= 3599) {
        $valid_tracks[] = [
          'title' => $track_title,
          'track_no' => $track_no,
          'duration' => $duration
        ];
      } elseif ($track_title !== '' || $track_no > 0 || $duration > 0) {
        if ($duration > 3599) {
          $errors[] = "Track " . ($index + 1) . " duration cannot exceed 3599 seconds.";
        } else {
          $errors[] = "Track " . ($index + 1) . " has incomplete data.";
        }
      }
    }

    // title + release_year duplicate check
    if (!$errors) {
      $check_stmt = $db->prepare("SELECT COUNT(*) FROM album WHERE title = ? AND release_year = ?");
      $check_stmt->execute([$title, $release_year]);
      $existing_count = $check_stmt->fetchColumn();

      if ($existing_count > 0) {
        $errors[] = "An album with the same title and release year already exists.";
      }
    }

    // if no errors, insert into DB
    if (!$errors) {
      $stmt = $db->prepare("INSERT INTO album (title, artist, label, release_year) VALUES (?, ?, ?, ?)");
      $result = $stmt->execute([$title, $artist, $label, $release_year]);
      logEvent($db, 'Album Added', $title.' ('.$release_year.') '.'added by '.$_SESSION['username']);

      if ($result) {
        $album_id = $db->lastInsertId();

        if (!empty($valid_tracks)) {
          $track_stmt = $db->prepare("INSERT INTO track (album_id, title, track_no, duration_sec) VALUES (?, ?, ?, ?)");
          foreach ($valid_tracks as $track) {
            $track_stmt->execute([
              $album_id,
              $track['title'],
              $track['track_no'],
              $track['duration']
            ]);
          }
          logEvent($db, 'Tracks Added', count($valid_tracks).' tracks added for '.$title.' ('.$release_year.')');
        }

        header('Location: album_details.php?id=' . urlencode($album_id));
        exit;
      } else {
        $errors[] = "Failed to insert album into the database.";
      }
    }
  }

  $page_title = "Add Album | Records";
  $page_description = "To add new albums and tracks.";
  require "header.php";
?>

<main>
  <h1 class="login-register-title">Add New Album</h1>
  <form class="form" method="post" name="album_form" action="add_album.php">
    <label class="form-label">
      <span>Album Title<sup>*</sup>:</span>
      <input type="text" name="title" value="<?= htmlspecialchars($title ?? '') ?>" />
    </label>

    <label class="form-label">
      <span>Artist<sup>*</sup>:</span>
      <input type="text" name="artist" value="<?= htmlspecialchars($artist ?? '') ?>" />
    </label>

    <label class="form-label">
      <span>Label<sup>*</sup>:</span>
      <input type="text" name="label" value="<?= htmlspecialchars($label ?? '') ?>" />
    </label>

    <label class="form-label">
      <span>Release Date<sup>*</sup>:</span>
      <input type="number" name="release_year" value="<?= htmlspecialchars($release_year ?? '') ?>" />
    </label>

    <fieldset class="track-fieldset">
      <legend>Tracks</legend>

      <button type="button" style="margin: 10px 0; padding: 5px; font-size: 12px;" class="button" onclick="addTrack()">Add a Track</button>

      <?php
        $tracks = $tracks ?? [];
        foreach ($tracks as $i => $track):
      ?>
        <div class="track-block">
          <label>
            Title:
            <input type="text" name="tracks[<?= $i ?>][title]" value="<?= htmlspecialchars($track['title'] ?? '') ?>" />
          </label>
          <label>
            Track No:
            <input type="number" name="tracks[<?= $i ?>][track_no]" value="<?= htmlspecialchars($track['track_no'] ?? '') ?>" />
          </label>
          <label>
            Duration (sec):
            <input type="number" name="tracks[<?= $i ?>][duration]" value="<?= htmlspecialchars($track['duration'] ?? '') ?>" />
          </label>
          <button type="button" class="button remove-track">X</button>
        </div>
      <?php endforeach; ?>
    </fieldset>

    <?php if (!empty($errors)): ?>
      <?php foreach ($errors as $error): ?>
        <p class="error"><?= $error ?></p>
      <?php endforeach; ?>
    <?php endif; ?>

    <input class="button submit-button" type="submit" name="submit" value="Add Album" />
  </form>
</main>

<script>
  function addTrack() {
    const fieldset = document.querySelector('.track-fieldset');
    const index = fieldset.querySelectorAll('.track-block').length;
    const div = document.createElement('div');
    div.classList.add('track-block');
    div.innerHTML = `
      <label>Title: <input type="text" name="tracks[${index}][title]" /></label>
      <label>Track No: <input type="number" name="tracks[${index}][track_no]" /></label>
      <label>Duration (sec): <input type="number" name="tracks[${index}][duration]" /></label>
      <button type="button" class="button remove-track">X</button>
    `;
    fieldset.appendChild(div);
  }

  document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-track')) {
      e.target.closest('.track-block').remove();
    }
  });
</script>

<?php require "footer.php"; ?>
