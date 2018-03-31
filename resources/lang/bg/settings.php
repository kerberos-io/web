<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Settings Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines are used on the settings page.
	|
	*/

    'settings' => 'Настройки',

    'configuration' => 'Конфигурация',

		'update' => 'Запиши',

		'heatmap' => 'Топлинна карта',

		'general' => 'Основни настройки',

		'purchase' => 'Гледай навсякъде по света използвайки <b>Kerberos.cloud</b>, <u>започни сега</u> само за 1,49€ на месец!',

		'basic' => 'Базови',

		'advanced' => 'Разширени',

		'name' => 'Име',

		'nameInfo' => 'Уникално име на камерата е необходимо ако ще ползвате повече от една Kerberos.io инстанции.',

		'timezone' => 'Часова зона',

		'timezoneInfo' => 'Часовата зона се използва за да показва коректно времето на събитията. Използва се от Machinery и Web интерфейсът.',

		'camera' => 'Камера',

		'usbcamera' => 'USB камера',

		'usbcameraInfo' => 'Избери тази опция, ако ще използваш USB камера.',

		'rpicamera' => 'RPi камера',

		'rpicameraInfo' => 'Избери тази опция, ако Kerberos.io работи на Raspberry Pi. Използвай при Raspberry Pi камера модул (v1 или v2).',

		'ipcamera' => 'IP камера',

		'ipcameraInfo' => 'Избери тази опция, ако искаш да използваш IP камера която поддържа RTSP или MJPEG протокол.',

		'surveillanceMode' => 'Наблюдение',

		'motion' => 'Движение',

		'motionInfo' => 'Детектор на движение който записва снимка, видео и може да включи други устройства използвайки webhook. Настройка за отчитане на двивижение само в определени зони от изгледа.',

		'storage' => 'Съхранение',

		'storageInfo' => 'Използвай Kerberos.cloud a да гледаш повече от една Kerberos.io инстанции от целия свят.',

		'dontForget' => 'Натисни "Запиши" за да запазиш промените.',

		'update' => 'Запиши',

		'cancel' => 'Отмени',

		'confirmAndSelect' => 'Избери',


		// --------------
		// Camera

		/* to translate */ 'fpsRaspberryInfo' => 'The number of frames processed per second; note that this parameter also defines the number of frames per second of a video recording.',

		'width' => 'Широчина',

		'height' => 'Височина',

		'widthHeightInfo' => 'Резолюцията на изображението което ще бъде записано. Убедете се че се поддържа от камерата!',

		'delay' => 'закъснение в секунди',

		'delayInfo' => 'Закъснението (в секунди) което Kerberos.io ще изчака между два фрейма при запис. Това е полезно за да се намали броя на снимките които се обработват за секунда, което намаля натовареността на системата.',

		'livestream' => 'фрейм/секунда при гледане на живо',

		'livestreamInfo' => 'Фреймове за секунда при гледане на живо. Гледането на живо може да се спре, ако тази опция се сложи на нула.',

		'rotate' => 'Кликнете върху картинката ако камерата за завъртяна. Пример: ако камерата е завъртяна на обратно и картинката трябва да бъде завъртяна на обратно.',

		'url' => 'Въведете URL на RTSP или MJPEG stream на вашата IP камера.',

		// ----------------
		// Motion

		'image' => 'Снимка',

		'video' => 'Видео',

		'step1' => 'Стъпка 1. Изберете зона',

		'step1Info' => 'Преместете точките за да очертаете зоната на интерест. С двойно кликване върху точка може те да я премахнете. С двойно кликване върху бялата линия може да създаде нова точка.',

		'step2' => 'Стъпка 2. Задайте параметри',

		'step2Info' => 'Променяйки настройте може да направите засичането на движение повече или по-малко чувствително.',

		'step3' => 'Стъпка 3. Избери един или повече изхода',

		'step3Info' => 'Когато движение бъде засечено един или няколко изхода могат да бъдат включени. Операциите са не блокиращи.',

		'sensitivity' => 'чувствителност',

		'sensitivityInfo' => 'Увеличавайки плъзгача ще накара Kerberos.io да бъде по чувствителен на движение и обратното, намалявайки го ще се намали и чувствителността.',

		'numberOfDetections' => 'необходими движения за валидно събитие',

		'numberOfDetectionsInfo' => 'Броя на засечените последователни движения които са необходими за да сметне че е настъпило събитие. Ако увеличите тази стойност, ще намалите възможността от фалшиви събития предизвикани от облаци и други.',

		// ------------------
		// Timestamp - Colors

		'noTimestamp' => 'без времеви индикатор',

		'white' => 'бял',

		'black' => 'черен',

		'red' => 'червен',

		'green' => 'зелен',

		'blue' => 'син',

		'drawTimestamp' => 'добави времеви индикатор',

		'drawTimestampInfo' => 'Може добавите текущата дата и част към снимките когато се записват.',

		'drawTimestampInfoVideo' => 'Може добавите текущата дата и част към видеото когато се записва.',

		'privacy' => 'поверителност',

		'privacyInfo' => 'Ако тази опция е пусната, само зоната избрана от Стъпка 1 ще бъде видима при запис, останалата част ще бъде в черно.',

		'fps' => 'фрейма за секунда',

		'fpsInfo' => 'Фрейма за секунда при запис на видео файл. Имайте предвид, че Raspberry Pi може да обработи ограничен брой фрейма за секунда (пример: 7 FPS).',

		'secondsRecord' => 'секунди на запис',

		'secondsRecordInfo' => 'Брой секунди които да бъдат записани след като движение бъде засечено.',

		'webhookUrl' => 'url',

		'webhookUrlInfo' => 'URL към който POST заявка ще изпрати JSON обект.',

		'scriptPath' => 'път на файловата система',

		'scriptPathInfo' => 'Път до BASH скрипт който да бъде изпълнен. JSON обект ще бъде подаден като параметър.',

		'gpioPin' => 'пин',

		'gpioPinInfo' => 'Избери GPIO пин който да получи импулс.',

		'gpioPeriod' => 'времетраене',

		'gpioPeriodInfo' => 'Времетраене на импулса в микросекунди.',

		/* to translate */ 'hardwareEncodingEnabled' => 'Your capture device supports on board hardware encoding, that\'s why you can\'t choose additional parameters (e.g. timestamping).
			Also the video generated will have the same specifications as the capture device you\'ve chosen (e.g. FPS, sharpness, etc).',

    /* to translate */ 'secure' => 'secure',

  	/* to translate */ 'secureInfo' => 'Enable SSL/TLS. CA certificate should be in /etc/ssl/certs/ directory.',

    /* to translate */ 'verifycn' => 'verify',

  	/* to translate */ 'verifycnInfo' => 'Verify certificate CN (Common Name)',

    /* to translate */ 'mqttServer' => 'server',

    /* to translate */ 'mqttServerInfo' =>  'The IP address of the MQTT broker service.',

    /* to translate */ 'mqttPort' => 'port',

    /* to translate */ 'mqttPortInfo' =>  'Port number of the MQTT broker service.',

    /* to translate */ 'mqttTopic' => 'topic',

    /* to translate */ 'mqttTopicInfo' =>  'The topic name to which MQTT messages are sent.',

    /* to translate */ 'mqttUsername' => 'username',

    /* to translate */ 'mqttUsernameInfo' =>  'The username to authenticate with the MQTT broker.',

    /* to translate */ 'mqttPassword' => 'password',

    /* to translate */ 'mqttPasswordInfo' =>  'The password to authenticate with the MQTT broker.',

    /* to translate */ 'throttler' => 'throttle',

    /* to translate */ 'throttlerInfo' =>  'Use to prevent spamming. Eg. only execute once within 5 seconds.',

		// --------------
		// Cloud

		'whatIsThis' => 'Какво е това',

		'whatIsthisInformation' => 'Kerberos.io идва със собствено cloud-базирано приложение. Ако се абонирате може да синхронизирате и преглеждате всички снимки и видеа от всякъде по света. След абонирате, ще получите информация която трябва да попълните на полетата от ляво. След потвърждение и запазване на настройките, активността ще бъде синхронизирана автоматично. Забавлявайте се!',

		'subscribeNow' => 'Абонирай се само за €1,49',

    /* to translate */ 'verifyConnectivity' => 'Verify connectivity',

    /* to translate */ 'cloudHurray' => 'Hurray, connection was succesful. Your media will now be synced automatically to your cloud account.',

    /* to translate */ 'cloudWentWrong' => 'Something went wrong, verify you\'ve entered your credentials correctly.',

    /* to translate */ 'cloudWentWrongMoreHelp' => 'Click here for more support.',

    /* to translate */ 'checkConnection' => 'Check connection',


		// ---------------
		// KiOS settings

		/* to translate */ 'forceNetwork' => 'Force network mode',

		/* to translate */ 'forceNetworkInfo' => 'When enabled the OS will reboot if it can\'t connect to the internet. This is necessary if you are using the cloud application, but have an unreliable network.',

		/* to translate */ 'autoRemoval' => 'Auto removal media',

		/* to translate */ 'autoRemovalInfo' => 'When enabled images are automatically removed when disk is almost full.'

);
