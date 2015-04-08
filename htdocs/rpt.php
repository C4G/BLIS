<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<STYLE type="text/css">
.t0{width: 748px;margin-top: 32px;font: 15px 'Times New Roman';}
.tblLine {border:#000 1px solid; width:auto}
.p3{text-align: left;padding-left: 7px; padding-right:7px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.ft4{font: 15px 'Times New Roman';line-height: 16px;}
.tr{height: 35px;}
.tdleft{border-left: #000000 1px solid;border-top: #000000 1px solid;padding: 0px;margin: 0px;vertical-align: top;}
.tdright{border-left: #000000 1px solid;border-top: #000000 1px solid;border-right:#000000 1px solid;padding: 0px;margin: 0px;vertical-align: top;}
.tdmid{border-left: #000000 1px solid;border-top: #000000 1px solid;padding: 0px;margin: 0px;vertical-align: top;}
.tdleftbuttom{border-left: #000000 1px solid;border-top: #000000 1px solid;border-bottom:#000000 1px solid;padding: 0px;margin: 0px;vertical-align: top;}
.tdrightbuttom{border-left: #000000 1px solid;border-top: #000000 1px solid;border-bottom:#000000 1px solid;border-right:#000000 1px solid;padding: 0px;margin: 0px;vertical-align: top;}
.tdmidbuttom{border-left: #000000 1px solid;border-top: #000000 1px solid;border-bottom:#000000 1px solid;padding: 0px;margin: 0px;vertical-align: top;}
.tdleftfull{border-left: #000000 1px solid;border-top: #000000 1px solid;border-bottom:#000000 1px solid;border-right:#000000 1px solid;padding: 0px;margin: 0px;vertical-align: top;}
</style>
</head>

<body>
<?php
$column_size = 3;
$c=1;
$values = array();
for($i=0;$i<6;$i++)
	$values[] = "Item ".($i+1) .' of '.'10 ';
?>
<table cellpadding=0 cellspacing=0 class="t0" >
<?php
$endlineclass="";
$endmark = (count($values)- $column_size)-1;
$colspan=0;
for($i=0;$i<count($values);$i++)
{
	
	if($c == 1) 
	{		
		$endlineclass = $i > $endmark ? "tdleftbuttom":"tdleft";		
		echo "<tr>";
		if(($i+1) == count($values))
		{
			$colspan = $column_size;
			$endlineclass = "tdleftfull";
		}
		
		echo '<td colspan="'.$colspan.'" class="tr '.$endlineclass.'"><P class="p3 ft4">'.$values[$i].'</P></td>';
	}
	elseif($c >=  $column_size &&  $column_size != 0)
	{
			$endlineclass = $i > $endmark ? "tdrightbuttom":"tdright";
			//$endlineclass ="tdright";
			echo '<td class="tr '.$endlineclass.'"><P class="p3 ft4">'.$values[$i].'</P></td>';
			echo "</tr>";
			$c=0;
	}
	else
	{
		$endlineclass = $i > $endmark ? "tdmidbuttom":"tdmid";
		//$endlineclass ="tdmid";
		if(($i+1) == count($values))
		{
			$colspan = ($column_size-$c)+1;
			$endlineclass = "tdleftfull";
		}
		
		echo '<td colspan="'.$colspan.'" class="tr '.$endlineclass.'"><P class="p3 ft4">'.$values[$i].'</P></td>';
	}
	$c++;
	
?>    
    
  
  <? 
  		
  } ?>
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td  class="tr tdleftbuttom"><P class="p3 ft4">Patient ID: 0001 / 14</P></td>
    <td  class="tr tdmidbuttom"><P class="p3 ft4">Patient ID: 0001 / 14</P></td>
    <td  class="tr tdmidbuttom"><P class="p3 ft4">Patient ID: 0001 / 14</P></td>
    <td  class="tr tdmidbuttom"><P class="p3 ft4">Patient ID: 0001 / 14</P></td>
    <td  class="tr tdrightbuttom"><P class="p3 ft4">Patient ID: 0001 / 14</P></td>
  </tr> 
  
  <tr>
    <td colspan="">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>