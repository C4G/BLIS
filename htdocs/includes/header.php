<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
#
$path = "../";
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

# Start session if not already started
if(session_id() == "")
	session_start();
# Include required libraries
require_once("includes/db_lib.php");
require_once("includes/user_lib.php");
		$user = get_user_by_name($_SESSION['username']);
if(!is_allowed(basename($_SERVER['PHP_SELF']),$user->rwoptions))
{
header("Location: home.php");
die();
}
$TRACK_LOADTIME = false;
$TRACK_LOADTIMEJS = false;
if($TRACK_LOADTIME)
{
	$starttime = microtime();
	$startarray = explode(" ", $starttime);
	$starttime = $startarray[1] + $startarray[0];
}


require_once("includes/page_elems.php");
require_once("includes/script_elems.php");
LangUtil::setPageId("header");
require_once("includes/perms_check.php");

# Perform system updates to portable version , if any
/*
if
(
	$SERVER == $ON_PORTABLE && 
	strpos($_SERVER['PHP_SELF'], "/home.php") !== false &&
	$_SESSION['user_level'] != $LIS_SUPERADMIN &&
	$_SESSION['user_level'] != $LIS_COUNTRYDIR
)
{
	if
	(
		$_SESSION['user_level'] == $LIS_ADMIN && 
		! User::onlyOneLabConfig($_SESSION['user_id'], $_SESSION['user_level'])
	)
	{
		# Do not include update file as this lab admin account is incharge of multiple labs
	}
	else
	{
		include("update/update.php");
	}
}
*/
$script_elems = new ScriptElems();
$page_elems = new PageElems();
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>
		Basic Laboratory Information System v<?php echo $VERSION; ?>
		</title>
<?php
		include("styles.php");
		/*if ($_SESSION['theme'] ==  1) 
		{
			?>
			changeSheets('green');
			<?php
		}
		else {
			?>
			changeSheets('grey');
			<?php
		}*/
		$script_elems->enableJQuery();
		$script_elems->enableTreeView();
		$script_elems->enableFacebox();
		$script_elems->enableAutoScrollTop();
		$script_elems->enableMultiSelect();
		if(strpos($_SERVER['PHP_SELF'], "login.php") === false)
		{	
			if($AUTO_LOGOUT === true)
				$script_elems->enableAutoLogout();
		}
?>

	<script language="JavaScript">
	<!--
	function changeSheets(whichSheet){
	  if(document.styleSheets){
		  if(whichSheet == 'green' ){
			document.styleSheets[1].disabled=true;
			<?php $_SESSION['theme']=1; ?>
		  }else{
			document.styleSheets[1].disabled=false;
			<?php $_SESSION['theme']=2; ?>
		  }
		}
	}
	
	//-->
	</script>


	<script type='text/javascript'>
	<?php 
	if($TRACK_LOADTIMEJS)
	{
		echo "var t = new Date();";
	}
	?>
	$(document).ready(function(){
		$('.globalnav_option').click( function() {
			$('.globalnav_option').removeClass('globalnav_option_current');
			$(this).addClass('globalnav_option_current');
		});
	});	
	</script>
	
	
	</head>
	<body class='parent_pane'>
<?php $script_elems->enablePageloadIndicator(); ?>
	<div id="top_pane">
		<div id="top_pane_user_info">
<?php
if(isset($_SESSION['username']))
{
?>
	<?php echo LangUtil::getPageTerm("LOGGEDINAS"); ?>: <?php echo $_SESSION['username'];?> | 
	<a href='edit_profile.php'><?php echo LangUtil::$pageTerms['EDITPROFILE']; ?></a> | 
	<?php
	//echo "test".$_SESSION['admin_as_tech'];
	if(isset($_SESSION['admin_as_tech']) && $_SESSION['admin_as_tech'] === true)
	{
		?>
		<a href='switchto_admin.php'><?php echo LangUtil::getPageTerm("SWITCH_TOMGR"); ?></a> | 
		<?php
	}
	else if(isset($_SESSION['dir_as_tech']) && $_SESSION['dir_as_tech'] === true)
	{
		?>
		<a href='switchto_admin.php'><?php echo LangUtil::getPageTerm("SWITCH_TODIR"); ?></a> | 
		<?php
	}
	else if(User::onlyOneLabConfig($_SESSION['user_id'], $_SESSION['user_level']))
	{
		$lab_config_list = get_lab_configs($_SESSION['user_id']);
		?>
		<a href='switchto_tech.php?id=<?php echo $lab_config_list[0]->id; ?>'><?php echo LangUtil::getPageTerm("SWITCH_TOTECH"); ?></a> | 
		<?php
	}
	?>
	<a rel='facebox' href='user_rating.php'><?php echo LangUtil::getPageTerm("LOGOUT"); ?></a>
	
	<?php
	//if(User::onlyOneLabConfig($_SESSION['user_id'], $_SESSION['user_level']))
	if(false)
	{
		$lab_config_list = get_lab_configs($_SESSION['user_id']);
		?>
		<br><br>
		<a class='dummy_class' id='top_pane_secondrow' href='data_backup?id=<?php echo $lab_config_list[0]->id; ?>' ><?php echo LangUtil::$pageTerms['MENU_BACKUP']; ?></a>
		<?php
	}
}
?>		
		</div>
		<table cellspacing="10px">
			<tr>
				<td>
					<span class="lis_title">Basic Laboratory Information System v<?php echo $VERSION; ?> </span>
				</td>
				<td>
				</td>
				<td> 
				</td>
			</tr>
		</table>
<?php
if(strpos($_SERVER['PHP_SELF'], 'login.php') === false)
{
?>
	<div id="menus">
	<ul id='globalnav'>
<?php
	if(isset($top_menu_options))
	{
		foreach($top_menu_options as $key => $value)
		{
			//echo "hello "."<br/>";
			
			echo "<li ";
			echo "><a href='".$value."' ";
			if(
				(strpos($_SERVER['PHP_SELF'], $value) !== false)
				&& !(strpos($_SERVER['PHP_SELF'], "_home.php") !== false && $value == "home.php")
			)
			{
				# Highlight current page tab
				echo " class='here' ";
			}
			if(strpos($key, LangUtil::$pageTerms['MENU_BACKUP']) !== false)
			{
				echo " target='_blank' ";
			}
			if(strpos($_SERVER['PHP_SELF'], "_home.php") !== false && strpos($value, "lab_configs.php") !== false)
			{
				echo " class='here' ";
			}
			echo ">".$key."</a></li>";
		}
	}
?>
	<span id='backup_div' style='float:right;margin-right:15px;'>
	</span>
	</ul>
	</div>
<?php
}
?>
</div><!--end of top_pane-->
<div id='center_pane'>