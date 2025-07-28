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
    <title>Form Element Examples</title>
    <meta name="author" content="Greg Baatard" />
    <meta name="description" content="Examples of various form elements" />
    <style>
      h3 {margin-top: 40px;}
    </style>
    <script>
      function showHelp() {
      alert('The showHelp() function has been called!');
    }
    </script>
  </head>

  <body>
    <form method="post" name="demo_form" action="form_element_examples.php">

      <h3>Text Field Example</h3>
      <label>Username: <input type="text" name="uname" maxlength="20" placeholder="Username..." title="Username" /></label>


      <h3>Password Field Example</h3>
      <label>Password: <input type="password" name="pword" placeholder="Password..." /></label>


      <h3>Text Area Example</h3>
      <textarea name="description" style="width: 200px; height: 100px;">Default text</textarea>


      <h3>Drop Down List Example</h3>
      <select name="forum">
        <option value="" selected disabled>Select a forum</option>
        <option value="1">General Discussion</option>
        <option value="2">News and Events</option>
        <option value="3">Videos and Images</option>
      </select>


      <h3>Multiple Selection List Example</h3>
      <select name="interests[]" multiple>
        <option value="IT">Information Technology</option>
        <option value="CS">Computer Science</option>
        <option value="NW">Networking</option>
        <option value="PG">Programming</option>
      </select>

      <h3>Radio Button Example</h3>
      <label><input type="radio" name="crust" value="thin" /> Thin Crust</label><br />
      <label><input type="radio" name="crust" value="thick" /> Thick Crust</label><br />
      <label><input type="radio" name="crust" value="cheese" /> Cheese Stuffed</label>

  
      <h3>Checkbox Example (Single)</h3>
      <label><input type="checkbox" name="remember" /> Remember me</label>
  

      <h3>Checkbox Example (Group)</h3>
      <label><input type="checkbox" name="pets[]" value="Cat" /> Cat</label><br />
      <label><input type="checkbox" name="pets[]" value="Dog" /> Dog</label><br />
      <label><input type="checkbox" name="pets[]" value="Bird" /> Bird</label>


      <h3>Hidden Field Example</h3>
      <input type="hidden" name="thread_id" value="10124" />


      <h3>Button Example</h3>
      <input type="submit" name="submit" value="Submit Form" />
      <input type="reset" name="reset" value="Reset Form" />
    
      <input type="button" value="Back" onclick="history.back()" />
      <input type="button" value="Home" onclick="window.location.href = 'index.php'" />
      <input type="button" value="Help" onclick="showHelp()" />
  
    </form>
	<p><a href="index.php">Back to Index</a></p>
  </body>
</html>