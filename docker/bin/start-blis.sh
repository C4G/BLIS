#!/bin/bash

echo "Dumping environment variables to environment file..."
A2ENVVARS="$(env | grep DB_ | sed -e 's/^/export /')"
echo "$A2ENVVARS" > /var/www/blis/files/apache2_blis.env

if ! grep -q 'apache2_blis.env' /etc/apache2/envvars; then
    echo "Adding BLIS environment variables to Apache2 configuration..."
    echo ". /var/www/blis/files/apache2_blis.env" >> /etc/apache2/envvars
fi

if [[ ! -f "/etc/apache2/sites-available/blis-release.conf" ]]; then
    if [[ -f "/etc/apache2/blis-release.conf" ]]; then
        echo -e "Thanks for setting up BLIS! Just getting some things in place..."
        mv /etc/apache2/blis-release.conf /etc/apache2/sites-available/blis-release.conf
    else
        echo "The blis-release.conf Apache2 configuration is not present. Did the container build correctly?"
        exit 1
    fi
fi

set-apache2-servername.py

a2enmod rewrite

a2ensite blis-release

if [[ -f "/etc/apache2/sites-available/blis-release-le-ssl.conf" ]]; then
    echo "Detected an SSL configuration... enabling Apache2 modules"
    a2enmod socache_shmcb ssl
    a2ensite blis-release-le-ssl
fi

service apache2 start