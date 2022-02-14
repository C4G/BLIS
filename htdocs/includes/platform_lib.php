<?php

/**
 * Functions that provide access to resources on the system that BLIS is running on.
 */
class PlatformLib {
    public static function runningOnWindows() {
		// PHP_OS will have something like "Windows XXX..." or "Linux..."
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			return true;
		}
		return false;
	}

	public static function mySqlDumpPath() {
		$currentDir = dirname(realpath(__FILE__));
		if(self::runningOnWindows()) {
			// If running on Windows, assume that we're running the portable/traditional
			// version of BLIS, and use the bundled mysqldump.
			return "../../server/mysql/bin/mysqldump.exe";
		} else {
			// Otherwise, assume that mysqldump is in the system PATH.
			// This should work on Linux!
			return "mysqldump";
		}

	}
}
?>