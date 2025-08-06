<?php
  require 'db_connect.php';

  if (!isset($_SESSION['username']) || !isset($_SESSION['access_level'])) {
    header('Location: list_threads.php');
    exit;
  }

  if ($_SESSION['access_level'] !== "admin") {
    header('Location: list_threads.php');
    exit;
  }

  if (!isset($_GET['username'])) {
    echo "<p>Invalid or missing username.</p>";
    echo '<a href="javascript: window.history.back()">Go Back</a>';
    exit;
  }

  if ($_GET['username'] === $_SESSION['username']) {
    echo "<p>Nice try but you change your own access level.</p>";
    echo '<a href="javascript: window.history.back()">Go Back</a>';
    exit;
  }

  // check for user
  $stmt = $db->prepare("SELECT * FROM user WHERE username = ?");
  $stmt->execute( [$_GET['username']] );
  $user = $stmt->fetch();
  
  if (!$user) {
    echo "<p>No user found</p>";
    echo '<a href="javascript: window.history.back()">Go Back</a>';
    exit;  
  }

  $new_access_level = $user['access_level'] === "member" ? "admin" : "member";

  // change users access_level to admin if member or to member if admin
  $stmt = $db->prepare("UPDATE user
                        SET access_level = ?
                        WHERE username = ?");
  $result = $stmt->execute( [$new_access_level, $_GET['username']] );

  if ($result) {
    header('Location: change_access_level_form.php');
    exit;
  } else {
    echo "<p>Something went wrong.</p>";
    echo '<a href="javascript: window.history.back()">Go Back</a>';
    // print_r($stmt->errorInfo());
    exit;
  }

?>