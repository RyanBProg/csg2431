<?php
  require 'db_connect.php';
  $page_title = "Album List | Records";
  $page_description = "A list of our album selection";
  require "header.php";
?>

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

<?php
  require "footer.php"
?>
