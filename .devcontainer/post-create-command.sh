#!/bin/bash

export DEBIAN_FRONTEND=noninteractive

echo "export PATH=\"$HOME/.local/bin:\$PATH\"" | tee -a "$HOME/.bashrc"
# shellcheck disable=SC1091
source "$HOME/.bashrc"

sudo apt-get update
sudo apt-get install -y python3 python3-venv libpango-1.0-0 libpangoft2-1.0-0 php-cli
python3 -m venv ~/.mkdocs/
~/.mkdocs/bin/pip3 install -r requirements.txt
mkdir -p ~/.local/bin && ln -s ~/.mkdocs/bin/mkdocs ~/.local/bin/mkdocs
