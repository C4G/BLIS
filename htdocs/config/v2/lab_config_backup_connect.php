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
$lab_config_id = $_REQUEST['id'];

DbUtil::switchToGlobal();

$lab_db_name_query = "SELECT lab_config_id, name, db_name FROM lab_config WHERE lab_config_id = '$lab_config_id';";
$lab = query_associative_one($lab_db_name_query);
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
    header('HTTP/1.1 401 Unauthorized', true, 401);
    header("Location: /home.php");
    exit;
}

require_once(__DIR__."/../../includes/header.php");
LangUtil::setPageId("lab_config_home");

require_once(__DIR__."/../../includes/keymgmt.php");

$selected_tab = "connect";
require_once(__DIR__."/lab_config_backup_header.php");
require_once(__DIR__."/lib/lab_connection.php");
?>

<style type="text/css">


    #connection-code label {
        font-weight: bold;
    }

    #connection-code input {
        width: 13rem;
    }

    #connection-url {
        margin-bottom: 0.5rem;
    }

    #connection-url label {
        font-weight: bold;
    }

    #connection-url input {
        width: 30rem;
    }

    input.readonly-text {
        background-color: lightgrey;
        font-family: monospace;
        font-weight: bold;
        width: 11rem;
    }
</style>

<div id="connect-lab">
    <h3 class="section-head">Connect Offline Lab</h3>

    <?php
        $connection = LabConnection::find_or_create($lab_config_id);
        $code = $connection->connection_code;
        $code_quartets = array();
        for($x = 0; $x <= 3; $x++) {
            if ($x < 3) {
                array_push($code_quartets, substr($code, $x * 5, 5));
            } else {
                array_push($code_quartets, substr($code, $x * 5));
            }
        }
        $formatted_code = implode("-", $code_quartets);

        if ($_SERVER['HTTP_HOST'] == "localhost") {
            $scheme = "http";
        } else {
            $scheme = "https";
        }
        $connection_url = "$scheme://" . $_SERVER['HTTP_HOST'] . "/config/v2/blis_cloud_server.php?lab_config_id=$lab_config_id";

        if ($connection->last_backup_time) {
            $last_backup = date("Y-m-d H:i:s", $connection->last_backup_time);
        } else {
            $last_backup = "Never";
        }

    ?>
    <div id="connection-url">
        <label for="connection-url">Connection URL:</label>
        <input class="readonly-text" name="connection-url" type="text" readonly value="<?php echo($connection_url); ?>" />
    </div>

    <div id="connection-code">
        <label for="connection-code">Connection Code:</label>
        <input class="readonly-text" name="connection-code" type="text" readonly value="<?php echo($formatted_code); ?>" />
    </div>
</div>

<hr>

<div id="connected-labs">
    <h3 class="section-head">Connected Lab Information</h3>

    <ul>
        <li>Lab name: <?php echo($connection->lab_name); ?></li>
        <li>Last successful backup: <?php echo($last_backup); ?></li>
        <li>Last backup IP address: <?php echo($connection->last_backup_ip); ?></li>
</div>

<?php require_once(__DIR__."/../../includes/footer.php"); ?>
