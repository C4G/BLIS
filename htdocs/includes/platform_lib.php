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
		if(self::runningOnWindows()) {
			// If running on Windows, assume that we're running the portable/traditional
			// version of BLIS, and use the bundled mysqldump.
			$exe_path = realpath(dirname(__FILE__)."/../../server/mysql/bin/mysqldump.exe");
            // https://www.php.net/manual/en/function.escapeshellcmd.php
            return preg_replace('`(?<!^) `', '^ ', escapeshellcmd('"'.$exe_path.'"'));
		} else {
			// Otherwise, assume that mysqldump is in the system PATH.
			// This should work on Linux!
			return "mysqldump";
		}

	}

	public static function mySqlClientPath() {
		if(self::runningOnWindows()) {
			// If running on Windows, assume that we're running the portable/traditional
			// version of BLIS, and use the bundled mysql.
            $exe_path = realpath(dirname(__FILE__)."\..\..\server\mysql\bin\mysql.exe");
			return preg_replace('`(?<!^) `', '^ ', escapeshellcmd('"'.$exe_path.'"'));
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

	public static function removeDirectory($dir)
    {
        $it = new RecursiveDirectoryIterator($dir);//, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator(
            $it,
            RecursiveIteratorIterator::CHILD_FIRST
        );
        foreach ($files as $file) {
            if ($file->isDir()) {
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        rmdir($dir);
    }
}
?>
