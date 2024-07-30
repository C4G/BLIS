<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Lists currently accessible lab configurations with options to modify/add
# Check whether to redirect to lab configuration page
# Called when the lab admin has only one lab under him/her
#

require_once(__DIR__."/../../users/accesslist.php");
require_once(__DIR__."/../../includes/user_lib.php");
require_once(__DIR__."/lib/backup.php");

$current_user_id = $_SESSION['user_id'];
$current_user = get_user_by_id($current_user_id);
$lab_config_id = $_REQUEST['id'];

DbUtil::switchToGlobal();

$lab_db_name_query = "SELECT lab_config_id, name, db_name FROM lab_config WHERE lab_config_id = '$lab_config_id';";
$lab = query_associative_one($lab_db_name_query);
db_change($lab['db_name']);

$unauthorized = true;

if (is_super_admin($current_user) || is_country_dir($current_user)) {
    $unauthorized = false;
}

if ($unauthorized) {
    // If the user is not a super admin or country director, they should only
    // be able to access data for their own lab, and only if they are an admin.
    if ($lab_config_id == $current_user->labConfigId && is_admin($current_user)) {
        $unauthorized = false;
    }
}

if ($unauthorized) {
    header('HTTP/1.1 401 Unauthorized', true, 401);
    header("Location: /home.php");
    exit;
}

require_once(__DIR__."/../../includes/header.php");
LangUtil::setPageId("lab_configs");

$backups = Backup::for_lab_config_id($lab_config_id);

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
</style>

<div class="tab-bar">
    <a href="/lab_config_home.php?id=<?php echo($lab_config_id) ?>"><< Lab Configuration</a>
    | <b>Lab Backups</b>
    | <a href='#'>Upload Backup</a>
    | <a href="#">Connect Lab</a>
</div>

<div id='backup_list'>
    <?php
    if (count($backups) == 0) {
        echo "<div class='sidetip_nopos'>".LangUtil::$generalTerms['MSG_NOTFOUND']."</div>";
    } else {
        ?>
    <table class='hor-minimalist-b'>
        <thead>
            <tr valign='top'>
                <th>
                    Date
                </th>
                <th>
                    Database Name
                </th>
                <th>
                    BLIS Version
                </th>
                <th>
                    Filename
                </th>
                <th></th>
            </tr>
        </thead>
        <tbody>
    <?php
        $count = 1;
        foreach ($backups as $backup) {
            $analyzed = $backup->analyze();

            ?>
            <tr valign='top'>
                <td class="text-right">
                    <?php echo date("F j Y g:i:s", $backup->timestamp); ?>
                </td>
                <td class="text-right">
                    <?php echo $analyzed->database_name; ?>
                </td>
                <td class="text-right">
                    <?php echo $analyzed->version; ?>
                </td>
                <td>
                    <?php echo $backup->filename; ?>
                </td>
                <td>
                    Restore
                </td>
            </tr>
    <?php
        } ?>
        </tbody>
    </table>
    <?php
    }
    ?>
</div>

<?php require_once(__DIR__."/../../includes/footer.php"); ?>
