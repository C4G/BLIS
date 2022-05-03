New-Item -ItemType Directory -Path "Build-BLIS/" -Force
Push-Location -Path "Build-BLIS/"

$runtime_url = "https://github.com/C4G/BLISRuntime/archive/refs/heads/main.zip"
$code_url = "https://github.com/C4G/BLIS/archive/refs/heads/master.zip"

Write-Host "Downloading BLIS Runtime..."
Invoke-WebRequest -Uri $runtime_url -OutFile "BLISRuntime.zip"

Write-Host "Downloading BLIS code..."
Invoke-WebRequest -Uri $code_url -OutFile "BLISCode.zip"

Expand-Archive "BLISRuntime.zip" -DestinationPath "."
Expand-Archive "BLISCode.zip" -DestinationPath "."

Move-Item -Path "BLIS-master" -Destination "BLIS"
Get-ChildItem -Path "BLISRuntime-main" | Move-Item -Destination "BLIS/"

Compress-Archive -Path BLIS -DestinationPath BLIS.zip

Pop-Location

Move-Item -Path "Build-BLIS/BLIS.zip" -Destination BLIS.zip
Remove-Item -Force -Path "Build-BLIS"

Write-Host -ForegroundColor Green "Done!"