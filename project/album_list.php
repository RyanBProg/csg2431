<?php
  require 'db_connect.php';

  $page_title = "Album List | Records";
  $page_description = "A list of our album selection";
  require "header.php";

  $allowed_orders = ['title', 'artist', 'release_date'];
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

  $sql = "SELECT album_id, title, artist, YEAR(release_date) AS release_year 
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
          <option value="release_date" <?= $order_by === 'release_date' ? 'selected' : '' ?>>Year</option>
        </select>
      </label>
    </form>
  <?php endif; ?>

  <ul class="album-list">
    <?php if (count($records_data) > 0): ?>
      <?php foreach ($records_data as $row): ?>
        <li>
          <a href="album_details.php?id=<?= $row['album_id'] ?>">
            <?= htmlspecialchars($row['title']) ?>, 
            "<?= htmlspecialchars($row['artist']) ?>" 
            (<?= htmlspecialchars($row['release_year']) ?>)
          </a>
        </li>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No albums found<?= !empty($search_term) ? " matching \"" . htmlspecialchars($search_term) . "\"" : "" ?>.</p>
    <?php endif; ?>
  </ul>
</main>

<?php require "footer.php"; ?>
