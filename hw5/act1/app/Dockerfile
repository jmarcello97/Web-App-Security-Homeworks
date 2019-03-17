FROM php:7.2.1-apache

RUN apt-get update && \
    apt-get install -y zlib1g-dev
COPY armbook /var/www/html/
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
COPY server.crt /etc/apache2/ssl/
COPY server.key /etc/apache2/ssl/
COPY 000-default.conf /etc/apache2/sites-enabled/000-default.conf
#RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN docker-php-ext-install mysqli pdo pdo_mysql zip mbstring && docker-php-ext-enable mysqli
RUN a2enmod rewrite
RUN a2enmod ssl
RUN a2enmod http2
RUN service apache2 restart
EXPOSE 443
