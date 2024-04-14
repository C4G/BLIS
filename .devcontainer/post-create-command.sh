#!/bin/bash

echo "export PATH=\"$HOME/.local/bin:\$PATH\"" | tee -a "$HOME/.bashrc"
# shellcheck disable=SC1091
source "$HOME/.bashrc"

pip3 install -r requirements.txt
