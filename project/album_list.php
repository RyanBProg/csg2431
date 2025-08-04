<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Album List | Records</title>
    <meta name="author" content="Ryan Bowler" />
    <meta name="description" content="A list of all the albums" />
    <link rel="stylesheet" type="text/css" href="base_styles.css" />
    <link rel="stylesheet" type="text/css" href="album_list.css" />
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
      <h1>Album List</h1>
      <form>
        <label>
          Order by
          <select name="order">
            <option value="name" selected>Name</option>
            <option value="artist">Artist</option>
            <option value="year">Year</option>
          </select>
        </label>
      </form>
      <ul class="album-list">
        <li><a href="album_details.php">Marvin Gaye, "What's Going On" (1971)</a></li>
        <li><a href="#">Stevie Wonder, "For Once In My Life" (1968)</a></li>
        <li><a href="#">Khruangbin, "Texas Moon" (2022)</a></li>
      </ul>
    </main>
  </body>
</html>
