#!/usr/bin/env bash
# Last updated: 2017-01-16

sudo yum-config-manager --enable epel

# LAMP
echo "[OVASE] Installing LAMP stack"
sudo yum install -y httpd24 php56 mysql55-server php56-mysqlnd
sudo yum install -y php56-pecl-apc
sudo yum install -y phpMyAdmin
# Composer
sudo curl -sS https://getcomposer.org/installer | sudo php
sudo mv composer.phar /usr/local/bin/composer
sudo ln -s /usr/local/bin/composer /usr/bin/composer
# Can now run: sudo composer install

# Other
echo "[OVASE] Installing essential tools"
sudo yum install -y git
sudo yum install -y gcc gcc-c++ make

# Node and Parsoid
echo "[OVASE] Installing Parsoid dependencies"
curl --silent --location https://rpm.nodesource.com/setup_6.x | bash -
sudo yum -y install nodejs

# TODO: Parsoid cloning and installing
