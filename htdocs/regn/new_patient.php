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

include_once("generate_customize_field_order_patient.php");
include_once("field_htmlFactory.php");
include_once("includes/field_order_update.php");

LangUtil::setPageId("new_patient");
$script_elems->enableDatePicker();
$script_elems->enableJQueryForm();

$lab_config = get_lab_config_by_id($_SESSION['lab_config_id']);
//$daily_num = get_daily_number(); 
$session_num = get_session_number();
$uiinfo = "qr=".$_REQUEST['n'];
putUILog('new_patient', $uiinfo, basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');
$field_odering = field_order_update::install_first_order($lab_config, 1);
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
	
	/* $('#custom_field_form').submit(function() { 
		// submit the form 
		$(this).ajaxSubmit({async:false}); 
		// return false to prevent normal browser submit and page navigation 
		return false; 
	}); */
});

function prefetch_pname()
{
	var name = $('#name').val();
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
    var card_num = $("#card_num").val();
	$('#pid2').val(card_num);
	var addl_id = $("#addl_id").val();
	var name = $("#name").val();
	//name = name.replace(/[^a-z ]/gi,'');
	var yyyy = $("#yyyy").val();
	yyyy = yyyy.replace(/[^0-9]/gi,'');
	var mm = $("#mm").val();
	mm = mm.replace(/[^0-9]/gi,'');
	var dd = $("#dd").val();
	dd = dd.replace(/[^0-9]/gi,'');
	var receipt_yyyy = $("#receipt_yyyy").val();
	
	receipt_yyyy = receipt_yyyy.replace(/[^0-9]/gi,'');
	var receipt_mm = $("#receipt_mm").val();
	receipt_mm = receipt_mm.replace(/[^0-9]/gi,'');
	var receipt_dd = $("#receipt_dd").val();
	receipt_dd = receipt_dd.replace(/[^0-9]/gi,'');
	var age = $("#age").val();
	var nan_flag=0;
	if((/^([>][0-9]*)$/.test(age) === true))
	{
		//this branch is for age range inputs of form greater than some number
		age = age.replace(/[^0-9]/gi,'');
	}
	else if(/^([' ']*[0-9]+[' ']*[-][' ']*[0-9]+[' ']*)$/.test(age) === true)
	{
		//this branch is for age range inputs of form start age to end end separated by a hyphen
		age_split = age.split("-")
		start_age=parseInt(age_split[0].trim());
		end_age=parseInt(age_split[1].trim());
		if(start_age<=end_age)
		{
		    age=(Math.round((start_age+end_age)/2)).toString();
		}
		else
		{
		    age=0;
		}
	}
	else if((/^([-][0-9]+)$/.test(age) === false) && (/^([0-9]*)$/.test(age) === false))
	{
		nan_flag = 1;
		age = 0;
	}

	var age_param = $('#age_param').val();
	age_param = age_param.replace(/[^0-9]/gi,'');
	var sex = "";
	var pid = $('#pid').val();
	for(i = 0; i < document.new_record.sex.length; i++)
	{
		if(document.new_record.sex[i].checked)
			sex = document.new_record.sex[i].value;
	}
	var email = $("#email").val();
	var phone = $("#phone").val();
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
		
	<?php $_SESSION['pid']= $lab_config->pid; ?>	
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
	else if (nan_flag==1)
	{
		alert("<?php echo LangUtil::$generalTerms['ERROR'].": ".LangUtil::$generalTerms['AGE']; ?>");
		return;
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
	
	var check_url = "ajax/patient_check_surr_id.php?sur_id="+pid;
	$.ajax({ url: check_url, success: function(response){	
		<?php
		if($_SESSION['pid'] == 3 || $_SESSION['pid'] == 4)
		{
		?>		
			if(response == "1")	
			{		
				alert("<?php echo LangUtil::$generalTerms['ERROR'].": ".LangUtil::$generalTerms['TIPS_PATIENTID_EXISTS']; ?>");	
				return;		
			}
	<?php }?>	
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
						
					//$('#custom_field_form').submit();
					addCustomElements();
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
	});
}


function fetchPatientAjax()
{
	var card_num = $("#card_num").val();
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

function addCustomElements(){
	var myCustomName = new Array();
	var myCustomVal = new Array();
	$(".custom").each(function(){
		myCustomName.push(this.name);
	});
	
	if(myCustomName.length > 0){
		var card_num = $("#card_num").val();
		var params = "pid2="+card_num+"&";
		for (var i = 0; i < myCustomName.length; i++) {
			myCustomVal.push($('[name="'+myCustomName[i]+'"]').val());
			params = params+myCustomName[i]+"="+$('[name="'+myCustomName[i]+'"]').val()+"&";
		}
		params = params.match(/(.*).$/)[1];
			
		$.ajax({
			url : "ajax/patient_add_custom?"+params,
			async: false,
			success : function(data) {
			}	
		});
	}

	
}
</script>
<div class="page-header"></div>
    <h1 class="page-title"><a href="javascript:history.go(-1);" class="btn btn-secondary" role="button"><i class="fe fe-chevron-left mr-2"></i><?php echo LangUtil::$pageTerms['MSG_BACKTOLOOKUP']; ?></a>&nbsp;&nbsp;<?php echo LangUtil::getTitle(); ?></h1>


<br>
<div class="row">
    <div class="col-lg-12">
         <div class="card">
            <div class="card-body">
                <div class="text-wrap p-lg-12"> 
                    <div id='patient_new'>
                            <form name="new_record" action="add_patient.php" method="post" id="new_record" class="new_record">
	                       
                                <!-- Hidden field for db key -->
                                <input type='hidden' name='card_num' id='card_num' value="<?php echo get_max_patient_id()+1; ?>" >
                                <input type='hidden' name='pid2' id='pid2' value=''>

                                <table class="table card-table table-vcenter text-nowrap regn_form_table">
                                    <?php CustomFieldOrderGeneration_Patient::init(); 
                                          $HTMLFactory = new field_htmlFactory(); ?>
                                    
                                    <?php 
                                        $fieldOrder = $field_odering->form_field_inOrder;
                                        $fieldOrder = explode(',', $fieldOrder);
                                        foreach($fieldOrder as $fieldName){
                                            $HTMLFactory->generateHTML($fieldName);
                                        }
                                    ?>

                                    <?php CustomFieldOrderGeneration_Patient::generate_patient_rdate(); ?>
                                </table>
                                <div class="form-group">
                                    <center>
                                        <span id='progress_spinner' style='display:none'><?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?></span>
                                    </center>
                                </div>
                                 <div class="btn-list">
                                    <a onclick="javascript:add_patient();" class="btn btn-primary btn-block" id="submit_button"><?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?></a>
                                    <a class="btn btn-secondary btn-block" href="find_patient.php" ><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a>
                                </div>
    	                   </form>
                    </div>
                </div>
             </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>