<?php
  $page_title = "Register | Records";
  $page_description = "Registration Form to sign up";
  require "header.php";
?>

<main>
  <h1 class="login-register-title">Register Form</h1>
  <span class="info-link">Already have an account?
    <a href="login.php">
      Login
    </a>
  </span>
  <form
    class="form"
    name="register_form"
    method="post"
    action="register_handler.php"
    onsubmit="return validateRegister()">
    <label class="form-label">
      <span>Username<sup>*</sup>:</span>
      <input type="text" name="uname" autofocus />
    </label>
    <label class="form-label">
      <span>Email<sup>*</sup>:</span>
      <input type="email" name="email" />
    </label>
    <label class="form-label">
      <span>Password<sup>*</sup>:</span>
      <input type="password" name="pword" />
    </label>
    <label class="form-label">
      <span>Confirm Password<sup>*</sup>:</span>
      <input type="password" name="pword_conf" />
    </label>
    <label class="form-label">
      <span>Date of Birth<sup>*</sup>:</span>
      <input type="date" name="dob" />
    </label>
    <label class="form-label">
      <span>Profile:</span>
      <textarea rows="6" name="profile"></textarea>
    </label>
    <label>
      <input type="checkbox" name="agree" />
      I agree to all
      <a href="javascript: alert('Nobody reads this...')">
        terms and conditions
      </a>
    </label>
    <input class="button submit-button" type="submit" name="submit" value="Submit" />
  </form>
</main>

<?php
  require "footer.php"
?>
