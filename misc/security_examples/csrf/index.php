<?php
  require 'db_connect.php';
  
  // "Log in" as a specific user or default to victim
  if (isset($_GET['uname']))
  {
    $_SESSION['uname'] = $_GET['uname'];
  }
  else if (!isset($_SESSION['uname']))
  {
    $_SESSION['uname'] = 'victim1';
  }
  
  // Select user's account and transaction details
  $stmt = $db->prepare("SELECT * FROM csrf_account WHERE username = ?");
  $stmt->execute( [$_SESSION['uname']] );
  $account = $stmt->fetch();
  
  $stmt = $db->prepare("SELECT  t.*, at.username AS 'to_uname', af.username AS 'from_uname'
                        FROM    csrf_transaction AS t JOIN csrf_account AS af ON t.from_acc = af.acc_num 
                                JOIN csrf_account AS at ON t.to_acc = at.acc_num
                        WHERE t.from_acc = ? OR t.to_acc = ? ORDER BY transfer_date");
  $stmt->execute( [$account['acc_num'], $account['acc_num']] );
  $transactions = $stmt->fetchAll();  
  
?>
<!DOCTYPE html>
<html>
  <head>
    <title>CSRF Example - Online Banking Website</title>
    <meta name="author" content="Greg Baatard" />
    <meta name="description" content="Index page for CSRF example" />
    <link rel="stylesheet" type="text/css" href="../example_stylesheet.css" />
  </head>
  <body>
    <h3>Online Banking (Insecure Version)</h3>
    <a href="../">Security Example Index</a> | <a href="protected/">Go to Protected Version</a>
    <br /><br />
    <a href="index.php?uname=victim1">Log in as Victim 1</a> | <a href="index.php?uname=victim2">Log in as Victim 2</a> | <a href="index.php?uname=hackerman">Log in as Hackerman</a> | <a href="reset.php">Reset Data</a>
    <?php  
    
      if (strpos($_SESSION['uname'], 'victim') !== false)
      {
        echo '<p><a href="transfer_form.php">Transfer Money</a> | <a href="compromised.php">Visit Compromised Site</a></p>';        
      }
    
      // Show account details
      echo '<p><strong>Account of: </strong>'.strtoupper($account['username']).'<br />';
      echo '<strong>Account num: </strong>'.$account['acc_num'].'<br />';
      echo '<strong>Balance: </strong>$'.number_format($account['balance'], 2, '.', ',').'</p>';
 
      // Show transaction details 
      echo '<strong>Transactions:</strong><br />';
      if (count($transactions))
      {
        echo '<small><ul>';
        foreach ($transactions as $tran)
        {
          if ($tran['from_acc'] == $account['acc_num'])
          {
            echo '<li>'.$tran['transfer_date'].' - You transferred $'.number_format($tran['amount'], 2, '.', ',').' to '.$tran['to_acc'].' ('.$tran['to_uname'].') - "'.$tran['reference'].'"</li>';
          }
          else
          {
            echo '<li>'.$tran['transfer_date'].' - '.$tran['from_acc'].' ('.$tran['from_uname'].') transferred $'.number_format($tran['amount'], 2, '.', ',').' to you - "'.$tran['reference'].'"</li>';
          }
        }
        echo '</ul></small>';
      }
      else
      {
        echo '<em>No transactions.</em>';
      }
    ?>
  </body>
</html>