<?php
  require 'db_connect.php';

  if (!isset($_SESSION['username']) || !isset($_SESSION['access_level'])) {
    header('Location: list_threads.php');
    exit;
  }

  // Check for valid thread ID in URL
  if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
      echo "<p>Invalid or missing thread ID.</p>";
      echo '<a href="javascript: window.history.back()">Go Back</a>';
      exit;
  }

  if ($_SESSION['access_level'] === "admin") {
    $stmt = $db->prepare("DELETE FROM thread WHERE thread_id = ?");
    $stmt->execute([$_GET['id']]);
  } else {
    $stmt = $db->prepare("DELETE FROM thread WHERE thread_id = ? AND username = ?");
    $stmt->execute([$_GET['id'], $_SESSION['username']]);
  }

  // Check if a row was deleted
  if ($stmt->rowCount() === 1) {
      echo "<p>Thread deleted successfully.</p>";
      echo '<p><a href="list_threads.php">Back to thread list</a></p>';
  } else {
      echo "<p>Thread not found or you don't have permission to delete it.</p>";
      echo '<p><a href="list_threads.php">Back to thread list</a></p>';
  }
?>
