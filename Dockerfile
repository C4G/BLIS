FROM ubuntu:focal

# Install a bunch of stuff from the standard repositories
RUN apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install -y \
        apache2 \
        curl \
        gpg \
        htop \
        mysql-client \
        software-properties-common

# PPAs - additional software from questionable sources go here...
# Namely, pulling in PHP 5.6 here from a repo
RUN add-apt-repository ppa:ondrej/php && apt-get update && \
    DEBIAN_FRONTEND=noninteractive apt-get install -y \
        php5.6 \
        php5.6-curl \
        php5.6-gd \
        php5.6-mysql \
        php5.6-zip \
        php5.6-mbstring \
        php5.6-xml

RUN echo "column-statistics = 0" | tee -a /etc/mysql/conf.d/mysqldump.cnf

# Copy the custom Apache2 config (blis.conf) into the 
# Apache2 configuration directory and enable it.
COPY docker/config/blis-release.conf /etc/apache2/sites-available/blis-release.conf
RUN rm /etc/apache2/sites-enabled/000-default.conf && \
    ln -s /etc/apache2/sites-available/blis-release.conf /etc/apache2/sites-enabled/blis-release.conf && \
    a2enmod rewrite

COPY docker/config/php.ini /etc/php/5.6/apache2/php.ini

RUN mkdir /var/www/blis
COPY . /var/www/blis
RUN chown -R www-data:www-data /var/www/blis

ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid
ENV APACHE_RUN_DIR /var/run/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2

RUN mkdir -p /var/lock/apache2

EXPOSE 80

CMD rm -f $APACHE_PID_FILE \
    && /usr/sbin/apache2 \
    & tail -f /var/log/apache2/error.log