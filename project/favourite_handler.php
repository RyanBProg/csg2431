<?php
  require "db_connect.php";

  if (!isset($_SESSION['username'])) {
    header('Location: album_list.php');
    exit;
  }

  // favourite album
  if (isset($_POST["album_id"])) {
    $album_id = filter_input(INPUT_POST, "album_id", FILTER_VALIDATE_INT);

    if ($album_id === false || $album_id === null) {
      echo '<p class="error">Invalid album ID.</p>';
      echo '<a href="javascript: window.history.back()">Go Back</a>';
      exit;
    }

    // check album exists
    $check = $db->prepare("SELECT 1 FROM album WHERE album_id = ?");
    $check->execute([$album_id]);
    $check_result = $check->fetch();
    if (!$check_result) {
      echo '<p class="error">Album does not exist.</p>';
      echo '<a href="javascript: window.history.back()">Go Back</a>';
      exit;
    }

    // ppdate favourite album
    $stmt = $db->prepare("UPDATE user SET favourite_album_id = ? WHERE username = ?");
    $result = $stmt->execute([$album_id, $_SESSION['username']]);
    print_r($stmt->errorInfo());

    if (!$result) {
      echo '<p class="error">Failed to add favourite album.</p>';
      echo '<a href="javascript: window.history.back()">Go Back</a>';
      print_r($stmt->errorInfo());
      exit;
    }

    header("Location: user_profile.php?username=" . urlencode($_SESSION['username']));
    exit;
  }

  // favourite track
  if (isset($_POST["track_id"])) {
    $track_id = filter_input(INPUT_POST, "track_id", FILTER_VALIDATE_INT);

    if ($track_id === false || $track_id === null) {
      echo '<p class="error">Invalid track ID.</p>';
      echo '<a href="javascript: window.history.back()">Go Back</a>';
      exit;
    }

    // check track exists
    $check = $db->prepare("SELECT 1 FROM track WHERE track_id = ?");
    $check->execute([$track_id]);
    $check_result = $check->fetch();
    if (!$check_result) {
      echo '<p class="error">Track does not exist.</p>';
      echo '<a href="javascript: window.history.back()">Go Back</a>';
      exit;
    }

    // update favourite track
    $stmt = $db->prepare("UPDATE user SET favourite_track_id = ? WHERE username = ?");
    $result = $stmt->execute([$track_id, $_SESSION['username']]);
    print_r($stmt->errorInfo());

    if (!$result) {
      echo '<p class="error">Failed to add favourite track.</p>';
      echo '<a href="javascript: window.history.back()">Go Back</a>';
      print_r($stmt->errorInfo());
      exit;
    }

    header("Location: user_profile.php?username=" . urlencode($_SESSION['username']));
    exit;
  }

    echo '<p class="error">No valid form data provided.</p>';
    echo '<a href="javascript: window.history.back()">Go Back</a>';
    exit;
?>
