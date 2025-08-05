<?php
  require 'db_connect.php';
?>

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
            <option value="title" selected>Name</option>
            <option value="artist">Artist</option>
            <option value="release_date">Year</option>
          </select>
        </label>
      </form>
      <ul class="album-list">
        <?php
          if (isset($_GET['order_by'])) {
            $stmt = $db->prepare("SELECT album_id, title, artist, YEAR(release_date) AS release_year
                                  FROM album
                                  ORDER BY ? DESC");

            $stmt->execute( [$_GET['order_by']] );
          } else {
            $stmt = $db->prepare("SELECT album_id, title, artist, YEAR(release_date) AS release_year
                                  FROM album
                                  ORDER BY title DESC");
                                  
            $stmt->execute();
          }

          $records_data = $stmt->fetchAll();
          
          if (count($records_data) > 0) {
            foreach($records_data as $row) {
              echo '<li><a href="album_details.php?id='.$row['album_id'].'">
              '.$row['title'].', 
              "'.$row['artist'].'" 
              ('.$row['release_year'].')
              </a></li>';
            }
          } else {
            echo '<p>No albums found.</p>';
          }
        ?>
      </ul>
    </main>
  </body>
</html>
