#!/usr/bin/env bash
sudo DEBIAN_FRONTEND=noninteractive apt-get -y install mysql-server

DB=$1;
mysql -uroot -e "DROP DATABASE IF EXISTS $DB";
mysql -uroot -e "CREATE DATABASE $DB";
