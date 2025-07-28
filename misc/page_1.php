<!DOCTYPE html>
<html>
  <head>
    <title>Workshop 1, Task 2</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <h1>Three Tier Client-Server Model</h1>
    <p>A three tier client-server model involves clients making requests to a web server, which in turn can make requests to a database server as part of generating a response to the request. The end result of processing a request is usually a <a href="https://en.wikipedia.org/wiki/HTML">HTML</a> page, which is sent to the client.</p>

    <p>In our environment...</p>

    <ul>
      <li>The <strong>client</strong> is a web browser such as <em>Firefox</em> or <em>Chrome</em></li>
      <li>The <strong>web server</strong> is <em>Apache</em></li>
      <li>The <strong>database server</strong> is <em>MySQL</em></li>
    </ul>

    <h2>Forms</h2>
    <p>Forms allow clients to submit data as part of a request.</p>

    <form method="POST" action="page_2.php">
      <label for="name">Student Name:</label>
      <input type="text" id="name" name="name">
      <br>
      <label for="number">Student Number:</label>
      <input type="text" id="number" name="number">
      <br>
      <button type="submit" name="submit">Submit</button>
    </form>
  </body>
</html>