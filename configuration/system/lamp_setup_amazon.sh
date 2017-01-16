#!/usr/bin/env bash
# Last updated: 2017-01-16

echo "This script has two parts, since the user must re-log in the middle. Have you ran the first part already? y/n [ENTER]:"

read answer

if [ $answer == "n" ]; then
    # Start httpd
    sudo service httpd start
    # Let it start at boot
    sudo chkconfig httpd on

    # File permissions
    sudo groupadd www
    sudo usermod -a -G www ec2-user

    echo "Type 'exit' to log out, then log back in"
elif [ $answer == "y" ]; then
    # Let www group own www folder
    sudo chown -R root:www /var/www
    # Fix file permissions
    sudo chmod 2775 /var/www
    find /var/www -type d -exec sudo chmod 2775 {} \;
    find /var/www -type f -exec sudo chmod 0664 {} \;
    # Other
    sudo mysql_secure_installation
    sudo service mysqld restart
    sudo chkconfig mysqld on

    echo "Remaning work:"
    echo "  - Edit '/etc/httpd/conf.d/phpMyAdmin.conf' to allow outside access"
    echo "  - Restart mysqld"
    echo "  - Secure server with https"
fi


