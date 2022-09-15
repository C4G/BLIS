#!/bin/bash

DIR="$(dirname "$0")"
cd "$DIR" || exit

mkdir ../dist/Build-BLIS
cd ../dist/Build-BLIS || exit
 
curl -L "https://github.com/C4G/BLISRuntime/archive/refs/heads/main.zip" > BLISRuntime.zip &
curl -L "https://github.com/C4G/BLIS/archive/refs/heads/master.zip" > BLISCode.zip &

wait

unzip BLISRuntime.zip &
unzip BLISCode.zip &

wait

mkdir BLIS-Standalone/
mkdir BLIS-Upgrade/

cp -r BLISRuntime-main/* BLIS-Standalone/ &
cp -r BLIS-master/* BLIS-Standalone/ &

cp -r BLIS-master/* BLIS-Upgrade/ && rm -rf BLIS-Upgrade/local/ &
cp -r BLISRuntime-main/server BLIS-Upgrade/server &

wait

zip -r BLIS-Standalone.zip BLIS-Standalone/ &
zip -r BLIS-Upgrade.zip BLIS-Upgrade/ &

wait

rm -rf BLIS-master/
rm -rf BLISRuntime-main/

rm BLISCode.zip
rm BLISRuntime.zip

rm -rf BLIS-Standalone/
rm -rf BLIS-Upgrade/

mv BLIS-*.zip ../