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

  'settings' => 'Ajustos',

  'configuration' => 'Configuracio',

	'update' => 'Validar',

	'heatmap' => 'Mapa de calor',

	'general' => 'Preferncies',

	'purchase' => 'Accediu a la video vigia�ncia des de qualsevoll lloc del mon amb <b>Kerberos.cloud</b>, <u>Proveu-ho</u> per noms 1,49€/mes!',

	'basic' => 'Basic',

	'advanced' => 'Avandat',

	'name' => 'Nom',

	'nameInfo' => 'Cal que proporcioneu un nom onic per a la vostra camera si voleu executar multiples sessions de Kerberos.io.',

	'timezone' => 'Zona horria',

	'timezoneInfo' => 'La zona horria es necessaria per a poder-vos proporcionar l\'hora local. Es fa servir tant en el maquinari com a la interfacie web.',

	'camera' => 'Camera',

	'usbcamera' => 'Camera USB',

	'usbcameraInfo' => 'Seleccioneu aquesta opci si voleu fer servir una camera USB.',

	'rpicamera' => 'RPi camera',

	'rpicameraInfo' => 'Si feu servir la camera Raspberry Pi (modul v1 o v2) connectada a una Raspberry Pi seleccioneu aquesta opci.',

	'ipcamera' => 'Camera IP',

	'ipcameraInfo' => 'Seleccioneu aquesta opci si voleu fer servir una camera IP que suporti flux RTSP o MJPEG.',

	'surveillanceMode' => 'Vigilancia',

	'motion' => 'Moviment',

	'motionInfo' => 'Detector intelligent de moviment: pot prendre una fotografia o un video o activar altres dispositius a travos d\'un webhook. Es pot configurar la deteccio de moviment noms en una zona especifica de la imatge.',

	'storage' => 'Emmagatzemament',

	'storageInfo' => 'Feu servir Kerberos.cloud per a monitoritzar diverses sessions de Kerberos.io des de qualsevol lloc del m�n.',

	'dontForget' => 'Premeu validar per a confirmar la configuracio.',

	'update' => 'Validar',

	'cancel' => 'Cancellar',

	'confirmAndSelect' => 'Confirmeu i seleccioneu',

	// --------------
	// Camera

	/* to translate */ 'fpsRaspberryInfo' => 'The number of frames processed per second; note that this parameter also defines the number of frames per second of a video recording.',

	'width' => 'Amplada',

	'height' => 'Altura',

	'widthHeightInfo' => 'Resolucio de les imatges capturades. Assegureu-vos que sigui compatible amb les especificacions de la camera!',

	'delay' => 'retard en segons',

	'delayInfo' => 'El retard �s el temps en segons entre dues captures d\'imatge. Permet reduir el nombre d\'imatges processades (per exemple si teniu problemes de rendiment).',

	'livestream' => 'imatges/sec',

	'livestreamInfo' => 'Nombre d\'imatges per segon del flux en temps real. Amb 0 queda desactivat el flux.',

	'rotate' => 'Feu clic per girar la imatge. Per exemple, si la vostra camera esta muntada de cap per avall, assegureu-vos que aquesta imatge tambo ho esto.',

	'url' => 'Introducu la direccio url del flux RTSP o MJPEG de la vostra camera IP.',

	// ----------------
	// Motion

	'image' => 'Imatge',

	'video' => 'Video',

	'step1' => 'Pas 1. Seleccioneu una zona',

	'step1Info' => 'Moveu els punts per a seleccionar la zona de vigilancia. Per suprimir un punt feu-hi doble clic. Si cliqueu sobre el punt blanc n\'afegireu de nous.',

	'step2' => 'Pas 2. Configureu els parametres',

	'step2Info' => 'Amb el canvi de la configuracio de sota podeu fer mes o menys sensible la deteccio de moviment.',

	'step3' => 'Pas 3. Seleccioneu una o mes sortides',

	'step3Info' => 'Quan es detecta moviment podeu executar una o mes sortides.',

	'sensitivity' => 'sensibilitat',

	'sensitivityInfo' => 'Incrementeu el cursor per augmentar la sensibilitat al moviment. Decrementeu-lo per reduir-la.',

	'numberOfDetections' => 'nombre de deteccions per a considerar-ho valid',

	'numberOfDetectionsInfo' => 'Representa el nombre de deteccions seguides per tal que Kerberos.io activi un esdeveniment com a valid. En incrementar el valor s\'eliminen falsos positius com ara llampecs, novols, etc.',

		// ------------------
		// Timestamp - Colors

		'noTimestamp' => 'sense marca de data i hora',

		'white' => 'blanc',

		'black' => 'negre',

		'red' => 'vermell',

		'green' => 'verd',

		'blue' => 'blau',

	'drawTimestamp' => 'activeu la insercio de data i hora',

	'drawTimestampInfo' => 'En guardar la imatge al disc hi quedara marcada la data i l\'hora.',

	'drawTimestampInfoVideo' => 'En guardar la imatge al disc hi quedara marcada la data i l\'hora.',

	'fps' => 'imatges per segon',

	'fpsInfo' => 'El nombre d\'imatges per segon amb qui es guarda el fitxer de video; tingueu present que la Raspberry Pi pot processar un nombre limitat d\'imatges per segon (al voltant de 7).',

	'secondsRecord' => 'durada de l\'enregistrament en segons',

	'secondsRecordInfo' => 'Durada de l\'enregistrament (en segons) despres d\'una deteccio de moviment.',

	'webhookUrl' => 'url',

	'webhookUrlInfo' => 'URL (direccio web) a la que s\'enviara el POST amb un objecte JSON.',

	'scriptPath' => 'cam',

	'scriptPathInfo' => 'Cam d\'acces a un script bash que sero executat. S\'enviar com a parametre un objecte JSON.',

	'gpioPin' => 'pin',

	'gpioPinInfo' => 'Definiu el numero del pin al qual s\'enviara la pulsacia.',

	'gpioPeriod' => 'durada',

	'gpioPeriodInfo' => 'Durada (en microsegons) de la pulsacia.',

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

	'whatIsThis' => 'De qui va aixo?',

	'whatIsthisInformation' => 'Kerberos.io disposa de la seva propia aplicacia en el novol. Si us subscriviu a un pla podreu sincronitzar totes les vostres imatges i videos, i veure\'ls des de qualsevol lloc del m�n. En subscriure-us rebreu les credencials per posar en els camps de l\'esquerra. Despros de confirmar i actualitzar els ajustos, la vostra activitat es comencara a sincronitzar automaticament.',

	'subscribeNow' => 'Subscriviu-vos ara per noms 1,49€',

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
