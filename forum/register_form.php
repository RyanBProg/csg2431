<!DOCTYPE html>
<html>
  <head>
    <title>Register Form</title>
    <meta name="author" content="Ryan Bowler" />
    <meta name="description" content="Register Form" />
    <link rel="stylesheet" type="text/css" href="register_styles.css" />
    <script defer>
      function validateForm() {
        const form = document.register_form;
        const errors = [];

        form.uname.style.borderColor = '';
        form.pword.style.borderColor = '';
        form.pword_conf.style.borderColor = '';
        form.real_name.style.borderColor = '';
        form.dob.style.borderColor = '';

        // trim all input values and update the input fields with the trimmed values
        form.uname.value = form.uname.value.trim();
        form.pword.value = form.pword.value.trim();
        form.pword_conf.value = form.pword_conf.value.trim();
        form.real_name.value = form.real_name.value.trim();

        if (form.uname.value.length < 6 || form.uname.value.length > 20) {
          errors.push('Username must be between 6 and 20 characters long.');
          form.uname.style.borderColor = 'red';
        }

        if (!/^[a-zA-Z0-9]+$/.test(form.uname.value)) {
          errors.push('Username may only contain letters and numbers (no spaces or symbols).');
          form.uname.style.borderColor = 'red';
        }

        if (form.pword.value.length < 8) {
          errors.push('Password must be at least 8 characters long.');
          form.pword.style.borderColor = 'red';
        }

        if (form.pword.value != form.pword_conf.value) {
          errors.push('Password does not match confirmation.');
          form.pword.style.borderColor = 'red';
          form.pword_conf.style.borderColor = 'red';
        }

        if (form.dob.value === "") {
          errors.push('Date of birth not specified.');
          form.dob.style.borderColor = 'red';
        }

        // check that the user is at least 14 years old
        if (form.dob.value !== "") {
          const dob = new Date(form.dob.value);
          const today = new Date();
          let age = today.getFullYear() - dob.getFullYear();
          const m = today.getMonth() - dob.getMonth();
          if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
            age--;
          }
          if (isNaN(dob.getTime())) {
            errors.push('Invalid date of birth.');
            form.dob.style.borderColor = 'red';
          } else if (age < 14) {
            errors.push('You must be at least 14 years old to register.');
            form.dob.style.borderColor = 'red';
          }
        }

        if (!form.agree.checked) {
          errors.push('You must agree to the terms and conditions.');
        }

        if (errors.length > 0) {
          alert("Form Errors:\n" + errors.join('\n'));
          return false;
        }
      }
    </script>
  </head>
  <body>
    <h3>Create Account</h3>
    <p><a href="list_threads.php">List</a> | <a href="search_threads.php">Search</a></p>
    <form name="register_form" method="post" action="register.php" onsubmit="return validateForm()">

      <fieldset>
        <legend>User Credentials</legend>
  
        <label><span>Username<sup>*</sup>:</span><input type="text" name="uname" autofocus /></label>

        <label><span>Password<sup>*</sup>:</span><input type="password" name="pword" /></label>

        <label><span>Confirm Password<sup>*</sup>:</span><input type="password" name="pword_conf" /></label>
  
      </fieldset>
  
      <fieldset>
        <legend>Other Details</legend>

        <label><span>Real Name:</span><input type="text" name="real_name" /></label>

        <label><span>Date of Birth<sup>*</sup>:</span><input type="date" name="dob" /></label>

        <br />

        <label class="middle"><input type="checkbox" name="agree" /> I agree to all <a href="javascript: alert('Nobody reads this...')">terms and conditions</a>.</label>

        <input type="submit" name="submit" value="Submit" class="middle" />
      </fieldset>
    </form>
  </body>
</html>