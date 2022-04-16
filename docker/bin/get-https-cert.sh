#!/bin/bash

if [[ -z "$BLIS_SERVER_NAME" ]]; then
    echo "You need to set BLIS_SERVER_NAME as an environment variable in the docker-compose.yml file."
    exit 1
fi

if ! set-apache2-servername.py; then
    echo "Could not set Apache2 ServerName."
    exit 1
fi

certbot --apache