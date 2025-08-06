<?php
  require 'db_connect.php';
  
  if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) { // If there is no "id" URL data or it isn't a number
    header('Location: list_threads.php');
    exit;
  }

  $stmt = $db->prepare("SELECT t.thread_id, t.username, t.content, t.title, UNIX_TIMESTAMP(t.post_date) AS post_date, t.forum_id, f.forum_name
            FROM thread t
            JOIN forum f ON t.forum_id = f.forum_id
            WHERE t.thread_id = ?
            ORDER BY t.post_date DESC");

  $stmt->execute( [$_GET['id']] );
  $thread = $stmt->fetch();
  
  if (!$thread) { // If no data (no thread with that ID in the database)
    header('Location: list_threads.php');
    exit;  
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?php echo htmlentities($thread['title']); ?></title>
    <meta name="author" content="Ryan Bowler" />
    <meta name="description" content="View thread page of forum scenario" />
    <link rel="stylesheet" type="text/css" href="forum_stylesheet.css" />
    <script defer>
      function validateForm() {
        const form = document.reply_thread;
        const errors = []

        form.reply.style.borderColor = '';
        form.reply.value = form.reply.value.trim();

        if (form.reply.value === '') {
          errors.push('Reply is empty');
          form.reply.style.borderColor = 'red';
        }

        if (errors.length > 0) {
          alert("Form Errors:\n" + errors.join('\n'));
          return false;
        }
      }
    </script>
  </head>

  <body>
    <h3>View Thread</h3>
    <p><a href="list_threads.php">List</a> | <a href="search_threads.php">Search</a></p>
		<?php
      // Display the thread's details
      echo '<h4>'.htmlentities($thread['title']).'</h4>';

      echo '<p><small><em>Posted by <a href="view_profile.php?username='.$thread['username'].'">'.$thread['username'].'</a>
      in <a href="list_threads.php?forum_id='.$thread['forum_id'].'">'.$thread['forum_name'].'</a>
      on '.date('d M Y, H:i', $thread['post_date']).'
      </em></small></p>';

      if ($_SESSION['username'] === $thread['username']) {
        echo '<a href="edit_thread_form.php?id='.$thread['thread_id'].'">Edit</a> | ';
      }

      if (isset($_SESSION['access_level']) && $_SESSION['access_level'] === "admin") {
        echo '<a onclick="return confirm(\'Are you sure you want to delete this thread?\')" href="delete_thread.php?id='.$thread['thread_id'].'">Delete</a>';
      } else if ($_SESSION['username'] === $thread['username']) {
        echo '<a onclick="return confirm(\'Are you sure you want to delete this thread?\')" href="delete_thread.php?id='.$thread['thread_id'].'">Delete</a>';
      }

      echo '<p>'.nl2br(htmlentities($thread['content'])).'</p>';
    ?>

    <hr style="margin: 40px 0 20px">

    <?php
      $stmt = $db->prepare("SELECT reply_id, username, content, UNIX_TIMESTAMP(post_date) AS post_date
                            FROM reply
                            WHERE thread_id = ?
                            ORDER BY post_date ASC");
      $stmt->execute([ $thread['thread_id'] ]);
      $replies = $stmt->fetchAll();

      if (count($replies) > 0) {
        echo '<h4>Comments</h4>';
        echo '<ul style="list-style: none; padding-left: 0;">';
        foreach ($replies as $reply) {
          echo '<li class="reply">';
          echo '<p><strong><a href="view_profile.php?username=' . htmlentities($reply['username']) . '">' . htmlentities($reply['username']) . '</a></strong> ';
          echo '<small><em>on ' . date('d M Y, H:i', $reply['post_date']) . '</em></small></p>';
          echo '<p>' . nl2br(htmlentities($reply['content'])) . '</p>';
          echo '</li>';
        }
        echo '</ul>';
      } else {
        echo '<p>No replies yet!</p>';
      }
    ?>

    <?php
      if (isset($_SESSION['username'])) {
        echo '<form style="margin-top: 40px" name="reply_thread" method="post" action="reply.php" onsubmit="return validateForm()">
          <input type="hidden" name="thread_id" value="' . $thread['thread_id'] . '" />
          <div style="display: flex; gap: 5px;">
            <textarea name="reply" rows="3" placeholder="Type your reply..."></textarea>
            <input type="submit" name="submit" value="Reply" />
          </div>
        </form>';
      }
    ?>
  </body>
</html>
