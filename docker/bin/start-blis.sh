#!/bin/bash

echo "Dumping environment variables to environment file..."

A2ENVVARS="$(env | grep -E "(^DB_|^BLIS_)" | sed -e 's/^/export /')"
echo "$A2ENVVARS" > /var/www/apache2_blis.env

GIT_COMMIT_SHA="$(cat /etc/blis_git_commit_sha 2>/dev/null)"
if [[ -n "$GIT_COMMIT_SHA" ]]; then
    echo "export GIT_COMMIT_SHA=\"$GIT_COMMIT_SHA\"" >> /var/www/apache2_blis.env
fi

if [[ -d /var/www/blis ]]; then
    if [[ ! -d /var/www/blis/files ]]; then
        echo "/var/www/blis/files does not exist. Please mount this as a Docker volume."
    else
        if [[ ! -d /var/www/blis/files/backups ]]; then
            echo "Creating /var/www/blis/files/backups"
            sudo mkdir /var/www/blis/files/backups
        fi

        if [[ ! -d /var/www/blis/files/storage ]]; then
            echo "Creating /var/www/blis/files/storage"
            sudo mkdir /var/www/blis/files/storage
        fi

        sudo chown -R www-data:www-data /var/www/blis/files/
    fi
fi

sudo service cron start
sudo service apache2 start

echo "BLIS is running!"
