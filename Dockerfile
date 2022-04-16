FROM ubuntu:focal

# Install a bunch of stuff from the standard repositories
RUN apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install -y \
        apache2 \
        curl \
        gpg \
        htop \
        mysql-client \
        software-properties-common \
        certbot \
        python3-certbot-apache

# PPAs - additional software from questionable sources go here...
# Namely, pulling in PHP 5.6 here from a repo
RUN add-apt-repository ppa:ondrej/php && apt-get update && \
    DEBIAN_FRONTEND=noninteractive apt-get install -y \
        php5.6 \
        php5.6-bcmath \
        php5.6-curl \
        php5.6-gd \
        php5.6-mysql \
        php5.6-zip \
        php5.6-mbstring \
        php5.6-xml

RUN echo "column-statistics = 0" | tee -a /etc/mysql/conf.d/mysqldump.cnf

# Copy the custom Apache2 config (blis.conf) into the 
# Apache2 configuration directory. This will be enabled by the start-blis.sh
COPY docker/config/blis-release.conf /etc/apache2/blis-release.conf
ENV BLIS_APACHE2_CONFIG /etc/apache2/sites-available/blis-release.conf

COPY docker/config/php.ini /etc/php/5.6/apache2/php.ini

# Copy utility scripts to /usr/bin
COPY docker/bin/set-apache2-servername.py /usr/bin/
COPY docker/bin/get-https-cert.sh /usr/bin/
COPY docker/bin/start-blis.sh /usr/bin/

RUN mkdir /var/www/blis
COPY . /var/www/blis
RUN chown -R www-data:www-data /var/www/blis

EXPOSE 80
EXPOSE 443

CMD start-blis.sh && tail -f /var/log/apache2/error.log