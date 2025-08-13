<?php 
  require 'db_connect.php';
  
  // Generate a random CSRF Token and set it as a session variable
  // This value will be different each time the form is loaded, 
  // and is included in the form data as a hidden field
  $_SESSION['csrf_token'] = bin2hex(random_bytes(10));
  
  
  // Select user's account details
  $stmt = $db->prepare("SELECT * FROM csrf_account WHERE username = ?");
  $stmt->execute( [$_SESSION['uname']] );
  $account = $stmt->fetch();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>CSRF Example - Online Banking Website</title>
    <meta name="author" content="Greg Baatard" />
    <meta name="description" content="Bank transfer form for CSRF example" />
    <link rel="stylesheet" type="text/css" href="../../example_stylesheet.css" />
  </head>
  <body>
    <h3>Online Banking (Protected Version)</h3>
    <a href="../../">Security Example Index</a> | <a href="../">Go to Insecure Version</a> <a href="transfer.php">TEST</a>
    <br /><br />
    <a href="index.php?uname=victim1">Log in as Victim 1</a> | <a href="index.php?uname=victim2">Log in as Victim 2</a> | <a href="index.php?uname=hackerman">Log in as Attacker</a> | <a href="reset.php">Reset Data</a>
    <?php  
    
      if (strpos($_SESSION['uname'], 'victim') !== false)
      {
        echo '<p><a href="index.php">View Transactions</a> | <a href="compromised.php">Visit Compromised Site</a></p>';        
      }
      
      // Show account details
      echo '<p><strong>Account of: </strong>'.strtoupper($account['username']).'<br />';
      echo '<strong>Account num: </strong>'.$account['acc_num'].'<br />';
      echo '<strong>Balance: </strong>$'.number_format($account['balance'], 2, '.', ',').'</p>';
    ?>
    <form name="transfer" id="transfer" method="post" action="transfer.php">  
      <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>" />
      
      <fieldset style="width: 170px; height: 280px;">
        <legend style="text-align: center;">Pay Anyone Transfer</legend>
        <p><strong><small>Account Number:</small></strong><br />
          <input type="text" name="acc_num" style="width: 150px;" placeholder="9 digits" /><br />
          <small><em>victim1 - 111111111<br />victim2 - 111111112<br />hackerman - 123456789</em></small>
        </p>

        <p><strong><small>Amount:</small></strong><br />
          <input type="text" name="amount" style="width: 150;" placeholder="$" />
        </p>

        <p><small><strong>Reference </strong>(optional)<strong>:</strong></small><br />
          <input type="text" name="reference" style="width: 150;" placeholder="Reference" />
        </p>
    
        <p style="text-align: right;">
          <input type="submit" name="submit" value="Transfer" />
        </p>
      </fieldset>
    </form>
  </body>
</html>