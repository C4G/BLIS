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
$csvdata = apc_fetch('csvdata');
$classes = apc_fetch('classes');

function getClass($cid)
{
    global $classes;
  
    $cat = "-";
    foreach($classes as $key=>$value)
    {
        foreach($value as $id)
        {
            if($id == $cid)
            {
                if($cat == '-')
                    $cat = $key;
                else
                    $cat = $cat.','.$key;
            }
        }
    }
    return $cat;
}
?>
<script type='text/javascript'>
$(document).ready(function() {
        var oTable = $('#table_id').dataTable( {
		"sDom": 'W<"H"><"H"Clfr>t<"F"ip>',
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
                 "iDisplayLength": 50,
                 "oColumnFilterWidgets": {
			"aiExclude": [ 0 ]
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
$ids = array();
$counts = array();
foreach($csvdata as $csv)
{
    array_push($ids, $csv[1]);
}     
$counts = array_count_values($ids);
?>
<form>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="table_id">
    <thead>
        <tr>
            <th>ID</th>
            <th>Category</th>
            <th>Occurrence</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($counts as $key=>$value)
            {
                $ilink = "individual_logs.php?id=".$key;
                $clink = "class_logs.php?id=".$key;
                echo "<tr>";
                echo "<td><a href='".$ilink."' target='_blank'>".$key."</a></td>";
                $cat = getClass($key);
                //echo "<td><a href='".$clink."' target='_blank'>".$cat."</td>";
                echo "<td>".$cat."</td>";
                echo "<td>".$value."</td>";
                echo "</tr>";
            }
        ?>
    </tbody>
</table>
    </form>
