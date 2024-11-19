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
      <legend>CREATE USER</legend>
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
        <textarea id="comment" name="comment" rows=2 cols=13></textarea>
      <p><input type="hidden" name="submitted" value="CREATE-USER"></p>
      <p><button type="submit">SUBMIT</button></p>
    </fieldset>
  </form>
  <form action="./includes/helpers.php" method="post">
    <fieldset>
        <legend>CREATE PERSON</legend>
        <p>Add a person to our database! We like information about people! :D</p>
        <p>
          <label for="firstName">First Name:</label>
          <input required type="text" id="firstName" name="firstName">
        </p>
        <p>
          <label for="lastName">Last Name:</label>
          <input required type="text" id="lastName" name="lastName">
        </p>
        <p>
          <label for="email">Email:</label>
          <input required type="email" id="email" name="email"></input>
        </p>
        <p>
          <label for="comment">Tell Us About Your Person (optional but highly reccommended for acknowledging the ego):</label>
          <textarea id="comment" name="comment" rows=2 cols=13></textarea>
        </p>
        <p><input type="hidden" name="submitted" value="CREATE-PERSON"></p>
        <p><button type="submit">SUBMIT</button></p>
      </fieldset>
  </form>
  <form action="./includes/helpers.php" method="post">
    <fieldset>
      <legend>CREATE WEBSITE</legend>
      <p>The internet always needs more websites. What else would you do without them? ;)</p>
      <p>
        <label for="websiteName">Website Name:</label>
        <input required type="text" id="websiteName" name="websiteName"></input>
      </p>
      <p>
        <label for="url">URL:</label>
        <input required type="url" id="url" name="url">
      </p>
      <p>
        <label for="comment">Tell Us About Your Website (optional but highly reccommended for understanding your impact on the digital landscape):</label>
        <textarea id="comment" name="comment" rows=2 cols=13></textarea>
      </p>
      <p><input type="hidden" name="submitted" value="CREATE-WEBSITE"></p>
      <p><button type="submit">SUBMIT</button></p>
    </fieldset>
  </form>
</body>
</html>
