<?php
  require 'db_connect.php';

  if (!isset($_SESSION['username'])) {
    header('Location: list_threads.php');
    exit;
  }

  if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    echo "<p>No thread id provided</p>";
    exit;
  }

  $stmt = $db->prepare("SELECT *
                        FROM thread
                        WHERE thread_id = ? AND username = ?
                        ORDER BY post_date DESC");

  $stmt->execute( [$_GET['id'], $_SESSION['username']] );
  $thread = $stmt->fetch();
  
  if (!$thread) {
    echo "<p>No thread found</p>";
    exit;  
  }
?>

<!DOCTYPE html>
<html>
  <head>
   <title>Edit Thread</title>
   <meta name="author" content="Ryan Bowler" />
   <meta name="description" content="Edit forum thread form." />
   <link rel="stylesheet" type="text/css" href="forum_stylesheet.css" />
   <script defer>
      function validateForm() {
        const form = document.edit_thread;
        const errors = []

        form.title.style.borderColor = '';
        form.content.style.borderColor = '';
        form.forum.style.borderColor = '';

        // trim all input values and update the input fields with the trimmed values
        form.title.value = form.title.value.trim();
        form.content.value = form.content.value.trim();
        form.forum.value = form.forum.value.trim();

        if (form.title.value === '') {
          errors.push('Title is empty');
          form.title.style.borderColor = 'red';
        }

        if (form.content.value === '') {
          errors.push('Content is empty');
          form.content.style.borderColor = 'red';
        }

        if (form.forum.value === '') {
          errors.push('Please select a forum');
          form.forum.style.borderColor = 'red';
        }

        if (errors.length > 0) {
          alert("Form Errors:\n" + errors.join('\n'));
          return false;
        }
      }
    </script>
  </head>

  <body>
    <h1>Edit Thread</h1> 
    <p><a href="list_threads.php">List</a> | <a href="search_threads.php">Search</a></p>
    <?php echo '<a style="display: inline-block; margin: 10px 0;" href="view_thread.php?id='.$thread['thread_id'].'"><- Return to thread</a>'; ?>
    <form class="thread-form" name="edit_thread" method="post" action="edit_thread.php" onsubmit="return validateForm()">
	
      <label for="title"><strong>Title:</strong></label>
      <?php echo '<input type="text" id="title" name="title" value="'.htmlspecialchars($thread['title']).'" />'; ?>

      <br />

      <label for="content"><strong>Content:</strong></label>
      <textarea id="content" name="content" rows="8"><?php echo htmlspecialchars($thread['content']); ?></textarea>

      <div class="forum-group">
        <label for="forum"><strong>Select Forum:</strong></label>
        <select id="forum" name="forum_id">
          <option value="" disabled>Select a forum</option>
          <?php  
            // Select details of all forums
            $result = $db->query("SELECT * FROM forum ORDER BY forum_id");
      
            // Loop through each forum to generate an option of the drop-down list
            foreach($result as $row) {
              echo '<option value="'.htmlspecialchars($row['forum_id']).'"'. (($thread['forum_id'] ?? '') == $row['forum_id'] ? ' selected' : '') .'>'.htmlspecialchars($row['forum_name']).'</option>';
            }
          ?>
        </select>
      </div>

      <input type="hidden" name="thread_id" value="<?php echo htmlspecialchars($thread['thread_id']); ?>" />
	
      <input type="submit" name="submit" value="Submit" />
    </form>
  </body>
</html>