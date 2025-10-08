#!/bin/bash

echo "export PATH=\"$HOME/.local/bin:\$PATH\"" | tee -a "$HOME/.bashrc"
# shellcheck disable=SC1091
source "$HOME/.bashrc"

# Set vscode as owner of /workspaces
sudo chown vscode:vscode /workspaces/

# For the BLIS folder specifically, we will apply specific ACLs
WORKSPACE_FOLDER="/workspaces/BLIS"

# Remove all existing ACLs recursively
sudo setfacl -R -b "$WORKSPACE_FOLDER"

# Grant www-data all access to directory recursively
# (capital X means execute bit is set for directories only)
sudo setfacl -R -m u:www-data:rwX "$WORKSPACE_FOLDER"

# Set default ACL recursively to give www-data access to new files and folders too
sudo setfacl -R -m d:u:www-data:rwx "$WORKSPACE_FOLDER"

python3 -m venv ~/venv-mkdocs
~/venv-mkdocs/bin/pip3 install -r requirements.txt
mkdir -p ~/.local/bin && ln -s ~/venv-mkdocs/bin/mkdocs ~/.local/bin/mkdocs

