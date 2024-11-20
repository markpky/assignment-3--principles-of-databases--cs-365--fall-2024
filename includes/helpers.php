<?php

session_start();
include_once "config.php";
        $db = new PDO(
            "mysql:host=" . DBHOST . "; dbname=" . DBNAME . ";charset=utf8",
            DBUSER,
        );
        $statement = $db -> prepare("SET @key_str = UNHEX(SHA2('my secret passphrase', 256));");
        $statement -> execute();
        $statement = $db -> prepare("SELECT @key_str");
        $statement -> execute();
        $row = $statement -> fetch();
        $_SESSION['key_str'] = $row['@key_str'];

        $statement = $db -> prepare("SET @init_vector = RANDOM_BYTES(16)");
        $statement -> execute();
        $statement = $db -> prepare("SELECT @init_vector");
        $statement -> execute();
        $row = $statement -> fetch();
        $_SESSION['init_vector'] = $row['@init_vector'];

        $row = null;
        $statement = null;
        $db = null;

if (isset($_POST['submitted'])) {
    echo "<p>You submitted the form. Hurray!<p>";

    if ($_POST['submitted'] === "CREATE-USER") {
        echo "<p>Looks like you want to create a user there big guy...</p>";
        $websiteID = null;
        $username = null;
        $personID = null;

        if (valueExistsInAttribute($_POST['url'], "url", "websites")) {
            echo "<p>We found the website! :)</p>";
            $websiteID = getValue("websiteID", "websites", "url", $_POST['url']);
        } else {
            echo "<p>We didn't find the website... :(</p>";
        }

        if ($websiteID === null) {
            echo "<p>Since we couldn't find the website you were looking for, the username might become available once we know about the website! ;)</p>";
        }
        else if (!valuePairExistsInAttributePair($_POST['username'], $websiteID, "username", "websiteID", "users")) {
            echo "<p>This username is available! :))</p>";
            $username = $_POST['username'];
        } else {
            echo "<p>That username is already taken... :((</p>";
        }

        if (valueExistsInAttribute($_POST['email'], "email", "people")) {
            echo "<p>We found the email! :)))</p>";
            $personID = getValue("personID", "people", "email", $_POST['email']);
        } else {
            echo "<p>We couldn't find that email... :(((</p>";
        }

        if ($websiteID && $username && $personID) {
            echo "<p>We can create your user in our database! :D</p>";
            insertUser($personID, $websiteID, $username, $_POST['password'], $_POST['comment']);
            echo "<p>They've been created!</p>";
        } else {
            echo "<p>We cannot create your user in our database... D:</p>";
        }

        $websiteID = null;
        $username = null;
        $personID = null;
    }

    if ($_POST['submitted'] === "CREATE-PERSON") {
        echo "<p>Looks like you want to create a person there b-</p>";
        echo "<p>No not a baby! No no no no! Gross!!!</p>";

        if (!valueExistsInAttribute($_POST['email'], "email", "people")) {
            echo "<p>We can add this email and their person to the database! :)</p>";
            insertPerson($_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['comment']);
            echo "<p>They're happily existing inside me- I mean the database.</p>";
        } else {
            echo "<p>This email already exists in our database! We can't add it! >:(</p>";
        }
    }

    if ($_POST['submitted'] === "CREATE-WEBSITE") {
        echo "<p>Looks like you want to create a website!</p>";
        echo "<p>But first, let me tell you about today's sponsor \"Squarespace\"! XD</p>";

        if (!valueExistsInAttribute($_POST['url'], "url", "websites")) {
            echo "<p>We can add this website to the database! :)</p>";
            insertWebsite($_POST['websiteName'], $_POST['url'], $_POST['comment']);
            echo "<p>You have shaped landscape of the digital world. To what extent we shall see...</p>";
        } else {
            echo "<p>The URL for this website already exists within our database! We can't add it again silly! O 3 O</p>";
        }
    }

    if ($_POST['submitted'] === "UPDATE-USER") {
        echo "<p>Attempting to update user...</p>";
        updateUser($_POST['personID'], $_POST['websiteID'], $_POST['username'], $_POST['attribute'], $_POST['newValue']);
        echo "<p>Maybe that worked?</p>";
    }

    if ($_POST['submitted'] === "UPDATE-WEBSITE") {
        echo "<p>Attempting to update website...</p>";
        updateTableEntry("websites", "websiteID", $_POST['websiteID'], $_POST['attribute'], $_POST['newValue']);
        echo "<p>Maybe that worked?</p>";
    }

    if ($_POST['submitted'] === "UPDATE-PERSON") {
        echo "<p>Attempting to update person...</p>";
        updateTableEntry("people", "personID", $_POST['personID'], $_POST['attribute'], $_POST['newValue']);
        echo "<p>Maybe that worked?</p>";
    }

    if ($_POST['submitted'] === "DELETE-PERSON/WEBSITE") {
        echo "<p>Looks like you're trying to delete either a person a website...</p>";
        if ($_POST['table'] === "people")
            $idName = "personID";
        else
            $idName = "websiteID";
        deleteTableEntry($_POST['table'], $idName, $_POST['ID']);
        echo "<p>That might have worked?</p>";
    }

    if ($_POST['submitted'] === "DELETE-USER") {
        echo "<p>Looks like you're trying to delete a user...</p>";
        deleteUser($_POST['personID'], $_POST['websiteID'], $_POST['username']);
        echo "<p>That might have worked?</p>";
    }

    echo "<p>Click <a href=\"../index.php\">here</a> to go back.</p>";
} else {
    echo "<p>One of the forms from index.php was not submitted. Click <a href=\"../index.php\">here</a> to go back.</p>";
}

