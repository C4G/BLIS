<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
#
$path = "../";
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

# Include required libraries
require_once("includes/SessionCheck.php");
require_once("includes/db_lib.php");

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

$script_elems = new ScriptElems();
$page_elems = new PageElems();
?>
<!DOCTYPE html>
<html lang="<?php echo($_SESSION['locale'] == 'fr' ? 'fr' : 'en') ?>">
    <head>
        <meta charset=UTF-8>
        <title>Basic Laboratory Information System v<?php echo $VERSION; ?></title>
        <?php
        require_once("styles.php");

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

    <body>
<?php $script_elems->enablePageloadIndicator(); ?>
    <div id="top_pane">
        <div id="top_pane_user_info">
<?php
if(isset($_SESSION['username']))
{
?>
    <?php echo LangUtil::getPageTerm("LOGGEDINAS"); ?>: <?php echo $_SESSION['username'];?> | 
    <a href='edit_profile.php' class="black"><?php echo LangUtil::$pageTerms['EDITPROFILE']; ?></a> | 
    <?php
    //echo "test".$_SESSION['admin_as_tech'];
    if(isset($_SESSION['admin_as_tech']) && $_SESSION['admin_as_tech'] === true)
    {
        ?>
        <a href='switchto_admin.php' class="black"><?php echo LangUtil::getPageTerm("SWITCH_TOMGR"); ?></a> | 
        <?php
    }
    else if(isset($_SESSION['dir_as_tech']) && $_SESSION['dir_as_tech'] === true)
    {
        ?>
        <a href='switchto_admin.php' class="black"><?php echo LangUtil::getPageTerm("SWITCH_TODIR"); ?></a> | 
        <?php
    }
    else if(User::onlyOneLabConfig($_SESSION['user_id'], $_SESSION['user_level']))
    {
        $lab_config_list = get_lab_configs($_SESSION['user_id']);
        ?>
        <a href='switchto_tech.php?id=<?php echo $lab_config_list[0]->id; ?>' class="black"><?php echo LangUtil::getPageTerm("SWITCH_TOTECH"); ?></a> | 
        <?php
    }
    ?>
    <a rel='facebox' href='user_rating.php' class="black"><?php echo LangUtil::getPageTerm("LOGOUT"); ?></a>	
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
    // echo "hi <br>";
    // echo $top_menu_options;
    // echo "<br>";
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
//				echo " target='_blank' ";
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