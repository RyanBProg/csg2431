<?php
  require 'db_connect.php';

  if (!isset($_SESSION['username']) || !isset($_SESSION['access_level']) || $_SESSION['access_level'] !== "admin") {
    header('Location: album_list.php');
    exit;
  }

  $page_title = "View Logs | Records";
  $page_description = "View the sites event logs";
  require "header.php";

  $result = $db->query("SELECT * FROM log ORDER BY log_date DESC");
?>

<main>
  <h1>View Event Logs</h1>

    <table style="width: 100%">
      <tr>
        <th>Log Date</th>
        <th>IP Address</th>
        <th>Event</th>
      </tr>

      <?php foreach($result as $row): ?>
        <tr>
          <td><?= htmlentities($row['log_date'] ?? '-') ?></td>
          <td><?= htmlentities($row['ip_address'] ?? '-') ?></td>
          <td>
            <strong><?= htmlentities($row['event_type'] ?? '-') ?></strong> - 
            <?= htmlentities($row['event_details'] ?? '-') ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
</main>

<?php require "footer.php"; ?>