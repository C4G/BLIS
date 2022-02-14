#!/bin/bash

# Apply modifications to the php.ini file
sudo cp /etc/php/5.6/apache2/php.ini /etc/php/5.6/apache2/php.ini.original
sudo patch /etc/php/5.6/apache2/php.ini < /workspaces/BLIS/.devcontainer/config/php.ini.patch

# Apply modification to the my.cnf file for mysqldump
echo "column-statistics = 0" | sudo tee -a /etc/mysql/conf.d/mysqldump.cnf

# wait for mysql database container to come awake
printf "Waiting for MySQL"
until mysqladmin ping -h 127.0.0.1 -uroot -pblis123 2>/dev/null; do
    printf "."
    sleep 1
done
echo

# Create and seed the database
# Database root password is set in docker-compose.yml
mysql -h 127.0.0.1 -uroot -pblis123 -e "create database blis_revamp;"
mysql -h 127.0.0.1 -uroot -pblis123 blis_revamp < /workspaces/BLIS/.devcontainer/database/dump-blis_12-202202091919.sql
mysql -h 127.0.0.1 -uroot -pblis123 blis_revamp < /workspaces/BLIS/.devcontainer/database/dump-blis_127-202202091919.sql
mysql -h 127.0.0.1 -uroot -pblis123 blis_revamp < /workspaces/BLIS/.devcontainer/database/dump-blis_revamp-202202091919.sql

