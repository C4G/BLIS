@echo off
echo This script will attempt to repair the database files.
echo Please make sure mysqld.exe is not running before continuing.
echo ENSURE YOU HAVE A BACKUP BEFORE CONTINUING.
pause

"%~dp0\..\server\mysql\bin\mysqladmin.exe" -h"127.0.0.1" --port 7188 -uroot -pblis123 shutdown
timeout 10

"%~dp0\..\server\php\php.exe" "%~dp0\windows_repair_mysql.php" "blis_revamp"
"%~dp0\..\server\php\php.exe" "%~dp0\windows_repair_mysql.php" "blis_127"
"%~dp0\..\server\php\php.exe" "%~dp0\windows_repair_mysql.php" "blis_1"

pause
