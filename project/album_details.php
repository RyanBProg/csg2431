<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ablum Details | Records</title>
    <meta name="author" content="Ryan Bowler" />
    <meta name="description" content="More details for a chosen album" />
    <link rel="stylesheet" type="text/css" href="base_styles.css" />
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
      <h1>Album Details</h1>
    </main>
  </body>
</html>
