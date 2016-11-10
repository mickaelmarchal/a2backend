FROM php:7.0-apache

# Install PHP plugins
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng12-dev \
    libmcrypt-dev \
    libxslt-dev \
    unzip \
    imagemagick \
    mysql-client \
    default-jre \
  && docker-php-ext-install \
    pdo_mysql \
    mysqli \
    mbstring \
    gd \
    iconv \
    mcrypt \
    xsl \
    pcntl \
#    ldap \  # not working, missing ldap.h
  && rm -rf /var/lib/apt/lists/*


# Install Composer
RUN cd $HOME &&\
    curl -sS https://getcomposer.org/installer | php &&\
    chmod +x composer.phar &&\
    mv composer.phar /usr/local/bin/composer

# Install Symfony CLI
RUN cd $HOME &&\
    curl -LsS https://symfony.com/installer -o /usr/local/bin/symfony &&\
    chmod a+x /usr/local/bin/symfony

# Install dev tools: phing, PHPUnit, PHPDox, PHPCodeSniffer, Robo.li with user "dev"
RUN useradd -ms /bin/bash dev
USER dev

# Note: first line is necessary due to Robo.li not being available in stable version at the moment. Remove this later.
RUN composer global config minimum-stability RC &&\
    composer global require "phing/phing=2.*" &&\
    composer global require "phpunit/phpunit=*" &&\
    composer global require "theseer/phpdox=@stable" &&\
    composer global require "phpmetrics/phpmetrics" &&\
    composer global require "consolidation/robo:~1"


USER root
ENV PATH $PATH:/home/dev/.composer/vendor/bin/


# Create project directories
RUN mkdir /var/www/html/a2backend


# PHP config
COPY ./php.ini /usr/local/etc/php/


# Apache SSL certificates
RUN mkdir /etc/apache2/ssl
COPY ./ssl-cert.key /etc/apache2/ssl/ssl-cert.key
COPY ./ssl-cert.crt /etc/apache2/ssl/ssl-cert.crt


# Apache config and virtual hosts
RUN a2enmod ssl rewrite &&\
    rm -rf /etc/apache2/sites-enabled/* &&\
    rm -rf /etc/apache2/sites-available/*

COPY ./apache2.conf /etc/apache2/conf-enabled/docker.conf
COPY ./vhosts.conf /etc/apache2/sites-available/000-vhost.conf
RUN a2ensite 000-vhost.conf


# using "local" environment for app
ENV APPLICATION_ENV local

# Expose http and https ports
EXPOSE 80 443

# By default, start apache in foreground
CMD ["apache2-foreground"]
