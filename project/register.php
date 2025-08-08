<?php
  require "db_connect.php";

  if (isset($_SESSION['username'])) {
    header('Location: album_list.php');
    exit;
  }

  if (isset($_POST["submit"])) {
    $errors = [];

    // trim all input values
    $username = trim($_POST["uname"]) ?? "";
    $email = trim($_POST["email"]) ?? "";
    $password = trim($_POST["pword"]) ?? "";
    $conf_password = trim($_POST["pword_conf"]) ?? "";
    $profile = trim($POST["profile"]) ?? "";
    $dob = $_POST["dob"];

    // username checks
    if (strlen($username) < 6 || strlen($username) > 20) {
      $errors[] = "Username must be between 6 and 20 characters long.";
    }

    if (!ctype_alnum($username)) {
      $errors[] = "Username may only contain letters and numbers (no spaces or symbols).";
    }

    // email checks
    if ($email === "") {
      $errors[] = "Email is empty.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors[] = "Invalid email format.";
    }

    // password checks
    if (strlen($password) < 5) {
      $errors[] = "Password must be at least 5 characters long.";
    }

    if ($conf_password !== $password) {
      $errors[] = "Password and confirm password must match.";
    }

    // date of birth checks
    if ($dob === "") {
      $errors[] = "Date of birth is empty.";
    }
    if (strtotime($_POST['dob']) === false) {
      $errors[] = 'Invalid date of birth.';
    }
    if (strtotime($_POST['dob']) > strtotime('-14 years')) {
      $errors[] = 'You must be at least 14 to register.';
    }

    if (!isset($_POST["agree"])) {
      $errors[] = "You must agree to the terms and conditions.";
    }

    if ($errors){
      foreach ($errors as $error) {
        echo "<p>".$error."</p>";
      }
    } else {
      $stmt = $db->prepare("INSERT INTO user (username, password, date_of_birth, profile, email) 
                            VALUES (?, ?, ?, ?, ?)");
      $result = $stmt->execute( [$username, $password, $dob, $profile, $email] );

      if ($result) {
        $stmt = $db->prepare("SELECT username, access_level FROM user WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user) {
          $_SESSION['username'] = $user['username'];
          $_SESSION['access_level'] = $user['access_level'];
          header('Location: album_list.php');
          exit;
        } else {
          echo "<p>Registration succeeded, but failed to fetch user info. Please try again.</p>";
        }
      } else if ($stmt->errorCode() === "23000") {
        echo '<p>Username "'.$_POST['uname'].'" already taken</p>';
        echo '<a href="javascript: window.history.back()">Return to form</a>';
        // print_r($stmt->errorInfo());
      } else {
        echo "<p>Something went wrong.</p>";
        echo '<a href="javascript: window.history.back()">Return to form</a>';
        // print_r($stmt->errorInfo());
      }
    }
  }

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
    action="register.php"
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
