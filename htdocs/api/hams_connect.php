<?php
include('../adodb5/adodb.inc.php');  
class HAMS
{
	function getConn()
	{
		$conn = ADONewConnection("mssql");  // create a connection
		$conn->Connect('localhost','stevkky','stevo177','hams_BlissDB') or die('Fail');
	}
	
	public static function getOrder($patientID="")
	{
		$conn = getConn();
		$sql="select * from order_from_hams where Processed=0";
		if(!empty($patientID))
			$sql.= " and PatientID ='".$patientID."'";			
		$recordSet = &$conn->Execute($sql);
		if (!$recordSet) 
			return NULL;
		else
		{
			$Orders = array();			
			while (!$recordSet->EOF) 
			{
				$row = array();
				$row['ID'] = $recordSet->fields[0];
				$row['PatientID'] = $recordSet->fields[1];
				$row['PatientName'] = $recordSet->fields[2];
				$row['Sex'] = $recordSet->fields[3];
				$row['Age'] = $recordSet->fields[4];
				$row['SpecimenID'] = $recordSet->fields[5];
				$row['TestID'] = $recordSet->fields[6];
				$row['RequestedDoctor'] = $recordSet->fields[7];
				$row['OrderedTime'] = $recordSet->fields[8];
				$row['Processed'] = $recordSet->fields[9];
				
				$Orders[] = $row;
				$recordSet->MoveNext();			
			}
			
			return $Orders;
		}

	}
	
	function setProcessed($id)
	{
		$conn = getConn();
		$conn->Execute("UPDATE  order_from_hams set Processed=1 where ID = ".$id);
	}
	
	public static function sendtoHAMS($ElementID,$Result,$TestRange,$Units,$Comment,$ValidatedDate,$UserID)
	{
		$ElementID = getHAMSElementID($ElementID);
		$conn = getConn();
		$sql ="insert into Results_to_HAMS(ID,ElementID,Result,TestRange,Units,Comment,ValidatedDate,TimeStamp,UserID,Processed) 
		 values(NULL,'$ElementID','$Result','$TestRange','$Units','$Comment','$ValidatedDate',now(),'$UserID',0)";
		$conn->Execute($sql);
	}
	
	function getHAMSElementID($blismeasureid)
	{
		$conn = getConn();
		$recordSet = &$conn->Execute("select HAMSID from TEST_ELEMENTS_MAPPING where BLISID =".$blismeasureid);
		if (!$recordSet) 
			return NULL;
		else
		{
			if(!$recordSet->EOF) 
			{
				return $recordSet->fields[0];
			}
			else
			{
				return 0;
			}
		}
	}
}