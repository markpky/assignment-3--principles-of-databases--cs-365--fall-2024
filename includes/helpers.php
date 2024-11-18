<?php

if(isset($_POST['submitted']) && $_POST['submitted'] == "painis") {
    echo "<p><strong><code>\$_POST[submitted]</code>: {$_POST['submitted']} hurroay</p>";
    echo "<p>Click <a href=\"../index.php\">here</a> to go back.</p>";
}
