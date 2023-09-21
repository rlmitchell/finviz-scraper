FROM php:8.1-apache
RUN cd /etc/apache2/mods-enabled && ln -s ../mods-available/rewrite.load
RUN mkdir /var/www/html/api
COPY api/* /var/www/html/api/
COPY api/.htaccess /var/www/html/api/.htaccess
RUN chown -R www-data:www-data /var/www/html
