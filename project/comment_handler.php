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

  if (!isset($_POST['comment'])) {
    echo "<p>Missing comment value, please re-submit comment</p>";
    echo '<a href="javascript: window.history.back()">Go Back</a>';
    exit;
  }

    $stmt = $db->prepare("INSERT INTO comment (username, album_id, content) 
                          VALUES (?, ?, ?)");
    $result = $stmt->execute( [$_SESSION['username'], $_GET['id'], $_POST['comment']] );

  if ($result) {
    header('Location: album_details.php?id=' . urlencode($_GET['id']));
  } else {
    echo "<p>Something went wrong, please re-submit comment</p>";
    echo '<a href="javascript: window.history.back()">Go Back</a>';
    //print_r($stmt->errorInfo());
    exit;
  }
?>