FROM webdevops/php-apache-dev:7.2

LABEL maintainer="gonzalo4@gmail.com"

# Update apt-get
RUN apt-get -y update

# Install composer
RUN curl -sS https://getcomposer.org/installer | php \
&& mv composer.phar /usr/local/bin/composer