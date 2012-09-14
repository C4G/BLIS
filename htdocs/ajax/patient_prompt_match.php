<?php
#
# Returns a list of similar patient names
# To aid/help during new patient registration
#

include("../includes/db_lib.php");
LangUtil::setPageId("new_patient");

$q = $_REQUEST['q'];
$query_string = 
	"SELECT * FROM patient ".
	"WHERE name LIKE '%$q%' ";
$resultset = query_associative_all($query_string, $row_count);
if(count($resultset) == 0 || $resultset == null)
	return;
$patient_list = array();
foreach($resultset as $record)
{
	$patient_list[] = Patient::getObject($record);
}
?>
<table class='hor-minimalist-c' style='width:450px;'>
	<thead>
		<tr valign='top'>
			<th>
				<span style='background-color:#FFCC66'><?php echo LangUtil::$pageTerms['SIMILAR_NAMES']; ?></span>
			</th>
			<?php
			if($_SESSION['pid'] != 0)
			{
				?>
				<th><?php echo LangUtil::$generalTerms['PATIENT_ID']; ?></th>
				<?php
			}
			?>
			<th><?php echo LangUtil::$generalTerms['GENDER']; ?></th>
			<th style="width:70px;"><?php echo LangUtil::$generalTerms['AGE']; ?></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php
	foreach($patient_list as $patient)
	{
		?>
		<tr valign='top'>
			<td>
				<?php 
				echo $patient->name; 
				?>
			</td>
			<?php
			if($_SESSION['pid'] != 0)
			{
				?>
				<td><?php echo $patient->getSurrogateId(); ?></td>
				<?php
			}
			?>
			<td>
				<?php
				echo $patient->sex;
				?>
			</td>
			<td>
				<?php
				echo $patient->getAge();
				?>
			</td>
			<td>
				<a href='new_specimen.php?pid=<?php echo $patient->patientId; ?>'>
					<?php echo LangUtil::$pageTerms['CMD_SELECTFORREGN']; ?>
				</a>
			</td>
		</tr>
		<?php
	}
	?>
	</tbody>
</table>