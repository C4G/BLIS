<?php

require_once(__DIR__."/util.php");

require_admin_or_401();

require_once(__DIR__."/../includes/header.php");

LangUtil::setPageId("debug");

?>

<style type="text/css">
    .red-danger {
        font-size: large;
        font-weight: bold;
        color: red;
    }
</style>

<h2><?php echo LangUtil::$pageTerms['DEBUG_UTILITIES']; ?></h2>

<?php
    $commit_sha = getenv('GIT_COMMIT_SHA');

    if (!!$commit_sha) {
        $github_link = "https://github.com/C4G/BLIS/tree/$commit_sha";
    } else {
        $github_link = "https://github.com/C4G/BLIS";
    }
?>

<p>
    <b><?php echo LangUtil::$pageTerms['GIT_COMMIT_SHA']; ?>:</b> <code><?php echo($commit_sha); ?></code> <i>(<a href="<?php echo($github_link); ?>"><?php echo LangUtil::$pageTerms['BROWSE_SOURCE_CODE']; ?></a>)</i>
</p>

<h3><?php echo LangUtil::$pageTerms['AVAILABLE_LOG_FILES']; ?></h3>

<ul>
<?php
    $available_logs = available_log_files();
    $log_names = array_keys($available_logs);
    foreach($log_names as $logfile) {
        echo "<li><a href=\"/debug/logs.php?name=$logfile\">$logfile</a></li>\n";
    }
?>
</ul>

<h3><?php echo LangUtil::$pageTerms['LANGUAGE_UTILITIES']; ?></h3>

<ul>
    <li><a href="/debug/debug_update_language.php"><?php echo LangUtil::$pageTerms['RESET_UPDATE_LANGUAGE_FILES']; ?></a></li>
</ul>

<h3><?php echo LangUtil::$pageTerms['DATABASE_UTILITIES']; ?></h3>

<h4><?php echo LangUtil::$pageTerms['LEGACY_LAB_DATABASE_MIGRATIONS']; ?></h4>

<p>
    <span class="red-danger"><?php echo LangUtil::$pageTerms['WARNING']; ?></span><br/>
    <?php echo LangUtil::$pageTerms['MIGRATION_WARNING']; ?><br/>
    <?php echo LangUtil::$pageTerms['MIGRATION_DESCRIPTION']; ?>
</p>

<form action="/debug/debug_apply_migration.php" method="GET">
    <label for="migration-lab-select"><?php echo LangUtil::$pageTerms['LAB_DATABASE']; ?>:</label>
    <select id="migration-lab-select" name="lab">
        <option value=""><?php echo LangUtil::$pageTerms['SELECT_LAB']; ?></option>
    <?php
        $lab_configs = get_lab_configs();
        foreach($lab_configs as $lab) {
            $display_name = $lab->name . " (" . $lab->dbName . ")";
            echo("<option value=\"".$lab->dbName."\">$display_name</option>\n");
        }
    ?>
    </select>

    <br/>

    <label for="migration-select"><?php echo LangUtil::$pageTerms['SQL_MIGRATION']; ?>:</label>
    <select id="migration-select" name="migration">
        <option value=""><?php echo LangUtil::$pageTerms['SELECT_MIGRATION']; ?></option>
    <?php
        $available_migrations = list_files_like(__DIR__."/../data/", "/db_update_lab/");
        foreach($available_migrations as $migration) {
            echo("<option value=\"$migration\">$migration</option>\n");
        }
    ?>
    </select>

    <br/>

    <input type="submit" value="<?php echo LangUtil::$pageTerms['APPLY']; ?>"/>
</form>

<?php

require_once("includes/footer.php");
