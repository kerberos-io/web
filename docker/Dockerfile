FROM phusion/baseimage:latest

MAINTAINER "Cédric Verstraeten" <hello@cedric.ws>

#################################
# Surpress Upstart errors/warning

RUN dpkg-divert --local --rename --add /sbin/initctl
RUN ln -sf /bin/true /sbin/initctl

#############################################
# Let the container know that there is no tty

ENV DEBIAN_FRONTEND noninteractive

#########################################
# Update base image
# Add sources for latest nginx and cmake
# Install software requirements

RUN sudo sed -i -e 's/us.archive.ubuntu.com/archive.ubuntu.com/g' /etc/apt/sources.list
RUN apt-get update && \
apt-get install -y software-properties-common && \
nginx=stable && \
add-apt-repository ppa:nginx/$nginx && \
apt-get update && \
apt-get upgrade -y
RUN apt-get -y install supervisor curl subversion libcurl4-gnutls-dev cmake dh-autoreconf nginx nodejs npm php5-fpm git php5-mysql php-apc php5-curl php5-gd php5-mcrypt php5-memcache php5-tidy php5-xsl pwgen 

########################################
# fix ownership of sock file for php-fpm

RUN sed -i -e "s/;listen.mode = 0660/listen.mode = 0750/g" /etc/php5/fpm/pool.d/www.conf && \
find /etc/php5/cli/conf.d/ -name "*.ini" -exec sed -i -re 's/^(\s*)#(.*)/\1;\2/g' {} \;

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

VOLUME ["/etc/opt/kerberosio/capture/"]
VOLUME ["/etc/opt/kerberosio/config/"]

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
