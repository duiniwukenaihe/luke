# Your installation or use of this SugarCRM file is subject to the applicable
# terms available at
# http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
# If you do not agree to all of the applicable terms or do not have the
# authority to bind the entity as an authorized representative, then do not
# install or use this SugarCRM file.
#
# Copyright (C) SugarCRM Inc. All rights reserved.

FROM debian:jessie

# install common packages
RUN export DEBIAN_FRONTEND=noninteractive && \
    apt-get update && \
    apt-get -y install apt-utils && \
    apt-get -y install apt-transport-https git curl wget ca-certificates --no-install-recommends

# PHP set up
RUN apt-get -y install apache2 php5 php5-mcrypt php5-mysql php5-ldap php5-curl

# MySQL set up
RUN echo 'mysql-server mysql-server/root_password password Sugar123' | debconf-set-selections && \
    echo 'mysql-server mysql-server/root_password_again password Sugar123' | debconf-set-selections && \
    apt-get -y install mysql-server

# Apache set up
RUN mkdir /var/www/sugarcrm
RUN a2enmod rewrite
COPY apache/mango.conf /etc/apache2/sites-available
COPY apache/apache2.conf /etc/apache2
RUN a2dissite 000-default.conf default-ssl.conf
RUN a2ensite mango.conf

#prepare mango
COPY sugarcrm /var/www/sugarcrm
COPY config_override.php /var/www/sugarcrm/config_override.php
COPY config_si.php /var/www/sugarcrm/config_si.php
RUN chown -R www-data:www-data /var/www/sugarcrm

COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod a+x /usr/local/bin/entrypoint.sh

COPY refreshCache.php /var/www/sugarcrm/refreshCache.php

WORKDIR /var/www/sugarcrm

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

EXPOSE 80