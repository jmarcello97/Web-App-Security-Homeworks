FROM php:7.2.1-apache

#RUN rm /var/www/html/index.html
#COPY armbook /usr/local/apache2/htdocs/armbook
COPY index.html /var/www/html/
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
EXPOSE 81

