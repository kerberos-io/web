#KERBEROS.**WEB**

[![Build Status](https://magnum.travis-ci.com/cedricve/kerberos-web.svg?token=xAPfGKsCyaCbE3s5sbJ3&branch=master)](https://magnum.travis-ci.com/cedricve/kerberos-web) [![Stories in Ready](https://badge.waffle.io/kerberos-io/machinery.svg?label=ready&title=Ready)](http://waffle.io/kerberos-io/machinery)

## Introduction

[Kerberos](http://kerberos.io) is a low-budget surveillance solution created for the Rapsberry Pi, but it also works on OSX and Linux. It uses a motion detection algorithm to detect changes and stores images when motion is detected. Kerberos is open source, so you and others, can customize the source code to your needs and share it. It has a low-energy footprint when deploying on the Raspberry Pi and it's easy to install, you only need to transfer the image to the SD card and you're done.

Use your mobile phone, tablet or PC to keep an eye on your property. View the images taken by [Kerberos](http://kerberos.io) with our responsive and user-friendly web interface. Look at the dashboard to get a graphical overview of the past days. Multiple [Kerberos](http://kerberos.io) instances can be installed and can be viewed with only 1 web interface.

## The web interface

The webinterface allows you to configure the machinery and to view events that were detected by the machinery. You can use your mobile phone, tablet or desktop to view the images with the *responsive* and *intuitive* web interface.

## How does it work?

The webinterface is written in PHP using the extremely popular PHP Framework **Laravel**. It visualizes images, taken by the machinery, in a intuitive and responsive way. Besides a server-side framework, it also uses a client-side framework **Backbone** to create the dynamic behaviour. The webinterface includes the latest development tools, to increase development efficiency: RequireJS, bower, LESS, etc.

Besides visualization, the webinterface is also used to configure the machinery. On the settings page a user can select different options, for example a user could select a region where motion should be detected. Could select a time range when motion could be detected, which algorithm is used, etc; more information can be found on the [documentation website](http://doc.kerberos.io).


## Installation

First make sure you've enabled following php extensions: mcrypt, phar, gd and openssl.

    nano /etc/php/php.ini
    uncomment extension=mcrypt.so
    uncomment extension=phar.so
    uncomment extension=gd.so
    uncomment extension=openssl.so


Go to your www directory, the directory to which your webserver is pointing
	
	cd /some/directory/www

Get the source code from github

    git clone https://github.com/cedricve/kerberos-web

Install php packages by using composer

    cd kerberos-web
    composer install

Change config file: edit the "configFile" variable, link it to the config directory of the kerberos-io repository. If you don't have the kerberos-io repository installed on that specific server, you can make it an empty string. In this case the option "settings" won't show up in the navigation menu.

    nano app/config/app.php

Change write permission on the storage directory

    chmod -R 777 app/storage

Install bower globally by using node package manager, this is installed when installing nodejs.

    npm -g install bower

Install Front end dependencies with bower
    
    cd public
    bower --allow-root install

## How to access

You can access the webinterface by entering the ip address in your favorite browser. You will see a login page showing up, on which you will need to enter your credentials. The default username and password is **root**. You are able to change this password by editing the **app/config/app.php** file.

![Login page kerberos.io webinterface](https://doc.kerberos.io/documentation/1.0.0/40_web/1_how-to-access.png)
