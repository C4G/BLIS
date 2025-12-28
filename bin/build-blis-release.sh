#!/bin/bash

set -euo pipefail

if ! command -v curl >/dev/null; then
    echo "You must have curl installed to continue."
    exit 1
fi

if ! command -v unzip >/dev/null || ! command -v zip >/dev/null; then
    echo "You must have zip & unzip installed to continue."
    exit 1
fi

echo -e "Creating $(pwd)/dist/ and downloading BLIS release files."

read -n 1 -s -r -p "Press any key to continue "

echo ""

mkdir -p dist/Build-BLIS || exit 1
cd dist/Build-BLIS || exit 1

echo "Downloading C4G/BLISRuntime..."
curl --silent -L "https://github.com/C4G/BLISRuntime/archive/refs/heads/main.zip" > BLISRuntime.zip &
echo "Downloading C4G/BLIS..."
curl --silent -L "https://github.com/C4G/BLIS/archive/refs/heads/main.zip" > BLISCode.zip &

wait

unzip BLISRuntime.zip &
unzip BLISCode.zip &

wait

mkdir BLIS-Standalone/
mkdir BLIS-Upgrade/

cp -r BLISRuntime-main/* BLIS-Standalone/ &
cp -r BLIS-main/* BLIS-Standalone/ &

cp -r BLIS-main/* BLIS-Upgrade/ && rm -rf BLIS-Upgrade/local/ &
cp -r BLISRuntime-main/server BLIS-Upgrade/server &

wait

zip -r BLIS-Standalone.zip BLIS-Standalone/ &
zip -r BLIS-Upgrade.zip BLIS-Upgrade/ &

wait

rm -rf BLIS-main/
rm -rf BLISRuntime-main/

rm BLISCode.zip
rm BLISRuntime.zip

rm -rf BLIS-Standalone/
rm -rf BLIS-Upgrade/

mv BLIS-*.zip ../

cd .. || exit 1
rm -rf Build-BLIS/
