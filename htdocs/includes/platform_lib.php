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

	public static function mySqlClientPath() {
		$currentDir = dirname(realpath(__FILE__));
		if(self::runningOnWindows()) {
			// If running on Windows, assume that we're running the portable/traditional
			// version of BLIS, and use the bundled mysql.
			return "../../server/mysql/bin/mysql.exe";
		} else {
			// Otherwise, assume that mysql is in the system PATH.
			// This should work on Linux!
			return "mysql";
		}
	}

	public static function copyDirectory($source, $dest) {
		$command = "";
		if(self::runningOnWindows()) {
			// The 'C: &' is an apparently useless convention that prevents Windows from failing
			// to execute a command with too many double-quotes.
			$command = "C: & xcopy /s /y \"$source\" \"$dest\"";
		} else {
			$command = "cp -r \"$source\" \"$dest\"";
		}

		$result = 1;
		system($command, $result);

		return $result === 0;
	}
}
?>