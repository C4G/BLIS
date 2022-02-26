FROM ubuntu:focal

# THIS IS A DEVCONTAINER
# This is not a production-ready Dockerfile.
# See the documentation here to see why devcontainers are awesome:
# https://code.visualstudio.com/docs/remote/containers

# Install a bunch of stuff from the standard repositories
RUN apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install -y \
        apache2 \
        bash-completion \
        curl \
        git \
        gpg \
        htop \
        mysql-client \
        p7zip \
        shellcheck \
        software-properties-common \
        sudo \
        tmux \
        unzip \
        vim

# Install overmind
RUN curl -L https://github.com/DarthSim/overmind/releases/download/v2.2.2/overmind-v2.2.2-linux-amd64.gz > /tmp/overmind.gz \
  && gunzip /tmp/overmind.gz \
  && mv /tmp/overmind /usr/local/bin \
  && chmod +x /usr/local/bin/overmind

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
# Apache2 configuration directory and enable it.
COPY docker/config/blis-dev.conf /etc/apache2/sites-available/blis.conf
RUN rm /etc/apache2/sites-enabled/000-default.conf && \
    ln -s /etc/apache2/sites-available/blis.conf /etc/apache2/sites-enabled/blis.conf && \
    a2enmod rewrite

# Copy custom php.ini into the container
RUN cp /etc/php/5.6/apache2/php.ini /etc/php/5.6/apache2/php.ini.original
COPY docker/config/php.ini /etc/php/5.6/apache2/php.ini

# Modify the www-data user (which Apache runs as) to be usable by us and give it password-less sudo
# Also add the www-data user to the adm group so we can view some logs
RUN usermod -aG sudo www-data && \
    usermod -aG adm www-data && \
    chown -R www-data:www-data /var/www && \
    chsh -s /bin/bash www-data && \
    echo '%sudo ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers
USER www-data
WORKDIR /workspace