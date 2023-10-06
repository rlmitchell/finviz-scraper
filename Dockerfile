FROM php:8.1-apache
RUN cd /etc/apache2/mods-enabled && ln -s ../mods-available/rewrite.load
RUN mkdir /var/www/html/api
COPY api/* /var/www/html/api/
COPY api/.htaccess /var/www/html/api/.htaccess
RUN chown -R www-data:www-data /var/www/html

# docker run -d --rm --name finviz-scraper --net host finviz-scraper:20230920.2046
