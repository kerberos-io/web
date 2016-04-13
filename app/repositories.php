<?php

/**********************************
*
*   Bind repositories to controllers 
*   (Dependency Injection)
*
**********************************/

App::bind('Repositories\ImageHandler\ImageHandlerInterface', 'Repositories\ImageHandler\ImageFilesystemHandler');
App::bind('Repositories\Filesystem\FilesystemInterface', 'Repositories\Filesystem\DiskFilesystem');
App::bind('Repositories\ConfigReader\ConfigReaderInterface', 'Repositories\ConfigReader\ConfigXMLReader');
App::bind('Repositories\Date\DateInterface', 'Repositories\Date\Carbon');
App::bind('Repositories\Support\SupportInterface', 'Repositories\Support\ZendeskSupport');