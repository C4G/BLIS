<?php
#
# Adds a new lab user account to DB
# Called via Ajax from lab_user_new.php
#

include("../includes/db_lib.php");
include("../includes/script_elems.php");
include("../includes/page_elems.php");
include("../includes/user_lib.php");
$script_elems = new ScriptElems();
$page_elems = new PageElems();

$saved_session = SessionUtil::save();

$usertype=$_REQUEST['u'];

$rwoptions =  get_user_type_options($usertype);

echo $rwoptions;

?>

<?php SessionUtil::restore($saved_session); ?>