# PGSProject

LINUX
1. To run our project fist you need to install LAMP (Linux, Apache, MySQL and PHP). To accoplish this process just follow  steps under this link https://www.atlantic.net/community/howto/install-linux-apache-mysql-php-lamp-stack-on-ubuntu-16-04/.

2. After that add the code below to the 00-default.conf (/etc/apache2/sites-availble/). It is necessary to allow .htaccess files.

<*/VirtualHost>
<*Directory "/var/www/html">
  AllowOverride All
<*/Directory>

3. Put zend directory to /var/www/html/. Then type this -> (localhost/zend/public) to the address bar. Enjoy!
  
