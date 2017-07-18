#!/bin/bash

# PhalconPhp with PHP7 installation on ubuntu:16.04

######################################
### TO INSTALL PHP 7.1, YOU NEED ####
### THIS REPOSITORY ADDED         ###
### *** FOR PHP 7.0 COMMENT THIS  ###
#####################################
sudo add-apt-repository ppa:ondrej/php
######################################

sudo apt-get update 

sudo apt-get install -y apache2 mysql-server mysql-client

sudo mysql_secure_installation

sudo apt-get install -y php-mysql php-curl php-json php-cgi libapache2-mod-php php php7.1-fpm php7.1-cli php7.1-curl php7.1-gd php7.1-intl php7.1-pgsql php7.1-mbstring php7.1-xml php-msgpack curl vim wget git gcc make re2c libpcre3-dev php7.1-dev build-essential php7.1-zip redis-server htop

# Install composer
sudo curl -sS http://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install zephir
sudo composer global require "phalcon/zephir:dev-master" 

# Install phalcon dev tool 
git clone git://github.com/phalcon/phalcon-devtools.git
cd phalcon-devtools/
. ./phalcon.sh

#maybe file exists
sudo ln -s ~/phalcon-devtools/phalcon.php /usr/bin/phalcon

#maybe
chmod ugo+x /usr/bin/phalcon

sudo curl -s "https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh" | sudo bash
sudo apt-get install php7.1-phalcon
#sudo echo "extension=phalcon.so" >> /etc/php/7.0/fpm/conf.d/20-phalcon.ini
#sudo echo "extension=phalcon.so" >> /etc/php/7.0/cli/conf.d/20-phalcon.ini

#sudo echo "extension=phalcon.so" >> /etc/php/7.1/fpm/conf.d/20-phalcon.ini
#sudo echo "extension=phalcon.so" >> /etc/php/7.1/cli/conf.d/20-phalcon.ini


# some additional php settings if you care
#sudo sed -i "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/g" /etc/php/7.0/cli/php.ini 
#sudo sed -i "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/g" /etc/php/7.0/fpm/php.ini
#sudo sed -i "s/memory_limit = 128M/memory_limit = 256M /g" /etc/php/7.0/fpm/php.ini

sudo sed -i "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/g" /etc/php/7.1/cli/php.ini 
sudo sed -i "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/g" /etc/php/7.1/fpm/php.ini
sudo sed -i "s/memory_limit = 128M/memory_limit = 256M /g" /etc/php/7.1/fpm/php.ini


sudo a2enmod php7.1

#sudo phpenmod phalcon

# restart php-fpm
#sudo service php7.0-fpm restart
sudo service apache2 restart
