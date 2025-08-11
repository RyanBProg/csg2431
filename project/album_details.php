<?php
  require 'db_connect.php';

  if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header('Location: album_list.php');
    exit;
  }

  // Fetch album and tracks
  $stmt = $db->prepare("SELECT a.album_id, a.title AS album_title, a.artist, a.label, a.release_date, 
                              t.track_id, t.title AS track_title, t.duration_sec, t.track_no
                        FROM album a
                        LEFT JOIN track t ON a.album_id = t.album_id
                        WHERE a.album_id = ?
                        ORDER BY t.track_no");
  $stmt->execute([$_GET['id']]);
  $rows = $stmt->fetchAll();

  if (!$rows) {
    header('Location: album_list.php');
    exit;
  }

  // Build album array
  $album = [
    'album_id' => $rows[0]['album_id'],
    'title' => $rows[0]['album_title'],
    'artist' => $rows[0]['artist'],
    'label' => $rows[0]['label'],
    'release_date' => $rows[0]['release_date'],
    'tracks' => []
  ];

  foreach ($rows as $row) {
    if ($row['track_id'] !== null) {
      $album['tracks'][] = [
        'track_id' => $row['track_id'],
        'title' => $row['track_title'],
        'duration_sec' => $row['duration_sec'],
        'track_no' => $row['track_no']
      ];
    }
  }

  $page_title = "Album Details | Records";
  $page_description = "A detailed view of a selected album";
  require "header.php";
?>

<main>
  <h1><?= htmlentities($album['title']) ?> (<?= date('Y', strtotime($album['release_date'])) ?>)</h1>
  <div class="column-container">
    <section>
      <p><strong>Artist:</strong> <?= htmlentities($album['artist']) ?></p>
      <p><strong>Label:</strong> <?= htmlentities($album['label']) ?></p>
      <p><strong>Track List:</strong></p>

      <?php if (!empty($album['tracks'])): ?>
        <ol class="track-list">
          <?php foreach ($album['tracks'] as $track): ?>
            <li>
              <?= htmlentities($track['track_no']) ?>. <?= htmlentities($track['title']) ?> 
              (<?= gmdate("i:s", $track['duration_sec']) ?>)
            </li>
          <?php endforeach; ?>
        </ol>
      <?php else: ?>
        <p>No tracks found.</p>
      <?php endif; ?>

      <?php if(isset($_SESSION['access_level']) && $_SESSION['access_level'] === "admin"): ?>
        <form action="delete_handler.php" method="post" onsubmit="return handleDelete()">
          <input type="hidden" name="album_id" value="<?= $album['album_id'] ?>">
          <button type="submit" class="button delete-button">Delete</button>
        </form>
      <?php endif; ?>
    </section>

    <aside>
      <?php
        $album_id = (int) $_GET['id'];
        $username = $_SESSION['username'] ?? null;

        // average rating
        $stmt_avg = $db->prepare("SELECT ROUND(AVG(value), 2) AS avg_rating FROM rating WHERE album_id = ?");
        $stmt_avg->execute([$album_id]);
        // returns each row as an associative array only (only named keys, not indexed)
        $avg_result = $stmt_avg->fetch(PDO::FETCH_ASSOC);
        $avg_rating = $avg_result['avg_rating'] ?? 'N/A';

        // current user's rating
        $user_rating = 'N/A';
        if ($username) {
          $stmt_user = $db->prepare("SELECT value FROM rating WHERE album_id = ? AND username = ?");
          $stmt_user->execute([$album_id, $username]);
          $user_result = $stmt_user->fetch(PDO::FETCH_ASSOC);
          if ($user_result) {
            $user_rating = $user_result['value'];
          }
        }
      ?>

      <p><strong>Member Rating:</strong> <?= $avg_rating ?> <span style="font-size: 12px">/5</span></p>
      <?php if (isset($_SESSION['username'])): ?>
        <p><strong>Your Rating:</strong> <?= $user_rating ?> <span style="font-size: 12px">/5</span></p>
      <?php endif; ?>

      <?php
        if (isset($_SESSION['username'])) {
          $ratingOptions = '';
          for ($i = 1; $i <= 5; $i++) {
            $ratingOptions .= '<label>
                <input type="radio" name="rating" value="' . $i . '">
                ' . $i . '&#9733;
              </label>';
          }
        }
      ?>

      <?php if (isset($_SESSION['username'])): ?>
        <form
          name="rating_form"
          method="post"
          action="rating_handler.php?id=' . $_GET['id'] . '"
          onsubmit="return validateRating()">
          <fieldset class="star-rating">
            <legend>Rate this album</legend>
            <div class="rating-list">
              <?= $ratingOptions ?>
            </div>
            <input class="button" type="submit" name="submit" value="Submit" />
          </fieldset>
        </form>
      <?php endif; ?>


      <p class="member-comments-title"><strong>Member Comments:</strong></p>
      <?php
        $album_id = (int) $_GET['id'];
        $stmt = $db->prepare("SELECT username, content, created_at
                              FROM comment
                              WHERE album_id = ?
                              ORDER BY created_at DESC");

        $stmt->execute([$album_id]);
        // returns each row as an associative array only (only named keys, not indexed)
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
      ?>

      <ul class="comment-list">
        <?php if ($comments): ?>
          <?php foreach ($comments as $comment): ?>
            <li>
              <div class="comment-details">
                <p>
                  <strong>
                    <?php if (isset($_SESSION['username'])): ?>
                      <a href="user_profile.php?username=<?= urlencode($comment['username']) ?>">
                        <?= htmlspecialchars($comment['username']) ?>
                      </a>
                    <?php else: ?>
                      <?= htmlspecialchars($comment['username']) ?>
                    <?php endif; ?>
                  </strong>
                </p> -
                <p><em><?= date('d/m/Y', strtotime($comment['created_at'])) ?></em></p>
              </div>
              <p><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
            </li>
          <?php endforeach; ?>
        <?php else: ?>
          <li><p>No comments yet. Be the first to comment!</p></li>
        <?php endif; ?>
      </ul>

      <?php if (isset($_SESSION['username'])): ?>
          <form name="comment_form" method="post" action="comment_handler.php?id=<?= $_GET['id'] ?>" class="add-comment-form" onsubmit="return validateComment()">
            <fieldset class="comment-fieldset">
              <legend>Add a Comment</legend>
              <label for="comment">Comment:</label>
              <textarea id="comment" name="comment" rows="3"></textarea>
              <input class="button" type="submit" name="submit" value="Submit" />
            </fieldset>
          </form>
      <?php endif; ?>
    </aside>
  </div>
</main>

<?php require "footer.php"; ?>
