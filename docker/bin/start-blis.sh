#!/bin/bash

echo "Dumping environment variables to environment file..."
A2ENVVARS="$(env | grep DB_ | sed -e 's/^/export /')"
echo "$A2ENVVARS" > /var/www/blis/files/apache2_blis.env

if ! grep -q 'apache2_blis.env' /etc/apache2/envvars; then
    echo "Adding BLIS environment variables to Apache2 configuration..."
    echo ". /var/www/blis/files/apache2_blis.env" >> /etc/apache2/envvars
fi

# This is a little funky...
# The container build puts the config in /etc/apache2, but this is not the correct place for it.
# The reason for this is so you can mount a volume to /etc/apache2/sites-available to persist your changes.
# When the container starts, it will only overwrite the configuration with the default if the file doesn't
# exist already.
if [[ ! -f "/etc/apache2/sites-available/blis-release.conf" ]]; then
    if [[ -f "/etc/apache2/blis-release.conf" ]]; then
        echo -e "Thanks for setting up BLIS! Just getting some things in place..."
        mv /etc/apache2/blis-release.conf /etc/apache2/sites-available/blis-release.conf
        # Set the ServerName properly, according to the environment
        BLIS_APACHE2_CONFIG="/etc/apache2/sites-available/blis-release.conf" set-apache2-servername.py
    else
        echo "The blis-release.conf Apache2 configuration is not present. Did the container build correctly?"
        exit 1
    fi
fi

if [[ -f "/etc/apache2/sites-available/blis-release-le-ssl.conf" ]]; then
    echo "Detected an SSL configuration!"
fi

a2ensite blis-release*

service apache2 start