<?php
  require 'db_connect.php';
  $page_title = "Album List | Records";
  $page_description = "A list of our album selection";
  require "header.php";

  // define allowed sort options
  $allowed_orders = ['title', 'artist', 'release_date'];

  // set default order
  $order_by = 'title';

  // if user submitted a valid order value
  if (isset($_GET['order']) && in_array($_GET['order'], $allowed_orders)) {
    $order_by = $_GET['order'];
  }

  // build the query (no placeholder for column name)
  $stmt = $db->prepare("SELECT album_id, title, artist, YEAR(release_date) AS release_year
                        FROM album
                        ORDER BY $order_by ASC");
  $stmt->execute();
  $records_data = $stmt->fetchAll();
?>

<main>
  <h1>Album List</h1>
  <form method="GET">
    <label>
      Order by
      <select name="order" onchange="this.form.submit()">
        <option value="title" <?= $order_by === 'title' ? 'selected' : '' ?>>Name</option>
        <option value="artist" <?= $order_by === 'artist' ? 'selected' : '' ?>>Artist</option>
        <option value="release_date" <?= $order_by === 'release_date' ? 'selected' : '' ?>>Year</option>
      </select>
    </label>
  </form>

  <ul class="album-list">
    <?php if (count($records_data) > 0): ?>
      <?php foreach ($records_data as $row): ?>
        <li>
          <a href="album_details.php?id=<?= htmlspecialchars($row['album_id']) ?>">
            <?= htmlspecialchars($row['title']) ?>, 
            "<?= htmlspecialchars($row['artist']) ?>" 
            (<?= htmlspecialchars($row['release_year']) ?>)
          </a>
        </li>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No albums found.</p>
    <?php endif; ?>
  </ul>
</main>

<?php require "footer.php"; ?>
