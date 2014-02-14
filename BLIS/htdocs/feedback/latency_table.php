<html>
	<head>
		<?php
		include("redirect.php");
		include("includes/db_lib.php");
		include("includes/styles.php");
		include("includes/script_elems.php");
		$script_elems = new ScriptElems();
		$script_elems->enableJQuery();
		$script_elems->enableTableSorter();
		?>
		<script type="text/javascript">
		$(document).ready(function() { 
				$("#delay_table").tablesorter(); 
			} 
		); 
		</script>
	</head>
	<body>
		<br>
		<b>Latency Table</b>
		<br><br>
		<table id='delay_table' class="tablesorter" cellspacing="5px">
			<thead>
			<tr>
				<th><b>Username</b></th>
				<th><b>IP</b></th>
				<th><b>Latency</b></th>
				<th><b>Time recorded</b></th>
				<th><b>Page Name</b></th>
			</tr>
			</thead>
			<tbody>
			<?php
			$query_string = 
				"select User_Id, IP_Address, Page_Name, Recorded_At, Latency ".
				"from Delay_Measures order by Recorded_At desc LIMIT 100";
			$resultset = query_associative_all($query_string, $row_count);
			foreach($resultset as $row)
			{
				echo "<tr>";
				echo "<td>";
				echo $row['User_Id'];
				echo "</td>";
				echo "<td>";
				echo $row['IP_Address'];
				echo "</td>";
				echo "<td>";
				echo $row['Latency'];
				echo "</td>";
				echo "<td>";
				echo $row['Recorded_At'];
				echo "</td>";
				echo "<td>";
				echo $row['Page_Name'];
				echo "</td>";
				echo "</tr>";
			}
			?>
			</tbody>
		</table>
	</body>
</html>