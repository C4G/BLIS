<?php

include("../includes/db_lib.php");
include("../includes/script_elems.php");

$patientId = $_REQUEST['pid'];
$type = $_REQUEST['type'];

$script_elems = new ScriptElems();
$script_elems->enableTableSorter();
$script_elems->enableJQueryForm();

if($type == 'national') {

	$user = get_user_by_id($_SESSION['user_id']);
	$country = strtolower($user->country);
	$saved_db = DbUtil::switchToCountry($country);
	$patient = Patient::getById($patientId);
	DbUtil::switchRestore($saved_db);

	$lab_config = LabConfig::getById($_SESSION['lab_config_id']);
	?>
	<table class='hor-minimalist-b' <?php  if($width!="") echo " style='width:".$width."px;' "; ?>>
		<tbody>
				<tr>
					<td><u><?php echo LangUtil::$generalTerms['NAME']; ?></u></td>
					<td><?php echo $patient->getName(); ?></td>
				</tr>
				<tr>
					<td><u><?php echo LangUtil::$generalTerms['GENDER']; ?></u></td>
					<td><?php echo $patient->sex; ?></td>
				</tr>
				<tr>
					<td><u><?php echo LangUtil::$generalTerms['AGE']; ?></u></td>
					<td>
						<?php 
							echo $patient->getAge(); 
						?>
					</td>
				</tr>
				<?php
				if($lab_config->dob != 0)
				{
				?>
				<tr>
					<td><u><?php echo LangUtil::$generalTerms['DOB']; ?></u></td>
					<td><?php 
							echo $patient->getDob();
						?>
					</td>
				</tr>
				<?php 
				}
				?>
				</tbody>
		</table>
<?php	
}
?>