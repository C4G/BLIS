#!/bin/bash

set -eo pipefail

echo "Dumping environment variables to environment file..."

A2ENVVARS="$(env | grep -E "(^DB_|^BLIS_)" | sed -e 's/^/export /')"
echo "$A2ENVVARS" > /var/www/apache2_blis.env

if [[ -f "/etc/blis_git_commit_sha" ]]; then
    GIT_COMMIT_SHA="$(cat /etc/blis_git_commit_sha 2>/dev/null)"
fi

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

# Remove the PID file if it exists from the last run, or apache2 won't start
rm -f /var/run/apache2/apache2.pid

# If BLIS_USERNAME is defined, we want to override the default apache2 user
if [[ -n "$BLIS_USERNAME" ]]; then
    sed -i "/^export APACHE_RUN_USER=www-data/c\export APACHE_RUN_USER=$BLIS_USERNAME" /etc/apache2/envvars
    sed -i "/^export APACHE_RUN_GROUP=www-data/c\export APACHE_RUN_GROUP=$BLIS_USERNAME" /etc/apache2/envvars
fi

# Override the log directory for local/Docker development
if [[ -d "/workspaces/BLIS/log" ]]; then
    sed -i "/^export APACHE_LOG_DIR=/c\export APACHE_LOG_DIR=/workspaces/BLIS/log" /etc/apache2/envvars
fi

apachectl -DFOREGROUND

