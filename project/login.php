<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login | Records</title>
    <meta name="author" content="Ryan Bowler" />
    <meta name="description" content="Login Form" />
    <link rel="stylesheet" type="text/css" href="base_styles.css" />
    <link rel="stylesheet" type="text/css" href="login_register.css" />
    <script defer src="login.js"></script>
  </head>
  <body>
    <header>
      <nav>
        <ul>
          <li><a href="home.php">Home</a></li>
          <li><a href="login.php">Login</a></li>
          <li><a href="register.php">Register</a></li>
        </ul>
      </nav>
    </header>
    <main>
      <h1>Login Form</h1>
      <span class="info-link">Don't have an account?
        <a href="register.php">
          Register
        </a>
      </span>
      <form
        name="login_form"
        method="post"
        action="login_handler.php"
        onsubmit="return validateForm()">
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
        <input class="button" type="submit" name="submit" value="Submit" />
      </form>
    </main>
  </body>
</html>
