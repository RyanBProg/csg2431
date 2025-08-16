<?php
  require 'db_connect.php';

  $page_title = "Album List | Records";
  $page_description = "A list of our album selection";
  require "header.php";

  $allowed_orders = ['title', 'artist', 'release_year'];
  $order_by = 'title';

  if (isset($_GET['order']) && in_array($_GET['order'], $allowed_orders)) {
    $order_by = $_GET['order'];
  }

  $search_term = '';
  $where_clause = '';
  $params = [];

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $search_term = trim($_POST['search']);

    if (!empty($search_term)) {
      $where_clause = "WHERE title LIKE :search OR artist LIKE :search";
      $params[':search'] = "%" . $search_term . "%";
    }
  }

  $sql = "SELECT album_id, title, artist, release_year
          FROM album 
          $where_clause
          ORDER BY $order_by ASC";
  $stmt = $db->prepare($sql);
  $stmt->execute($params);
  $records_data = $stmt->fetchAll();
?>

<main>
  <h1><?= !empty($search_term) ? "Search Results" : "Album List" ?></h1>

  <?php if (empty($search_term)): ?>
    <form method="GET">
      <label>
        Order by
        <select name="order" onchange="this.form.submit()">
          <option value="title" <?= $order_by === 'title' ? 'selected' : '' ?>>Name</option>
          <option value="artist" <?= $order_by === 'artist' ? 'selected' : '' ?>>Artist</option>
          <option value="release_year" <?= $order_by === 'release_year' ? 'selected' : '' ?>>Year</option>
        </select>
      </label>
    </form>
  <?php endif; ?>

  <ul class="album-list">
    <?php if (count($records_data) > 0): ?>
      <?php foreach ($records_data as $row): ?>
        <li>
          <a href="album_details.php?id=<?= urlencode($row['album_id']) ?>">
            <?= htmlspecialchars($row['artist']) ?>, 
            "<?= htmlspecialchars($row['title']) ?>" 
            (<?= htmlspecialchars($row['release_year']) ?>)
          </a>

          <?php if(isset($_SESSION['access_level']) && $_SESSION['access_level'] === "admin"): ?>
            <form style="display: inline-block; margin-left: 20px;" action="delete_handler.php" method="post" onsubmit="return handleDelete()">
              <input type="hidden" name="album_id" value="<?= htmlspecialchars($row['album_id']) ?>">
              <button type="submit" style="margin: 0; padding: 5px; font-size: 12px;" class="button delete-button">Delete</button>
            </form>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No albums found<?= !empty($search_term) ? " matching \"" . htmlspecialchars($search_term) . "\"" : "" ?>.</p>
    <?php endif; ?>
  </ul>
</main>

<?php require "footer.php"; ?>
