#!/bin/bash

echo "Dumping environment variables to environment file..."

A2ENVVARS="$(env | grep -E "(^DB_|^BLIS_)" | sed -e 's/^/export /')"
echo "$A2ENVVARS" > /var/www/apache2_blis.env

GIT_COMMIT_SHA="$(cat /etc/blis_git_commit_sha 2>/dev/null)"
if [[ -n "$GIT_COMMIT_SHA" ]]; then
    echo "export GIT_COMMIT_SHA=\"$GIT_COMMIT_SHA\"" >> /var/www/apache2_blis.env
fi

# if [[ -d "/workspace" ]]; then
#     # add sticky bit so all files remain belonging to vscode:vscode
#     find /workspace -type d -exec sudo chmod ug+s {} \;
# fi

sudo service cron start
sudo service apache2 start

echo "BLIS is running!"
