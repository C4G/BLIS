<?php
class DHIMS2API
{
	
	//public static $testBaseURL="https://apps.dhis2.org/demo";	
	//public static $testBaseURL ="https://www.ghsdhims.org/training";
	//public static $testBaseURL ="https://www.ghsdhims.org/tracker";
	public static $testBaseURL="http://localhost:8282/dhis";
	public static $liveBaseURL="https://www.ghsdhims.org/dhims";
	//public static $liveBaseURL="https://apps.dhis2.org/demo/";


	public static $mode ="live";
	
	public static function Authenticate($username="admin",$password="district")
	{
		
		$URL = DHIMS2API::$mode == "test" ? DHIMS2API::$testBaseURL : DHIMS2API::$liveBaseURL;
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,"$URL/dhis-web-commons-security/login.action?authOnly=true");		
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		curl_setopt($ch, CURLOPT_USERPWD,"$username:$password");			
		curl_exec($ch);
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); 		
		if($status_code ===302)
		{
			curl_setopt($ch,CURLOPT_URL,"$URL/api/currentUser");
			curl_setopt($ch,CURLOPT_HEADER,"application/json");
			curl_setopt($ch,CURLOPT_POST,0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
			$return=curl_exec($ch);
			$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
			curl_close($ch);							
			if($status_code ===200)
			{
				return $return;

			}
			else
			{
				return $status_code;
			}
		}		
		else
		{
			return $status_code;
		}
	}
	
	public static function getDataSets($orgUnitID,$username,$password)
	{		
		$URL = DHIMS2API::$mode == "test" ? DHIMS2API::$testBaseURL : DHIMS2API::$liveBaseURL;
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,"$URL/api/organisationUnits/$orgUnitID".'.json');	
		curl_setopt($ch,CURLOPT_HEADER,"application/json");	
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		curl_setopt($ch, CURLOPT_USERPWD,"$username:$password");			
		$return=curl_exec($ch);	
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); 			
		curl_close($ch);
		if($status_code ===200)
		{
			return $return;

		}
		else
		{
			return $status_code;
		}
	}
	
	public static function getDataElements($dataSetID,$username,$password)
	{		
		$URL = DHIMS2API::$mode == "test" ? DHIMS2API::$testBaseURL : DHIMS2API::$liveBaseURL;
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,"$URL/api/dataSets/$dataSetID".'.json');	
		curl_setopt($ch,CURLOPT_HEADER,"application/json");	
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		curl_setopt($ch, CURLOPT_USERPWD,"$username:$password");			
		$return=curl_exec($ch);	
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
		//file_put_contents("dhims2.txt", $status_code);	
		curl_close($ch);
		if($status_code ===200)
		{
			return $return;

		}
		else
		{
			return $status_code;
		}
	}
	
	public static function getDataElementsCombo($dataElementID,$username,$password)
	{		
		$URL = DHIMS2API::$mode == "test" ? DHIMS2API::$testBaseURL : DHIMS2API::$liveBaseURL;
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,"$URL/api/dataElements/$dataElementID".'.json');	
		curl_setopt($ch,CURLOPT_HEADER,"application/json");	
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		curl_setopt($ch, CURLOPT_USERPWD,"$username:$password");			
		$return=curl_exec($ch);	
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
		//file_put_contents("dhims2.txt", "$URL/api/dataElements/$dataElementID".'.json');	
		curl_close($ch);
		if($status_code ===200)
		{
			$dataelement = json_decode($return,true);
			$catcombo = $dataelement["categoryCombo"];
			if(!empty($catcombo))
			{				
				return DHIMS2API::getComboOptions($catcombo["href"],$username,$password);
			}
			else
			{
				return "true";
			}

		}
		else
		{
			return $status_code;
		}
	}
	private static function getComboOptions($url,$username,$password)
	{		
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,"$url".'.json');	
		curl_setopt($ch,CURLOPT_HEADER,"application/json");	
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		curl_setopt($ch, CURLOPT_USERPWD,"$username:$password");			
		$return=curl_exec($ch);	
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); 		
		curl_close($ch);
		if($status_code ===200)
		{			
			return $return;

		}
		else
		{
			return $status_code;
		}
	}
	
}
?>