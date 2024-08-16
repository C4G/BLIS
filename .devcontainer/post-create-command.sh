#!/bin/bash

echo "export PATH=\"$HOME/.local/bin:\$PATH\"" | tee -a "$HOME/.bashrc"
# shellcheck disable=SC1091
source "$HOME/.bashrc"

# Set ACL on /workspace so that www-data can do what it wants
sudo setfacl -R -m u:www-data:rwX /workspace

pip3 install -r requirements.txt
