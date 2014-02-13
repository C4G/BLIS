<?php
include("../includes/db_lib.php");

$file_name = $_REQUEST['fl'];
$file_name_and_extension = explode('.', $file_name);
$file_name_parts = explode("_", $file_name_and_extension['0']);
$count = 0;
if($file_name_parts[0] == 'blis')
    $count++;
if($file_name_parts[2] == 'backup')
    $count++;
if(is_numeric($file_name_parts[1]))
    $count++;
if(is_numeric($file_name_parts[1]))
{    
    $last = get_last_import_date(intval($file_name_parts[1]));
    if(isset($last))
        $last = date('F j, Y g:i a', strtotime($last));
    else
        $last = 'Never';
}
else
{
    $last = "Unknown";
}
$lname = "Unknown";
if(is_numeric($file_name_parts[1]))
{
    $lab_obj = LabConfig::getById(intval($file_name_parts[1]));
    if(isset($lab_obj))
        $lname = $lab_obj->name;
}
?>

<table>
    <tr>
        <td>File name: </td>
        <td><?php echo $file_name_and_extension[0]; ?></td>
    </tr>
    <tr>
        <td>File type: </td>
        <td><?php echo $file_name_and_extension[1]; ?></td>
    </tr>
    <tr>
        <td>File Status:</td>
        <?php if($count == 3){ ?>
        <td style='color:green'><?php echo "Verified" ?></td>
        <?php }else{ ?>
         <td style='color:red'><?php echo "Not Verified" ?></td>  
        <?php } ?>
    </tr>
    <tr>
        <td>Lab Name:</td>  
        <td><?php echo $lname; ?></td>
    </tr>
    <tr>
        <td>Last Import Date: </td>
        <td><?php echo $last; ?></td>
    </tr>
    <tr>
    </tr>
</table>
