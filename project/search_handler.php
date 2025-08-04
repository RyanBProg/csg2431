<?php
  if (isset($_POST['submit'])) {
    echo '<h3>Form submitted successfully!</strong></h3>';
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
  }
?>