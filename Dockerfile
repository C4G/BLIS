FROM ubuntu:noble

ARG PHP_VERSION="7.4"

# Install a bunch of stuff from the standard repositories
RUN apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install -y \
        apache2 \
        cron \
        curl \
        logrotate \
        mysql-client \
        pandoc \
        software-properties-common \
        sudo \
        weasyprint \
        && rm -rf /var/lib/apt/lists/*

# PPAs - additional software from questionable sources go here...
# Namely, pulling in PHP  here from a repo
RUN add-apt-repository ppa:ondrej/php && apt-get update && \
    DEBIAN_FRONTEND=noninteractive apt-get install -y \
        php$PHP_VERSION \
        php$PHP_VERSION-bcmath \
        php$PHP_VERSION-curl \
        php$PHP_VERSION-gd \
        php$PHP_VERSION-mysql \
        php$PHP_VERSION-zip \
        php$PHP_VERSION-mbstring \
        php$PHP_VERSION-xml \
        && rm -rf /var/lib/apt/lists/*

# This is a mysqldump configuration option required in this environment to
# preserve backwards compatibility with earlier versions of mysqldump
RUN echo "column-statistics = 0" | tee -a /etc/mysql/conf.d/mysqldump.cnf

# Copy the custom Apache2 config (blis.conf) into the
# Apache2 configuration directory. This will be enabled by the start-blis.sh
COPY docker/config/blis-release.conf /etc/apache2/sites-available/blis-release.conf

# Enable Apache2 modules needed by application and disable default site
RUN a2enmod rewrite socache_shmcb ssl && \
    a2dissite 000-default && \
    a2ensite blis*

# Copy custom PHP config into the container
COPY docker/config/php.ini /etc/php/$PHP_VERSION/apache2/php.ini

# Copy logrotate configuration into container
COPY docker/config/logrotate-blis.conf /etc/logrotate.d/blis

# Copy utility scripts to /usr/bin
COPY docker/bin/start-blis.sh /usr/bin/start-blis

# Copy all of the BLIS files into the container
RUN mkdir /var/www/blis
COPY . /var/www/blis
RUN chown -R www-data:www-data /var/www && \
    chmod +x /var/log/apache2 && \
    chmod +r /var/log/apache2/* && \
    echo ". /var/www/apache2_blis.env" >> /etc/apache2/envvars

# Inject the current git commit SHA as a build parameter
# This isn't foolproof, but will help when someone is using the
# distributed Docker container, so we can see this and know what version it is.
ARG GIT_COMMIT_SHA=""
RUN echo "${GIT_COMMIT_SHA}" | tee /etc/blis_git_commit_sha

# Expose port 80 for HTTP
EXPOSE 80

STOPSIGNAL SIGWINCH

CMD ["/usr/bin/start-blis"]
