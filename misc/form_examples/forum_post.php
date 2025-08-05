<?php
// This code checks if the $_POST variable (which contains form data submitted using the POST method)
// contains a key of 'submit' (the name of the submit button), and if so it prints the form data.
if (isset($_POST['submit']))
{
  echo '<h3>Form submitted successfully!</strong></h3>';

  // The <pre> tags ensure that the layout/whitespace is preserved, for easy reading.
  // See https://www.php.net/manual/en/function.print-r.php for details about print_r().
  echo '<pre>';
  print_r($_POST);
  echo '</pre>';
}

// If the form has not been submitted, the PHP doesn't do/display anything...
?>
<!DOCTYPE html>
<html>
  <head>
   <title>New Thread</title>
   <meta name="author" content="Ryan Bowler" />
   <meta name="description" content="Example of a new forum thread form." />
  </head>

  <body>
    <h1>New Thread</h1>
    <p>What do you want to post about today?</p>
 
    <form name="new_thread" method="post" action="forum_post.php">
	
      <p><strong>Title:</strong><br />
        <input type="text" name="title" style="width: 600px;" />
      </p>

      <p><strong>Content:</strong><br />
        <textarea name="content" style="width: 600px; height: 200px"></textarea>
      </p>

      <p><strong>Select Forum:</strong>
        <select name="forum">
          <option value="" selected disabled>Select a Forum</option>
          <option value="1">TV and Movies</option>
          <option value="2">Gaming</option>
          <option value="3">Music</option>
        </select>
      </p>

      <p><strong>Tags:</strong><br />
        <input type="checkbox" name="tags[]" value="news" /> News 
        <input type="checkbox" name="tags[]" value="question" /> Question 
        <input type="checkbox" name="tags[]" value="humour" /> Humour 
        <input type="checkbox" name="tags[]" value="achievement" /> Achievement 
        <input type="checkbox" name="tags[]" value="controversial" /> Controversial 
      </p>
	
      <p>
        <input type="submit" name="submit" value="Submit" />
      </p>

    </form>
	<p><a href="index.php">Back to Index</a></p>
  </body>
</html>