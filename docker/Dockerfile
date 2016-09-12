FROM kerberos/base:latest

ARG APP_ENV=master
ENV APP_ENV ${APP_ENV}

MAINTAINER "Cédric Verstraeten" <hello@cedric.ws>

#################################
# Surpress Upstart errors/warning

RUN dpkg-divert --local --rename --add /sbin/initctl
RUN ln -sf /bin/true /sbin/initctl

#############################################
# Let the container know that there is no tty

ENV DEBIAN_FRONTEND noninteractive

###################
# nginx site conf

RUN rm -Rf /etc/nginx/conf.d/* && \
rm -Rf /etc/nginx/sites-available/default && \
mkdir -p /etc/nginx/ssl
ADD ./web.conf /etc/nginx/sites-available/default.conf
RUN ln -s /etc/nginx/sites-available/default.conf /etc/nginx/sites-enabled/default.conf

#################################
# Kerberos.io version

ENV BRANCH develop

#####################
# Clone and build web

RUN git clone https://github.com/kerberos-io/web /var/www/web && \
cd /var/www/web && \ 
git checkout develop && \
chown -Rf www-data.www-data /var/www/web && \
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer && \
cd /var/www/web && \
php5enmod mcrypt && \
composer install --prefer-source && \
npm install -g bower && \
cd public && \
nodejs /usr/local/bin/bower --allow-root install

RUN rm /var/www/web/public/capture && \
ln -s /etc/opt/kerberosio/capture/ /var/www/web/public/capture

###########################################
# Make capture and config directory visible

VOLUME ["/etc/opt/kerberosio/capture"]
VOLUME ["/etc/opt/kerberosio/config"]
VOLUME ["/etc/opt/kerberosio/logs"]

##############
# Expose Ports

EXPOSE 443
EXPOSE 80

#############################
# Supervisor Config and start

ADD ./supervisord.conf /etc/supervisord.conf
ADD ./run.sh /run.sh
RUN chmod 755 /run.sh

CMD ["/bin/bash", "/run.sh"]
