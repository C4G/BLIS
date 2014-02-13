<?php
#
# Sends a new specimen registration form
# Called via Ajax from new_specimen.php
#

include("../includes/page_elems.php");


/*
$lang_util_included = false;
$included_list = get_included_files();
foreach($included_list as $included_file)
{
	if(strpos($included_file, $_SESSION['locale'].".php") === true)
	{
		$lang_util_included = true;
		break;
	}
}
if($lang_util_included === false)
{
	include("../lang/".$_SESSION['locale'].".php");
}
*/
$doc_session = $_SESSION['doctor'];

putUILog('specimenbox_add', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');


$page_elems = new PageElems();
$num = $_REQUEST['num'];
$pid = $_REQUEST['pid'];
$dnum = $_REQUEST['dnum'];
$session_num = $_REQUEST['session_num'];
$doctor = "";
$refTo = "";
if(isset($_REQUEST['doc']))
	{
	$doc = $_REQUEST['doc'];
	$title=$_REQUEST['title'];
	}
if(isset($_REQUEST['refTo']))
	{
		$refTo = $_REQUEST['refTo'];
	}
	
$_SESSION['doctor'] = $doc_session;
$page_elems->getNewSpecimenForm($num, $pid, $dnum, $session_num, $doc , $title, $refTo);
?>