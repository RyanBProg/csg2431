<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="<?= $page_description ?? 'Records music browser' ?>">
    <title><?= $page_title ?? 'Records' ?></title>
    <meta name="author" content="Ryan Bowler" />
    <link rel="stylesheet" type="text/css" href="styles.css" />
    <script defer src="scripts.js"></script>
  </head>
  <body>
    <header>
      <nav>
        <ul>
          <li><a class="button" href="album_list.php">Albums</a></li>
          <?php
            if (!isset($_SESSION['username'])) {
              echo '<li><a class="button" href="login.php">Login</a></li>
                    <li><a class="button" href="register.php">Register</a></li>';
            }
          ?>
        </ul>
      </nav>
      <div class="navbar-end">
        <form
          name="search_form"
          class="searchbar"
          method="post"
          action="search_handler.php"
          onsubmit="return validateSearch()">
          <label for="search">Search Albums</label>
          <input id="search" name="search" type="text" placeholder="Search Albums...">
          <input class="button" type="submit" name="submit" value="Search" />
        </form>

        <?php
          if (isset($_SESSION['username'])) {
            echo '<div class="navbar-auth">
                    <div class="navbar-auth-info">
                      <span>' . $_SESSION['username'] . '</span>
                      <a href="user_profile.php">Update Profile</a>
                    </div>
                    <a class="button logout-button" href="logout.php">Logout</a>
                  </div>';
          }
        ?>
      </div>
    </header>

<!-- Todo: Make search form work -->