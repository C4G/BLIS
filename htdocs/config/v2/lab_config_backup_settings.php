<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Lists currently accessible lab configurations with options to modify/add
# Check whether to redirect to lab configuration page
# Called when the lab admin has only one lab under him/her
#

require_once(__DIR__."/../../users/accesslist.php");
require_once(__DIR__."/../../includes/lab_config.php");
require_once(__DIR__."/../../includes/user_lib.php");
require_once(__DIR__."/lib/backup.php");

$current_user_id = $_SESSION['user_id'];
$current_user = get_user_by_id($current_user_id);
$lab_config_id = $_REQUEST['id'];

DbUtil::switchToGlobal();

$lab_db_name_query = "SELECT * FROM lab_config WHERE lab_config_id = '$lab_config_id';";
$lab = query_associative_one($lab_db_name_query);
$lab_config = LabConfig::getObject($lab);

db_change($lab['db_name']);

$lab_config_name = $lab["name"];

$super_admin_or_country_dir = is_super_admin($current_user) || is_country_dir($current_user);

$unauthorized = true;

if ($super_admin_or_country_dir) {
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
    header(LangUtil::$generalTerms['401_UNAUTHORIZE'], true, 401);
    header("Location: /home.php");
    exit;
}

require_once(__DIR__."/../../includes/header.php");
LangUtil::setPageId("lab_config_home");

$settings_encryption_enabled = $lab_config->backup_encryption_enabled;

$selected_tab = "settings";
require_once(__DIR__."/lab_config_backup_header.php");
require_once(__DIR__."/../../encryption/keys.php");

function key_to_row($key) {
    global $lab_config_id;
    $key_id = $key->id;
    echo(
        "<tr>\n" .
        "<td class=\"text-right\">" . $key->created_at . "</td>\n" .
        "<td class=\"text-right\">" . $key->name . "</td>\n" .
        "<td><a href=\"../../encryption/download_key.php?lab_config_id=$lab_config_id&key_id=$key_id\">Download</a></td>\n" .
        "</tr>\n"
    );
}

$server_keys = Key::where_type(Key::$KEYPAIR);
$public_keys = Key::where_type(Key::$PUBLIC);

?>

<div id="settings" class="section">
    <h3 class="section-head">Settings for <?php echo($lab_config_name); ?></h3>
    <form id="settings_form" action="update_backup_settings.php?id=<?php echo($lab_config_id); ?>" method="POST">
        <div class="form-element">
            <input type="checkbox" id="settings_encryption_enabled" name="settings_encryption_enabled" <?php echo($settings_encryption_enabled ? "checked" : ""); ?>>
            <label for="settings_encryption_enabled">Enable Encrypted Backups</label>
        </div>
        <div class="form-element">
            <?php if ($settings_encryption_enabled) {
            ?>
            <label for="settings_lab_decryption_key">Backup decryption key:</label>
            <select id="settings_lab_decryption_key" name="settings_lab_decryption_key" autocomplete="off">
                <option value=""></option>
                <?php
                foreach ($server_keys as $keypair)
                {
                    $selected = $lab_config->backup_encryption_key_id != null && ($keypair->id == $lab_config->backup_encryption_key_id);
                    $selected_attr = $selected ? "selected" : "";
                    echo "<option value=\"" . $keypair->id . "\" $selected_attr>" . $keypair->name . "</option>";
                }
                ?>
            </select>
            <?php
            }
            ?>

        </div>

        <div class="form-element">
            <input type="submit" value="Update">
        </div>
    </form>
</div>

<?php
    if ($super_admin_or_country_dir) {
?>

<div id="key-management" class="section">
    <h3 class="section-head">Decryption Keys</h3>
    <div id="server-keypair-table">
        <table class="hor-minimalist-b">
            <thead>
                <tr>
                    <th class="text-right">Created at</th>
                    <th class="text-center">Name</th>
                    <th></th>
                </tr>
            </thead>
            <?php
                foreach($server_keys as $key) {
                    echo(key_to_row($key));
                }
            ?>
        </table>
    </div>

    <div id="create-key-form">
        <br/>
        <form id="create_key_form" name="create_key_form" action="lab_config_backup_create_keypair.php?id=<?php echo($lab_config_id); ?>" method="post" enctype="multipart/form-data">
            <b>Create new server key:</b> <input type="text" id="keypair_name" name="keypair_name">
            <input type="submit" id="create_submit" value="Create">
        </form>
    </div>
</div>
<?php
    }
?>

<div id="pubkey-table" class="section">
    <h3 class="section-head">Encryption Keys</h3>

    <table class="hor-minimalist-b">
        <thead>
            <tr>
                <th class="text-right">Created at</th>
                <th class="text-center">Name</th>
                <th></th>
            </tr>
        </thead>
        <?php
            foreach($public_keys as $key) {
                echo(key_to_row($key));
            }
        ?>
    </table>
</div>

<div id="upload-key-form" class="section">
    <form id="upload_key_form" name="upload_key_form" action="lab_config_backup_upload_pubkey.php?id=<?php echo($lab_config_id); ?>" method="post" enctype="multipart/form-data">
        <b>Upload encryption key:</b> <input type="file" id="pubkey" name="pubkey">
        <input type="submit" id="upload_submit" value="Upload">
    </form>
</div>

<?php require_once(__DIR__."/../../includes/footer.php"); ?>
