#!/bin/bash

if ! command -v apt-get >/dev/null; then
    echo "Could not find apt-get... are you running Ubuntu?"
    exit 1
fi

if [[ -z "$(sudo echo hello)" ]]; then
    echo "Could not obtain root access with sudo!"
    exit 1
fi

export DEBIAN_FRONTEND=noninteractive

echo "--> Removing old versions of Docker..."
sudo apt-get remove -q docker docker-engine docker.io containerd runc

echo -e "\n--> Installing prerequisites..."
sudo apt-get update -q
sudo apt-get install -q -y ca-certificates curl gnupg lsb-release jq

echo -e "\n--> Downloading Docker repository key..."
sudo mkdir -p /etc/apt/keyrings
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o - | sudo tee /etc/apt/keyrings/docker.gpg >/dev/null

echo -e "--> Adding Docker repository..."
echo "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

echo -e "--> Installing Docker..."
sudo apt-get update -q
sudo apt-get install -q -y docker-ce docker-ce-cli containerd.io docker-compose-plugin

echo -e "\n--> Docker installation completed!"
echo -e "--> Downloading BLIS support files..."

SETUP_DIR="$HOME/blis"
if [[ ! -d "$SETUP_DIR" ]]; then
    mkdir "$SETUP_DIR"
fi
cd "$SETUP_DIR" || exit 1

echo -e "--> Downloading docker-compose.yml..."
curl -s "https://raw.githubusercontent.com/C4G/BLIS/master/docker/docker-compose.yml" > docker-compose.yml

echo -e "--> Downloading database seed files..."
if [[ ! -d database ]]; then
    mkdir database
fi
cd database || exit 1
curl -s https://api.github.com/repos/c4g/blis/contents/docker/database | jq '.[] | .["download_url"]' | xargs wget -N -nv {} \;

cd "$SETUP_DIR" || exit 1

echo -e "\n--> Done downloading BLIS!"

if [[ "$USER" != "root" ]]; then
    echo -e "--> Adding $USER to docker group..."
    sudo usermod -aG docker "$USER"
    echo -e "\n--> Please log out and log back in to this server to continue."
fi


