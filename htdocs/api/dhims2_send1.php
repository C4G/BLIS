<?php
ini_set('max_execution_time', 600); 
ini_set('memory_limit','300M');
include_once("../includes/db_lib.php");
include_once("../includes/dhims2.php");
$dhims2_test_counts = json_decode(stripslashes($_REQUEST['dhims2_test_counts']),true);
//file_put_contents('dhims2.txt', $_REQUEST['dhims2_test_counts']);
$dhims2 = new DHIMS2();
$sending_configs = $dhims2->getSendingConfigs($_REQUEST['lab_config_id']);
var_dump($sending_configs );exit;
$scount=0;

$jsonsending_start='{ "dataValues": [';
$jsonsending_end= '] }';

$xmlsending_start='<dataValueSet xmlns="http://dhis2.org/schema/dxf/2.0">'."\n";
$xmlsending_end= "\n".'</dataValueSet>';
$sending_values="";

///we can either send as xml or json.
////but my default is json

//$mode = 'xml';
$mode = 'json';
if(!is_array($sending_configs))
{
	echo "no";
	exit;
}
if(is_array($dhims2_test_counts))
{
	$icount = count($dhims2_test_counts);
	$scount = count($sending_configs );
	for($i=0;$i<$icount;$i++)
	{
		if($mode == 'json')
		{
			if(empty($sending_values))
			{
				$sending_values = prepareJSONValues($dhims2_test_counts[$i]);
			}
			else
			{
				
					$rtn_value = prepareJSONValues($dhims2_test_counts[$i]);
					if(!empty($rtn_value))
						$sending_values .= ', '.$rtn_value;
			}				
		}
		else
		{
					if(empty($sending_values))
					{
						$sending_values = prepareXMLValues($dhims2_test_counts[$i]);
					}
					else
					{
						
							$rtn_value = prepareXMLValues($dhims2_test_counts[$i]);
							if(!empty($rtn_value))
								$sending_values .= "\n".$rtn_value;
					}	
				
		}
	}	
	
	
			if(!empty($sending_values))
			{
				if($mode == 'json')
				{
					$data = $jsonsending_start.$sending_values.$jsonsending_end;
				}
				else
				{
					$data = $xmlsending_start.$sending_values.$xmlsending_end;
				}
								
				$return = sendtoDHIMS($data);
				if($return === 404 || empty($return))
				{
					echo "404";
				}
				else if($return === 401)
				{	
					echo "false";
				}
				else
				{
					//to do xml response
					if($mode == 'json')
					{
						$dhims2_reply = json_decode($return,true);
						if($dhims2_reply['status'] == 'ERROR')
						{
							echo "0";	
						}
						else
						{							
							sendCompleteDateData($data);
							echo $return;
						}
					}	
					
				}
				
			}
			else
			{
				echo "no";	
			}

}
else
{
	echo "no";
}

function prepareJSONValues($blis_count)
{
	global $sending_configs;
	global $scount;
	$info="";
	for($i=0;$i<$scount;$i++)
	{
		if(intval($blis_count['value']) == 0)
			continue;
			
		if(($sending_configs[$i]['blistestID'] == $blis_count['test_type_id']) 
			&& ($sending_configs[$i]['gender'] == $blis_count['gender']) 
			&& ($sending_configs[$i]['blisageGroup'] == $blis_count['age_group']))
		{
			//$info = '{ "dataSet": "'.$sending_configs[$i]['dataSet'].'", "period":"'.date('Ym',strtotime("-1 month")).'", "completeDate":"'.date('Y-m-d').'",';
		//$info .= '"orgUnit":"'.$sending_configs[$i]['orgUnit'].'", "dataValues": [';
		//$info .= ' { "dataElement":"'.$sending_configs[$i]['dataElement'].'", "categoryOptionCombo":"'.$sending_configs[$i]['categoryOptionCombo'].'", "value": "'.$blis_count['value'].'" }] }';
			$info ='{ "dataSet": "'.$sending_configs[$i]['dataSet'].'", "period":"'.date('Ym',strtotime("-1 month")).'", "completeDate":"'.date('Y-m-d').'",';
		$info .= '"orgUnit":"'.$sending_configs[$i]['orgUnit'].'", "dataElement":"'.$sending_configs[$i]['dataElement'].'", "categoryOptionCombo":"'.									$sending_configs[$i]['categoryOptionCombo'].'", "value": "'.$blis_count['value'].'" }';
			
			//$info ='{ "dataElement": "'.$sending_configs[$i]['dataElement'].'", "period":"'.date('Ym',strtotime("-1 month")).'", "orgUnit":"'.$sending_configs[$i]['orgUnit'].'","categoryOptionCombo":"'.$sending_configs[$i]['categoryOptionCombo'].'", "value": "'.$blis_count['value'].'" }';
			
		}
	}
	
	return $info;
}

