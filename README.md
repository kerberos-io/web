# KERBEROS.**IO**

[![Build Status](https://travis-ci.org/kerberos-io/web.svg)](https://travis-ci.org/kerberos-io/web) [![Stories in Ready](https://badge.waffle.io/kerberos-io/web.svg?label=ready&title=Ready)](http://waffle.io/kerberos-io/web) [![Join the chat](https://img.shields.io/gitter/room/TechnologyAdvice/Stardust.svg?style=flat)](https://gitter.im/kerberos-io/hades?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge) [![gitcheese.com](https://s3.amazonaws.com/gitcheese-ui-master/images/badge.svg)](https://www.gitcheese.com/donate/users/1546779/repos/22601588)

[![Kerberos.io - video surveillance](https://kerberos.io/images/kerberos.png)](https://kerberos.io)

## Help us internationalize

We're looking for contributors to help us translating the web interface, so that more people can start using and understanding Kerberos.io. Want to help? [**Send us your contribution**](https://github.com/kerberos-io/web/issues/74).

## Vote for features

[![Feature Requests](http://feathub.com/kerberos-io/machinery?format=svg)](http://feathub.com/kerberos-io/machinery)

# CC-NC-ND license

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

### KiOS (for Raspberry Pi)

[KiOS](https://github.com/kerberos-io/kios) is a custom linux OS (created by buildroot) which runs Kerberos.io out-of-the-box (it contains both the machinery and the web). KiOS is **installed like every other OS** for the Raspberry Pi, you need to flash the OS (.img) to a SD card, update your network configration and you're up and running; no manual compilation or horrible configurations. This is the **most simple** and **basic** installation procedure.

[Read more](https://doc.kerberos.io/2.0/installation/KiOS)

### Raspbian (for Raspberry Pi)

If you already have a Raspberry Pi running with Raspbian, you probably don't want to reflash your SD-card. Therefore you can install and download the different parts of Kerberos.io (the machinery and the web) without the need for complex and time consuming compiling.

[Read more](https://doc.kerberos.io/2.0/installation/Raspbian)

### Armbian (for Orange Pi, PCDuino, etc)

Kerberos.io can also be installed on other boards, which run the Armbian OS.

[Read more](https://doc.kerberos.io/2.0/installation/Armbian)

### Generic

If you want to install **the web**, you'll need to have **a webserver** (e.g. Nginx) and **PHP** running with some extensions. You also need **NodeJS** and **npm** installed to install **Bower**. Below you can find the installation procedure to install the web on your preferred environment.

#### Install Dependencies

Install Git, PHP7 (+extensions) and NodeJS.

A) Ubuntu
    
    sudo apt-get update && sudo apt-get upgrade
    curl -sL https://deb.nodesource.com/setup | sudo bash -
    sudo apt-get install git nginx php7.0-cli php7.0-gd php7.0-mcrypt php7.0-curl php7.0-mbstring php7.0-dom php7.0-zip php7.0-fpm nodejs npm
    
B) Raspbian

    echo "deb http://mirrordirector.raspbian.org/raspbian/ stretch main contrib non-free rpi" | sudo tee --append /etc/apt/sources.list
    sudo apt-get update
    sudo apt-get install -t stretch php7.0 php7.0-curl php7.0-gd php7.0-fpm php7.0-cli php7.0-opcache php7.0-mbstring php7.0-xml php7.0-zip php7.0-mcrypt nodejs npm
    sudo ln -s /usr/bin/nodejs /usr/bin/node
    
C) OSX

    brew install php7.0 php7.0-curl php7.0-gd php7.0-fpm php7.0-cli php7.0-opcache php7.0-mbstring php7.0-xml php7.0-zip php7.0-mcrypt nodejs npm

#### Configure webserver

Install Nginx,

    sudo apt-get install nginx

or if you're running OSX use brew.

    sudo brew install nginx

Creating a Nginx config.

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
                fastcgi_pass unix:/var/run/php/php7.0-fpm.sock;
                fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
                include fastcgi_params;
        }
    }

#### Clone source

Create a www location.

    mkdir -p /var/www

Get the source code from Github.

    cd /var/www && sudo git clone https://github.com/kerberos-io/web && cd web

Install PHP packages by using composer.

    curl -sS https://getcomposer.org/installer | sudo php
    sudo mv composer.phar /usr/bin/composer
    sudo composer install

Add write permission for the storage directory, and the kerberos config file.

    sudo chmod -R 777 storage
    sudo chmod -R 777 bootstrap/cache
    sudo chmod 777 config/kerberos.php

Install bower globally by using npm.

    sudo npm -g install bower

Install Front-end dependencies with bower

    cd public
    sudo bower --allow-root install

Restart nginx

    sudo service nginx restart

## How to access

You can access **the web** by entering the IP-address in your favorite browser. You'll see a welcome page showing up, on which you will be able to choose an username and password; the default username and password is **root**. 

![Welcome](https://doc.kerberos.io/documentation/develop/70_installation/1_how-to-access.png)
