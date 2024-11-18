<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your First Form</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <form action="./includes/helpers.php" method="post">
    <fieldset>
      <legend>CREATE</legend>
      <p>
        <label for="website-name">Website Name:</label>
        <input required type="text" id="website-name" name="website-name">
      </p>
      <p>
        <label for="url">URL:</label>
        <input required type="url" id="url" name="url">
      </p>
      <p>
        <label for="email">Email:</label>
        <input required type="email" id="email" name="email"></input>
      </p>
      <p>
        <label for="username">Username:</label>
        <input required type="text" id="username" name="username"></input>
      </p>
      <p>
        <label for="password">Password:</label>
        <input required type="password" id="password" name="password"></input>
      </p>
      <p>
        <label for="comment">Tell Us About Your Online Self (optional but highly reccommended for the best user experience):</label>
        <textarea id="comment" name="comment" rows=13 cols=13></textarea>
      <p><input type="hidden" name="submitted" value="CREATE"></p>
      <p><button type="submit">SUBMIT</button></p>
    </fieldset>
  </form>
</body>
</html>
