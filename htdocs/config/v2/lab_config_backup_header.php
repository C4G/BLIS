<?php

// Assume authentication + everything has been done outside of this file
global $lab_config_id;
global $selected_tab;

function render_tab($tab_name, $tab_link, $tab_label) {
    global $selected_tab;

    if ($tab_name == $selected_tab) {
        echo("<b>$tab_label</b>");
    } else {
        echo("<a href=\"$tab_link\">$tab_label</a>");
    }
}

?>

<script src="/config/v2/js/lab_config.js" type="application/javascript"></script>

<style type="text/css">
.tab-bar {
    padding: 1rem 0;
}

#backup_list table {
    width: 100%;
}

#backup_list table th {
    font-weight: bold;
}

.text-right {
    text-align: right;
}

.text-center {
    text-align: center;
}

#settings {
    padding: 0.5rem 1rem;
}

#key-management {
    padding: 0.5rem 1rem;
}

.section {
    padding: 0.5rem 1rem;
}

.section-head {
    margin-top: 0rem;
}

.form-element {
    margin: 0.5rem 1rem;
}

.backup-flash {
    background-color: lightgreen;
    margin: 0.5rem;
    padding: 1rem;
    font-size: large;
}

</style>

<div class="tab-bar">
    <a href="/lab_config_home.php?id=<?php echo($lab_config_id) ?>"><< Lab Configuration</a>
    | <?php render_tab("lab_backups", "lab_config_backups.php?id=$lab_config_id", "Lab Backups"); ?>
    | <?php render_tab("settings", "lab_config_backup_settings.php?id=$lab_config_id", "Settings"); ?>
    | <?php render_tab("upload", "lab_config_backup_upload.php?id=$lab_config_id", "Upload Backup"); ?>
</div>

<?php
    # This is used for rendering ephemeral messages on this page.
    # To use, set $_SESSION['BACKUP_FLASH'] on another page and then redirect to this one.
    if ($_SESSION['BACKUP_FLASH'] != '') {
        echo "<div class=\"backup-flash\">".$_SESSION['BACKUP_FLASH']."</div>";
        $_SESSION['BACKUP_FLASH'] = '';
    }
?>
