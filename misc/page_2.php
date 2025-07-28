<!DOCTYPE html>
<html>
  <head>
    <title>Workshop 1, Task 3</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <h1>Receiving Form Data</h1>
    <a href="page_1.php">⬅️ Back to Form</a>

    <?php
      if (isset($_POST["submit"])){
        echo "<p>Recieved student name: " . $_POST['name'] . "</p>";
        echo "<p>Recieved student number: " . $_POST['number'] . "</p>";
      } else {
        echo "<p>No form data available.</p>";
      }
    ?>
  </body>
</html>