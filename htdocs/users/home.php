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
</style>

<script type='text/javascript'>

$(document).ready(function(){
    $.ajax({
		type : 'POST',
		url : 'update/check_version.php',
		success : function(data) {
			if ( data=="show" ) 
                        {
                            $('#update_div').show();
			}
			else 
                        {
                             $('#update_div').hide();
			}
		}
	});
    $('#update_div').show();
});

function blis_update()
{
    
    $.ajax({
		type : 'POST',
		url : 'update/bliss_update.php',
		success : function(data) {
			if ( data=="true" ) {
                            $('#update_failure').hide();
                            $('#update_spinner').hide();
                            $('#update_success').show();
			}
			else {
                                $('#update_success').hide();

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

<div id="update_div" style="display:none;" class="warning">
   <a rel='facebox' id='stype_link' href='javascript:blis_update();'>Click here to complete update to version <?php echo $VERSION ?></a>
</div>

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