<?php
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Functions for date calculations and date formatting
#

include_once(__DIR__."/../lang/lang_util.php");

class DateLib
{
	public static function dateDiff($dformat, $endDate, $beginDate)
	{
		# Calculates difference between two dates
		# Input date format m, d, Y
		$date_parts1=explode($dformat, $beginDate);
		$date_parts2=explode($dformat, $endDate);
		$start_date=gregoriantojd($date_parts1[0], $date_parts1[1], $date_parts1[2]);
		$end_date=gregoriantojd($date_parts2[0], $date_parts2[1], $date_parts2[2]);
		return $end_date - $start_date;
	}

	public static function dobToAge($dob)
	{
		# Converts date of birth to age in years/months
		/*
		$today = date("m-d-Y");
		$dob_array = explode("-", $dob); # gives Y-m-d
		$dob_formatted = $dob_array[1]."-".$dob_array[2]."-".$dob_array[0];
		$diff = round(floor(DateLib::dateDiff("-", $today, $dob_formatted)/365), 0);
		if($diff >= 2)
		{
			return $diff." ".LangUtil::$generalTerms['YEARS'];
		}
		else
		{
			$diff = round(floor(DateLib::dateDiff("-", $today, $dob_formatted)/30), 0);
			if($diff >= 2)
			{
				return "$diff ".LangUtil::$generalTerms['MONTHS'];
			}
			else
			{
				$diff = round(floor(DateLib::dateDiff("-", $today, $dob_formatted)%31), 0);
				return "$diff ".LangUtil::$generalTerms['DAYS'];
			}
		}
		*/
		$labConfig = LabConfig::getById($_SESSION['lab_config_id']);

		$today = date('Y-m-d');
		$diff = abs(strtotime($today) - strtotime($dob));

		# explode below gives Y-m-d (Required, because the difference function to get years, months & days is approximate.
		# Therefore if current day is same as dob day, do display days.
		$dob_array = explode("-", $dob);
		$today_array = explode("-", $today);
		$value = "";

		$years = floor($diff / (365*60*60*24));
		if( $years >= $labConfig->ageLimit ) {
			$value .= $years . " " . LangUtil::$generalTerms['YEARS'];
		}
		else {
			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

			if ( $years > 0 )
				$value .= $years . " " . LangUtil::$generalTerms['YEARS'];
			if ( $months > 0 ) {
				if ( $years > 0 )
					$value .= ", ";
				$value .= $months . " " . LangUtil::$generalTerms['MONTHS'];
			}

			if($dob_array[2] != $today_array[2]) {
				if ( $days > 0 ) {
					if ( $months > 0 || $years > 0 )
						$value .= ", ";
					$value .= $days . " " .LangUtil::$generalTerms['DAYS'] . " ";
				}
			}
		}
		return $value;
	}

	public static function dobToAgeNumber($dob)
	{
		# Converts date of birth to age in years without appendin string " years"
		$today = date("m-d-Y");
		$dob_array = explode("-", $dob); # gives Y-m-d
		$dob_formatted = $dob_array[1]."-".$dob_array[2]."-".$dob_array[0];
		$diff = round(DateLib::dateDiff("-", $today, $dob_formatted)/365, 0);
		return $diff;
	}

	public static function mysqlToString($date, $lab_config=null)
	{
		# Converts MySQL date format to the one chosen in lab configuration
		# Input in "Y-m-d" format
		$target_format = "";
		if($lab_config == null)
		{
			# Fetch format from session variable
			$target_format = $_SESSION['dformat'];
		}
		else
		{
			# Fetch format from lab config
			$target_format = $lab_config->dateFormat;
		}
		$date_parts = explode("-", $date);
		$retval = date($target_format, mktime(0, 0, 0,(int)$date_parts[1], (int)$date_parts[2], (int)$date_parts[0]));
		return $retval;
	}
}
?>
