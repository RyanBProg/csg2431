<?php
  require 'db_connect.php';

  if (!isset($_SESSION['username'])) {
    header('Location: album_list.php');
    exit;
  }

  if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    echo "<p>Invalid or missing album ID</p>";
    echo '<a href="javascript: window.history.back()">Go Back</a>';
    exit;
  }

  if (!isset($_POST['rating'])) {
    echo "<p>Missing rating value, please re-submit rating</p>";
    echo '<a href="javascript: window.history.back()">Go Back</a>';
    exit;
  }

  $stmt = $db->prepare("INSERT INTO rating (username, album_id, value)
                        VALUES (?, ?, ?)
                        ON DUPLICATE KEY UPDATE value = VALUES(value)");
  $result = $stmt->execute( [$_SESSION['username'], $_GET['id'], $_POST['rating']] );

  if ($result) {
    header('Location: album_details.php?id=' . $_GET['id']);
  } else {
    echo "<p>Something went wrong, please re-submit rating</p>";
    echo '<a href="javascript: window.history.back()">Go Back</a>';
    //print_r($stmt->errorInfo());
    exit;
  }
?>