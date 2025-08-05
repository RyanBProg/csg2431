<?php
  require 'db_connect.php';

  $PLACEHOLDER = "jbloggs";

  // Check for valid thread ID in URL
  if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
      echo "<p>Invalid or missing thread ID.</p>";
      exit;
  }

  $stmt = $db->prepare("DELETE FROM thread WHERE thread_id = ? AND username = ?");
  $stmt->execute([$_GET['id'], $PLACEHOLDER]);

  // Check if a row was deleted
  if ($stmt->rowCount() === 1) {
      echo "<p>Thread deleted successfully.</p>";
      echo '<p><a href="list_threads.php">Back to thread list</a></p>';
  } else {
      echo "<p>Thread not found or you don't have permission to delete it.</p>";
      echo '<p><a href="list_threads.php">Back to thread list</a></p>';
  }
?>
