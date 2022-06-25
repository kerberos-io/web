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

  'settings' => 'Paramètres',

  'configuration' => 'Configuracion',

	'update' => 'Mesa a jorn',

	'heatmap' => 'Mapa de calor',

	'general' => 'Paramètres general',

	'purchase' => 'Agachatz vòstra activitat de partir pel monde amb <b>Kerberos Cloud</b>, Podètz <u>començar</u> per sonque 1,99€/mes !',

	'basic' => 'Basic',

	'advanced' => 'Advançat',

	'name' => 'Nom',

	'nameInfo' => 'Un nom unic per la camèra es requerit, s’avètz mantuna instància Kerberos.io',

	'timezone' => 'Fus orari',

	'timezoneInfo' => 'Lo fus orari es emplegat per convertir los oradatages dins vòstra ora locala. Es utilizat tan per las maquinas e l’interfàcia web.',

	'camera' => 'Camèra',

	'usbcamera' => 'Camèra USB',

	'usbcameraInfo' => 'Causissètz aquesta opcion se volètz utilizar una camèra USB.',

	'rpicamera' => 'Camèra RPi',

	'rpicameraInfo' => 'S’utilizatz Kerberos.io sus un Raspberry Pi, causissètz aquesta opcion, se volètz utilizar lo modul camèra de Raspberry Pi (v1 or v2).',

	'ipcamera' => 'Camèra IP',

	'ipcameraInfo' => 'Causissètz aquesta opcion, se volètz utilizar una camèra IP amb la presa en carga del flux vidèo RTSP o MJPEG.',

	'surveillanceMode' => 'Susvelhança',

	'motion' => 'Movement',

	'motionInfo' => 'Un detector intelligent de movements, qu’enregistra de snapshots o de videos, e/o avia d’autres aparelhs en utilizant un webhook. Condicions de configuracion per sonque detectar un movement dins una region donada de la vista.',

	'storage' => 'Emmagazinatge',

	'storageInfo' => 'Utilizatz Kerberos Cloud per seguir mantuna instància Kerberos.io  de pertot pel monde.',

	'dontForget' => 'Quichatz Actualizar per confirmar la configuracion.',

	'update' => 'Actualizar',

	'cancel' => 'Anullar',

	'confirmAndSelect' => 'Confirmar e causir',


	// --------------
	// Camera

	'fpsRaspberryInfo' => 'The number of frames processed per second; note that this parameter also defines the number of frames per second of a video recording.',

	'width' => 'Largor',

	'height' => 'Nautor',

	'widthHeightInfo' => 'La resolucion dels imatges capturats per la camèra. Asseguratz-vos que la resolucion es compatibla !',

	'delay' => 'relambi en segondas',

	'delayInfo' => 'The delay time will tell Kerberos.io to wait for x amount of seconds, between two frame captures. This is helpful when you would like to reduce the number of images being processed per second (e.g. for performance reasons).',

	'livestream' => 'live stream frames/sec',

	'livestreamInfo' => 'The frames per second of the live stream can be configured. Setting this option to zero, will disable the live stream.',

	'rotate' => 'Click on this image if your camera is rotated. E.g. if your camera is mounted upside down, make sure this image is also upside down.',

	'url' => 'Enter the url of the RTSP or MJPEG stream of your IP camera.',

	// ----------------
	// Motion

	'image' => 'Imatge',

	'video' => 'Vidèo',

	'step1' => 'Etapa 1. Causir una region',

	'step1Info' => 'Move the points to draw the region of interest. Double click on a point to remove it, and/or on the white point to add more points.',

	'step2' => 'Etape 2. Configurar los paramètres',

	'step2Info' => 'By changing the configuration below you can make the motion detection more or less sensitive.',

	'step3' => 'Etapa 3. Causir una o mai sortidas',

	'step3Info' => 'Once motion is detected you can execute (asynchronous) one or more outputs.',

	'sensitivity' => 'sensitivitat',

	'sensitivityInfo' => 'Increasing this slider will make Kerberos.io more sensitive for motion. Decreasing will make it less sensitive for motion.',

	'numberOfDetections' => 'number of detections before valid',

	'numberOfDetectionsInfo' => 'This number represents the number of detections in a row before Kerberos.io will trigger a valid event. By increasing this value, you can eliminate false-positives: e.g. lightning, clouds, etc.',

		// ------------------
		// Timestamp - Colors

		'noTimestamp' => 'cap d’orodatge',

		'white' => 'blanc',

		'black' => 'negre',

		'red' => 'roge',

		'green' => 'verd',

		'blue' => 'blau',

	'drawTimestamp' => 'draw timestamp',

	'drawTimestampInfo' => 'When an image is saved to disk, you can draw the current date and time on the image.',

	'drawTimestampInfoVideo' => 'When a video is saved to disk, you can draw the current date and time on the video.',

	'privacy' => 'confidencialitat',

	'privacyInfo' => 'By enabling this option, only the selected region of step 1 will be visible. All pixels outside the region are made black.',

	'fps' => 'frames per segonda',

	'fpsInfo' => 'The frames per second written to the video file; be aware that a Raspberry Pi can only process a limited number of FPS (e.g. 7 FPS).',

	'secondsRecord' => 'seconds to record',

	'secondsRecordInfo' => 'The number of seconds that will be recorded after motion was detected.',

	'webhookUrl' => 'url',

	'webhookUrlInfo' => 'The url to which a POST will be sent with a JSON object.',

	'scriptPath' => 'camin',

	'scriptPathInfo' => 'The path to a bash script that will be executed. A JSON object is send as a parameter.',

	'gpioPin' => 'pin',

	'gpioPinInfo' => 'Define the pin number on which a pulse will be send.',

	'gpioPeriod' => 'periòde',

	'gpioPeriodInfo' => 'The number of microseconds the pulse will last.',

	'hardwareEncodingEnabled' => 'Your capture device supports on board hardware encoding, that\'s why you can\'t choose additional parameters (e.g. timestamping).
	Also the video generated will have the same specifications as the capture device you\'ve chosen (e.g. FPS, sharpness, etc).',

  'secure' => 'secure',

	'secureInfo' => 'Activar SSL/TLS. Lo certificat CA deu se trobar dins lo repertòri /etc/ssl/certs/.',

  'verifycn' => 'verificar',

	'verifycnInfo' => 'Verify certificate CN (Common Name)',

  'mqttServer' => 'servidor',

  'mqttServerInfo' =>  'The IP address of the MQTT broker service.',

  'mqttPort' => 'pòrt',

  'mqttPortInfo' =>  'Port number of the MQTT broker service.',

  'mqttTopic' => 'topic',

  'mqttTopicInfo' =>  'The topic name to which MQTT messages are sent.',

  'mqttClientId' =>  'client_id',

  'mqttClientIdInfo' =>  'The ClientId which is used to connect to a MQTT broker.',

  'mqttUsername' => 'nom d’utilizaire',

  'mqttUsernameInfo' =>  'The username to authenticate with the MQTT broker.',

  'mqttPassword' => 'senhal',

  'mqttPasswordInfo' =>  'The password to authenticate with the MQTT broker.',

  'throttler' => 'throttle',

  'throttlerInfo' =>  'Use to prevent spamming. Eg. only execute once within 5 seconds.',

	// --------------
	// Cloud

	'whatIsThis' => 'Qu’es aquò',

	'whatIsthisInformation' => 'Kerberos.io comes with its own cloud application. By subscribing to a plan, you can sync all your images and videos, and review it from anywhere in the world. Once subscribed, you\'ll receive some credentials which you can fill in the fields on the left. After confirming and updating the settings, you\'re activity will be synced automatically. Have fun!',

	'subscribeNow' => 'Abonatz-vos per sonque €1,99',

  'verifyConnectivity' => 'Verificar la connectivitat',

  'cloudHurray' => 'Hurray, connection was succesful. Your media will now be synced automatically to your cloud account.',

  'cloudWentWrong' => 'Something went wrong, verify you\'ve entered your credentials correctly.',

  'cloudWentWrongMoreHelp' => 'Clicatz aquí per mai d’assistencia.',

  'checkConnection' => 'Verificar la connexion',

	// ---------------
	// KiOS settings

	'forceNetwork' => 'Forçar lo mòde ret',

	'forceNetworkInfo' => 'When enabled the OS will reboot if it can\'t connect to the internet. This is necessary if you are using the cloud application, but have an unreliable network.',

	'autoRemoval' => 'Auto removal media',

	'autoRemovalInfo' => 'When enabled images are automatically removed when disk is almost full.'

);
