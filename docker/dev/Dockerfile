FROM ubuntu:noble

ARG PHP_VERSION="7.4"

ARG MNT_UID=1000
ARG MNT_GID=1000

ARG BLIS_USERNAME="blis"

RUN echo "Setting ownership of dev directory to $MNT_UID:$MNT_GID" && \
    groupadd -o -g "${MNT_GID}" "${BLIS_USERNAME}" && \
    cat /etc/passwd && \
    useradd -o -u "${MNT_UID}" -g "${MNT_GID}" "${BLIS_USERNAME}"

# Install a bunch of stuff from the standard repositories and a custom PHP repository
RUN apt-get update && apt-get install -y software-properties-common && \
    add-apt-repository ppa:ondrej/php && apt-get update && \
    DEBIAN_FRONTEND=noninteractive apt-get install -y \
        apache2 \
        curl \
        mysql-client \
        unzip \
        zip \
        php$PHP_VERSION \
        php$PHP_VERSION-bcmath \
        php$PHP_VERSION-curl \
        php$PHP_VERSION-gd \
        php$PHP_VERSION-mysql \
        php$PHP_VERSION-zip \
        php$PHP_VERSION-mbstring \
        php$PHP_VERSION-xml \
        && rm -rf /var/lib/apt/lists/*

RUN echo "column-statistics = 0" | tee -a /etc/mysql/conf.d/mysqldump.cnf

# Copy the custom Apache2 config (blis.conf) into the
# Apache2 configuration directory and enable it.
COPY docker/config/blis-dev.conf /etc/apache2/sites-available/blis.conf

RUN rm /etc/apache2/sites-enabled/000-default.conf && \
    ln -s /etc/apache2/sites-available/blis.conf /etc/apache2/sites-enabled/blis.conf && \
    a2enmod rewrite && \
    echo ". /var/www/apache2_blis.env" >> /etc/apache2/envvars

# Copy custom php.ini into the container
RUN cp /etc/php/$PHP_VERSION/apache2/php.ini /etc/php/$PHP_VERSION/apache2/php.ini.original
COPY docker/config/php.ini /etc/php/$PHP_VERSION/apache2/php.ini

COPY docker/bin/start-blis.sh /usr/bin/start-blis

# Modify the www-data user (which Apache runs as) to be usable by us and give it password-less sudo
# Also add the www-data user to the adm group so we can view some logs
RUN touch /var/www/apache2_blis.env && chown ${BLIS_USERNAME}:${BLIS_USERNAME} /var/www/apache2_blis.env

ENV BLIS_USERNAME="${BLIS_USERNAME}"

STOPSIGNAL SIGWINCH

CMD ["/usr/bin/start-blis"]
