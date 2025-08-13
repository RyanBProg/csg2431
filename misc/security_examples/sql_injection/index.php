<?php
  require 'db_connect.php';
?>
<!DOCTYPE html>
<html>
  <head>
  <title>SQL Injection Example</title>
  <meta name="author" content="Greg Baatard" />
  <meta name="description" content="Transaction search page for SQL Injection example" />
  <link rel="stylesheet" type="text/css" href="../example_stylesheet.css" />
  <style> #sqli span {font-family: monospace; color: blue; font-weight: bold; padding: 0px 5px} </style>
  <script>
    function toggleSQLInjectionBox()
    {
      if (document.getElementById('sqli').style.display == 'none' )
      {
        document.getElementById('sqli').style.display = 'block';
      }
      else
      {
        document.getElementById('sqli').style.display = 'none';
      }      
    }
  </script>
  </head>

  <body>
    <h3>Search Transactions (Insecure Version)</h3>
    <a href="../">Security Example Index</a> | <a href="protected/">Go to Protected Version</a> | <a href="reset.php">Reset Data</a>
    <?php
      echo '<p>You are logged in as <strong>'.$_SESSION['uname'].'</strong>.';
      
      // First, create a small form with a drop-down list to select the desired forum
      echo '<p><form method="get">Search Term: <input type="text" name="search_term" /> ';
      echo '<input type="submit" value="Search" /> or <input type="submit" name="all" value="Show All" /></form></p>';

      // Only try to show threads if form has been submitted...
      if (isset($_GET['search_term']))
      {
        if (isset($_GET['all']))
        { // If "show all" button pressed, just set search term to wildcard to match all rows
          $search_term = '%';                           
          echo '<p>All of your transactions:</p>';
        }
        else
        { // If search button pressed, wrap the search term in wildcards
          $search_term = '%'.$_GET['search_term'].'%';       
          echo '<p>Results for search of "<strong style="margin: 1px; letter-spacing: 1px; color: blue;">'.$_GET['search_term'].'</strong>":</p>';
        }
        
        // Concatenate the search term and session variable into a query string, then execute it
        $query_string = "SELECT * FROM sqli_transaction 
                         WHERE (sent_by = '".$_SESSION['uname']."' OR sent_to = '".$_SESSION['uname']."') AND description LIKE '".$search_term."'
                         ORDER BY pay_date";
        $stmt = $db->query($query_string);
        
        if ($db->errorCode() != '00000')
        { // Handle any errors and display information if query failed
          echo '<p style="margin-left: 25px; font-style: italic;">'.$db->errorInfo()[2].'.</p>';
        }
        else
        { // Show results
          $result = $stmt->fetchAll();
          
          if (count($result))
          { // Loop through results

            foreach($result as $row)
            {
              echo '<p style="margin-left: 25px;">'.$row['pay_date'].' - $'.$row['amount'].', "'.$row['description'].'" from '.$row['sent_by'].' to '.$row['sent_to'].'.</p>';
            }
          }
          else
          { // No results
            echo '<p style="margin-left: 25px; font-style: italic;">No matching transactions.</p>';
          }
        }
        echo '<br /><p><strong>Query string:</strong><br /><span style="font-family: monospace;">'.nl2br($query_string).'</span></p>'; 
      }
    ?>

      <p style="cursor: pointer;" onclick="toggleSQLInjectionBox()"><strong>SQL Injection Suggestions</strong> (click to reveal)</p>
      <div id="sqli" style="display: none;">
        <p>Select all transactions: "<span>' OR 'a%'='a</span>"</p>
        <p>Insert fake transaction: "<span>'; INSERT INTO sqli_transaction VALUES (DEFAULT, CURRENT_TIMESTAMP, 1000.00, 'gift', 'bsmith', 'jbloggs'); -- </span>"</p>
        <p>Drop transactions table: "<span>'; DROP TABLE sqli_transaction; -- </span>"</p>
      </div>

    <p></p>
  </body>
</html>