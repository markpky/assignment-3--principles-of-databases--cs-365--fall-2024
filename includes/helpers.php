<?php
if (isset($_POST['submitted'])) {
    if ($_POST['submitted'] == "CREATE") {
        echo "<p>Looks like you want to create a user there big guy...<p>";
    }
    echo "<p>You submitted the form. Hurray! Click <a href=\"../index.php\">here</a> to go back.</p>";
} else {
    echo "<p>One of the forms from index.php was not submitted. Click <a href=\"../index.php\">here</a> to go back.</p>";
}
