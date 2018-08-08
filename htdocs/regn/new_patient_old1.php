<?php
#
# Main page for adding new patient into the system
#
/*
$load_time = microtime(); 
$load_time = explode(' ',$load_time); 
$load_time = $load_time[1] + $load_time[0]; 
$page_start = $load_time; 
*/

include("redirect.php");
include("includes/header.php");
LangUtil::setPageId("new_patient");
 
$script_elems->enableDatePicker();
$script_elems->enableJQueryForm();
$script_elems->enableFacebox();

$lab_config = get_lab_config_by_id($_SESSION['lab_config_id']);
$daily_num = get_daily_number(); 
$session_num = get_session_number();
$uiinfo = "qr=".$_REQUEST['n'];
putUILog('new_patient', $uiinfo, basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');
?>
<script type='text/javascript'>
$(document).ready(function(){
	$('#progress_spinner').hide();
	<?
	if(isset($_REQUEST['n']))
	{
		# Prefill patient name field
		?>
		$('#name').attr("value", "<?php echo $_REQUEST['n']; ?>");
		prefetch_pname();
		<?php
	}
	if(isset($_REQUEST['jmp']))
	{
		?>
		$('#new_patient_msg').html("<center>'<?php echo $_REQUEST['n']."' - ".LangUtil::$generalTerms['PATIENT_NAME']." ".LangUtil::$generalTerms['MSG_NOTFOUND'].". ".LangUtil::$pageTerms['MSG_ADDNEWENTRY']; ?></center>");
		$('#new_patient_msg').show();
		<?php
	}
	?>
	$('#name').keydown(function() {
		prefetch_pname();
	});
	
	$('#custom_field_form').submit(function() { 
		// submit the form 
		$(this).ajaxSubmit({async:false}); 
		// return false to prevent normal browser submit and page navigation 
		return false; 
	});
});

function prefetch_pname()
{
	var name = $('#name').attr("value");
	name = name.replace(" ", "%20");
	if(name == "" || name.length < 3)
	{
		$('#patient_prompt_div').html("");
		return;
	}
	var url_string = "ajax/patient_prompt_match.php?q="+name;
	$('#patient_prompt_div').load(url_string);
}

function add_patient()
{
	var card_num = $("#card_num").attr("value");
	$('#pid2').attr("value", card_num);
	var addl_id = $("#addl_id").attr("value");
	var name = $("#name").attr("value");
	//name = name.replace(/[^a-z ]/gi,'');
	var yyyy = $("#yyyy").attr("value");
	yyyy = yyyy.replace(/[^0-9]/gi,'');
	var mm = $("#mm").attr("value");
	mm = mm.replace(/[^0-9]/gi,'');
	var dd = $("#dd").attr("value");
	dd = dd.replace(/[^0-9]/gi,'');
	var receipt_yyyy = $("#receipt_yyyy").attr("value");
	receipt_yyyy = receipt_yyyy.replace(/[^0-9]/gi,'');
	var receipt_mm = $("#receipt_mm").attr("value");
	receipt_mm = receipt_mm.replace(/[^0-9]/gi,'');
	var receipt_dd = $("#receipt_dd").attr("value");
	receipt_dd = receipt_dd.replace(/[^0-9]/gi,'');
	var age = $("#age").attr("value");
	age = age.replace(/[^0-9]/gi,'');
	var age_param = $('#age_param').attr("value");
	age_param = age_param.replace(/[^0-9]/gi,'');
	var sex = "";
	var pid = $('#pid').attr("value");
	for(i = 0; i < document.new_record.sex.length; i++)
	{
		if(document.new_record.sex[i].checked)
			sex = document.new_record.sex[i].value;
	}
	var email = $("#email").attr("value");
	var phone = $("#phone").attr("value");
	var error_message = "";
	var error_flag = 0;
	var partial_dob_ym = 0;
	var partial_dob_y = 0; 
	for(i = 0; i < document.new_record.sex.length; i++)
	{
		if(document.new_record.sex[i].checked)
		{
			error_flag = 2;
			break;
		}
	}
	if(error_flag == 2)
	{
		error_flag = 0;
	}
	else
	{
		//sex not checked
		error_flag = 1;
		error_message += "<?php echo LangUtil::$generalTerms['ERROR'].": ".LangUtil::$generalTerms['GENDER']; ?>\n";
	}
	
	if(card_num == "" || !card_num)
	{
		error_message += "<?php echo LangUtil::$generalTerms['ERROR'].": ".LangUtil::$generalTerms['PATIENT_ID']; ?>\n";
		error_flag = 1;
	}
	if(name.trim() == "" || !name)
	{
		alert("<?php echo LangUtil::$generalTerms['ERROR'].": ".LangUtil::$generalTerms['PATIENT_NAME']; ?>");
		return;
	}
	
	//Age not given
	if(age.trim() == "")
	{
		//Check partial DoB
		var currentTime = new Date();
		if(yyyy.trim() != "" && mm.trim() != "" && dd.trim() == "")
		{
			dd = currentTime.getDate();
			if(checkDate(yyyy, mm, dd) == false)
			{
				alert("<?php echo LangUtil::$generalTerms['ERROR'].": ".LangUtil::$generalTerms['DOB']; ?>");
				return;
			}
			partial_dob_ym =  1;
			
		}
		else if(yyyy.trim() != "" && mm.trim() == "" && dd.trim() == "")
		{
			dd = currentTime.getDate();
			mm = currentTime.getMonth();
			if(checkDate(yyyy, mm, dd) == false)
			{
				alert("<?php echo LangUtil::$generalTerms['ERROR'].": ".LangUtil::$generalTerms['DOB']; ?>");
				return;
			}
			partial_dob_y =  1;
		}
		else if(yyyy.trim() == "" && mm.trim() == "" && dd.trim() == "")
		{
			error_message += "Please enter either Age or Date of Birth\n";//<br>";
			error_flag = 1;
			alert("Error: Please enter either Age or Date of Birth");
			return;
		}
		else
		{
			//Full DoB - check
			if(checkDate(yyyy, mm, dd) == false)
			{
				alert("<?php echo LangUtil::$generalTerms['ERROR'].": ".LangUtil::$generalTerms['DOB']; ?>");
				return;
			}
		}
	}
	else if (isNaN(age))
	{
	
		if(age_param!=5)
		{
			alert("<?php echo LangUtil::$generalTerms['ERROR'].": ".LangUtil::$generalTerms['AGE']; ?>");
			return;
		}
	}	
	if(sex == "" || !sex)
	{
		alert("<?php echo LangUtil::$generalTerms['ERROR'].": ".LangUtil::$generalTerms['GENDER']; ?>");
		return;
	}
	<?php
	if($_SESSION['dnum'] != 0)
	{
	?>
		var dnum = $("#dnum").attr("value");
		if(dnum.trim() == "" || !dnum)
		{
			alert("<?php echo LangUtil::$generalTerms['ERROR'].": ".LangUtil::$generalTerms['PATIENT_DAILYNUM']; ?>");
			return;
		}
	<?php
	}
	?>
	var data_string = "card_num="+card_num+"&addl_id="+addl_id+"&name="+name+"&yyyy="+yyyy+"&mm="+mm+"&dd="+dd+"&age="+age+"&sex="+sex+"&pd_ym="+partial_dob_ym+"&pd_y="+partial_dob_y+"&agep="+age_param+"&pid="+pid+"&receipt_yyyy="+receipt_yyyy+"&receipt_mm="+receipt_mm+"&receipt_dd="+receipt_dd;
	if(error_flag == 0)
	{
		$("#progress_spinner").show();
		//Submit form by ajax
		$.ajax({  
			type: "POST",  
			url: "ajax/patient_add.php", 
			data: data_string,
			success: function(data) { 
				//Add custom fields
				//$('#custom_field_form').ajaxSubmit();
					
				$('#custom_field_form').submit();
				$("#progress_spinner").hide();
				
				/* Retrieve actual DB Key used */
				var pidStart = data.indexOf("VALUES") + 8;
				var pidEnd = data.indexOf(",",pidStart);
				var new_card_num = data.substring(pidStart,pidEnd);
				
				/* If DB key used was different from one sent, increase daily num if set in session and card_num to new DB key 
				if ( new_card_num != card_num ) {
						<?php 
							if($_SESSION['dnum'] != 0) 
							{
						?>
								dnum = parseInt(dnum) + 1;
						<?php
							}
						?>
				*/
					card_num = new_card_num;
				<?php
				if( is_numeric($_SESSION['dnum']) && $_SESSION['dnum'] != 0 ) 
				{
				?>
					window.location = "new_specimen.php?pid="+card_num+"&dnum="+dnum+"&session_num=<?php echo $session_num ?>";
				<?php
				}
				else
				{
				?>
					window.location = "new_specimen.php?pid="+card_num+"&session_num=<?php echo $session_num ?>";
				<?php
				}
				?>
			}
		});
		//Patient added
	}
	else
	{
		alert(error_message);
	}
}

function fetchPatientAjax()
{
	var card_num = $("#card_num").attr("value");
	if(card_num == "")
	{
		document.getElementById("card_num_msg").innerHTML = "";
		return;
	}
	if(isNaN(card_num))
	{
		var msg_string = "<small><font color='red'>"+"Invalid ID. Only numbers allowed.</font></small>";
		document.getElementById("card_num_msg").innerHTML = msg_string;
		return;
	}
	var url = "ajax/patient_check_id.php?card_num="+card_num;
	var xmlHttp;
	try
	{
		// Firefox, Opera 8.0+, Safari
		xmlHttp=new XMLHttpRequest();
	}
	catch (e)
	{
		// Internet Explorer
		try
		{
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e)
		{
			try
			{
				xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e)
			{
				alert("Your browser does not support AJAX!");
				return false;
			}
		}
	}
	xmlHttp.onreadystatechange=function()
    {
		if(xmlHttp.readyState==4)
		{
			if(xmlHttp.responseText == "0")
			{
				var msg_string = "";
				document.getElementById("card_num_msg").innerHTML = msg_string;
			}
			else
			{
				var msg_string = "<small><font color='red'>"+"ID "+card_num+" already exists</font></small>";
				document.getElementById("card_num_msg").innerHTML = msg_string;
			}
		}
	}
	xmlHttp.open("GET", url, true);
	xmlHttp.send(null);
}

function reset_new_patient()
{
	$('#new_record').resetForm();
}

</script>
<p style="text-align: right;"><a rel='facebox' href='#regn_sidetip'>Page Help</a></p>
<b><?php echo LangUtil::getTitle(); ?></b>
 | <a href='find_patient.php'>&laquo; <?php echo LangUtil::$pageTerms['MSG_BACKTOLOOKUP']; ?></a>
<br><br>
<div id='new_patient_msg' class='sidetip_nopos' style='display:none;width:510px;'>
</div>
<br>
<table cellspacing='0px'>
<tr valign='top'>
<td>
<div id='patient_new'>
<div class='pretty_box' style='width:500px'>
<form name="new_record" action="add_patient.php" method="post" id="new_record" class="new_record">
	<?php # Hidden field for db key ?>
	<input type='hidden' name='card_num' id='card_num' value="<?php echo get_max_patient_id()+1; ?>" ></input>
	<table cellpadding="2" class='regn_form_table'>
	<tr <?php
	if($_SESSION['pid'] == 0)
		echo " style='display:none;' ";
	?>>
		<td>
			<?php echo LangUtil::$generalTerms['PATIENT_ID']; ?>
			<?php
			if($_SESSION['pid'] == 2)
				$page_elems->getAsterisk();
			?>
		</td>
		<td><input type="text" name="pid" id="pid" value="" size="20" class='uniform_width' /></td>
	</tr>
	<tr>
		<td>Date of Registration</td>
		<td>
		<?php

		$today1 = date("Y-m-d");
		$today_array1 = explode("-", $today1);
		$name_list1 = array("receipt_yyyy", "receipt_mm", "receipt_dd");
		$id_list1 = array("receipt_yyyy", "receipt_mm", "receipt_dd");
		$value_list1 = array($today_array1[0], $today_array1[1], $today_array1[2]);
		$page_elems->getDatePicker($name_list1, $id_list1, $value_list1, true);
		
		?>
		</td>
	</tr>
	<tr <?php
	if($_SESSION['p_addl'] == 0)
		echo " style='display:none;' ";
	?>>
		<td>
			<?php echo LangUtil::$generalTerms['ADDL_ID'];
			if($_SESSION['p_addl'] == 2)
				$page_elems->getAsterisk();
			?>
		</td>
		<td><input type="text" name="addl_id" id="addl_id" value="" size="20" class='uniform_width' /></td>
	</tr>
	<tr <?php
	if( is_numeric($_SESSION['dnum']) && $_SESSION['dnum'] == 0 )
		echo " style='display:none;' ";
	?>>
		<td><?php echo LangUtil::$generalTerms['PATIENT_DAILYNUM']; ?>
		<?php
			if($_SESSION['dnum'] == 2)
				$page_elems->getAsterisk();
			?>
		</td>
		<td><input type="text" name="dnum" id="dnum" value="<?php echo $daily_num; ?>" size="20" class='uniform_width' /></td>
	</tr>
	<tr<?php
	if($_SESSION['pname'] == 0)
		echo " style='display:none;' ";
	?>>	
		<td><?php echo LangUtil::$generalTerms['NAME']; ?><?php $page_elems->getAsterisk(); ?> </td>
		<td><input type="text" name="name" id="name" value="" size="20" class='uniform_width' /></td>
	</tr>
	
	<tr<?php
	if($_SESSION['sex'] == 0)
		echo " style='display:none;' ";
	?>>
		<td><?php echo LangUtil::$generalTerms['GENDER']; ?><?php $page_elems->getAsterisk();?> </td>
		<td>
			<INPUT TYPE=RADIO NAME="sex" id="sex" VALUE="M" checked><?php echo LangUtil::$generalTerms['MALE']; ?>
			<INPUT TYPE=RADIO NAME="sex" VALUE="F"><?php echo LangUtil::$generalTerms['FEMALE']; ?>
		<br>
			
		</td>
	</tr>
	
	<tr><?php
	if($_SESSION['age'] == 0)
		echo " style='display:none;' ";
	?>
		<td><?php echo LangUtil::$generalTerms['AGE']; ?> <?php
			if($_SESSION['age'] == 2)
				$page_elems->getAsterisk();
			?>
		</td>
		<td>
		<font style='color:red'><?php echo LangUtil::$pageTerms['TIPS_DOB_AGE'];?></font>
			<input type="text" name="age" id="age" value="" size="4" maxlength="10" class='uniform_width' />
			
			<select name='age_param' id='age_param'>
				<option value='1'><?php echo LangUtil::$generalTerms['YEARS']; ?></option>
				<option value='2'><?php echo LangUtil::$generalTerms['MONTHS']; ?></option>
				<option value='3'><?php echo LangUtil::$generalTerms['DAYS']; ?></option>
				<option value='4'>Weeks</option>
				<option value='5'>Range(Years)</option>
			</select>
			
		</td>
	</tr>
	<tr valign='top'<?php
	if($_SESSION['dob'] == 0)
		echo " style='display:none;' ";
	?>>	
		<td>
			<?php echo LangUtil::$generalTerms['DOB']; ?> 
			<?php
			if($_SESSION['dob'] == 2)
				$page_elems->getAsterisk();
			?>
		</td>
		<td>
		<?php
		$name_list = array("yyyy", "mm", "dd");
		$id_list = $name_list;
		$value_list = array("", "", "");
		$page_elems->getDatePicker($name_list, $id_list, $value_list); 
		?>
		</td>
	</tr>
		
</form>
	
<form id='custom_field_form' name='custom_field_form' action='ajax/patient_add_custom.php' method='get'>
<input type='hidden' name='pid2' id='pid2' value=''></input>
	<?php
	$custom_field_list = get_custom_fields_patient();
	foreach($custom_field_list as $custom_field)
	{
		if(($custom_field->flag)==NULL)
		{
		?>
		<tr valign='top'>
			<td><?php echo $custom_field->fieldName; ?></td>
			<td><?php $page_elems->getCustomFormField($custom_field); ?></td>
		</tr>
		<?php
		}
	}
	?>
</form>
	
	<tr>
		<td></td>
		<td>
			<input type="button" id='submit_button' onclick="add_patient();" value="<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>" />
			&nbsp;&nbsp;
			<a href='find_patient.php'><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a>
			&nbsp;&nbsp;
			<span id='progress_spinner' style='display:none'>
				<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
			</span>
		</td>
	</tr>

</table>
<!--</form>-->
</div>
<small>
<span style='float:right'>
	<?php $page_elems->getAsteriskMessage(); ?>
</span>
</small>
</div>
</td>
<td>
&nbsp;&nbsp;&nbsp;
</td>
<td>
<div>
	<div id='regn_sidetip' class='right_pane' style='display:none;margin-left:10px;'>
	<ul>
		<li><?php echo LangUtil::$pageTerms['TIPS_REGN_NEW'];?></li>
		<li><?php echo LangUtil::$pageTerms['TIPS_REGN'];?></li>
	</ul>
	</div>
	<br><br><br><br><br><br><br>
	<div id='patient_prompt_div'>
	
	</div>
</div>
</td>
</tr>
</table>
<?php 
/*
$load_time = microtime(); 
$load_time = explode(' ',$load_time); 
$load_time = $load_time[1] + $load_time[0]; 
$page_end = $load_time; 
$final_time = ($page_end - $page_start); 
$page_load_time = number_format($final_time, 4, '.', ''); 
echo("Page generated in " . $page_load_time . " seconds"); 
*/
include("includes/footer.php"); ?>