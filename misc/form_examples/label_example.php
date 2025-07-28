<!DOCTYPE html>
<html>
  <head>
    <title>Label Example</title>
    <meta name="author" content="Greg Baatard" />
    <meta name="description" content="Example of the label tag" />
  </head>

  <body>
    <form method="post" name="label_demo" action="label_example.php">
      <h3>Label Example</h3>

      <label>Name: <input type="text" name="name" /></label>
	
      <p>Bread:
        <label><input type="radio" name="bread" value="white" /> White</label>
        <label><input type="radio" name="bread" value="rye" /> Rye</label>
      </p>

      <p>Extras:
        <label><input type="checkbox" name="extras[]" value="pickles" /> Pickles</label>
        <label><input type="checkbox" name="extras[]" value="tomato" /> Tomato</label>
      </p>
	
      <input type="submit" name="submit" value="Place Order" />
    </form>
	<p><a href="index.php">Back to Index</a></p>
  </body>
</html>