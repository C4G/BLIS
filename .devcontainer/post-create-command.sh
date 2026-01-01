#!/bin/bash

echo "export PATH=\"$HOME/.local/bin:\$PATH\"" | tee -a "$HOME/.bashrc"
# shellcheck disable=SC1091
source "$HOME/.bashrc"

#python3 -m venv ~/venv-mkdocs
#~/venv-mkdocs/bin/pip3 install -r requirements.txt
#mkdir -p ~/.local/bin && ln -s ~/venv-mkdocs/bin/mkdocs ~/.local/bin/mkdocs

