<?php
  require 'db_connect.php';
  
  if (isset($_POST['submit']) && isset($_SESSION['uname']))
  { // If logged in and transfer form submitted...

    // Select logged in user's account number and balance...
    $stmt = $db->prepare("SELECT acc_num, balance FROM csrf_account WHERE username = ?");
    $stmt->execute( [$_SESSION['uname']] );
    $account = $stmt->fetch();
    
    if ($account['balance'] < $_POST['amount'])
    { // Not enough money
      echo '<p>Not enough funds!<br />';
      echo '<a href="index.php">Back to index page</a>';
    }
    else if ($account['acc_num'] == $_POST['acc_num'])
    { // Transferring to self
      echo '<p>You cannot transfer to yourself!<br />';
      echo '<a href="index.php">Back to index page</a>';
    }
    else
    { // Make the transfer
      $db->beginTransaction();
  
      $stmt = $db->prepare("UPDATE csrf_account SET balance = balance - ? WHERE acc_num = ?");
      $decrease = $stmt->execute( [$_POST['amount'], $account['acc_num']] );
      
      $stmt = $db->prepare("UPDATE csrf_account SET balance = balance + ? WHERE acc_num = ?");
      $increase = $stmt->execute( [$_POST['amount'], $_POST['acc_num']] );

      $stmt = $db->prepare("INSERT INTO csrf_transaction (from_acc, to_acc, amount, reference) VALUES (?, ?, ?, ?)");
      $log = $stmt->execute( [$account['acc_num'], $_POST['acc_num'], $_POST['amount'], $_POST['reference']] );

      if ($decrease && $increase && $log)
      { // Transfer was successful      
        $db->commit();
        echo '<p>Transfer complete!<br />';
        echo '<a href="index.php">Back to index page</a>';
      }
      else
      { // Error performing transfer   
        $db->rollBack();   
        echo '<p>Something went wrong.<br />';
        echo '<a href="index.php">Back to index page</a>';
      }	
    }
  }
?>
