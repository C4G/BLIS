@echo OFF

For /f "tokens=2-4 delims=/ " %%a in ('date /t') do (set mydate=%%c-%%a-%%b)
For /f "tokens=1-2 delims=/:" %%a in ("%TIME%") do (set mytime=%%a%%b)
set ts="%mydate%_%mytime%"

set currentDirectory=%CD%
set pathToMySQL=\server\mysql\bin\mysql.exe
set completePath="%currentDirectory%%pathToMySQL%"

:execution
	echo Updating to C4G BLIS v2.0... Please wait...
	
	echo Backing up the present version of BLIS...
	ren htdocs htdocs_backup_%ts%
	if "%errorlevel%"=="1" goto failurefolder

	if not exist htdocs.zip goto failurezip
	
	echo Backup complete.
	echo .
	
	echo Now updating to BLIS v2.0...
	7za x htdocs.zip -aoa>tmpFile2
	if "%errorlevel%"=="1" goto failure
	del tmpFile2
	echo Code update complete.
	echo .
	
	set databaseName=blis_revamp
	set sqlFilePath="%CD%\blis_revamp_labcfg_update.sql"
	
	echo Now updating database configuration...
	%completePath% --host=localhost --port=7188 --user=root --password=blis123 %databaseName% < %sqlFilePath% > tmpFile
	if "%errorlevel%"=="1" goto failuredb
	set /p dbCommandOutput= < tmpFile
	del tmpFile
	echo Database configuration update compelete.
	echo .
	
:success
	echo C4G BLIS updated Successfully to v2.0!
	goto eof

:failurezip
	echo htdocs.zip not found!
	echo BLIS Update failed!
	goto eof

:failurefolder
	echo htdocs folder not found!
	echo BLIS Update Failed!
	echo Refer to manual_update_instructions.txt in the BLIS folder to update to C4G BLIS v2.0 manually.	
	goto eof	

	
:failure
	if exist del tmpFile2
	echo BLIS Update Failed!
	echo Refer to manual_update_instructions.txt in the BLIS folder to update to C4G BLIS v2.0 manually.	
	goto eof	

:failuredb
	del tmpFile
	echo Error in updating database!
	echo Make sure BLIS is running before you apply this update...
	echo BLIS Update Failed!
	goto eof
	
:eof
	if exist del tmpFile
	if exist del tmpFile2
	ping -n 100 -w 1000 0.0.0.1 > NUL