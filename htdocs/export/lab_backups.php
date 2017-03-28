<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Lists currently accessible lab configurations with options to modify/add 
# Check whether to redirect to lab configuration page
# Called when the lab admin has only one lab under him/her
#

include("../users/accesslist.php");
include("redirect.php");
include("includes/user_lib.php");
include("includes/header.php");



?>
<style>
#f1_upload_process{
   z-index:100;
   position:absolute;
   visibility:hidden;
   text-align:center;
   width:400px;
   margin:0px;
   padding:0px;
   background-color:#fff;
}
#import_help
{
   background: none repeat scroll 0 0 #B3C6E6;
    border: 1px solid #333333;
    float: right;
    font-size: 13px;
    padding: 10px;
    position: relative;
    right: 0;
    top: 0;
    width: 230px;
}

#file_info{
    border: 2px solid #C8CDD1;
     padding: 10px;
     width: 500px;
     
}
#confirm{
    background: none repeat scroll 0 0 #C8CDD1;
     padding: 5px;
     width: 514px;
}

#nothing{
    
    border: 1px solid;
    width: 300px;
    margin: 10px 0px;
    padding:15px 10px 15px 50px;
    background-repeat: no-repeat;
    background-position: 10px center;
    color: #9F6000;
    background-color: #FEEFB3;
    background-image: url('../includes/img/knob_attention.png');

}


.emsg{
    
    border: 1px solid;
    width: 300px;
    margin: 10px 0px;
    padding:15px 10px 15px 50px;
    background-repeat: no-repeat;
    background-position: 10px center;
    color: #9F6000;
    background-color: #FEEFB3;
    background-image: url('../includes/img/knob_attention.png');

}

#nnothing
{
     border: 2px solid #FF0000;
      padding: 10px;
     width: 300px;
}

.smsg {
    
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
<script type="text/javascript">
    function confirmationMsg()
    {
        $('#nothing').hide();
        $('.emsg').hide();
        $('.smsg').hide();
        var cf = $('#sqlFile').val();
        if(cf == '')
        {
            $('#nothing').show();
            return;
        }
        $('#file_info').load('export/get_import_file_info.php?fl='+cf);
        $('#file_info').show();
        //console.log(cf);
        $('#confirm').show();
    }
	function submitSQLForm() {
		//alert($("#sqlFile").val());
                //var filename = document.sqlFile.value;
                //alert(filename);
                disableFields();
                $('#file_info').hide();
                $('#nothing').hide();
                $('#confirm').hide();
                startUpload();
                //console.log('reached');
		$('#SQLimportForm').submit();
	}
        function disableFields()
        {
                $('#import').attr('disabled', 'disabled');

        }
        function enableFields()
        {
                $('#import').removeAttr('disabled');

        }
function notSubmitSQLForm()
{
    $('.emsg').hide();
        $('.smsg').hide();
    $('#nothing').hide();
    $('#confirm').hide();
    $('#file_info').hide();
}
function startUpload(){
    document.getElementById('f1_upload_process').style.visibility = 'visible';
    return true;
}
function stopUpload(success){
      var result = '';
      if (success == 0){
         document.getElementById('result').innerHTML =
           '<span class="smsg">The file was imported successfully!</span><br/>';
      }
      else {
         document.getElementById('result').innerHTML = 
           '<span class="emsg">There was an error during file import!</span><br/>';
      }
      document.getElementById('f1_upload_process').style.visibility = 'hidden';
      enableFields();
      return true;   
}
</script>
  <div id='importt_help'>
<?php
	$tips_string = "Click on browse and select the backup file to import. <br>Backup file name should be <i>blis_{lab ID}_backup.sql</i>";
	$page_elems->getSideTip(LangUtil::$generalTerms['TIPS'], $tips_string);
        //echo "<b>Tips</b><br>".$tips_string;
?>
</div>
<body>
    <?php
  echo "<br>";
echo "<a href='lab_configs.php'>< Back </a>| ";
echo '<b>Import Lab Data</b>';
echo "<br>";
echo "<br>";
?>
<div class='left_al' id="boxx"> 
    
<form id='SQLimportForm' name='SQLimportForm' action='import_data_director.php' method='post' enctype="multipart/form-data" target="upload_target" >
Select update file
<input type="file" id="sqlFile" name="sqlFile" size="40" /></td>
<br>
Please copy and paste langdata folder path present in backup folder 
<input type="text" name="lang_data_folder_path" id="lang_data_folder_path" value=" ">
<br>
<input type="button" id="import" value="Import" onclick="javascript:confirmationMsg();">
</form>
<br>
 <p id="f1_upload_process">Importing...<br/><img src="export/loader.gif" /></p>
<p id="result"></p><iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>                 

</div>
    <div class='left_al' id="file_info" style="display:none;">
        
        
    </div>
    <div class='left_al'  id="confirm" style="display:none;">
        Are you sure you want to import the data?
        <input type="button" id="Yup" value="Yes" onclick="javascript:submitSQLForm();" />
        <input type="button" id="Nope" value="No" onclick="javascript:notSubmitSQLForm();" />
        
    </div>
    <div class='left_al' id="nothing" style="display:none;">
        Please select a file to import
        
    </div>
</body>
<br><br><br><br>
<?php
include("includes/footer.php"); ?>