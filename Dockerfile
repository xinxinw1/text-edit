FROM php:7.4-apache

RUN a2enmod rewrite

COPY public/ /var/www/html/
RUN chown -R www-data:www-data /var/www

EXPOSE 80
CMD ["apache2-foreground"]
