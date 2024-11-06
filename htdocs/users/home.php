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
<style type='text/css'>
.warning {

    border: 1px solid;
    width: 350px;
    margin: 10px 0px;
    padding:15px 10px 15px 50px;
    background-repeat: no-repeat;
    background-position: 10px center;
    color: #9F6000;
    background-color: #FEEFB3;
    background-image: url('../includes/img/knob_attention.png');
}
.update_error {

    border: 1px solid;
    width: 500px;
    margin: 10px 0px;
    padding:15px 10px 15px 50px;
    background-repeat: no-repeat;
    background-position: 10px center;
    color: #D8000C;
    background-color: #FFBABA;
    background-image: url('../includes/img/knob_cancel.png');
}
.update_success {

    border: 1px solid;
    width: 350px;
    margin: 10px 0px;
    padding:15px 10px 15px 50px;
    background-repeat: no-repeat;
    background-position: 10px center;
    color: #000000;
    background-color: #99FF99;
    background-image: url('../includes/img/knob_valid_green.png');
}
</style>

<script type='text/javascript'>

$(document).ready(function(){
    $.ajax({
		type : 'POST',
		url : 'update/check_version.php',
		success : function(data) {
			if ( data=='0' )
             {
                            $('#update_div').show();
			}
			else
             {
                            // $('#update_div').show();
                            $('#update_div').hide();
			}
		}
	});
    //$('#update_div').show();
});

function blis_update_t()
{
    $('#update_spinner').show();
    setTimeout( "blis_update();", 5000);
}

function blis_update()
{
    $.ajax({
		url : '../update/blis_update.php?lab_config_id=<?php echo($_SESSION['lab_config_id']); ?>',
		success : function(data) {
			if ( data=="true" ) {
                            $('#update_failure').hide();
                             $('#update_div').hide();
                            $('#update_spinner').hide();
                            $('#update_success').show();
			}
			else {
                                $('#update_success').hide();
                                 $('#update_div').hide();
                                $('#update_spinner').hide();
				$('#update_failure').show();
			}
		}
	});

    //$('#update_button').show();
}

</script>

<br>
<span class='page_title'><?php echo LangUtil::getTitle(); ?></span>
<br><br>

<?php
echo LangUtil::getPageTerm("WELCOME").", " . $_SESSION['username'] . ".<br><br>";
echo LangUtil::getPageTerm("TIPS_BLISINTRO");
?>
<br><br>
    <div id="update_div2" style="display:none;" class="warning">
    <a rel='facebox' id='update_link' href='../update/blis_update.php'>Click here to complete update to version <?php echo $VERSION ?></a>
    </div>

    <div id="update_div" style="display:none;" class="warning">
    <a id='update_link' href='javascript:blis_update_t();'>Click here to complete update to version <?php echo $VERSION ?></a>
    </div>

<div id='update_spinner' style='display:none;'>
<?php
$spinner_message = "Updating to C4G BLIS ".$VERSION."<br>";
$page_elems->getProgressSpinnerBig($spinner_message);
?>
</div>

 <div id="update_failure" style="display:none;" class="update_error">
    Update Error! Please Try Again by clicking <a id='update_link' href='javascript:blis_update_t();'>here</a><br>
    If still unsuccessful report error UE5 to dsaiteja@gatech.edu
    </div>

 <div id="update_success"  style="display:none;" class="update_success">
    Update Successful! Welcome to C4G BLIS <?php echo $VERSION; ?>
    </div>




<?php
# If technician user, show lab workflow
if($_SESSION['user_level'] == $LIS_ADMIN || $_SESSION['user_level'] == $LIS_SUPERADMIN || $_SESSION['user_level'] == $LIS_COUNTRYDIR)
{
?>


<?php
}
?>
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