if (isset($_GET['submitted'])) {
    echo "<p>You submitted a search form. Let's see what I can dig up for you...</p>";

    if ($_GET['submitted'] === "SEARCH-USERS") {
        echo "<p>Looks like you want to search the people table. Bob's your uncle!</p>";
        printUsers(searchUsers($_GET['personID'], $_GET['websiteID'], $_GET['username'], $_GET['password'], $_GET['timestamp'], $_GET['comment']));
        echo "<p>Hope that helps! :P</p>";
    }

    if ($_GET['submitted'] === "SEARCH-PEOPLE") {
        echo "<p>Looks like you want to search the people table. Bob's your uncle!</p>";
        printPeople(searchPeople($_GET['personID'], $_GET['firstName'], $_GET['lastName'], $_GET['email'], $_GET['comment']));
        echo "<p>Hope that helps! :P</p>";
    }

    if ($_GET['submitted'] === "SEARCH-WEBSITES") {
        echo "<p>Looks like you want to search the websites table. No prob bob!<p>";
        printWebsites(searchWebsites($_GET['websiteID'], $_GET['websiteName'], $_GET['url'], $_GET['comment']));
        echo "<p>Hope that helps! :P<p>";
    }

    echo "<p>Click <a href=\"../index.php\">here</a> to go back.</p>";
} else {
    echo "<p>One of the forms from index.php was not submitted. Click <a href=\"../index.php\">here</a> to go back.</p>";
}

/**
 * Looks for a $value from an $attribute’s column in a $table, returning true if
 * found, false if not. For example, if a value named “stairway to heaven”
 * exists under an attribute called “name” within a table called “songs,” then
 *
 *    valueExistsInAttribute("stairway to heaven", "name", "songs")
 *
 * would return true.
 *
 * @param $value      The query I’m interested in finding.
 * @param $attribute  The attribute under which I would like to locate $value.
 * @param $table      The table containing the $attribute.
 *
 * @access public
 * @return bool|void
 */
function valueExistsInAttribute($value, $attribute, $table) {
    try {
        include_once "config.php";

        $db = new PDO(
            "mysql:host=" . DBHOST . "; dbname=" . DBNAME . ";charset=utf8",
            DBUSER,
        );

        $statement = $db -> prepare("SELECT $attribute FROM $table");
        $statement -> execute();

        $found = false;

        while (($row = $statement -> fetch())) {
            if ($value == $row[$attribute]) {
                $found = true;

                break;
            }
        }

        $statement = null;

        return $found;
    }
    catch(PDOException $error) {
        echo "<p class='highlight'>The function " .
            "<code>valueExistsInAttribute</code> has generated the " .
            "following error:</p>" .
            "<pre>$error</pre>" .
            "<p class='highlight'>Exiting…</p>";

        exit;
    }
}

