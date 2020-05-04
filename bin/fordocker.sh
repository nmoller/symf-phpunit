#!/usr/bin/env bash

set -e
##########################
## From:
# https://github.com/moodlehq/moodle-php-apache/blob/master/root/tmp/setup/php-extensions.sh
#
#

# Build packages will be added during the build, but will be removed at the end.
BUILD_PACKAGES="gettext gnupg libcurl4-openssl-dev libfreetype6-dev libicu-dev libjpeg62-turbo-dev \
  libldap2-dev libmariadbclient-dev libmemcached-dev libpng-dev libpq-dev libxml2-dev libxslt-dev \
  unixodbc-dev uuid-dev"

# Packages for Postgres.
PACKAGES_POSTGRES="libpq5"

# Packages for MariaDB and MySQL.
PACKAGES_MYMARIA="libmariadb3"

# Packages for other Moodle runtime dependenices.
PACKAGES_RUNTIME="ghostscript libaio1 libcurl4 libgss3 libicu63 libmcrypt-dev libxml2 libxslt1.1 \
  libzip-dev locales sassc unixodbc unzip zip"

# Packages for Memcached.
PACKAGES_MEMCACHED="libmemcached11 libmemcachedutil2"

# Packages for LDAP.
PACKAGES_LDAP="libldap-2.4-2"

apt-get update
apt-get install -y --no-install-recommends apt-transport-https wget \
    $BUILD_PACKAGES \
    $PACKAGES_POSTGRES \
    $PACKAGES_MYMARIA \
    $PACKAGES_RUNTIME \
    $PACKAGES_MEMCACHED \
    $PACKAGES_LDAP

##Symfony client
wget https://get.symfony.com/cli/installer -O - | bash
mv /root/.symfony/bin/symfony /usr/local/bin/symfony

docker-php-ext-install -j $(nproc) intl \
       mysqli \
       opcache \
       pgsql \
       soap \
       xsl \
       xmlrpc pdo_mysql
# GD.
# https://github.com/docker-library/php/issues/912
docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/
docker-php-ext-install -j$(nproc) gd

#ZIP https://github.com/laradock/laradock/issues/2421
#docker-php-ext-configure zip --with-libzip
#docker-php-ext-install zip

apt-get remove --purge -y $BUILD_PACKAGES
apt-get autoremove -y
apt-get clean
rm -rf /var/lib/apt/lists/*