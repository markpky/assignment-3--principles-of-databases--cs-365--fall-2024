<?php
if (isset($_POST['submitted'])) {
    echo "<p>You submitted the form. Hurray!<p>";

    if ($_POST['submitted'] === "CREATE-USER") {
        echo "<p>Looks like you want to create a user there big guy...<p>";
        $websiteID = null;
        $username = null;
        $personID = null;

        if (valueExistsInAttribute($_POST['url'], "url", "websites")) {
            echo "<p>We found the website! :)<p>";
            $websiteID = getValue("websiteID", "websites", "url", $_POST['url']);
        } else {
            echo "<p>We didn't find the website... :(";
        }

        if ($websiteID === null) {
            echo "<p>Since we couldn't find the website you were looking for, the username might become available once we know about the website! ;)<p>";
        }
        else if (!valuePairExistsInAttributePair($_POST['username'], $websiteID, "username", "websiteID", "users")) {
            echo "<p>This username is available! :))<p>";
            $username = $_POST['username'];
        } else {
            echo "<p>That username is already taken... :((<p>";
        }

        if (valueExistsInAttribute($_POST['email'], "email", "people")) {
            echo "<p>We found the email! :)))<p>";
            $personID = getValue("personID", "people", "email", $_POST['email']);
        } else {
            echo "<p>We couldn't find that email... :(((<p>";
        }

        if ($websiteID && $username && $personID) {
            echo "<p>We can create your user in our database! :D<p>";
            insertUser($personID, $websiteID, $username, $_POST['password'], $_POST['comment']);
            echo "<p>They've been created!<p>";
        } else {
            echo "<p>We cannot create your user in our database... D:<p>";
        }

        $websiteID = null;
        $username = null;
        $personID = null;
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
            "<code>valueExistsInAttribute</code> has generated the " .
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

        $statement = $db -> prepare("insert into users (personID, websiteID, username, password, timestamp, comment)
            values (:personID , :websiteID , :username , :password , NOW() , :comment )");

        $statement -> execute(
            array(
                'personID'  => $personID,
                'websiteID' => $websiteID,
                'username'  => $username,
                'password'  => $password,
                'comment'   => $comment
            )
        );
    }
    catch(PDOException $error) {
        echo "<p class='highlight'>The function <code>getValue</code> has " .
            "generated the following error:</p>" .
            "<pre>$error</pre>" .
            "<p class='highlight'>Exiting…</p>";

        exit;
    }
}
