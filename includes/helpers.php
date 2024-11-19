<?php
if (isset($_POST['submitted'])) {
    echo "<p>You submitted the form. Hurray!<p>";

    if ($_POST['submitted'] === "CREATE-USER") {
        echo "<p>Looks like you want to create a user there big guy...<p>";
        if (valueExistsInAttribute($_POST['url'], "url", "websites")) {
            echo "<p>We found the website! :)<p>";
            $websiteID = getValue("websiteID", "websites", "url", $_POST['url']);
        } else {
            echo "<p>We didn't find the website... :(";
        }
        if (!valuePairExistsInAttributePair($_POST['username'], $websiteID, "username", "websiteID", "users")) {
            echo "<p>This username is available! :))<p>";
            $username = $_POST['username'];
        } else {
            echo "<p>That username is already taken... :((<p>";
        }
        $websiteID = null;
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
