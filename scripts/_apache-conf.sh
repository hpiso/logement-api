sudo apt-get -y install apache2

block="
<VirtualHost *:80>
    ServerName $1
    ServerAlias www.$1

    DocumentRoot $2
    <Directory $2>
        DirectoryIndex index.php
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
"

sudo mkdir -p "/etc/apache2/sites-available" "/etc/apache2/sites-enabled"
sudo echo "$block" > "/etc/apache2/sites-available/$1.conf"
sudo a2ensite $1.conf
sudo systemctl restart apache2
