<?php
#
# Main page for creating a new lab configuration
#
include("redirect.php");
include("includes/header.php");
LangUtil::setPageId("lab_configs");

//$script_elems->enableJWizard(); 
$script_elems->enableDatePicker();

putUILog('lab_config_new', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');


global $labIdArray;
?>
<link rel='stylesheet' type='text/css' href='css/wizard_styles.css' />
<script type="text/javascript">

<?php //$page_elems->getCompatibilityJsArray("st_map"); ?>


$(document).ready(function(){
	$('#tech_entries').show();
	$('.2').hide();
	$('.3').hide();
	$('.4').hide();
	$('.5').hide();
	
	$('.stype_entry').change(function() {
		//check_compatible();
	});
});

function check_compatible()
{
	return;
	$('.ttype_entry').attr("disabled", "disabled");
	$('.ttype_entry').removeAttr("checked");
	for(var i in st_map)
	{
		var stype_elem_id = "s_type_"+i;
		var stype_elem = $('#'+stype_elem_id);
		if(stype_elem == undefined || stype_elem == null)
			continue;
		if(stype_elem.attr("checked"))
		{
			var test_csv = st_map[i];
			if(test_csv == "" || test_csv == null || test_csv == undefined || typeof test_csv != 'string')
				continue;
			if(test_csv.contains(","))
			{
				var test_list = test_csv.split(",");
				for(var j in test_list)
				{
					var checkbox_elem_id = "t_type_"+j;
					var checkbox_elem = $('#'+checkbox_elem_id);
					checkbox_elem.removeAttr("disabled");
				}
			}
			else
			{
				var checkbox_elem_id = "t_type_"+test_csv;
				var checkbox_elem = $('#'+checkbox_elem_id);
				checkbox_elem.removeAttr("disabled");
			}
		}
	}
}
	
function loadnext(divout,divin){
	$("." + divout).hide();
	//$("." + divin).fadeIn("fast");
	$("." + divin).show();
}

function get_testbox2(stype_id)
{
	//var stype_val = $('#'+stype_id).attr("value");
        var stype_val = stype_id;
        $('#test_list_by_site').show();
	if(stype_val == "")
	{
		$('#test_list_by_site').html("-<?php echo 'Select Facility to display its Test Catalog here'; ?>-");
		return;
	}
	$('#test_list_by_site').html("<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?>");
	$('#test_list_by_site').load(
		"ajax/test_list_by_site.php", 
		{
			site_id: stype_val
		}
	);
}

function show_testbox2(st)
{
	//var stype_val = $('#'+stype_id).attr("value");
        $('.test_list_forms').hide();
        $('#test_list_'+ st).show();
	
}

function remove_option(st)
{
    $('#iloc_sites').find('select').removeAttr('disabled');
  $('#iloc_sites').empty();
       $("#iloc_sites").html($("#iloc_sites_t").html());
       $('#iloc_sites').find('select').attr('id', 'ilocation');
        $('#iloc_sites').find('select').attr('name', 'ilocation');
    $("#ilocation option[value='"+st+"']").remove();
    if(st == '0')
        {
            $('#iloc_sites').find('select').attr('disabled', true);
        }


}

function remove_option2(st)
{
   
    $("#ilocation option[value='"+st+"']").remove();	
}

function checkandadd()
{
	//Validate
	var name = $('#facility').attr("value");
	if(name == "")
	{
		alert("<?php echo LangUtil::$pageTerms['TIPS_MISSING_FACILITY']; ?>");
		return;
	}
	var location = $('#location').attr("value");
	if(location == "")
	{
		alert("<?php echo "Facility Location Missing"; ?>");
		return;
	}
	var lab_admin = $('#lab_admin').attr("value");
	if(lab_admin == "")
	{
		alert("<?php echo LangUtil::$pageTerms['TIPS_MISSING_MGR']; ?>");
		return;
	}
        
        var bloc = $('#blocation').attr("value");
	if(bloc == '0')
	{
		//alert("<?php echo 'Base Lab Configuration not selected'; ?>");
		//return;
	}
	/*
	var stype_entries = $('.stype_entry');
	var stype_selected = false;
	for(var i = 0; i < stype_entries.length; i++)
	{
		if(stype_entries[i].checked)
		{
			stype_selected = true;
			break;
		}
	}
	if(stype_selected == false)
	{
		alert("<?php echo LangUtil::$pageTerms['TIPS_MISSING_STYPES']; ?>");
		return;
	}
	var ttype_entries = $('.ttype_entry');
	var ttype_selected = false;
	for(var i = 0; i < ttype_entries.length; i++)
	{
		if(ttype_entries[i].checked)
		{
			ttype_selected = true;
			break;
		}
	}
	if(ttype_selected == false)
	{
		alert("<?php echo LangUtil::$pageTerms['TIPS_MISSING_TTYPES']; ?>");
		return;
	}
	//All okay
	*/
	$('.5').hide();
	$('.6').show();
	$('#new_lab_form').submit();
}
</script>

<style type="text/css">
	#registration { width:950px; margin:20px; background:#F6F6F6; }
	#registration > div { padding:0 10px; }
.hor-minimalist-compact
{
	font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
	font-size: 12px;
	background: #fff;
	width: 480px;
	border-collapse: collapse;
	text-align: left;
        padding: 6px 4px;
}

.hor-minimalist-compact th
{
	font-size: 14px;
	font-weight: normal;
	color: #039;
	 padding: 6px 4px;
	border-bottom: 2px solid #6678b1;
}
.hor-minimalist-compact td
{
	color: #669;
	padding: 2px 6px 0px 6px;
}

.hor-minimalist-compact tbody tr:hover td
{
	/*color: #009;*/
}
</style>
<br>
<b><?php echo LangUtil::$pageTerms['NEW_LAB_CONFIGURATION']; ?>	</b>
 | <a href="javascript:history.go(-1);"><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a>
<br><br>
<form id='new_lab_form' name='new_lab_form' action='lab_config_add.php' method='post'>
<DIV id="wizardwrapper">

  <DIV class="1" style="opacity: 1; display: block; margin-left: 150px;">
    <H3>1: <?php echo LangUtil::$pageTerms['MENU_SITEINFO']; ?></H3>
    <DIV id="wizardcontent"> 
	<br>
		<table>
			<tr>
				<td width='130px'><?php echo LangUtil::$generalTerms['FACILITY']; ?><?php $page_elems->getAsterisk();?></td>
				<td><input type='text' name='name' id='facility' value='' class='uniform_width' /></td>
			</tr>
			<tr>
				<td><?php echo LangUtil::$generalTerms['LOCATION']; ?><?php $page_elems->getAsterisk();?></td>
				<td><input type='text' name='location' id='location' value='' class='uniform_width' /></td>
			</tr>
			<tr>
				<td><?php echo "Country" ?><?php $page_elems->getAsterisk(); ?></td>
				<!--<td><select name='country' id='country'> 
					<?php 
						foreach($labIdArray as $key=>$value)
							echo "<option value='$key'>$key</option>";
					?>
				</select></td>-->
                                <td><?php 
                                $usr_c = get_username_by_id($_SESSION['user_id']);
                                $usr_c = strtolower($usr_c);
                                $usr_c = ucfirst($usr_c);
                                $usr_cs = substr($usr_c, 0, strpos($usr_c, "_"));
                                echo $usr_cs; 
                                ?>
                                <input type="hidden" name="country" value="<?php echo $usr_cs; ?>">
                                </td>
			</tr>
			<?php 
			//If user is superadmin
			if(true)
			{
			?>
			<tr>
				<td><?php echo LangUtil::$generalTerms['LAB_MGR']; ?> <?php $page_elems->getAsterisk();?></td>
				<td>
					<?php /*
					<select name='lab_admin' id='lab_admin' class='uniform_width'>
					<?php 
					# Fetch list of existing lab admins 
					$page_elems->getAdminUserOptions();
					?>
					<option value='0'>--New Admin Account--</option>			
					</select>
					*/ ?>
					<input type='text' name='lab_admin' id='lab_admin' class='uniform_width' />
				</td>
			</tr>
			<?php
			}
			?>
		</table>
	</DIV>
    <DIV class="buttons">
      <BUTTON type="button" class="previous" disabled="disabled"> <IMG src="js/jquery.jwizard/images/jwizard_arrow_left.png" alt=""> <?php echo LangUtil::$generalTerms['CMD_BACK']; ?> </BUTTON>
      <BUTTON type="button" class="next" onclick="loadnext(1,4);"> Next <IMG src="js/jquery.jwizard/images/jwizard_arrow_right.png" alt=""> </BUTTON>
    </DIV>
    <br><br>
    <UL id="mainNav" class="fiveStep" >
      <LI class="current"><div class='white_big'>Step 1:<br><?php echo LangUtil::$pageTerms['MENU_SITEINFO']; ?></div></LI>
      <!--<LI><div class='white_big'>Step 2:<br><?php //echo LangUtil::$generalTerms['SPECIMEN_TYPES']; ?></div></LI>-->
      <LI><div class='white_big'>Step 2:<br><?php echo LangUtil::$generalTerms['TECHNICIANS']; ?></div></LI>
      <LI><div class='white_big'>Step 3:<br><?php echo "Base Config"; ?></div></LI>
      <LI><div class='white_big'>Step 4:<br><?php echo LangUtil::$generalTerms['TEST_TYPES']; ?></div></LI>
      <!--<LI class="mainNavNoBg"><div class='white_big'>Step 5:<br><?php echo LangUtil::$pageTerms['MENU_FIELDS']; ?></div></LI>-->
    </UL>
    <DIV style="clear:both"></DIV>
  </DIV>
  
  <DIV id="wizardpanel" class="2" style="opacity: 1; display: none; ">
    <H3>2: <?php echo LangUtil::$generalTerms['SPECIMEN_TYPES']; ?></H3>
    <DIV id="wizardcontent">
	<br>
	<?php $page_elems->getSpecimenTypeCheckboxes(); ?>
	</DIV>
    <DIV class="buttons">
      <BUTTON type="button" class="previous" onclick="loadnext(2,1);"> <IMG src="js/jquery.jwizard/images/jwizard_arrow_left.png" alt=""> <?php echo LangUtil::$generalTerms['CMD_BACK']; ?> </BUTTON>
      <BUTTON type="button" class="next" onclick="loadnext(2,3);"> Next <IMG src="js/jquery.jwizard/images/jwizard_arrow_right.png" alt=""> </BUTTON>
    </DIV>
    <br><br>
    <UL id="mainNav" class="fiveStep">
      <LI class="lastDone"><div class='white_big'>Step 1:<br><?php echo LangUtil::$pageTerms['MENU_SITEINFO']; ?></div></LI>
      <LI class="current"><div class='white_big'>Step 2:<br><?php echo LangUtil::$generalTerms['SPECIMEN_TYPES']; ?></div></LI>
      <LI><div class='white_big'>Step 3:<br><?php echo LangUtil::$generalTerms['TEST_TYPES']; ?></div></LI>
      <LI><div class='white_big'>Step 4:<br><?php echo LangUtil::$generalTerms['TECHNICIANS']; ?></div></LI>
      <!--<LI class="mainNavNoBg"><div class='white_big'>Step 4:<br><?php echo LangUtil::$pageTerms['MENU_FIELDS']; ?></div></LI>-->
    </UL>
	<DIV style="clear:both"></DIV>
  </DIV>
  
    <DIV id="wizardpanel" class="7" style="opacity: 1; display: none; margin-left: 150px;">
    <H3>3: <?php echo "Base Lab Configuration"; ?></H3>
    <DIV id="wizardcontent">
	<br>
        
        <!--<form id='base_config_form' name='base_config_form' action='ajax/import_config.php' method='get'>-->
                    <input type='hidden' name='lid' value='<?php echo $lab_config->id; ?>'></input>
                    
                                    <?php echo 'Select the facility to set base configuration:'; ?>
                    
                                <?php
                                        //$site_list = get_site_list($_SESSION['user_id']);
                                        //print_r($site_list);
                                        //echo "<input type='checkbox' name='".$elem_name."[]' id='$elem_id' value='$key'>$value</input>";
                                        ?>
                                        <select name='blocation' id='blocation' class='uniform_width'  onchange="javascript:remove_option(this.value);">
                                            <option value='0'><?php echo 'None'; ?></option>
                                        <?php
                                            $page_elems->getSiteOptions();
                                        ?>
                                        </select>
                                        <br><br>
                                        <i><small>This setting will import lab configuration from the selected lab to this new lab.</small>
                                        <br>
                                        <small>If you want to create an empty lab then select 'None' above.</small>
                                        <br>
                                        <small>Setting a base lab configuration also allows you to import tests from other existing labs in the next step.</small></i>
                                
            </form>
	</DIV>
    <DIV class="buttons">
      <BUTTON type="button" class="previous" onclick="loadnext(7,4);"> <IMG src="js/jquery.jwizard/images/jwizard_arrow_left.png" alt=""> <?php echo LangUtil::$generalTerms['CMD_BACK']; ?> </BUTTON>
      <BUTTON type="button" class="next" onclick="loadnext(7,3);"> Next <IMG src="js/jquery.jwizard/images/jwizard_arrow_right.png" alt=""> </BUTTON>
    </DIV>
    <br><br>
    <UL id="mainNav" class="fiveStep">
      <LI class="done"><div class='white_big'>Step 1:<br><?php echo LangUtil::$pageTerms['MENU_SITEINFO']; ?></div></LI>
      <!--<LI class="done"><div class='white_big'>Step 2:<br><?php //echo LangUtil::$generalTerms['SPECIMEN_TYPES']; ?></div></LI>-->
      <LI class="done"><div class='white_big'>Step 2:<br><?php echo LangUtil::$generalTerms['TECHNICIANS']; ?></div></LI>
      <LI class='current'><div class='white_big'>Step 3:<br><?php echo "Base Config"; ?></div></LI>
      <LI class='mainNavNoBg'><div class='white_big'>Step 4:<br><?php echo LangUtil::$generalTerms['TEST_TYPES']; ?></div></LI>
      <!--<LI class="mainNavNoBg"><div class='white_big'>Step 5:<br><?php echo LangUtil::$pageTerms['MENU_FIELDS']; ?></div></LI>-->
    </UL>
	<DIV style="clear:both"></DIV>
  </DIV>
  
  <DIV id="wizardpanel" class="3" style="opacity: 1; display: none; margin-left: 150px;">
    <H3>4: <?php echo LangUtil::$generalTerms['TEST_TYPES']; ?></H3>
    <DIV id="wizardcontent">
	<br>
        
        <!--<form id='import_config_form' name='import_config_form' action='ajax/import_config.php' method='get'>-->
                    <input type='hidden' name='lid' value='<?php echo $lab_config->id; ?>'></input>
                    
                                  
                                
                                
                                <?php
                                   
                                        //$site_list = get_site_list($_SESSION['user_id']);
                                        //print_r($site_list);
                                        //echo "<input type='checkbox' name='".$elem_name."[]' id='$elem_id' value='$key'>$value</input>";
                                        ?>
                                        <div id="iloc_sites_t" style='display: none;'>
                                            <?php echo 'Select the facility from which you want to import tests:'; ?>
                                        <select name='ilocation2' id='ilocation2' class='uniform_width' onchange="javascript:show_testbox2(this.value);">
                                        <option value='0'><?php echo 'Select Facility'; ?></option>
                                        <?php
                                            $page_elems->getSiteOptions();
                                        ?>
                                        </select>
                                        </div>
                    
                                        <div id="iloc_sites">
                                              <?php echo 'Select the facility from which you want to import tests:'; ?>
                                        <select name='ilocation' id='ilocation' class='uniform_width' disabled="disabled" onchange="javascript:show_testbox2(this.value);">
                                        <option value='0'><?php echo 'Select Facility'; ?></option>
                                        <?php
                                            $page_elems->getSiteOptions();
                                        ?>
                                        </select>
                                        </div>
                                        <br>
                                        <?php  $site_ls = get_site_list($_SESSION['user_id']);
                                            foreach($site_ls as $st => $val) {
                                            $div_st = "test_list_".$st;
                                            echo "<div id='".$div_st."' class='test_list_forms' style='display: none;'>"; ?>
                                        <?php
                                        $test_type_list = get_test_types_by_site($st);
                                        /*if($site_id <= 0)
                                        {
                                            echo 'Select Facility to display its Test Catalog here';
                                            return;
                                        }
                                        */
                                        if(count($test_type_list) == 0)
                                        {
                                                # No compatible tests exist in the configuration
                                                ?>
                                                <br>
                                                <span class='clean-error uniform_width'>
                                                        <?php echo 'Test Catalog is empty for this site'; ?>
                                                </span>
                                                <?php
                                                
                                        }
                                        ?>
                                        <table style='width:auto;' class='hor-minimalist-compact'>
                                        <tbody>
                                        <tr valign='top'>
                                        <?php
                                        $count = 0;
                                        foreach($test_type_list as $test_type)
                                        {
                                        ?>
                                                <td>
                                                <table>
                                                <tr valign='top'>

                                                        <td>
                                                            <?php
                                                                //echo "<input type='checkbox' name='itest[".$st."][".$test_type->testTypeId."]' id='$st' value='Yes'>";
                                                                echo "<input type='checkbox' name='itest[".$st."][]' id='$st' value='".$test_type->testTypeId."'>";
                                                                echo $test_type->getName();
                                                                echo "</input>";
                                                                ?>
                                                        </td>
                                                </tr>
                                                </table>
                                                </td>
                                                <?php
                                                $count++;
                                                if($count % 3 == 0)
                                                {
                                                ?>
                                                        </tr>
                                                        <tr>
                                                <?php
                                                }
                                        }
                                        ?>
                                        </tbody>
                                        </table>
                                        
                                        <?php echo "</div>";
                                        } ?>
                                
            </form>
	</DIV>
    <DIV class="buttons">
      <BUTTON type="button" class="previous" onclick="loadnext(3,7);"> <IMG src="js/jquery.jwizard/images/jwizard_arrow_left.png" alt=""> <?php echo LangUtil::$generalTerms['CMD_BACK']; ?> </BUTTON>
      <BUTTON type="button" class="next" onclick="loadnext(3,5);"> Next <IMG src="js/jquery.jwizard/images/jwizard_arrow_right.png" alt=""> </BUTTON>
    </DIV>
    <br><br>
    <UL id="mainNav" class="fiveStep">
      <LI class="done"><div class='white_big'>Step 1:<br><?php echo LangUtil::$pageTerms['MENU_SITEINFO']; ?></div></LI>
      <!--<LI class="done"><div class='white_big'>Step 2:<br><?php //echo LangUtil::$generalTerms['SPECIMEN_TYPES']; ?></div></LI>-->
      <LI class="done"><div class='white_big'>Step 2:<br><?php echo LangUtil::$generalTerms['TECHNICIANS']; ?></div></LI>
      <LI class="done"><div class='white_big'>Step 3:<br><?php echo "Base Config"; ?></div></LI>
      <LI class='current'><div class='white_big'>Step 4:<br><?php echo LangUtil::$generalTerms['TEST_TYPES']; ?></div></LI>
      <!--<LI class="mainNavNoBg"><div class='white_big'>Step 5:<br><?php echo LangUtil::$pageTerms['MENU_FIELDS']; ?></div></LI>-->
    </UL>
	<DIV style="clear:both"></DIV>
  </DIV>

 
  <DIV id="wizardpanel" class="4" style="opacity: 1; display: none; margin-left: 150px;">
    <H3>2: <?php echo LangUtil::$generalTerms['TECHNICIANS']; ?></H3>
    <DIV id="wizardcontent">
	<br>
	<?php $page_elems->getOperatorForm(1); ?>
	</DIV>
    <DIV class="buttons">
      <BUTTON type="button" class="previous" onclick="loadnext(4,1);"> <IMG src="js/jquery.jwizard/images/jwizard_arrow_left.png" alt=""> <?php echo LangUtil::$generalTerms['CMD_BACK']; ?> </BUTTON>
      <BUTTON type="button" class="next" onclick="loadnext(4,7);"> Next <IMG src="js/jquery.jwizard/images/jwizard_arrow_right.png" alt=""> </BUTTON>
    </DIV>
    <br><br>
    <UL id="mainNav" class="fiveStep">
        <LI class="done"><div class='white_big'>Step 1:<br><?php echo LangUtil::$pageTerms['MENU_SITEINFO']; ?></div></LI>
      <!--<LI class="lastDone"><div class='white_big'>Step 2:<br><?php //echo LangUtil::$generalTerms['SPECIMEN_TYPES']; ?></div></LI>-->
      <LI class="current"><div class='white_big'>Step 2:<br><?php echo LangUtil::$generalTerms['TECHNICIANS']; ?></div></LI>
      <LI><div class='white_big'>Step 3:<br><?php echo "Base Config"; ?></div></LI>
      <LI><div class='white_big'>Step 4:<br><?php echo LangUtil::$generalTerms['TEST_TYPES']; ?></div></LI>
      <!--<LI class="mainNavNoBg"><div class='white_big'>Step 5:<br><?php echo LangUtil::$pageTerms['MENU_FIELDS']; ?></div></LI>-->
      
    </UL>
	<DIV style="clear:both"></DIV>
  </DIV>
 
  <DIV id="wizardpanel" class="5" style="display: none; opacity: 1; margin-left: 150px;">
    <H3>5: <?php echo LangUtil::$pageTerms['MENU_FIELDS']; ?></H3>
    <DIV id="wizardcontent">
	<?php #Specimen and Patient ID &nbsp;&nbsp;&nbsp; ?>
		<select name='id_mode' id='id_mode' style='display:none;'>
			<option value='<?php echo LabConfig::$ID_MANUAL; ?>'>Manual</option>
			<option value='<?php echo LabConfig::$ID_AUTOINCR; ?>' selected>Auto-increment</option>
		</select>
		<br><br><br>
		<?php echo LangUtil::$pageTerms['TIPS_CUSTOM']; ?>
		<br><br><br><br>
		<?php echo LangUtil::$pageTerms['TIPS_CONFIRMNEWLAB']; ?>
		<span id='site_name'></span>
		&nbsp;&nbsp;&nbsp;&nbsp;<input id='add_button' type='button' value='<?php echo LangUtil::$generalTerms['CMD_ADD']; ?>' onclick='javascript:checkandadd();'></input>
	</DIV>
    <DIV class="buttons">
      <BUTTON type="button" class="previous" onclick="loadnext(5,3);"> <IMG src="js/jquery.jwizard/images/jwizard_arrow_left.png" alt=""> <?php echo LangUtil::$generalTerms['CMD_BACK']; ?> </BUTTON>
      <BUTTON type="button" class="next" disabled="disabled"> Next <IMG src="js/jquery.jwizard/images/jwizard_arrow_right.png" alt=""> </BUTTON>
    </DIV>
	<br><br>
    <UL id="mainNav" class="fiveStep">
      <LI class="done"><div class='white_big'>Step 1:<br><?php echo LangUtil::$pageTerms['MENU_SITEINFO']; ?></div></LI>
      <!--<LI class="done"><div class='white_big'>Step 2:<br><?php //echo LangUtil::$generalTerms['SPECIMEN_TYPES']; ?></div></LI>-->
      <LI class="done"><div class='white_big'>Step 2:<br><?php echo LangUtil::$generalTerms['TECHNICIANS']; ?></div></LI>
      <LI class="done"><div class='white_big'>Step 3:<br><?php echo "Base Config"; ?></div></LI>
      <LI class='done'><div class='white_big'>Step 4:<br><?php echo LangUtil::$generalTerms['TEST_TYPES']; ?></div></LI>
      <!--<LI class="current"><div class='white_big'>Step 5:<br><?php echo LangUtil::$pageTerms['MENU_FIELDS']; ?></div></LI>-->
    </UL>
	<DIV style="clear:both"></DIV>
  </DIV>
  
   <DIV id="wizardpanel" class="6" style="display: none; opacity: 1; ">
    <H3><?php echo LangUtil::$generalTerms['CMD_SUBMITTING']; ?> ...</H3>
    <DIV id="wizardcontent">
	<center>
	<?php 
		$spinner_message = LangUtil::$pageTerms['TIPS_CREATINGLAB']."<br>";
		$page_elems->getProgressSpinnerBig($spinner_message);		
	?>
	</center>
	</DIV>
    <DIV class="buttons">
    </DIV>
	<br><br>
    <UL id="mainNav" class="fiveStep">
      <LI class="done"><div class='white_big'>Step 1:<br><?php echo LangUtil::$pageTerms['MENU_SITEINFO']; ?></div></LI>
      <!--<LI class="done"><div class='white_big'>Step 2:<br><?php //echo LangUtil::$generalTerms['SPECIMEN_TYPES']; ?></div></LI>-->
      <LI class="done"><div class='white_big'>Step 2:<br><?php echo LangUtil::$generalTerms['TECHNICIANS']; ?></div></LI>
      <LI class="done"><div class='white_big'>Step 3:<br><?php echo "Base Config"; ?></div></LI>
      <LI class='done'><div class='white_big'>Step 4:<br><?php echo LangUtil::$generalTerms['TEST_TYPES']; ?></div></LI>
      <!--<LI class="current"><div class='white_big'>Step 5:<br><?php echo LangUtil::$pageTerms['MENU_FIELDS']; ?></div></LI>-->
    </UL>
	<DIV style="clear:both"></DIV>
  </DIV>
  
</DIV>
<!--Random Data Section-->
	<div id='random' style='display:none'>
	<b>Random Data</b> [<a rel='facebox' href='#randomdata_help'>?</a>]
		<br><br>
		<?php
		$today = date("Y-m-d");
		$today_array = explode("-", $today);
		?>
		<table class='smaller_font' cellspacing='5px'>
		<tr>
		<td>Number of Patients</td>
		<td><input type='text' name='num_patients' value="150" /></td>
		</tr>
		<tr>
		<td>Number of Specimens</td>
		<td><input type='text' name='num_specimens' value="1000" /></td>
		</tr>
		<tr>
		<td>Specimen Collection Dates:</td>
		<td></td>
		</tr>
		<tr valign='top'>
		<td>From</td>
		<td>
		<?php
		$name_list = array("yyyy_from", "mm_from", "dd_from");
		$id_list = $name_list;
		//$value_list = array($today_array[0], "01", "01");
		$value_list = array("2009", "01", "01");
		$page_elems->getDatePicker($name_list, $id_list, $value_list); 
		?>
		</td>
		</tr>
		<tr valign='top'>
		<td>To</td>
		<td>
		<?php
		$name_list = array("yyyy_to", "mm_to", "dd_to");
		$id_list = $name_list;
		$value_list = $today_array;
		$page_elems->getDatePicker($name_list, $id_list, $value_list); 
		?>
		</td>
		</tr>
		</table>
		<div id='randomdata_help' style='display:none;'>
		<table class='smaller_font'>
		<tr>
		<td>
		<b>Random Data</b>
		<br><br>
		Currently, due to lack of existing data in the system, random data records are added for testing purposes.
		The number of patient and specimen records along with specimen collection date range can be specified as parameters for the random data generator.
		<br><br>
		This feature is only for evaluation phases and will not be part of the system when deployed.
		</td>
		</tr>
		</table>
		</div>
	</div>
	<!--End of Random Data Section-->
	
</form>
<br>
<?php include("includes/footer.php"); ?>
<!--
		<table cellpadding='5px'>
			<tbody>
				<tr>
					<td>
						'Specimen ID' field
					</td>
					<td>
						<select class='uniform_width'>
							<option value='1'>Manual</option>
							<option value='2'>Auto-increment</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						'Patient ID' field
					</td>
					<td>
						<select class='uniform_width'>
							<option value='1'>Manual</option>
							<option value='2'>Auto-increment</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						Use 'Additional ID' field for Specimens?
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</td>
					<td>
						<select class='uniform_width'>
							<option value='1'>Yes</option>
							<option value='0'>No</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						Use 'Additional ID' field for Patients?
					</td>
					<td>
						<select class='uniform_width'>
							<option value='1'>Yes</option>
							<option value='0'>No</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						Test Results Verification
					</td>
					<td>
						<select class='uniform_width'>
							<option value='1'>Not required</option>
							<option value='2'>Optional</option>
							<option value='3'>Mandatory</option>
						</select>
					</td>
				</tr>
			</tbody>
		</table>
		-->