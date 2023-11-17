#!/bin/bash

set -euo pipefail

if ! command -v apt-get >/dev/null; then
    echo "Could not find apt-get... are you running Ubuntu?"
    exit 1
fi

if [[ -z "$(sudo echo hello)" ]]; then
    echo "Could not obtain root access with sudo!"
    exit 1
fi

sudo DEBIAN_FRONTEND=noninteractive apt-get update
sudo DEBIAN_FRONTEND=noninteractive apt-get install -y python3-pip

MUST_RELOGIN=""

# Check if the user is root and they do not have their local bin/
# in their PATH (if they are root, they do not need this)
if [[ "$EUID" != "0" && "$PATH" != *"$HOME/.local/bin" ]]; then
    echo "export PATH=\"$HOME/.local/bin:\$PATH\"" | tee -a ~/.bashrc
    source ~/.bashrc
    MUST_RELOGIN="true"
fi

if ! command -v docker; then
    echo "--> Removing old versions of Docker..."
    # Use set +e to enable proceeding on an error.
    # This command might fail, if the packages aren't installed...
    # And that's OK!

    set +e
    sudo DEBIAN_FRONTEND=noninteractive apt-get remove -q docker docker-engine docker.io containerd runc
    set -e

    echo -e "\n--> Installing prerequisites..."
    sudo DEBIAN_FRONTEND=noninteractive apt-get update -q
    sudo DEBIAN_FRONTEND=noninteractive apt-get install -q -y ca-certificates curl gnupg lsb-release jq

    echo -e "\n--> Downloading Docker repository key..."
    sudo mkdir -p /etc/apt/keyrings
    curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o - | sudo tee /etc/apt/keyrings/docker.gpg >/dev/null

    echo -e "--> Adding Docker repository..."
    echo "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

    echo -e "--> Installing Docker..."
    sudo DEBIAN_FRONTEND=noninteractive apt-get update -q
    sudo DEBIAN_FRONTEND=noninteractive apt-get install -q -y docker-ce docker-ce-cli containerd.io docker-compose-plugin docker-buildx-plugin

    sudo systemctl enable docker.service
    sudo systemctl start docker.service

    sudo usermod -aG docker "$USER"
    MUST_RELOGIN="true"

    echo -e "\n--> Docker installation completed!"
fi

sudo pip3 install --force-reinstall git+https://github.com/mrysav/blis-cloud-cli.git

if [[ -n "$MUST_RELOGIN" ]]; then
    echo "You must log out and log back in to begin using BLIS."
    echo "After you log in, run:"
    echo "  blis install"
else
    # If we don't have to relogin, and blis was installed, we should be on our way...
    blis install
fi
