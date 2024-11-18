<?php
if (isset($_POST['submitted'])) {
    if ($_POST['submitted'] == "CREATE") {
        echo "<p>Looks like you want to create a user there big guy...<p>";
    }
    echo "<p>You submitted the form. Hurray! Click <a href=\"../index.php\">here</a> to go back.</p>";
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
