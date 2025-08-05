<!DOCTYPE html>
<html>
  <head>
    <title>Fieldset Example</title>
    <meta name="author" content="Ryan Bowler" />
    <meta name="description" content="Example of the fieldset and legend tags" />
    <style>
      fieldset {width: 350px;}
    </style>
  </head>

  <body>
    <form method="post" name="fieldset_demo" action="fieldset_example.php">
	
      <fieldset><legend>Login Credentials</legend>
        <p><input type="text" name="uname" placeholder="Username" title="Username" /></p>
        <p>
           <input type="password" name="pword" placeholder="Password" title="Password" />
           <input type="password" name="pword_conf" placeholder="Confirm password" title="Confirm password" />
        </p>
      </fieldset>
	  
      <br />
	  
      <fieldset><legend>Contact Details</legend>
        <p>
          <input type="text" name="phone" placeholder="Phone number" title="Phone number" />
          <input type="text" name="email" placeholder="Email address" title="Email address" />
        </p>
        <p><textarea name="address" placeholder="Postal address" title="Postal address" style="width: 344px; font-family: Arial;"></textarea></p>
      </fieldset>
	  
      <br />
	  
      <fieldset style="text-align: center;">
        <p>
          <input type="button" value="Back" onclick="history.back()" />
          <input type="submit" value="Register" />
        </p>
      </fieldset>
	  
    </form>
	<p><a href="index.php">Back to Index</a></p>
  </body>
</html>
