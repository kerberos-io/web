#!/bin/bash

echo "[www]" > /etc/php/7.0/fpm/pool.d/env.conf
echo "" >> /etc/php/7.0/fpm/pool.d/env.conf
env | grep "KERBEROSIO_" | sed "s/\(.*\)=\(.*\)/env[\1]='\2'/" >> /etc/php/7.0/fpm/pool.d/env.conf
service php7.0-fpm start

/usr/bin/supervisord -n -c /etc/supervisord.conf
