#KERBEROS.**IO**

[![Build Status](https://travis-ci.org/kerberos-io/web.svg)](https://travis-ci.org/kerberos-io/web) [![Stories in Ready](https://badge.waffle.io/kerberos-io/web.svg?label=ready&title=Ready)](http://waffle.io/kerberos-io/web) [![Join the chat at https://gitter.im/kerberos-io/hades](https://img.shields.io/badge/GITTER-join chat-green.svg)](https://gitter.im/kerberos-io/hades?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

[![Kerberos.io - video surveillance](https://kerberos.io/images/kerberos.png)](https://kerberos.io)

## Vote for features

[![Feature Requests](http://feathub.com/kerberos-io/machinery?format=svg)](http://feathub.com/kerberos-io/machinery)

#CC-NC-ND license

THE WORK (AS DEFINED BELOW) IS PROVIDED UNDER THE TERMS OF THIS CREATIVE COMMONS PUBLIC LICENSE ("CCPL" OR "LICENSE"). THE WORK IS PROTECTED BY COPYRIGHT AND/OR OTHER APPLICABLE LAW. ANY USE OF THE WORK OTHER THAN AS AUTHORIZED UNDER THIS LICENSE OR COPYRIGHT LAW IS PROHIBITED.

## Why Kerberos.io?

As burgalary is very common, we believe that video surveillance is a **trivial tool** in our daily lifes which helps us to **feel** a little bit more **secure**. Responding to this need, a lot of companies have started developing their own video surveillance software in the past few years.

Nowadays we have a myriad of **expensive** camera's, recorders and software solutions which are mainly **outdated** and **difficult** to install and use. Kerberos.io's goal is to solve these problems and to provide every human being in this world to have its own **ecological**, **affordable**, **easy-to-use** and **innovative** surveillance solution.

## Introduction

[Kerberos.io](http://kerberos.io) is a **low-budget** video surveillance solution, that uses computer vision algorithms to detect changes, and that can trigger other devices. [Kerberos.io](http://kerberos.io) is open source so everyone can customize the source code to its needs and share it with the community under the [**CC-NC-ND license model**](https://doc.kerberos.io/license). When deployed on the Raspberry Pi, it has a **green footprint** and it's **easy to install**; you only need to transfer the [Kerberos.io OS (KIOS)](https://doc.kerberos.io/2.0/installation/KiOS) to your SD card and that's it.

Use your mobile phone, tablet or PC to keep an eye on your property. View the images taken by [Kerberos.io](http://kerberos.io) with our responsive and user-friendly web interface. Look at the dashboard to get a graphical overview of the past days. Multiple [Kerberos.io](http://kerberos.io) instances can be installed and can be viewed with only 1 web interface.

## The web

The web is responsible for the visualization. It's a **GUI** which helps the user to find activity at a specific period, configure the machinery, view a live stream, see system information and much more. It's important to note that the machinery can work without the web, however we don't recommend this.

## How does it work?

The web is written in PHP using the extremely popular PHP Framework **Laravel**, and Javascript using the client-side framework **BackboneJS**; to create the dynamic behaviour. We will discuss the different pages and functionality briefly. Please check out the [demo environment](https//doc.kerberos.io) if you want to see a real life example.

[Read more](https://doc.kerberos.io/2.0/web/introduction)

## Installation

The reason why you're reading this paragraph is because you want to know how to install the web on your Raspberry Pi, local working station, server or whatever machine you prefer. The good news is that we have **different approaches** from basic to advanced; it depends on how you want to install it.

###KiOS (for Raspberry Pi)

[KiOS](https://github.com/kerberos-io/kios) is a custom linux OS (created by buildroot) which runs Kerberos.io out-of-the- (it contains both the machinery and the web). KiOS is **installed like every other OS** for the Raspberry Pi, you need to flash the OS (.img) to a SD card, update your network configration and you're up and running; no manual compilation or horrible configurations. This is the **most simple** and **basic** installation procedure.

[Read more](https://doc.kerberos.io/2.0/installation/KiOS)

###Raspbian (for Raspberry Pi)

If you already have a Raspberry Pi running with Raspbian, you probably don't want to reflash your SD-card. Therefore you can install the different parts of Kerberos.io (the machinery and the web) manual.

[Read more](https://doc.kerberos.io/2.0/installation/Raspbian)

###Advanced

If you want to install **the web**, you'll need to have **a webserver** (e.g. nginx) and **PHP** running with some extensions. You also need **nodejs** and **npm** installed to install **bower**. Below you can find the installation procedure to install the web on the Ubuntu OS; the process is similar for another Linux OS.

Update the packages and kernel.

    sudo apt-get update && sudo apt-get upgrade

Install git, nginx, php (+extension) and nodejs.

    curl -sL https://deb.nodesource.com/setup | sudo bash - 
    sudo apt-get install git nginx php5-cli php5-fpm php5-gd php5-mcrypt php5-curl nodejs

Creating a nginx config.

    sudo rm -f /etc/nginx/sites-enabled/default
    sudo nano /etc/nginx/sites-enabled/default 
    
Copy and paste following config file; this file tells nginx where the web will be installed and that it requires PHP.

    server
    {
        listen 80 default_server;
        listen [::]:80 default_server;

        root /var/www/web/public;
        index index.html index.htm index.nginx-debian.html;

        server_name kerberos.rpi kerberos.rpi;
        index index.php index.html index.htm;

        location /
        {
                autoindex on;
                try_files $uri $uri/ /index.php?$query_string;
        }

        location ~ \.php$
        {
                fastcgi_pass unix:/var/run/php5-fpm.sock;
                fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
                include fastcgi_params;
        }
    }

Create a www location.
    
    mkdir -p /var/www

Get the source code from Github.

    cd /var/www && sudo git clone https://github.com/kerberos-io/web && cd web

Install PHP packages by using composer.

    curl -sS https://getcomposer.org/installer | sudo php
    sudo mv composer.phar /usr/bin/composer
    sudo composer install

Add write permission for the storage directory, and the kerberos config file.

    sudo chmod -R 777 app/storage
    sudo chmod 777 app/config/kerberos.php

Install bower globally by using node package manager, this is installed when installing nodejs.

    sudo apt-get install npm
    sudo ln -s /usr/bin/nodejs /usr/bin/node
    sudo npm -g install bower

Install Front-end dependencies with bower
    
    cd public
    sudo bower --allow-root install
    
Restart nginx

    sudo service nginx restart

## How to access

You can access **the web** by entering the IP-address in your favorite browser. You'll see a welcome page showing up, on which you will be able to choose an username and password; the default username and password is **root**. 

![Welcome](https://doc.kerberos.io/documentation/develop/70_installation/1_how-to-access.png)
