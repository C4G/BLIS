@echo off
Rem BEFORE RUNNING THIS SCRIPT PLEASE ENSURE YOU HAVE BACKUPS
Rem This is a work-in-progress script to perform the upgrade from 3.7.2 to 3.8
Rem While this script has been tested and seems to work it has not yet been deployed to a partner
Rem This script is only for BLIS local or non-docker deployments
Rem If you get this script running or want to test it do the following
Rem 1. Ensure you have a full BACKUPS
Rem 2. Make sure curl is installed on the machine or ideally packaged with BLIS
Rem 3. Copy it to the root of the BLIS folder
Rem 4. Ensure BLIS is shutdown
Rem 5. Run the script
Rem 6. Once complete, login to BLIS and perform the upgrade
Rem 7. If everything is complete you should be upgraded to BLIS 3.8

set majorv=3
set minorv=8

set downloadpath=%~dp0
set filename=%majorv%_%minorv%_upgrade.zip
set downloadto=%downloadpath%%filename%
set urlversion=v%majorv%-%minorv%
set url=http://blis.cc.gatech.edu/files/C4GBLIS_%urlversion%_update_files.zip
set upgradeversion=%majorv%.%minorv%
set upgradefolder=C4GBLIS_v%upgradeversion%_Upgrade
set upgradepath=%downloadpath%%upgradefolder%

echo Downloading %version% upgrade files
curl -o %downloadto% %url%

cd %downloadpath%

echo Unzipping upgrade
7za.exe x %filename%

echo Copying upgrade files
xcopy /s /e /y /r %upgradepath% .

echo Removing upgrade folder
rmdir /s /q %upgradefolder%

echo Removing upgrade zip

del %downloadto%

echo Upgrade complete, complete the upgrade in BLIS

PAUSE