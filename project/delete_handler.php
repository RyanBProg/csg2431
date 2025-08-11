<?php
  require "db_connect.php";

  if (!isset($_SESSION['username']) || !isset($_SESSION['access_level']) || $_SESSION['access_level'] !== 'admin') {
    header("Location: album_list.php");
    exit;
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['album_id'])) {
    $deleteStmt = $db->prepare("DELETE FROM album WHERE album_id = ?");
    $result = $deleteStmt->execute([$_POST['album_id']]);

    if (!$result) {
      echo "<p>Delete failed, please try again</p>";
      echo '<a href="javascript: window.history.back()">Go Back</a>';
      //print_r($deleteStmt->errorInfo());
      exit;
    }

    header("Location: album_list.php");
    exit;
  } else {
    echo "<p>No album id provided</p>";
    echo '<a href="javascript: window.history.back()">Go Back</a>';
    exit;
  }
?>