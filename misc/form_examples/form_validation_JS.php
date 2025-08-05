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
    <title>Client-Side Form Validation Example (JavaScript)</title>
    <meta name="author" content="Ryan Bowler" />
    <meta name="description" content="Example of client-side form validation in JavaScript" />
    <link rel="stylesheet" type="text/css" href="validation_stylesheet.css" />
    <script>
      // This function is used to validate the form
      // It is called when the form is submitted, and returns false if an error is found
      function validateForm() {
    
        // Create a variable to refer to the form
        var form = document.create_form;


        // Tests if the username field is empty
        if (form.uname.value == '') {
          alert('Username is empty.');
          return false;
        }


        // Tests if the password field is less than 6 characters long
        if (form.pword.value.length < 6) {
          alert('Password must be at least 6 characters long.');
          return false;
        }


        // Tests if the password and password confirmation fields do not match
        if (form.pword.value != form.pword_conf.value) {
          alert('Password does not match confirmation.');
          return false;
        }


        // Tests if a radio button has been selected within a group (user type)
        if (form.utype.value == '') {
          alert('User type not specified.');
          return false;
        }


        // Tests if the postcode is Not a Number (isNaN) or not 4 digits
        // (this version of the code has been replaced with a more robust one below)
        /* if (isNaN(form.pcode.value) || form.pcode.value.length != 4) {
          alert('Postcode must be a 4 digit number.');
          return false;
        } */
        
        // Tests if the postcode is not 4 digits
        if (!/^\d{4}$/.test(form.pcode.value)) {
          alert('Postcode must be a 4 digit number.');
          return false;
        }


        // Tests if the access duration is empty ("Select a Duration" value)
        if (form.duration.value == '') {
          alert('Access duration not specified.');
          return false;
        }


        // Tests if the "I agree" checkbox is unchecked
          if (!form.agree.checked) {
          alert('You must agree to the terms and conditions.');
          return false;
        }
    
      // If we get this far without returning false, validation has succeeded!
      }
    </script>
  </head>

  <body>
    <h3>Create Account</h3>
    <form name="create_form" method="post" action="form_validation_JS.php" onsubmit="return validateForm()">

      <fieldset><legend>User Credentials</legend>
  
        <label><span>Username<sup>*</sup>:</span><input type="text" name="uname" autofocus /></label>

        <label><span>Password<sup>*</sup>:</span><input type="password" name="pword" /></label>

        <label><span>Confirm Password<sup>*</sup>:</span><input type="password" name="pword_conf" /></label>
  
      </fieldset>
  
      <fieldset><legend>Other Details</legend>
  
        <span>User Type<sup>*</sup>:</span>
        <label class="radio_label"><input type="radio" name="utype" value="G" /> Guest</label>
        <label class="radio_label"><input type="radio" name="utype" value="M" /> Member</label>

        <label><span>Postcode<sup>*</sup>:</span><input type="text" name="pcode" maxlength="4" /></label>

        <label><span>Access Duration<sup>*</sup>:</span>
          <select name="duration">
            <option value="" selected disabled>Select a Duration</option>
            <option value="1">Day</option>
            <option value="2">Week</option>
            <option value="3">Month</option>
          </select>
        </label>

        <br />

        <label class="middle"><input type="checkbox" name="agree" /> I agree to all <a href="javascript: alert('Nobody reads this...')">terms and conditions</a>.</label>

        <input type="submit" name="submit" value="Submit" class="middle" />
      </fieldset>
    </form>
	<p><a href="index.php">Back to Index</a></p>
  </body>
</html>