<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Download a lab backup, with access control.
#

require_once(__DIR__."/../../users/accesslist.php");
require_once(__DIR__."/../../includes/db_lib.php");
require_once(__DIR__."/../../includes/platform_lib.php");
require_once(__DIR__."/../../includes/user_lib.php");

$current_user_id = $_SESSION['user_id'];
$current_user = get_user_by_id($current_user_id);

if (!isset($_REQUEST["lab_config_id"])) {
    $_SESSION["FLASH"] = "Error deleting lab: no lab specified.";
    header("Location: /lab_config_index.php");
    exit;
}

$lab_config_id = $_REQUEST['lab_config_id'];
$lab_db_name_query = "SELECT lab_config_id, name, db_name FROM lab_config WHERE lab_config_id = '$lab_config_id';";
$lab = query_associative_one($lab_db_name_query);
$lab_config_name = $lab["name"];

$unauthorized = true;

// You can only delete a lab if you are a superadmin or country director
if (is_super_admin($current_user) || is_country_dir($current_user)) {
    $unauthorized = false;
}

if ($unauthorized) {
    header('HTTP/1.1 401 Unauthorized', true, 401);
    header("Location: /home.php");
    exit;
}

$confirmed = isset($_GET["confirm"]) && $_GET["confirm"] == "true";

global $log;

$err = false;
if ($confirmed) {
    $log->info("Deleting lab [ID $lab_config_id] database: " . $lab["db_name"]);

    try {
        // in db_lib.php
        delete_lab_config($lab_config_id);
    } catch (Exception $e) {
        $log->error("Could not delete database: ". $e);
        $err = true;
    }

    try {
        $langdata_dir = realpath("../../../local/langdata_$lab_config_id");
        if ($langdata_dir) {
            $log->info("Deleting folder: $langdata_dir");
            PlatformLib::removeDirectory($langdata_dir);
        } else {
            $log->info("Lab [ID $lab_config_id] does not have a langdata folder, so skipping delete.");
        }
    } catch (Exception $e) {
        $log->error("Could not delete langdata folder: ". $e);
        $err = true;
    }

    if (!$err) {
        $_SESSION["FLASH"] = "Lab deleted successfully.";
    } else {
        $_SESSION["FLASH"] = "There was a problem deleting the lab. Please see the logs for details.";
    }

    header("Location: lab_config_index.php");
    exit;
}

require_once(__DIR__."/../../includes/header.php");
LangUtil::setPageId("lab_config_home");

?>

<style type="text/css">
.section {
    padding: 0.5rem 1rem;
}

.section-head {
    margin-top: 0rem;
}

form input[type="submit"] {
    float: right;
    font-weight: bold;
    padding: 5px 10px;
    color: red;
}

.cancel-ok-buttons {
    margin: 0 auto;
    max-width: 400px;
}

.cancel {
    font-weight: bold;
}
</style>

<div id="confirm-delete-lab" class="section">
    <h3 class="section-head">Delete Lab</h3>

    <div class="text-center">
        <p>Are you sure you want to delete <b><?php echo($lab_config_name); ?></b>?</p>

        <p><b>This cannot be undone.</b> ALL data about this lab will be deleted forever!</p>

        <div class="cancel-ok-buttons">
            <form action="delete_lab_config.php" method="GET">
                <a class="cancel" href="lab_config_index.php">Cancel</a>

                <input type="hidden" name="lab_config_id" value="<?php echo($lab_config_id);?>" />
                <input type="hidden" name="confirm" value="true" />
                <input type="submit" value="Delete" />
            </form>
        </div>
    </div>
</div>

<?php
require_once(__DIR__."/../../includes/footer.php");
?>