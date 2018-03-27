#!/bin/bash

# Enable debugging
set -x

DAILY_LOCK=/tmp/vagrant-daily-lock-$(date +%Y%m%d)

sudo apt-get install python-software-properties

test -f /etc/apt/sources.list.d/ondrej-ubuntu-php-xenial.list || sudo add-apt-repository -y ppa:ondrej/php

# Commands to provision only once per day
# It's annoying to keep doing apt updates each time you are working on a manifest
if [ ! -e "$DAILY_LOCK" ]; then
    apt-get -q -y update

fi

sudo debconf-set-selections <<< "mysql-server mysql-server/root_password password awesome_password"
sudo debconf-set-selections <<< "mysql-server mysql-server/root_password_again password awesome_password"

sudo apt-get -y --allow-unauthenticated install mysql-server mysql-client apache2 php7.2 libapache2-mod-php7.2 php-mysql php7.2-mysql

cat << EOF > /etc/apache2/sites-available/000-default.conf
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/html/public
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined

    <Directory /var/www/html/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
EOF

sudo a2enmod rewrite

systemctl restart apache2

# stop commands running too often
touch "$DAILY_LOCK"

