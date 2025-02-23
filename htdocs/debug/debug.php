<?php

require_once(__DIR__."/util.php");

require_admin_or_401();

LangUtil::setPageId("debug");

require_once(__DIR__."/../includes/header.php");

?>

<style type="text/css">
    .red-danger {
        font-size: large;
        font-weight: bold;
        color: red;
    }
</style>

<h2><?php echo LangUtil::$debug['DEBUG_UTILITIES']; ?></h2>

<?php
    $commit_sha = getenv('GIT_COMMIT_SHA');

    if (!!$commit_sha) {
        $github_link = "https://github.com/C4G/BLIS/tree/$commit_sha";
    } else {
        $github_link = "https://github.com/C4G/BLIS";
    }
?>

<p>
    <b><?php echo LangUtil::$debug['GIT_COMMIT_SHA']; ?>:</b> <code><?php echo($commit_sha); ?></code> <i>(<a href="<?php echo($github_link); ?>"><?php echo LangUtil::$debug['BROWSE_SOURCE_CODE']; ?></a>)</i>
</p>

<h3><?php echo LangUtil::$debug['AVAILABLE_LOG_FILES']; ?></h3>

<ul>
<?php
    $available_logs = available_log_files();
    $log_names = array_keys($available_logs);
    foreach($log_names as $logfile) {
        echo "<li><a href=\"/debug/logs.php?name=$logfile\">$logfile</a></li>\n";
    }
?>
</ul>

<h3><?php echo LangUtil::$debug['LANGUAGE_UTILITIES']; ?></h3>

<ul>
    <li><a href="/debug/debug_update_language.php"><?php echo LangUtil::$debug['RESET_UPDATE_LANGUAGE_FILES']; ?></a></li>
</ul>

<h3><?php echo LangUtil::$debug['DATABASE_UTILITIES']; ?></h3>

<h4><?php echo LangUtil::$debug['LEGACY_LAB_DATABASE_MIGRATIONS']; ?></h4>

<p>
    <span class="red-danger"><?php echo LangUtil::$debug['WARNING']; ?></span><br/>
    <?php echo LangUtil::$debug['MIGRATION_WARNING']; ?><br/>
    <?php echo LangUtil::$debug['MIGRATION_DESCRIPTION']; ?>
</p>

<form action="/debug/debug_apply_migration.php" method="GET">
    <label for="migration-lab-select"><?php echo LangUtil::$debug['LAB_DATABASE']; ?>:</label>
    <select id="migration-lab-select" name="lab">
        <option value=""><?php echo LangUtil::$debug['SELECT_LAB']; ?></option>
    <?php
        $lab_configs = get_lab_configs();
        foreach($lab_configs as $lab) {
            $display_name = $lab->name . " (" . $lab->dbName . ")";
            echo("<option value=\"".$lab->dbName."\">$display_name</option>\n");
        }
    ?>
    </select>

    <br/>

    <label for="migration-select"><?php echo LangUtil::$debug['SQL_MIGRATION']; ?>:</label>
    <select id="migration-select" name="migration">
        <option value=""><?php echo LangUtil::$debug['SELECT_MIGRATION']; ?></option>
    <?php
        $available_migrations = list_files_like(__DIR__."/../data/", "/db_update_lab/");
        foreach($available_migrations as $migration) {
            echo("<option value=\"$migration\">$migration</option>\n");
        }
    ?>
    </select>

    <br/>

    <input type="submit" value="<?php echo LangUtil::$debug['APPLY']; ?>"/>
</form>

<?php

require_once("includes/footer.php");
