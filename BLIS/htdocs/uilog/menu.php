<?php
include("../includes/db_lib.php");
include("globals.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>C4G BLIS UI Profile Reports</title>

<meta charset="utf-8">
<meta name="description" content="C4G BLIS UI Profile Reports" />


<script type='text/javascript'>
$(document).ready(function(){
});

function load_file(id)
{
    if(id == 'counts')
        $('#content').load('counts.php');
    else if(id == 'initialize')
        $('#content').load('initialize.php?op=1');
     else if(id == 'clear')
        $('#content').load('initialize.php?op=0');
    else if(id == 'test')
        $('#content').load('individual_logs.php');
}
</script>
</head>

<body>
<?php 

?>
<div id="container">
	<div id="header">
		<p><b>C4G BLIS UI Profile Reports</b></p>
	</div>
	<div id="content">
            <p>Welcome</p>
	</div>
	<div id="sidebar">
		<b>Menu</b>
                <br>
                <a id='option1' href="javascript:load_file('initialize');"><?php echo "Load UI Log"; ?></a>
                <br>
                <a id='option1' href="javascript:load_file('clear');"><?php echo "Clear Cache"; ?></a>
                <br>
                <a id='option1' href="counts.php" target='_blank'><?php echo "Counts"; ?></a>
                <br>
                <!--<a id='option1' href="javascript:load_file('test');"><?php echo "Test Link"; ?></a>-->

	</div>
	
</div>


</body>
</html>