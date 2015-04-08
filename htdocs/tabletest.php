<?php
function dateDiff($dformat, $endDate, $beginDate)
	{
		# Calculates difference between two dates
		# Input date format m, d, Y
		$date_parts1=explode($dformat, $beginDate);
		$date_parts2=explode($dformat, $endDate);
		$start_date=gregoriantojd($date_parts1[0], $date_parts1[1], $date_parts1[2]);
		$end_date=gregoriantojd($date_parts2[0], $date_parts2[1], $date_parts2[2]);
		return $end_date - $start_date;
	}

function dobToAgeNumber($dob)
	{
		# Converts date of birth to age in years without appendin string " years" 
		$today = date("m-d-Y");
		$dob_array = explode("-", $dob); # gives Y-m-d
		$dob_formatted = $dob_array[1]."-".$dob_array[2]."-".$dob_array[0];
		$diff = round(dateDiff("-", $today, $dob_formatted), 0);
		return $diff;
	}
	
	//echo dobToAgeNumber("2013-04-24").'<br/>';	
	
	/* $l_age_s = "-1 day day";
    $l_age_t = strtotime($l_age_s);
    $l_age_d = date('Y-m-d', $l_age_t);
	echo  $l_age_d;
	
	 $u_yr = date('Y') - $l_age_d;
	echo '<br>'.$u_yr;*/
	
	///echo date('Ym',strtotime("-1 month"))."</b>";
	//echo date('Y')."</b>";
	
	
	print_r(getallheaders());
	echo "\n\n";
	echo file_get_contents('php://input');
	 
       