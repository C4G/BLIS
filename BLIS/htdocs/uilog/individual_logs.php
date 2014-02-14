<?php

include("../includes/db_lib.php");
include("globals.php");

/*
$uiLog = new UILog();
$csvdata = $uiLog->readUILog('2.2');
$bar = 'BAR';
apc_add('foo', $bar);
echo apc_fetch('foo');
 * 
 */
?>
<script type='text/javascript'>
$(document).ready(function() {
        var oTable = $('#table_id').dataTable( {
            "sDom": 'W<"H"><"H"Clfrt><"F"ip>',
		//"sDom": 'W<"clear"><"H"Clfr>t<"F"ip>',
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
                 "iDisplayLength": 50,
                 "oColumnFilterWidgets": {
			"aiExclude": [ 0,2   ]
		},
		"oColVis": {
			"bRestore": true
		}
                 //"bScrollInfinite": true,
    //"bScrollCollapse": true,
    //"sScrollY": "200px",
    //"iScrollLoadGap": 20
                } );
} );
</script>

<?php
$id = $_REQUEST['id'];
$log = array();
//$csvdata = apc_fetch('csvdata');
/*
echo "<pre>";
print_r($csvdata);
echo "</pre>";
 */
$uiLog = new UILog();
$log = $uiLog->getLogsByID($id);
echo "<b>ID:</b> ".$id;
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="table_id">
    <thead>
        <tr>
            <th>Date Time</th>
            <th>Info</th>
            <th>URI</th>
            <th>User</th>
            <th>Lab</th>
            <th>Version</th>
            <th>Tag1</th>
            <th>Tag2</th>
            <th>Tag3</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($log as $entry)
            {
                echo "<tr>";
                echo "<td>".$entry[0]."</td>";
                echo "<td>".$entry[2]."</td>";
                echo "<td>".$entry[3]."</td>";
                echo "<td>".$entry[4]."</td>";
                echo "<td><small><small>".$entry[5]."</small></small></td>";
                echo "<td>".$entry[6]."</td>";
                echo "<td>".$entry[7]."</td>";
                echo "<td>".$entry[8]."</td>";
                echo "<td>".$entry[9]."</td>";
                echo "</tr>";
            }
        ?>
    </tbody>
</table>
</body>