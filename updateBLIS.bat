@echo OFF

For /f "tokens=2-4 delims=/ " %%a in ('date /t') do (set mydate=%%c-%%a-%%b)
For /f "tokens=1-2 delims=/:" %%a in ("%TIME%") do (set mytime=%%a%%b)
set ts="%mydate%_%mytime%"

:execution
	echo Updating to C4G BLIS v2.1... Please wait...
	
	if not exist htdocs.zip goto failurezip
	
	if not exist 7za.exe goto failureza
	
	echo Backing up the present version of BLIS...
	ren htdocs htdocs_backup_%ts%
	if "%errorlevel%"=="1" goto failurefolder

	if not exist htdocs.zip goto failurezip
	
	echo Backup complete.
	echo .
	
	echo Now updating to BLIS v2.1...
	7za x htdocs.zip -aoa>tmpFile2
	if "%errorlevel%"=="1" goto failure
	del tmpFile2
	echo Code update complete.
	
:success
	echo C4G BLIS updated Successfully to v2.1!
	echo Now close this window and start BLIS.
	goto eof

:failurezip
	echo htdocs.zip not found!
	echo BLIS Update failed!
	goto eof

:failureza
	echo 7za.exe not found!
	echo BLIS Update failed!
	goto eof	
	
:failurefolder
	echo htdocs folder not found!
	echo BLIS Update Failed!
	goto eof	

	
:failure
	if exist del tmpFile2
	echo BLIS Update Failed!
	echo Email naomichopra@gatech.edu to report this error.
	goto eof	

	
:eof
	if exist del tmpFile
	if exist del tmpFile2
	ping -n 100 -w 1000 0.0.0.1 > NUL