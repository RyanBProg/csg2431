<?php
  require 'db_connect.php';
  
  // Handle rating submission
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rating'])) {
    $rating = htmlspecialchars($_POST['rating']);
    echo "<p>Rating submitted: $rating</p>";
  }

  // Handle comment submission
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $comment = htmlspecialchars($_POST['comment']);
    echo "<p>Comment submitted: $comment</p>";
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Album Details | Records</title>
    <meta name="author" content="Ryan Bowler" />
    <meta name="description" content="More details for a chosen album" />
    <link rel="stylesheet" type="text/css" href="base_styles.css" />
    <link rel="stylesheet" type="text/css" href="album_details.css" />
    <script defer src="search.js"></script>
    <script defer src="album_details.js"></script>
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
      <h1>What's Going On (1971)</h1>
      <div class="column-container">
        <section>
          <p><strong>Artist:</strong> Marvin Gaye</p>
          <p><strong>Label:</strong> UMG Recordings</p>
          <p><strong>Track List:</strong></p>
          <ol class="track-list">
            <li>What's Going On</li>
            <li>What's Happening Brother</li>
            <li>Flyin' High</li>
            <li>Save The Children</li>
            <li>God Is Love</li>
            <li>Mercy Mercy Me</li>
            <li>Right On</li>
            <li>Wholy Holy</li>
            <li>Inner City Blue</li>
          </ol>
          <form action="delete_handler.php" method="post" onsubmit="return handleDelete()">
              <input type="hidden" name="album_id" value="123">
              <button type="submit" class="button delete-button">Delete</button>
          </form>
        </section>
        <aside>
          <p><strong>Member Rating:</strong> 4.2/5</p>
          <form
          name="rating_form"
          method="post"
          action=""
          onsubmit="return validateRating()">
            <fieldset class="star-rating">
              <legend>Rate this album</legend>
              <div class="rating-list">
                <label>
                  <input type="radio" name="rating" value="1">
                  1&#9733;
                </label>
                <label>
                  <input type="radio" name="rating" value="2">
                  2&#9733;
                </label>
                <label>
                  <input type="radio" name="rating" value="3">
                  3&#9733;
                </label>
                <label>
                  <input type="radio" name="rating" value="4">
                  4&#9733;
                </label>
                <label>
                  <input type="radio" name="rating" value="5">
                  5&#9733;
                </label>
              </div>
              <input class="button" type="submit" name="submit" value="Submit" />
            </fieldset>
          </form>
          <p class="member-comments-title"><strong>Member Comments:</strong></p>
          <ul class="comment-list">
            <li>
              <div class="comment-details">
                <p><strong>Jblogs213</strong></p>
                -
                <p><em>14/04/2024</em></p>
              </div>
              <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dolorum repellat itaque ab deserunt facere laborum! Dicta non accusantium delectus unde.</p>
            </li>
            <li>
              <div class="comment-details">
                <p><strong>Laura135</strong></p>
                -
                <p><em>12/04/2024</em></p>
              </div>
              <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
            </li>
          </ul>
          <form name="comment_form" method="post" action="" class="add-comment-form" onsubmit="return validateComment()">
            <fieldset class="comment-fieldset">
              <legend>Add a Comment</legend>
              <label for="comment">Comment:</label>
              <textarea id="comment" name="comment" rows="3"></textarea>
              <input class="button" type="submit" name="submit" value="Submit" />
            </fieldset>
          </form>
        </aside>
      </div>
    </main>
  </body>
</html>