function valuePairExistsInAttributePair($value1, $value2, $attribute1, $attribute2, $table) {
    try {
        include_once "config.php";

        $db = new PDO(
            "mysql:host=" . DBHOST . "; dbname=" . DBNAME . ";charset=utf8",
            DBUSER,
        );

        $statement = $db -> prepare("SELECT $attribute1, $attribute2 FROM $table WHERE $attribute1=\"$value1\" AND $attribute2=\"$value2\"");
        $statement -> execute();

        $row = $statement -> fetch();
        $statement = null;

        if ($row === false)
            return false;
        else
            return true;
    }
    catch(PDOException $error) {
        echo "<p class='highlight'>The function " .
            "<code>valuePairExistsInAttributePair</code> has generated the " .
            "following error:</p>" .
            "<pre>$error</pre>" .
            "<p class='highlight'>Exiting…</p>";

        exit;
    }
}

/**
 * Returns one $value — or the first, if more than one is retrieved — from a
 * $table if a $query should match a $pattern. For example, imagine you want the
 * album name from an album table whose artist ID is 2:
 *
 *    $album = select("album_name", "album", "artist_id", "2");
 *
 * @param $value   The attribute I want to retrieve
 * @param $table   The table in which the attribute resides
 * @param $query   The query I want to match
 * @param $pattern The pattern that the query should match
 *
 * @access public
 * @return false|mixed|void
 */
function getValue($value, $table, $query, $pattern) {
    try {
        include_once "config.php";

        $db = new PDO("mysql:host=".DBHOST."; dbname=".DBNAME, DBUSER);

        $statement = $db ->
            prepare("SELECT $value FROM $table WHERE $query = :q");

        $statement -> execute(array('q' => $pattern));

        $row = $statement -> fetch();

        $statement = null;

        if ($row === false) {
            $result = false;
        } else {
            $result = $row[$value];
        }

        return $result;
    }
    catch(PDOException $error) {
        echo "<p class='highlight'>The function <code>getValue</code> has " .
            "generated the following error:</p>" .
            "<pre>$error</pre>" .
            "<p class='highlight'>Exiting…</p>";

        exit;
    }
}

