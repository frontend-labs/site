FROM richarvey/nginx-php-fpm 

# Create app directory
RUN mkdir -p /var/www/site
WORKDIR /var/www/site

COPY . /var/www/site/

