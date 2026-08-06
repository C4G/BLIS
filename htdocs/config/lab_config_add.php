<?php
#
# Adds a new lab configuration to DB
#
require_once("redirect.php");
require_once("includes/composer.php");
require_once("includes/platform_lib.php");
require_once("includes/user_lib.php");
require_once("includes/db_lib.php");
require_once("includes/random.php");
require_once("lang/lang_xml2php.php");

putUILog('lab_config_add', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');

$saved_session = SessionUtil::save();

$lab_config = new LabConfig();
$lab_config->name = $_REQUEST['name'];
$lab_config->location = $_REQUEST['location'];
$lab_config->country = $_REQUEST['country'];
$lab_admin = $_REQUEST['lab_admin'];
$country = $_REQUEST['country'];
$blocation = $_REQUEST['blocation'];
$itests = $_REQUEST['itest'];
global $labIdArray;
$count = 0;

$lab_config->idMode = $_REQUEST['id_mode'];
$saved_db = DbUtil::switchToGlobal();

$query = "SELECT lab_config_id from lab_config";
$records = query_associative_all($query);
$inds = array();
foreach($records as $record) {
	$inds[] = $record['lab_config_id'];
}
sort($inds);
$log->debug('Found lab ids: '.print_r($inds, 1));
$elems = count($inds);
$count = $elems + 2;
for($i=0;$i<=$elems;$i++){
	if($inds[$i] != $i+1) {
		$count = $i+1;
		break;
	}
}
$log->debug("New lab in: $count");


DbUtil::switchRestore($saved_db);

$lab_config_id = $count;
$db_name = "blis_".$lab_config_id;
$lab_config->id = $lab_config_id;
$lab_admin_id = checkAndAddAdmin($lab_admin, $lab_config_id);
checkAndAddUserConfig($lab_admin_id);
# Link admin user id to session variable of selection box value
$lab_config->adminUserId = $lab_admin_id;
$lab_config->db_name = $db_name;
# Add new lab configuration entry to DB
add_lab_config($lab_config);
$saved_config_id = $lab_config_id;
$user = get_user_by_id($_SESSION['user_id']);
if(is_country_dir($user)) {
	add_lab_config_access($_SESSION['user_id'], $lab_config_id);
}

set_lab_config_db_name($lab_config_id, $db_name);

# Add user accounts
$user_list = $_REQUEST['username'];
$pwd_list = $_REQUEST['password'];
$fullname_list = $_REQUEST['fullname'];
for($i = 0; $i < count($user_list); $i++)
{
	$username = $user_list[$i];
	$pwd = $pwd_list[$i];
	$actual_name = $fullname_list[$i];
	$access_level = $_REQUEST['access_priv_'.$i];
	if($username == "")
	{
		# Empty entry
		continue;
	}
	$user = new User();
	$user->userId = "to be assigned";
	$user->username = $username;
	$user->password = $pwd;
	$user->actualName = $actual_name;
	$user->email = "";
	$user->phone = "";
	$user->level = $access_level;
	$user->createdBy = $_SESSION['user_id'];
	$user->labConfigId = $lab_config_id;
	$user->langId = "default";
	$user->rwoptions = "2,3,4,6,7";
	add_user($user);
}

# Create DB instance for this lab
db_create($db_name);

# Switch to this new instance and create data tables
db_change($db_name);
create_lab_config_tables($db_name);

# Generate initial worksheet configs if missing
$lab_config = LabConfig::getById($lab_config_id);
$lab_config->worksheetConfigGenerate();

# TODO:
$saved_id = $_SESSION['lab_config_id'];
$_SESSION['lab_config_id'] = $lab_config_id;
//db_change($GLOBAL_DB_NAME);

# Create new langdata folder for this lab

global $LOCAL_PATH, $log;

# Copy contents of local/langdata_revamp/ into this new folder
if (is_dir($LOCAL_PATH."/langdata_".$lab_config_id)) {
    $log->warning("$LOCAL_PATH/langdata_$lab_config_id already exists. Deleting it.");
    PlatformLib::removeDirectory($LOCAL_PATH."/langdata_".$lab_config_id);
}
chmod($LOCAL_PATH."/langdata_revamp", 0755);
chmod($LOCAL_PATH."/langdata_".$lab_config_id, 0755);
mkdir($LOCAL_PATH."/langdata_".$lab_config_id);
$log->info("Copying langdata_revamp folder to langdata_$lab_config_id");
PlatformLib::copyDirectory($LOCAL_PATH."/langdata_revamp", $LOCAL_PATH."/langdata_".$lab_config_id);

$langdata_path = $LOCAL_PATH."/langdata_".$lab_config_id."/";
remarks_db2xml($langdata_path, $lab_config_id);

$_SESSION['lab_config_id'] = $saved_id;

if($blocation > 0)
{
    setBaseConfig($blocation, $lab_config_id);

    foreach($itests as $key=>$itest)
    {
        if($blocation != $key)
        {
            foreach($itest as $it)
            {
                import_test_between_labs($it, $key, $lab_config_id);
            }
        }
    }
}
SessionUtil::restore($saved_session);
header("Location: lab_config_added.php?id=$saved_config_id");
?>
