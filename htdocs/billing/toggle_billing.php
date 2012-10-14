<?php
#
# Toggles whether or not this lab calculates bills for patients
#

include("redirect.php");
include("includes/db_lib.php");
include("includes/user_lib.php");
include("includes/page_elems.php");
include("includes/script_elems.php");
include("includes/stats_lib.php");
include("lang/lang_xml2php.php");
include("users/accesslist.php");

LangUtil::setPageId("billing");

?>
<input type="checkbox" value="enable_billing" name="enable_billing"/>Enable Billing
<br>
<input type="submit" value="Update" />
<?

?>
