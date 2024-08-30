<?php
#
# Contains debugging related methods
#

require_once("composer.php");

class DebugLib
{
	public static function getCallerFunctionName($backtrace)
	{
		# Returns the name of the caller function
		# i.e. for the function which called this method
		# Uses result of debug_backtrace()
		return $backtrace[1]['function'];
	}

	public static function getCurrentFunctionName()
	{
		# Returns the name of the current function
		# i.e. the function which called this method
		$backtrace = debug_backtrace();
		return $backtrace[1]['function'];
	}

	public static function browserInfo($agent=null)
	{
		// Declare known browsers to look for
		$known = array('msie', 'firefox', 'safari', 'webkit', 'opera', 'netscape',
			'konqueror', 'gecko');

		// Clean up agent and build regex that matches phrases for known browsers
		// (e.g. "Firefox/2.0" or "MSIE 6.0" (This only matches the major and minor
		// version numbers.  E.g. "2.0.0.6" is parsed as simply "2.0"
		$agent = strtolower($agent ? $agent : $_SERVER['HTTP_USER_AGENT']);
		$pattern = '#(?<browser>' . join('|', $known) .
			')[/ ]+(?<version>[0-9]+(?:\.[0-9]+)?)#';

		// Find all phrases (or return empty array if none found)
		if (!preg_match_all($pattern, $agent, $matches))
			return array();

		// Since some UAs have more than one phrase (e.g Firefox has a Gecko phrase,
		// Opera 7,8 have a MSIE phrase), use the last one found (the right-most one
		// in the UA).  That's usually the most correct.
		$i = count($matches['browser'])-1;
		return array($matches['browser'][$i] => $matches['version'][$i]);
	}

	public static function isOldIe()
	{
		$browser_info = DebugLib::browserInfo();
		if(key($browser_info) == 'msie' && $browser_info[key($browser_info)] != '8.0')
		{
			return true;
		}
		return false;
	}

	public static function logQuery($query_string, $db_name, $username)
	{
        global $db_log;

		$lab_config_id = null;
		if (isset($_SESSION['lab_config_id'])) {
			$lab_config_id = $_SESSION['lab_config_id'];
		}

		# Adds current query to log
        date_default_timezone_set("UTC");
		$file_name = __DIR__."/../../local/log_".$lab_config_id.".txt";
		$file_handle = null;
		if(file_exists($file_name))
			$file_handle = fopen($file_name, "a");
		else
			$file_handle = fopen($file_name, "w");
		$timestamp = date("Y-m-d H:i:s");
		$log_line = $timestamp."\t".$username."\t".$db_name."\t".$query_string."\n";

        $db_log->debug("[database: $db_name] [application user: $username] $query_string");

		fwrite($file_handle, $log_line);
		fclose($file_handle);
	}

	public static function logDBUpdates($query_string, $db_name)
	{
		$lab_config_id = null;
		if (isset($_SESSION['lab_config_id'])) {
			$lab_config_id = $_SESSION['lab_config_id'];
		}

		# Adds current query to update log
		$file_name = __DIR__."/../../local/log_".$lab_config_id."_updates.sql";
		$file_name_revamp = __DIR__."/../../local/log_".$lab_config_id."_revamp_updates.sql";
		$file_handle = null;
		$file_handle_revamp = null;

		if(file_exists($file_name)) {
			$file_handle = fopen($file_name, "a");
		}
		else {
			$file_handle = fopen($file_name, "w");
			fwrite($file_handle, "USE blis_".$lab_config_id.";\n\n");
		}

		if(file_exists($file_name_revamp)) {
			$file_handle_revamp = fopen($file_name_revamp, "a");
		}
		else {
			$file_handle_revamp = fopen($file_name_revamp, "w");
			fwrite($file_handle_revamp, "USE blis_revamp;\n\n");
		}

		$timestamp = date("Y-m-d H:i:s");
		$log_line = $timestamp."\t".$query_string."\n";
		$pos = stripos($query_string, "SELECT");

        if($pos === false) {
			if($db_name=="blis_revamp")
				fwrite($file_handle_revamp, $log_line);
			else
				fwrite($file_handle, $log_line);
        }

		fclose($file_handle);
		fclose($file_handle_revamp);
	}

	#TODO: Add or transfer other debugging related functions here
}
?>
