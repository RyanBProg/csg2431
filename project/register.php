<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register | Records</title>
    <meta name="author" content="Ryan Bowler" />
    <meta name="description" content="Registration Form" />
    <link rel="stylesheet" type="text/css" href="base_styles.css" />
    <link rel="stylesheet" type="text/css" href="login_register.css" />
    <script defer src="register.js"></script>
    <script defer src="search.js"></script>
  </head>
  <body>
    <header>
      <nav>
        <ul>
          <li><a class="button" href="album_list.php">Albums</a></li>
          <li><a class="button" href="login.php">Login</a></li>
          <li><a class="button" href="register.php">Register</a></li>
        </ul>
      </nav>
      <form
        name="search_form"
        class="searchbar"
        method="post"
        action="search_handler.php"
        onsubmit="return validateSearch()">
        <label for="search">Search Albums</label>
        <input id="search" name="search" type="text" placeholder="Search Albums...">
        <input class="button" type="submit" name="submit" value="Submit" />
      </form>
    </header>
    <main>
      <h1>Register Form</h1>
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
  </body>
</html>
