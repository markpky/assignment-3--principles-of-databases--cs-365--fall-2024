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
      <legend>INSERT USER</legend>
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
        <legend>INSERT PERSON</legend>
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
      <legend>INSERT WEBSITE</legend>
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
  <form action="./includes/helpers.php" method="get">
    <fieldset>
      <legend>SEARCH USERS</legend>
      <p>
        <label for="personID">Person ID:</label>
        <input type="number" id="personID" name="personID">
      </p>
      <p>
        <label for="websiteID">Website ID:</label>
        <input type="number" id="websiteID" name="websiteID">
      </p>
      <p>
          <label for="username">Username:</label>
          <input type="text" id="username" name="username">
      </p>
      <p>
          <label for="password">Password:</label>
          <input type="password" id="password" name="password">
      </p>
      <p>
        <label for="timestamp">Timestamp:</label>
        <input type="text" id="timestamp" name="timestamp">
      </p>
      <p>
        <label for="comment">Comment:</label>
        <textarea id="comment" name="comment" rows=2 cols=13></textarea>
      </p>
      <p><input type="hidden" name="submitted" value="SEARCH-USERS"></p>
      <p><button type="submit">SEARCH</button></p>
    </fieldset>
  </form>
  <form action="./includes/helpers.php" method="get">
    <fieldset>
      <legend>SEARCH PEOPLE</legend>
      <p>
        <label for="personID">Person ID:</label>
        <input type="number" id="personID" name="personID">
      </p>
      <p>
          <label for="firstName">First Name:</label>
          <input type="text" id="firstName" name="firstName">
      </p>
      <p>
          <label for="lastName">Last Name:</label>
          <input type="text" id="lastName" name="lastName">
      </p>
      <p>
        <label for="email">Email:</label>
        <input type="text" id="email" name="email">
      </p>
      <p>
        <label for="comment">Comment:</label>
        <textarea id="comment" name="comment" rows=2 cols=13></textarea>
      </p>
      <p><input type="hidden" name="submitted" value="SEARCH-PEOPLE"></p>
      <p><button type="submit">SEARCH</button></p>
    </fieldset>
  </form>
  <form action="./includes/helpers.php" method="get">
    <fieldset>
      <legend>SEARCH WEBSITES</legend>
      <p>
        <label for="websiteID">Website ID:</label>
        <input type="number" id="websiteID" name="websiteID">
      </p>
      <p>
        <label for="websiteName">Name:</label>
        <input type="text" id="websiteName" name="websiteName">
      </p>
      <p>
        <label for="url">URL:</label>
        <input type="text" id="url" name="url">
      </p>
      <p>
        <label for="comment">Comment:</label>
        <textarea id="comment" name="comment" rows=2 cols=13></textarea>
      </p>
      <p><input type="hidden" name="submitted" value="SEARCH-WEBSITES"></p>
      <p><button type="submit">SEARCH</button></p>
    </fieldset>
  </form>
  <form action="./includes/helpers.php" method="post">
    <fieldset>
      <legend>UPDATE PERSON</legend>
      <p>Pattern Match:</p>
      <p>
        <label for="personID">Person ID:</label>
        <input required type="number" id="personID" name="personID"></input>
      </p>
      <p>Attributes That Can Be Updated:</p>
      <p>
        <label for="firstName">First Name</label>
        <input type="radio" id="firstName" name="attribute" value="firstName"  />
      </p>
      <p>
        <label for="lastName">Last Name</label>
        <input type="radio" id="lastName" name="attribute" value="lastName"  />
      </p>
      <p>
        <label for="email">Email</label>
        <input type="radio" id="email" name="attribute" value="email"  />
      </p>
      <p>
        <label for="comment">Comment</label>
        <input type="radio" id="comment" name="attribute" value="comment"  />
      </p>
      <p>
        <label for="newValue">New Value:</label>
        <textarea required id="newValue" name="newValue" rows=2 cols=13></textarea>
      </p>
      <p><input type="hidden" name="submitted" value="UPDATE-PERSON"></p>
      <p><button type="submit">UPDATE</button></p>
    </fieldset>
  </form>
  <form action="./includes/helpers.php" method="post">
    <fieldset>
      <legend>UPDATE WEBSITE</legend>
      <p>Pattern Match:</p>
      <p>
        <label for="websiteID">Website ID:</label>
        <input required type="number" id="websiteID" name="websiteID"></input>
      </p>
      <p>Attributes That Can Be Updated:</p>
      <p>
        <label for="websiteName">Website Name</label>
        <input type="radio" id="websiteName" name="attribute" value="name"  />
      </p>
      <p>
        <label for="url">URL</label>
        <input type="radio" id="url" name="attribute" value="url"  />
      </p>
      <p>
        <label for="comment">Comment</label>
        <input type="radio" id="comment" name="attribute" value="comment"  />
      </p>
      <p>
        <label for="newValue">New Value:</label>
        <textarea required id="newValue" name="newValue" rows=2 cols=13></textarea>
      </p>
      <p><input type="hidden" name="submitted" value="UPDATE-WEBSITE"></p>
      <p><button type="submit">UPDATE</button></p>
    </fieldset>
  </form>
</body>
</html>
