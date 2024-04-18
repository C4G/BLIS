<?php

require_once(__DIR__."/util.php");

require_admin_or_401();

require_once(__DIR__."/../includes/header.php");

?>

<style type="text/css">
    .debug-flash {
        background-color: lightpink;
        margin: 0.5rem;
        padding: 1rem;
        font-size: large;
    }
</style>

<h2>Debug Utilities</h2>

<?php
    # This is used for rendering ephemeral messages on this page.
    # To use, set $_SESSION['DEBUG_FLASH'] on another page and then redirect to this one.
    # See debug_update_language.php for an example.
    if ($_SESSION['DEBUG_FLASH'] != '') {
        echo "<div class=\"debug-flash\">".$_SESSION['DEBUG_FLASH']."</div>";
        $_SESSION['DEBUG_FLASH'] = '';
    }
?>

<h3>Available Log Files</h3>

<ul>
<?php
    $available_logs = available_log_files();
    $log_names = array_keys($available_logs);
    foreach($log_names as $logfile) {
        echo "<li><a href=\"/debug/logs.php?name=$logfile\">$logfile</a></li>\n";
    }
?>
</ul>

<h3>Language Utilities</h3>

<ul>
    <li><a href="/debug/debug_update_language.php">Reset/update language files</a></li>
</ul>

<?php

require_once("includes/footer.php");
