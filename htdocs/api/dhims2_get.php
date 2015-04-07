<?php
//This is just a test to retrieve Data from DHIS2
$URL = "https://www.ghsdhims.org/training";
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,"$URL/api/dataValueSets?dataSet=BjNYPEBRvRF&period=201408&orgUnit=eNgj8sPldci");		
	curl_setopt($ch,CURLOPT_HEADER,"application/json");
	curl_setopt($ch,CURLOPT_POST,0);	 
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);	
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	curl_setopt($ch, CURLOPT_USERPWD,"Stephen Adjei:Stephen2014");			
	$return = curl_exec($ch);	
	echo $return;
?>