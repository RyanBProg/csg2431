<?php
  $random_num = random_int(0, 10);
  $loop_count = 1;
  $seven_count = 0;
  $random_num_count += $random_num;
  
  while (true) {
    if ($loop_count === 1 && $random_num === 0) {
      echo "<p>Number $loop_count is $random_num</p>";
      echo "That was fast!";
      break;
    } else if ($random_num === 7) {
      echo "<p>Number $loop_count is $random_num, lucky number 7!</p>";
      $seven_loop_count++;

      if ($seven_loop_count === 3) {
        echo "<p>Triple 7's, you win!</p>";
        break;
      }
    } else {
      echo "<p>Number $loop_count is $random_num</p>";
    }

    if ($random_num === 0) {
      break;
    }
    
    $random_num = random_int(0, 10);
    $random_num_count += $random_num;
    $loop_count++;
  }

  $average = $random_num_count / $loop_count;

  echo "<p>Total: $random_num_count</p>";
  echo "<p>Average: $average</p>";
?>