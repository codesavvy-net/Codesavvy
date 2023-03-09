FROM php:8.2-apache-buster

ARG DEBIAN_FRONTEND=noninteractive

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
RUN echo "expose_php = false" | tee -a "$PHP_INI_DIR/php.ini"
RUN echo "memory_limit = 64M" | tee -a "$PHP_INI_DIR/php.ini"
RUN echo "post_max_size = 8M" | tee -a "$PHP_INI_DIR/php.ini"
RUN echo "upload_max_filesize = 2M"  | tee -a "$PHP_INI_DIR/php.ini"

RUN echo "<VirtualHost *>" > /etc/apache2/sites-enabled/000-default.conf
RUN echo "    ServerAdmin webmaster@localhost" >> /etc/apache2/sites-enabled/000-default.conf
RUN echo "    DocumentRoot /var/www/html/public" >> /etc/apache2/sites-enabled/000-default.conf
RUN echo "    ServerName localhost" >> /etc/apache2/sites-enabled/000-default.conf
RUN echo "</VirtualHost>" >> /etc/apache2/sites-enabled/000-default.conf

RUN apt-get -y update --fix-missing && \
  apt-get upgrade -y && \
  apt-get --no-install-recommends install -y apt-utils

RUN docker-php-ext-install pdo_mysql

RUN a2enmod rewrite headers

WORKDIR /var/www/html

COPY . .

RUN rm -rf /var/lib/apt/lists/* && \
  rm -rf /usr/src/* && \
  curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

EXPOSE 80
