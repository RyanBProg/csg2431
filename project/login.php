<?php
  $page_title = "Login | Records";
  $page_description = "Login Form for users";
  require "header.php";
?>

<main>
  <h1 class="login-register-title">Login Form</h1>
  <span class="info-link">Don't have an account?
    <a href="register.php">
      Register
    </a>
  </span>
  <form
    class="form"
    name="login_form"
    method="post"
    action="login_handler.php"
    onsubmit="return validateLogin()">
    <label class="form-label">
      <span>Email<sup>*</sup>:</span>
      <input type="email" name="email" autofocus />
    </label>
    <label class="form-label">
      <span>Password<sup>*</sup>:</span>
      <input type="password" name="pword" />
    </label>
    <input class="button submit-button" type="submit" name="submit" value="Submit" />
  </form>
</main>

<?php
  require "footer.php"
?>