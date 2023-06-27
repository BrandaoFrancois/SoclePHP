#!/bin/sh
#
# Installation script of a LAMP server
#  - PHP 7.4
#  - Maria DB
# Warning: The security installed is basic. You are in charge of improving your server security.
#   Tips: Close unused port, disable unused php functionnalities, user writes, ...
# author: Brandao Francois
#

# Step zero: Security of the server
apt install -y fail2ban

# Step One: Installation LAMP

echo "Apache 2 Installation"
apt install -y apache2 apache2-util libapache2-mod-evasive

apt install -y php7.4 php7.4-mysql php-common php7.4-cli php7.4-common php7.4-json php7.4-opcache php7.4-realine

apt install -y mariadb-server

# Step Two: Configuration

echo "Secure Apache"
a2enmod security2

echo "Secure Database"
mysql_secure_installation

echo "Secure PHP"
phpIniFile=`php --ini | grep "Loaded" | sed "s/^.*: *//"`
cp "$phpIniFile" "$phpIniFile.old"
sed -i "s/^display_errors *=.*$/display_errors=Off/" "$phpIniFile"
sed -i "s/^expose_php *=.*$/expose_php=Off/" "$phpIniFile"
sed -i "s/^file_uploads *=.*$/file_uploads=Off/" "$phpIniFile"

echo "Giving access to user"
read -p "Type the user authorized to modify the website:" user
chown -R "$user" /var/www/html/

# Step Three: Configuration Optionnal

echo "Rewrite activation"
a2enmod rewrite
systemctl restart apache2

echo "Installation of the .htaccess file"
cd /var/www/html/;
echo "  - Configuration du htpasswd"
read -p "Choose a login to access website:" login
htpasswd -mc "/.htpasswd" "$login"
chown -R "$user" .htpasswd

cd -;