function prepareXMLValues($blis_count)
{
	global $sending_configs;
	global $scount;
	$info="";
	for($i=0;$i<$scount;$i++)
	{
		if(intval($blis_count['value']) == 0)
			continue;
			
		if(($sending_configs[$i]['blistestID'] == $blis_count['test_type_id']) 
			&& ($sending_configs[$i]['gender'] == $blis_count['gender']) 
			&& ($sending_configs[$i]['blisageGroup'] == $blis_count['age_group']))
		{
			$info ='<dataValue dataSet= "'.$sending_configs[$i]['dataSet'].'" period="'.date('Ym',strtotime("-1 month")).'" completeDate= "'.date('Y-m-d').'"';
			$info .= ' orgUnit="'.$sending_configs[$i]['orgUnit'].'" dataElement= "'.$sending_configs[$i]['dataElement'].'" categoryOptionCombo="'.									$sending_configs[$i]['categoryOptionCombo'].'"  value= "'.$blis_count['value'].'"/>';
			
			//$info ='<dataValue dataElement="'.$sending_configs[$i]['dataElement'].'" period="'.date('Ym',strtotime("-1 month")).'"  orgUnit="'.$sending_configs[$i]['orgUnit'].'" categoryOptionCombo="'.$sending_configs[$i]['categoryOptionCombo'].'" value="'.$blis_count['value'].'" />';
			
		}
	}
	
	return $info;
}

function sendtoDHIMS($data)
{	
	global $mode;	
	
	$username = $_REQUEST['dhims2_username'];
	$password = $_REQUEST['dhims2_password'];
	
	$filename = "";
	$contenttype= "";	
	if($mode == 'json')
	{
		//$filename = "datavalueset.json";
		$contenttype = "application/json";	
	}
	else
	{
		//$filename = "datavalueset.xml";
		$contenttype = "application/xml";
	}
	
	//file_put_contents($filename, $data);	
	//$file_to_upload = array('data'=>'@'.realpath($filename)); 
	$URL = DHIMS2API::$mode == "test" ? DHIMS2API::$testBaseURL : DHIMS2API::$liveBaseURL;
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,"$URL/api/dataValueSets");		
	curl_setopt($ch,CURLOPT_HEADER,1);      
	curl_setopt($ch,CURLOPT_HTTPHEADER,array("Content-Type: $contenttype"));                               
	curl_setopt($ch, CURLOPT_POST,1); 
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	curl_setopt($ch, CURLOPT_USERPWD,"$username:$password");			
	$return = curl_exec($ch);	
	$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); 			
	curl_close($ch);	
	if($status_code === 200)
	{
		return $return;

	}
	else
	{
		return $status_code;
	}
}

///When I set complete Date along with the Bulk Data Sending Values; it does not take effect in DHIS. 
///So I decided to complete them individually.

//Todo:: look for a better way to implement this.
function sendCompleteDateData($data)
{
	$values = json_decode($data,true);
	$data_arr = array();
	$data_values = array();		
	for($i=0;$i<count($values["dataValues"]);$i++)
	{		
		if(!in_array($values["dataValues"][$i]["dataSet"],$data_arr))
		{
			$data_arr[] = $values["dataValues"][$i]["dataSet"];
			$tmp = array();
			$tmp["dataSet"] = $values["dataValues"][$i]["dataSet"];
			$tmp["period"] =  $values["dataValues"][$i]["period"];
			$tmp["orgUnit"] =  $values["dataValues"][$i]["orgUnit"];
			$tmp["completeDate"] =  $values["dataValues"][$i]["completeDate"];		
			$data_values[] = $tmp;
		}
	}
	unset($values);
	unset($data_arr);
	
	for($i=0;$i<count($data_values);$i++)
	{
		$data_json = json_encode($data_values[$i]);
		$data_json = trim($data_json,"[");
		$data_json = trim($data_json,"]");
		sendtoDHIMS($data_json);
	}	
}
?>