function insertUser($personID, $websiteID, $username, $password, $comment) {
    try {
        include_once "config.php";

        $db = new PDO("mysql:host=".DBHOST."; dbname=".DBNAME, DBUSER);

        /*
        $db -> exec("insert into users (personID, websiteID, username, password, timestamp, comment)
            values (".$personID."," .$websiteID. ",".$username.", AES_ENCRYPT(".$password.", ".$_SESSION['key_str'].", ".$_SESSION['init_vector']."), NOW(),".$comment.")");
            */

        $statement = $db -> prepare("insert into users (personID, websiteID, username, password, timestamp, comment)
            values (:personID , :websiteID , :username , AES_ENCRYPT(:password, :key_str, :init_vector), NOW() , :comment )");

        $statement -> bindValue(':personID', $personID);
        $statement -> bindValue(':websiteID', $websiteID);
        $statement -> bindValue(':username', $username);
        $statement -> bindValue(':password', $password);
        $statement -> bindValue(':key_str', $_SESSION['key_str']);
        $statement -> bindValue(':init_vector', $_SESSION['init_vector']);
        $statement -> bindValue(':comment', $comment);

        $statement -> execute();


    }
    catch(PDOException $error) {
        echo "<p class='highlight'>The function <code>insertUser</code> has " .
            "generated the following error:</p>" .
            "<pre>$error</pre>" .
            "<p class='highlight'>Exiting…</p>";

        exit;
    }
}

function insertPerson($firstName, $lastName, $email, $comment) {
    try {
        include_once "config.php";

        $db = new PDO("mysql:host=".DBHOST."; dbname=".DBNAME, DBUSER);

        $statement = $db -> prepare("insert into people (firstName, lastName, email, comment)
            values (:firstName , :lastName , :email , :comment )");

        $statement -> execute(
            array(
                'firstName'  => $firstName,
                'lastName' => $lastName,
                'email'  => $email,
                'comment'   => $comment
            )
        );
    }
    catch(PDOException $error) {
        echo "<p class='highlight'>The function <code>insertPerson</code> has " .
            "generated the following error:</p>" .
            "<pre>$error</pre>" .
            "<p class='highlight'>Exiting…</p>";

        exit;
    }
}

function insertWebsite($name, $url, $comment) {
    try {
        include_once "config.php";

        $db = new PDO("mysql:host=".DBHOST."; dbname=".DBNAME, DBUSER);

        $statement = $db -> prepare("insert into websites (name, url, comment)
            values (:name , :url , :comment )");

        $statement -> execute(
            array(
                'name'  => $name,
                'url' => $url,
                'comment'   => $comment
            )
        );
    }
    catch(PDOException $error) {
        echo "<p class='highlight'>The function <code>insertWebsite</code> has " .
            "generated the following error:</p>" .
            "<pre>$error</pre>" .
            "<p class='highlight'>Exiting…</p>";

        exit;
    }
}

function searchUsers($personID, $websiteID, $username, $password, $timestamp, $comment) {
    try {
        include_once "config.php";

        $db = new PDO("mysql:host=".DBHOST."; dbname=".DBNAME, DBUSER);

        if (!($personID || $websiteID || $username || $password || $timestamp || $comment)){
            $statement = $db -> prepare("SELECT * FROM users");

            $statement -> execute();

            return $statement;
        }

        $username = "%".$username."%";
        $password = "%".$password."%";
        $timestamp = "%".$timestamp."%";
        $comment = "%".$comment."%";

        if ($personID && $websiteID) {
            $statement = $db -> prepare("SELECT * FROM users WHERE personID = :personID AND websiteID = :websiteID AND username LIKE :username AND password LIKE :password AND timestamp LIKE :timestamp AND comment LIKE :comment");

            $statement -> bindValue(':personID', $personID, PDO::PARAM_INT);
            $statement -> bindValue(':websiteID', $websiteID, PDO::PARAM_INT);
            $statement -> bindValue(':username', $username, PDO::PARAM_STR);
            $statement -> bindValue(':password', $password, PDO::PARAM_STR);
            $statement -> bindValue(':timestamp', $timestamp, PDO::PARAM_STR);
            $statement -> bindValue(':comment', $comment, PDO::PARAM_STR);
        } elseif ($personID && empty($websiteID)) {
            $statement = $db -> prepare("SELECT * FROM users WHERE personID = :personID AND username LIKE :username AND password LIKE :password AND timestamp LIKE :timestamp AND comment LIKE :comment");

            $statement -> bindValue(':personID', $personID, PDO::PARAM_INT);
            $statement -> bindValue(':username', $username, PDO::PARAM_STR);
            $statement -> bindValue(':password', $password, PDO::PARAM_STR);
            $statement -> bindValue(':timestamp', $timestamp, PDO::PARAM_STR);
            $statement -> bindValue(':comment', $comment, PDO::PARAM_STR);
        } elseif (empty($personID) && $websiteID) {
            $statement = $db -> prepare("SELECT * FROM users WHERE websiteID = :websiteID AND username LIKE :username AND password LIKE :password AND timestamp LIKE :timestamp AND comment LIKE :comment");

            $statement -> bindValue(':websiteID', $websiteID, PDO::PARAM_INT);
            $statement -> bindValue(':username', $username, PDO::PARAM_STR);
            $statement -> bindValue(':password', $password, PDO::PARAM_STR);
            $statement -> bindValue(':timestamp', $timestamp, PDO::PARAM_STR);
            $statement -> bindValue(':comment', $comment, PDO::PARAM_STR);
        } else {
            $statement = $db -> prepare("SELECT * FROM users WHERE username LIKE :username AND password LIKE :password AND timestamp LIKE :timestamp AND comment LIKE :comment");

            $statement -> bindValue(':username', $username, PDO::PARAM_STR);
            $statement -> bindValue(':password', $password, PDO::PARAM_STR);
            $statement -> bindValue(':timestamp', $timestamp, PDO::PARAM_STR);
            $statement -> bindValue(':comment', $comment, PDO::PARAM_STR);
        }

        $statement -> execute();
        return $statement;
    }
    catch(PDOException $error) {
        echo "<p class='highlight'>The function <code>searchUsers</code> has " .
            "generated the following error:</p>" .
            "<pre>$error</pre>" .
            "<p class='highlight'>Exiting…</p>";

        exit;
    }
}

function searchPeople($personID, $firstName, $lastName, $email, $comment) {
    try {
        include_once "config.php";

        $db = new PDO("mysql:host=".DBHOST."; dbname=".DBNAME, DBUSER);

        if (!($personID || $firstName || $lastName || $email || $comment)){
            $statement = $db -> prepare("SELECT * FROM people");

            $statement -> execute();

            return $statement;
        }

        $firstName = "%".$firstName."%";
        $lastName = "%".$lastName."%";
        $email = "%".$email."%";
        $comment = "%".$comment."%";

        if ($personID) {
            $statement = $db -> prepare("SELECT * FROM people WHERE personID = :personID AND firstName LIKE :firstName AND lastName LIKE :lastName AND email LIKE :email AND comment LIKE :comment");

            $statement -> bindValue(':personID', $personID, PDO::PARAM_INT);
            $statement -> bindValue(':firstName', $firstName, PDO::PARAM_STR);
            $statement -> bindValue(':lastName', $lastName, PDO::PARAM_STR);
            $statement -> bindValue(':email', $email, PDO::PARAM_STR);
            $statement -> bindValue(':comment', $comment, PDO::PARAM_STR);
        } else  {
            $statement = $db -> prepare("SELECT * FROM people WHERE firstName LIKE :firstName AND lastName LIKE :lastName AND email LIKE :email AND comment LIKE :comment");

            $statement -> bindValue(':firstName', $firstName, PDO::PARAM_STR);
            $statement -> bindValue(':lastName', $lastName, PDO::PARAM_STR);
            $statement -> bindValue(':email', $email, PDO::PARAM_STR);
            $statement -> bindValue(':comment', $comment, PDO::PARAM_STR);
        }

        $statement -> execute();
        return $statement;
    }
    catch(PDOException $error) {
        echo "<p class='highlight'>The function <code>searchPeople</code> has " .
            "generated the following error:</p>" .
            "<pre>$error</pre>" .
            "<p class='highlight'>Exiting…</p>";

        exit;
    }
};

function searchWebsites($websiteID, $name, $url, $comment) {
    try {
        include_once "config.php";

        $db = new PDO("mysql:host=".DBHOST."; dbname=".DBNAME, DBUSER);

        if (!($websiteID || $name || $url || $comment)){
            $statement = $db -> prepare("SELECT * FROM websites");

            $statement -> execute();

            return $statement;
        }

        $name = "%".$name."%";
        $url = "%".$url."%";
        $comment = "%".$comment."%";

        if ($websiteID) {
            $statement = $db -> prepare("SELECT websiteID, name, url, comment FROM websites WHERE websiteID = :websiteID AND name LIKE :name AND url LIKE :url AND comment LIKE :comment");

            $statement -> bindValue(':websiteID', $websiteID, PDO::PARAM_INT);
            $statement -> bindValue(':name', $name, PDO::PARAM_STR);
            $statement -> bindValue(':url', $url, PDO::PARAM_STR);
            $statement -> bindValue(':comment', $comment, PDO::PARAM_STR);

            $statement -> execute();

        } else  {
            $statement = $db -> prepare("SELECT websiteID, name, url, comment, FROM websites
            WHERE name LIKE :name AND url LIKE :url AND comment LIKE :comment");

            $statement -> bindValue(':name', $name, PDO::PARAM_STR);
            $statement -> bindValue(':url', $url, PDO::PARAM_STR);
            $statement -> bindValue(':comment', $comment, PDO::PARAM_STR);

            $statement -> execute();
        }

        return $statement;

    }
    catch(PDOException $error) {
        echo "<p class='highlight'>The function <code>searchWebsites</code> has " .
            "generated the following error:</p>" .
            "<pre>$error</pre>" .
            "<p class='highlight'>Exiting…</p>";

        exit;
    }
}

function updateTableEntry($table, $idName, $id, $attribute, $newValue) {
    try {
        include_once "config.php";

        $db = new PDO("mysql:host=".DBHOST."; dbname=".DBNAME, DBUSER);

        $statement = $db -> prepare("UPDATE $table SET $attribute = :newValue WHERE $idName=:id");

        $statement -> bindValue(':newValue', $newValue, PDO::PARAM_STR);
        $statement -> bindValue(':id', $id, PDO::PARAM_INT);

        $statement -> execute();

    } catch(PDOException $error) {
        echo "<p class='highlight'>The function <code>updateTableEntry</code> has " .
            "generated the following error:</p>" .
            "<pre>$error</pre>" .
            "<p class='highlight'>Exiting…</p>";

        exit;
    }
}

function updateUser($personID, $websiteID, $username, $attribute, $newValue){
    try {
        include_once "config.php";

        $db = new PDO("mysql:host=".DBHOST."; dbname=".DBNAME, DBUSER);

        $statement = $db -> prepare("UPDATE users SET $attribute = :newValue WHERE personID = :personID AND websiteID = :websiteID AND username = :username");

        $statement -> bindValue(':newValue', $newValue, PDO::PARAM_STR);
        $statement -> bindValue(':personID', $personID, PDO::PARAM_INT);
        $statement -> bindValue(':websiteID', $websiteID, PDO::PARAM_INT);
        $statement -> bindValue(':username', $username, PDO::PARAM_STR);

        $statement -> execute();

        $statement = $db -> prepare("UPDATE users SET timestamp = NOW() WHERE personID = :personID AND websiteID = :websiteID and username = :username");

        $statement -> bindValue(':personID', $personID, PDO::PARAM_INT);
        $statement -> bindValue(':websiteID', $websiteID, PDO::PARAM_INT);
        $statement -> bindValue(':username', $username, PDO::PARAM_STR);

        $statement -> execute();
    } catch(PDOException $error) {
        echo "<p class='highlight'>The function <code>updateUser</code> has " .
            "generated the following error:</p>" .
            "<pre>$error</pre>" .
            "<p class='highlight'>Exiting…</p>";

        exit;
    }
}

function deleteTableEntry($table, $idName, $id) {
    try {
        include_once "config.php";

        $db = new PDO("mysql:host=".DBHOST."; dbname=".DBNAME, DBUSER);

        $statement = $db -> prepare("DELETE FROM $table WHERE $idName=:id");

        $statement -> bindValue(':id', $id, PDO::PARAM_INT);

        $statement -> execute();

    } catch(PDOException $error) {
        echo "<p class='highlight'>The function <code>deleteTableEntry</code> has " .
            "generated the following error:</p>" .
            "<pre>$error</pre>" .
            "<p class='highlight'>Exiting…</p>";

        exit;
    }
}

function deleteUser($personID, $websiteID, $username) {
    try {
        include_once "config.php";

        $db = new PDO("mysql:host=".DBHOST."; dbname=".DBNAME, DBUSER);

        $statement = $db -> prepare("DELETE FROM users WHERE personID = :personID AND websiteID = :websiteID AND username = :username");

        $statement -> bindValue(':personID', $personID, PDO::PARAM_INT);
        $statement -> bindValue(':websiteID', $websiteID, PDO::PARAM_INT);
        $statement -> bindValue(':username', $username, PDO::PARAM_STR);

        $statement -> execute();

    } catch(PDOException $error) {
        echo "<p class='highlight'>The function <code>deleteUser</code> has " .
            "generated the following error:</p>" .
            "<pre>$error</pre>" .
            "<p class='highlight'>Exiting…</p>";

        exit;
    }
}

function printUsers($statement) {
    echo "<table>";
    echo "<tr>";
    echo "<th>personID</th>";
    echo "<th>websiteID</th>";
    echo "<th>username</th>";
    echo "<th>password</th>";
    echo "<th>timestamp</th>";
    echo "<th>comment</th>";
    echo "</tr>";

    while ($row = $statement -> fetch()) {
        echo "<tr>";
        echo "<td>".$row['personID']."</td>";
        echo "<td>".$row['websiteID']."</td>";
        echo "<td>".$row['username']."</td>";
        echo "<td>".$row['password']."</td>";
        echo "<td>".$row['timestamp']."</td>";
        echo "<td>".$row['comment']."</td>";
        echo "</tr>";
    }

    echo "</table>";
}

function printPeople($statement) {
    echo "<table>";
    echo "<tr>";
    echo "<th>personID</th>";
    echo "<th>firstName</th>";
    echo "<th>lastName</th>";
    echo "<th>email</th>";
    echo "<th>comment</th>";
    echo "</tr>";

    while ($row = $statement -> fetch()) {
        echo "<tr>";
        echo "<td>".$row['personID']."</td>";
        echo "<td>".$row['firstName']."</td>";
        echo "<td>".$row['lastName']."</td>";
        echo "<td>".$row['email']."</td>";
        echo "<td>".$row['comment']."</td>";
        echo "</tr>";
    }

    echo "</table>";
}

function printWebsites($statement) {
    echo "<table>";
    echo "<tr>";
    echo "<th>websiteID</th>";
    echo "<th>name</th>";
    echo "<th>url</th>";
    echo "<th>comment</th>";
    echo "</tr>";

    while ($row = $statement -> fetch()) {
        echo "<tr>";
        echo "<td>".$row['websiteID']."</td>";
        echo "<td>".$row['name']."</td>";
        echo "<td>".$row['url']."</td>";
        echo "<td>".$row['comment']."</td>";
        echo "</tr>";
    }

    echo "</table>";
}
