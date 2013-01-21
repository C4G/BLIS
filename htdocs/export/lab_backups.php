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

echo "<br>";
echo "<a href='lab_configs.php'>< Back </a>| ";
echo '<b>Import Lab Data</b>';
echo "<br>";
echo "<br>";

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


</style>
<script type="text/javascript">
	function submitSQLForm() {
		//alert($("#sqlFile").val());
                //var filename = document.sqlFile.value;
                //alert(filename);
                startUpload();
		$('#SQLimportForm').submit();
	}

function startUpload(){
    document.getElementById('f1_upload_process').style.visibility = 'visible';
    return true;
}
function stopUpload(success){
      var result = '';
      if (success == 0){
         document.getElementById('result').innerHTML =
           '<span class="msg">The file was imported successfully!<\/span><br/>';
      }
      else {
         document.getElementById('result').innerHTML = 
           '<span class="emsg">There was an error during file import!<\/span><br/>';
      }
      document.getElementById('f1_upload_process').style.visibility = 'hidden';
      return true;   
}
</script>

<body>
<div id="boxx">   
<form id='SQLimportForm' name='SQLimportForm' action='import_data_director.php' method='post' enctype="multipart/form-data" target="upload_target" >
Select update file
<input type="file" id="sqlFile" name="sqlFile" /></td>

<input type="submit" id="submit" value="Import" onclick="javascript:submitSQLForm();">
</form>
<br>
 <p id="f1_upload_process">Importing...<br/><img src="export/loader.gif" /></p>
<p id="result"></p>
<iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>                 
</div>
</body>

<?php
include("includes/footer.php"); ?>