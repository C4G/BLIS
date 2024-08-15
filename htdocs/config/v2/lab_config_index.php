<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Lists currently accessible lab configurations with options to modify/add
# Check whether to redirect to lab configuration page
# Called when the lab admin has only one lab under him/her
#

require_once(__DIR__."/../../users/accesslist.php");
require_once(__DIR__."/../../includes/user_lib.php");

$current_user_id = $_SESSION['user_id'];
$current_user = get_user_by_id($current_user_id);

if (!isCountryDir($current_user) && !isSuperAdmin($current_user)) {
    header("Location: /home.php");
    return;
}

$lab_config_list = get_lab_configs($current_user_id);

if (User::onlyOneLabConfig($current_user_id, $current_user->level)) {
    $_SESSION['lab_config_id']=$lab_config_list[0]->id;
    header("Location: /lab_config_home.php?id=".$lab_config_list[0]->id);
    return;
}

require_once(__DIR__."/../../includes/header.php");
LangUtil::setPageId("lab_configs");

?>

<script src="/config/v2/js/lab_config.js" type="application/javascript"></script>

<style type="text/css">
.tab-bar {
    padding: 1rem 0;
}

#lab_config_list td hr {
    border: 1px solid #ccc;
}

.hor-minimalist-b td {
    border-bottom: 1px solid #555;
}

</style>

<div class="tab-bar">
    <b><?php echo LangUtil::getTitle(); ?></b>
    | <a href='/lab_config_new.php'><?php echo LangUtil::$pageTerms['CMD_ADDNEWLAB']; ?></a>
    | <a href="/ajax/download_key.php?role=dir">Download Public Key</a>
</div>

<div id='lab_config_list'>
    <?php
    if (count($lab_config_list) == 0) {
        echo "<div class='sidetip_nopos'>".LangUtil::$generalTerms['MSG_NOTFOUND']."</div>";
    } else {
        ?>
    <table class='hor-minimalist-b' style='width:950px;'>
        <thead>
            <tr valign='top'>
                <th>
                    #
                </th>
                <th>
                    <?php echo LangUtil::$generalTerms['FACILITY']; ?>
                </th>
                <th>
                    <?php echo LangUtil::$generalTerms['LOCATION']; ?>
                </th>
                <th>
                    <?php echo LangUtil::$generalTerms['LAB_MGR']; ?>
                </th>
                <th></th>
            </tr>
        </thead>
        <tbody>
    <?php
        $count = 1;
        foreach ($lab_config_list as $lab_config) {
            ?>
            <tr valign='top'>
                <td>
                    <?php echo $count; ?>.
                </td>
                <td>
                    <a href="/lab_config_home.php?id=<?php echo $lab_config->id; ?>">
                        <?php echo $lab_config->name; ?>
                    </a>
                </td>
                <td>
                    <?php echo $lab_config->location; ?>
                </td>
                <td>
                    <?php echo get_username_by_id($lab_config->adminUserId); ?>
                </td>
                <td>
                    <div>
                        <a href="/config/v2/lab_config_backups.php?id=<?php echo $lab_config->id; ?>">
                            <?php echo "Manage Lab Backups"; ?>
                        </a>
                    </div>
                    <hr>
                    <div>
                        <a href="/exportLabConfiguration.php?id=<?php echo $lab_config->id; ?>">
                            <?php echo "Export Lab Configuration"; ?>
                        </a>
                    </div>
                </td>
            </tr>
    <?php
            $count++;
        } ?>
        </tbody>
    </table>
    <?php
    }
    ?>
</div>

<?php require_once(__DIR__."/../../includes/footer.php"); ?>
