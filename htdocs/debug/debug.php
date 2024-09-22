<?php

require_once(__DIR__."/util.php");

require_admin_or_401();

require_once(__DIR__."/../includes/header.php");

?>

<style type="text/css">
    .red-danger {
        font-size: large;
        font-weight: bold;
        color: red;
    }
</style>

<h2>Debug Utilities</h2>

<?php
    $commit_sha = getenv('GIT_COMMIT_SHA');

    if (!!$commit_sha) {
        $github_link = "https://github.com/C4G/BLIS/tree/$commit_sha";
    } else {
        $github_link = "https://github.com/C4G/BLIS";
    }
?>

<p>
    <b>Git commit SHA:</b> <code><?php echo($commit_sha); ?></code> <i>(<a href="<?php echo($github_link); ?>">browse source code</a>)</i>
</p>

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

<h3>Database Utilities</h3>

<h4>Legacy Lab Database Migrations</h4>

<p>
    <span class="red-danger">Warning!</span><br/>
    Running ANY of these migrations could break your lab configuration
    <span class="red-danger">PERMANENTLY!</span><br/>
    These migrations are used to perform manual updates to an imported lab configuration
    from an older version of BLIS.
</p>

<form action="/debug/debug_apply_migration.php" method="GET">
    <label for="migration-lab-select">Lab database:</label>
    <select id="migration-lab-select" name="lab">
        <option value="">Select a lab</option>
    <?php
        $lab_configs = get_lab_configs();
        foreach($lab_configs as $lab) {
            $display_name = $lab->name . " (" . $lab->dbName . ")";
            echo("<option value=\"".$lab->dbName."\">$display_name</option>\n");
        }
    ?>
    </select>

    <br/>

    <label for="migration-select">SQL migration:</label>
    <select id="migration-select" name="migration">
        <option value="">Select a migration</option>
    <?php
        $available_migrations = list_files_like(__DIR__."/../data/", "/db_update_lab/");
        foreach($available_migrations as $migration) {
            echo("<option value=\"$migration\">$migration</option>\n");
        }
    ?>
    </select>

    <br/>

    <input type="submit" value="Apply"/>
</form>

<?php

require_once("includes/footer.php");
