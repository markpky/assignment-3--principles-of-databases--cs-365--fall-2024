<?php
if(isset($_POST['submitted'])) {
    echo "<p>You submitted the form. Hurray! Click <a href=\"../index.php\">here</a> to go back.</p>";
} else {
    echo "<p>The CREATE form from index.php was not submitted. Click <a href=\"../index.php\">here</a> to go back.</p>";
}
