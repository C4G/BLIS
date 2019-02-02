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
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#4188c9">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <title>
        Basic Laboratory Information System v
        <?php echo $VERSION; ?>
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

    <script language="text/javascript">
        <!--
        function changeSheets(whichSheet) {
            if (document.styleSheets) {
                if (whichSheet == 'green') {
                    document.styleSheets[1].disabled = true;
                    <?php $_SESSION['theme']=1; ?>
                } else {
                    document.styleSheets[1].disabled = false;
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
        $(document).ready(function() {
            $('.globalnav_option').click(function() {
                $('.globalnav_option').removeClass('globalnav_option_current');
                $(this).addClass('globalnav_option_current');
            });
        });

    </script>

    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }
        /* Modal Content/Box */
        
        .modal-content {
            padding: 25px;
            background-color: #fefefe;
            margin: 5% auto 15% auto;
            border: 1px solid #888;
            width: 80%;
        }

    </style>
</head>

<body class="">
    <?php $script_elems->enablePageloadIndicator(); ?>

    <div class="page">
        <div class="page-main">
            <!--start of top_pane-->
            <div class="header py-4">
                <div class="container">
                    <div class="d-flex">
                        <a class="header-brand">
                            <img src="../images/logo_small.png" class="header-brand-img" alt="C4G-BLIS Logo">&nbsp;
                            v
                            <?php echo $VERSION; ?>
                        </a>
                        <div class="d-flex order-lg-2 ml-auto">
                            <?php
                                if(isset($_SESSION['username']))
                                {
                            ?>
                            <div class="dropdown">
                                <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                                    <span class="avatar" style="background-image:url(../images/ic_settings.png)"></span>
                                    <span class="ml-2 d-none d-lg-block">
                                        <span class="text-default">
                                            <small class="text-muted d-block mt-1">
                                                <?php echo LangUtil::getPageTerm("LOGGEDINAS"); ?></small>
                                            <?php echo $_SESSION['username'];?></span>
                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item" href="edit_profile.php">
                                        <i class="dropdown-icon fe fe-user"></i>
                                        <?php echo LangUtil::$pageTerms['EDITPROFILE']; ?>
                                    </a>
                                    <?php
                                    //echo "test".$_SESSION['admin_as_tech'];
                                    if(isset($_SESSION['admin_as_tech']) && $_SESSION['admin_as_tech'] === true)
                                    {
                                        ?>
                                    <a class="dropdown-item" href="switchto_admin.php">
                                        <i class="dropdown-icon fe fe-unlock"></i>
                                        <?php echo LangUtil::getPageTerm("SWITCH_TOMGR"); ?>
                                    </a>
                                    <?php
                                    }
                                    else if(isset($_SESSION['dir_as_tech']) && $_SESSION['dir_as_tech'] === true)
                                    {
                                        ?>
                                    <a class="dropdown-item" href="switchto_admin.php">
                                        <i class="dropdown-icon fe fe-unlock"></i>
                                        <?php echo LangUtil::getPageTerm("SWITCH_TODIR"); ?>
                                    </a>
                                    <?php
                                    }
                                    else if(User::onlyOneLabConfig($_SESSION['user_id'], $_SESSION['user_level']))
                                    {
                                        $lab_config_list = get_lab_configs($_SESSION['user_id']);
                                        ?>
                                    <a class="dropdown-item" href="switchto_tech.php?id=<?php echo $lab_config_list[0]->id; ?>">
                                        <i class="dropdown-icon fe fe-unlock"></i>
                                        <?php echo LangUtil::getPageTerm("SWITCH_TOTECH"); ?>
                                    </a>
                                    <?php
                                    }
                                    ?>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="user_rating.php">
                                        <i class="dropdown-icon fe fe-log-out"></i>
                                        <?php echo LangUtil::getPageTerm("LOGOUT"); ?>
                                    </a>
                                </div>
                            </div>

                            <?php
                                }
                            ?>
                        </div>
                        <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
                            <span class="header-toggler-icon"></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg order-lg-first">
                            <?php
                            if(strpos($_SERVER['PHP_SELF'], 'login.php') === false)
                            {
                            ?>
                            <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                                <?php
                                if(isset($top_menu_options))
                                {
                                    foreach($top_menu_options as $key => $value)
                                    {
                                        echo "<li class=\"nav-item\">";
                                        echo "<a href=\"".$value."\"";
                                        if(
                                            (strpos($_SERVER['PHP_SELF'], $value) !== false)
                                            && !(strpos($_SERVER['PHP_SELF'], "_home.php") !== false && $value == "home.php")
                                        )
                                        {
                                            # Highlight current page tab
                                            echo " class=\"nav-link active\" ";
                                        }
                                        else{
                                            echo " class=\"nav-link\" ";    
                                        }
                                        if(strpos($key, LangUtil::$pageTerms['MENU_BACKUP']) !== false)
                                        {
                                            # Handle the backup function on the same page.
                                            #echo " target='_blank' ";
                                        }
                                        if(strpos($_SERVER['PHP_SELF'], "_home.php") !== false && strpos($value, "lab_configs.php") !== false)
                                        {
                                            echo " class=\"nav-link active\" ";
                                        }
                                        echo ">".$key."</a>";
                                        echo "</li>";
                                    }
                                }
                                ?>
                            </ul>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <!--end of top pane-->
            <!--start of center pane -->
            <div class="my-3 my-md-5">
                <div class="container">


