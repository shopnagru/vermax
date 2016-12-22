apt-get update
apt-get upgrade
apt-get install openssh-server apache2 php5 mysql-server libapache2-mod-php5 php5-mysql unrar phpmyadmin
mkdir /var/www/html/updatevermax
a2enmod rewrite
rm /etc/apache2/sites-available/updatevermax.conf
wget http://172.16.16.117/vermax.rar
unrar x ./vermax.rar /var/www/html/updatevermax/
chown -R root:root /var/www/html/updatevermax/
cp /var/www/html/updatevermax/updatevermax.conf /etc/apache2/sites-available/updatevermax.conf
a2dissite 000-default && sudo a2ensite updatevermax
apache2ctl restart
mysql -u root -pvermax < /var/www/html/updatevermax/vermax.sql