FROM php:7.3.4-apache

LABEL Name "Zippysoft PHP Routing Example"
LABEL Version="0.1"
LABEL Author="Justin Dearing <zippy1981@gmail.com>"

VOLUME [ "/var/www/html" ]

EXPOSE 80/tcp
EXPOSE 443/tcp

RUN curl -sS https://getcomposer.org/installer \
 | php -- --install-dir=/usr/local/bin --filename=composer \
 && a2enmod rewrite \
 && sed -i 's!/var/www/html!/var/www/public!g' /etc/apache2/sites-available/000-default.conf

#RUN composer install --prefer-source --no-interaction