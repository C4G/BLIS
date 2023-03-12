<div id='report_content'>
<link rel='stylesheet' type='text/css' href='css/table_print.css' />
<style type='text/css'>
tbody td, thead th { padding: .3em;} 
div.editable {
	/*padding: 2px 2px 2px 2px;*/
	margin-top: 2px;
	width:900px;
	height:20px;
}
div.editable input {
	width:700px;
}
div#printhead {
position: fixed; top: 0; left: 0; width: 100%; height: 100%;
padding-bottom: 5em;
margin-bottom: 100px;
display:none;
}
#lab_logo{
    margin-bottom:20px;
    height: 165px;
}
td{
    padding:5px;
}

@media all
{
 .page-break { display:none; }
}
@media print
{
	#options_header { display:none; }
	/* div#printhead {	display: block;
 } */
 div#docbody {
  margin-top: 5em;
 }
}
.landscape_content {-moz-transform: rotate(90deg) translate(300px); }
.portrait_content {-moz-transform: translate(1px); rotate(-90deg) }
</style>
<style type='text/css'>
	<?php $page_elems->getReportConfigCss($margin_list,false); ?>
</style>


<?php $align=$report_config->alignment_header;?>
<div id='report_config_content' style='display:block;'>
<?php
# All the report content
# Make a loop to get all the reports we want to print and feed them in to the report content
# 1. Store all the selected reports/patient data in an array
# 2. func generateReport(patient_data_array) {
#    report_doc_body
#}
# 3. foreach(patients as patient) {
#    generateReport(patient)
#}
include("report_word_content.php");
?>
</div>
</div>