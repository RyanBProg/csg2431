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
          <?php if (!isset($_SESSION['username'])): ?>
            <li><a class="button" href="login.php">Login</a></li>
            <li><a class="button" href="register.php">Register</a></li>
          <?php endif; ?>
          <?php if(isset($_SESSION['access_level']) && $_SESSION['access_level'] === "admin"): ?>
            <li><a class="button" href="add_album.php">Add Album</a></li>
          <?php endif; ?>
        </ul>
      </nav>
      <div class="navbar-end">
        <form
          name="search_form"
          class="searchbar"
          method="post"
          action="album_list.php"
          onsubmit="return validateSearch()">
          <label for="search">Search Albums</label>
          <input id="search" name="search" type="text" placeholder="Search Albums...">
          <input class="button" type="submit" name="submit" value="Search" />
        </form>
        
        <?php if (isset($_SESSION['username'])): ?>
          <div class="navbar-auth">
            <div class="navbar-auth-info">
              <a href="user_profile.php"><?= htmlspecialchars($_SESSION['username']) ?></a>
              <a href="update_profile.php">Update Profile</a>
            </div>
            <a class="button logout-button" href="logout_handler.php">Logout</a>
          </div>
        <?php endif; ?>
      </div>
    </header>