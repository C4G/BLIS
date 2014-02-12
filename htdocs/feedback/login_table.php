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
				$("#login_table").tablesorter(); 
			} 
		); 
		</script>
	</head>
	<body>
		<br>
		<b>Login Table</b>
		<br><br>
		<table id='login_table' class="tablesorter" cellspacing="5px">
			<thead>
				<tr>
					<th><b>Username</b></th>
					<th><b>Time recorded</b></th>
					<th><b>AppCodeName</b></th>
					<th><b>AppName</b></th>
					<th><b>AppVersion</b></th>
					<th><b>Platform</b></th>
				</tr>
			</thead>
			<tbody>
			<?php
			$query_string = 
				"select User_Id, AppCodeName, AppName, AppVersion, Recorded_At, Platform ".
				"from User_Props order by Recorded_At desc limit 100";
			$resultset = query_associative_all($query_string, $row_count);
			foreach($resultset as $row)
			{
				echo "<tr>";
				echo "<td>";
				echo $row['User_Id'];
				echo "</td>";
				echo "<td>";
				echo $row['Recorded_At'];
				echo "</td>";
				echo "<td>";
				echo $row['AppCodeName'];
				echo "</td>";
				echo "<td>";
				echo $row['AppName'];
				echo "</td>";
				echo "<td>";
				echo $row['AppVersion'];
				echo "</td>";
				echo "<td>";
				echo $row['Platform'];
				echo "</td>";
				echo "</tr>";
			}
			?>
			</tbody>
		</table>
	</body>
</html>