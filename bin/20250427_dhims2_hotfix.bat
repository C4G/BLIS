@echo off
echo 2025 April 27
echo dhims2_api_config Hotfix
echo This script will remove dhims2_api_config.frm and dhims2_api_config.ibd from the dbdir/blis_revamp folder.
echo CLOSE THIS WINDOW IF YOU DO NOT WISH TO DO THIS.
pause

"%~dp0\..\server\mysql\bin\mysqladmin.exe" -h"127.0.0.1" --port 7188 -uroot -pblis123 shutdown
timeout 10

del "%~dp0\..\dbdir\blis_revamp\dhims2_api_config.frm"
del "%~dp0\..\dbdir\blis_revamp\dhims2_api_config.ibd"

echo Script is complete.
pause
