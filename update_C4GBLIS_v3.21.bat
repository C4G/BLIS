@echo ON

For /f "tokens=2-4 delims=/ " %%a in ('date /t') do (set mydate=%%c-%%a-%%b)
For /f "tokens=1-2 delims=/:" %%a in ("%TIME%") do (set mytime=%%a%%b)
set ts="%mydate%_%mytime%"
	
:checksumcheck
	echo Updating to C4G BLIS v3.21... Please wait...
	if not exist htdocs.zip goto failurezip
	if not exist md5.exe goto failuremd
	md5 -2BC35F41B66A6338EFE2FFBCD8B71588   htdocs.zip
	IF ERRORLEVEL 1 goto checksumfailure
	IF ERRORLEVEL 0 goto checksumsuccess
	goto checkfailure

:updation
	if not exist 7za.exe goto failureza
	echo 7za.exe file exists
	echo Backing up the present version of BLIS...
	ren htdocs htdocs_backup_%ts%
	if "%errorlevel%"=="1" goto failurefolder
	echo Backup complete.
	echo .

	echo Starting C4G BLIS v3.21 source code update...
	echo Extracting htdocs.zip...
	7za x htdocs.zip -aoa>tmpFile2
	if "%errorlevel%"=="1" goto extractionfailure
	del tmpFile2
	echo Code update complete.
	goto success

:failuremd
	echo md5.exe not found!
	echo BLIS Update failed!
	goto eof
	
:checksumsuccess
	echo Update file verified to be correct.
	goto updation
	
:checksumfailure
	echo htdocs.zip file is corrupt!
	echo Redownload the update files and start the update process again.
	goto eof
	
:success
	echo Creating Desktop Shortcut 
	xxmklink "C:\Users\%username%\Desktop\BLIS.lnk" "%cd%\BLIS.exe" "" "%cd%" 
	echo C4G BLIS updated Successfully to v3.21!
	echo Starting C4G BLIS v3.21 ...
	start BLIS.exe
	goto eofExit

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


:checkfailure
	if exist del tmpFile2
	echo Error occurred during file verification
	echo BLIS Update Failed!
	echo Try again.
	echo If error persists, email dsaiteja@gatech.edu to report this error.
	goto eof

:extractionfailure
	if exist del tmpFile2
	echo Error occurred during file extraction
	echo BLIS Update Failed!
	echo Try again.
	echo If error persists, email dsaiteja@gatech.edu to report this error.
	goto eof

:eof
	if exist del tmpFile
	if exist del tmpFile2
	ping -n 100 -w 1000 0.0.0.1 > NUL

:eofExit
	if exist del tmpFile
	if exist del tmpFile2
	exit
