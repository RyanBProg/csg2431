<?php
  require 'db_connect.php';
?>

<!DOCTYPE html>
<html>
  <head>
   <title>New Thread</title>
   <meta name="author" content="Ryan Bowler" />
   <meta name="description" content="New forum thread form." />
   <link rel="stylesheet" type="text/css" href="new_thread_styles.css" />
   <script defer>
      function validateForm() {
        const form = document.new_thread;
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
    <h1>New Thread</h1> 
    <p><a href="list_threads.php">List</a> | <a href="search_threads.php">Search</a></p>
    <form name="new_thread" method="post" action="new_thread.php" onsubmit="return validateForm()">
	
      <label for="title"><strong>Title:</strong></label>
      <input type="text" id="title" name="title" />

      <br />

      <label for="content"><strong>Content:</strong></label>
      <textarea id="content" name="content" rows="8"></textarea>

      <div class="forum-group">
        <label for="forum"><strong>Select Forum:</strong></label>
        <select id="forum" name="forum_id">
          <option value="" selected disabled>Select a forum</option>
          <?php  
            // Select details of all forums
            $result = $db->query("SELECT * FROM forum ORDER BY forum_id");
      
            // Loop through each forum to generate an option of the drop-down list
            foreach($result as $row)
            {
              echo '<option value="'.$row['forum_id'].'">'.$row['forum_name'].'</option>';
            }
          ?>
        </select>
      </div>
	
      <input type="submit" name="submit" value="Submit" />
    </form>
  </body>
</html>