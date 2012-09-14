<?php
include("redirect.php");

include("includes/header.php");
LangUtil::setPageId("home");

$page_elems = new PageElems();
$profile_tip = LangUtil::getPageTerm("TIPS_PWD");
$page_elems->getSideTip(LangUtil::getGeneralTerm("TIPS"), $profile_tip);

# Enable JavaScript for recording user props and latency values
# Attaches record.js to this HTML
$script_elems->enableLatencyRecord();
?>

<br>
<span class='page_title'><?php echo LangUtil::getTitle(); ?></span>
<br><br>

<?php 
echo LangUtil::getPageTerm("WELCOME").", " . $_SESSION['username'] . ".<br><br>";
echo LangUtil::getPageTerm("TIPS_BLISINTRO");
?>

<br><br>

<?php
# If technician user, show lab workflow
if($_SESSION['user_level'] == $LIS_TECH_RW || $_SESSION['user_level'] == $LIS_TECH_SHOWPNAME || $_SESSION['user_level'] == $LIS_TECH_RO)
{
	//$page_elems->getLabConfigStatus($_SESSION['lab_config_id']);
}
else if(User::onlyOneLabConfig($_SESSION['user_id'], $_SESSION['user_level']))
{
	//$lab_config_list = get_lab_configs($_SESSION['user_id']);
	//$page_elems->getLabConfigStatus($lab_config_list[0]->id);
}
else
{
	//echo "<br>";
}
echo "<br>";
?>
<?php
include("includes/footer.php");
?>