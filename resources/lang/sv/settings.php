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

  'settings' => 'Inställningar',

  'configuration' => 'Konfiguration',

	'update' => 'Uppdatera',

	'heatmap' => 'Värmekarta',

	'general' => 'Generella inställningar',

	'purchase' => 'Håll koll på din aktivitet från var som helst i världen med <b>Kerberos Cloud</b>, Kom <u>igång</u> för enbart 1,99€/månad!',

	'basic' => 'Grundläggande',

	'advanced' => 'Avancerad',

	'name' => 'Namn',

	'nameInfo' => 'Det krävs ett unikt namn för din kamera, om du vill köra flera instanser av Kerberos.io.',

	'timezone' => 'Tidszon',

	'timezoneInfo' => 'Tidszonen används för att konvertera tidstämplar till din lokala tid. Det används både i maskineriet och i webbgränssnittet.',

	'camera' => 'Kamera',

	'usbcamera' => 'USB-kamera',

	'usbcameraInfo' => 'Välj detta alternativ om du vill använda en USB-kamera.',

	'rpicamera' => 'RPi-kamera',

	'rpicameraInfo' => 'Om du kör Kerberos.io på en Raspberry Pi, du kan välja detta alternativ om du vill använda en Raspberry Pi kameramodul (v1 eller v2).',

	'ipcamera' => 'IP-kamera',

	'ipcameraInfo' => 'Välj detta alternativ om du vill använda en IP-kamera som stödjer en RTSP eller MJPEG ström.',

	'surveillanceMode' => 'Övervakning',

	'motion' => 'Rörelse',

	'motionInfo' => 'En smart rörelsedetektor som sparar direktbilder eller video, och/eller anropar andra enheter med hjälp av en webhook. Ställ in förhållanden för att enbart detektera rörelse inom en specifik region i vyn.',

	'storage' => 'Lagring',

	'storageInfo' => 'Använd Kerberos Cloud för att följa upp flera instanser av Kerberos.io från var som helst i världen.',

	'dontForget' => 'Tryck på uppdatera för att bekräfta din konfiguration.',

	'update' => 'Uppdatera',

	'cancel' => 'Avbryt',

	'confirmAndSelect' => 'Bekräfta och välj',


	// --------------
	// Camera

	'fpsRaspberryInfo' => 'Antalet bildrutor som hanteras per sekund; tänk på att denna parameter också definierar antalet bildrutor per sekund på en videoinspelning.',

	'width' => 'Bredd',

	'height' => 'Höjd',

	'widthHeightInfo' => 'Upplösningen på bilderna som fångas av din kamera. Se till att denna upplösning stöds!',

	'delay' => 'försening i sekunder',

	'delayInfo' => 'Förseningen säger till Kerberos.io att vänta i x antal sekunder mellan två fångade bildrutor. Detta är användbart när du vill midska antalet bilder som hanteras per sekund (till exempel p.g.a. prestandaanledningar).',

	'livestream' => 'live ström bildrutor/sek',

	'livestreamInfo' => 'Antalet bildrutor per sekund av livesändningen kan konfigureras. Sätts detta alternativ till noll kommer liveströmmen att inaktiveras.',

	'rotate' => 'Klicka på denna bild om din kamera är roterad. T.ex. om din kamera är monterad upp och ner, se till att denna bild också är upp och ner.',

	'url' => 'Ange RTSP- eller MJPEG-urlen för din IP-kamera.',

	// ----------------
	// Motion

	'image' => 'Image',

	'video' => 'Video',

	'step1' => 'Step 1. Select a region',

	'step1Info' => 'Move the points to draw the region of interest. Double click on a point to remove it, and/or on the white point to add more points.',

	'step2' => 'Step 2. Configure parameters',

	'step2Info' => 'By changing the configuration below you can make the motion detection more or less sensitive.',

	'step3' => 'Step 3. Select one or more outputs',

	'step3Info' => 'Once motion is detected you can execute (asynchronous) one or more outputs.',

	'sensitivity' => 'sensitivity',

	'sensitivityInfo' => 'Increasing this slider will make Kerberos.io more sensitive for motion. Decreasing will make it less sensitive for motion.',

	'numberOfDetections' => 'number of detections before valid',

	'numberOfDetectionsInfo' => 'This number represents the number of detections in a row before Kerberos.io will trigger a valid event. By increasing this value, you can eliminate false-positives: e.g. lightning, clouds, etc.',

		// ------------------
		// Timestamp - Colors

		'noTimestamp' => 'no timestamp',

		'white' => 'white',

		'black' => 'black',

		'red' => 'red',

		'green' => 'green',

		'blue' => 'blue',

	'drawTimestamp' => 'draw timestamp',

	'drawTimestampInfo' => 'When an image is saved to disk, you can draw the current date and time on the image.',

	'drawTimestampInfoVideo' => 'When a video is saved to disk, you can draw the current date and time on the video.',

	'privacy' => 'privacy',

	'privacyInfo' => 'By enabling this option, only the selected region of step 1 will be visible. All pixels outside the region are made black.',

	'fps' => 'frames per second',

	'fpsInfo' => 'The frames per second written to the video file; be aware that a Raspberry Pi can only process a limited number of FPS (e.g. 7 FPS).',

	'secondsRecord' => 'seconds to record',

	'secondsRecordInfo' => 'The number of seconds that will be recorded after motion was detected.',

	'webhookUrl' => 'url',

	'webhookUrlInfo' => 'The url to which a POST will be sent with a JSON object.',

	'scriptPath' => 'path',

	'scriptPathInfo' => 'The path to a bash script that will be executed. A JSON object is send as a parameter.',

	'gpioPin' => 'pin',

	'gpioPinInfo' => 'Define the pin number on which a pulse will be send.',

	'gpioPeriod' => 'period',

	'gpioPeriodInfo' => 'The number of microseconds the pulse will last.',

	'hardwareEncodingEnabled' => 'Your capture device supports on board hardware encoding, that\'s why you can\'t choose additional parameters (e.g. timestamping).
	Also the video generated will have the same specifications as the capture device you\'ve chosen (e.g. FPS, sharpness, etc).',

  'secure' => 'secure',

	'secureInfo' => 'Enable SSL/TLS. CA certificate should be in /etc/ssl/certs/ directory.',

  'verifycn' => 'verify',

	'verifycnInfo' => 'Verify certificate CN (Common Name)',

  'mqttServer' => 'server',

  'mqttServerInfo' =>  'The IP address of the MQTT broker service.',

  'mqttPort' => 'port',

  'mqttPortInfo' =>  'Port number of the MQTT broker service.',

  'mqttTopic' => 'topic',

  'mqttTopicInfo' =>  'The topic name to which MQTT messages are sent.',

  'mqttClientId' =>  'client_id',

  'mqttClientIdInfo' =>  'The ClientId which is used to connect to a MQTT broker.',

  'mqttUsername' => 'username',

  'mqttUsernameInfo' =>  'The username to authenticate with the MQTT broker.',

  'mqttPassword' => 'password',

  'mqttPasswordInfo' =>  'The password to authenticate with the MQTT broker.',

  'throttler' => 'throttle',

  'throttlerInfo' =>  'Use to prevent spamming. Eg. only execute once within 5 seconds.',

	// --------------
	// Cloud

	'whatIsThis' => 'What is this',

	'whatIsthisInformation' => 'Kerberos.io comes with its own cloud application. By subscribing to a plan, you can sync all your images and videos, and review it from anywhere in the world. Once subscribed, you\'ll receive some credentials which you can fill in the fields on the left. After confirming and updating the settings, you\'re activity will be synced automatically. Have fun!',

	'subscribeNow' => 'Subscribe now for only €1,99',

  'verifyConnectivity' => 'Verify connectivity',

  'cloudHurray' => 'Hurray, connection was succesful. Your media will now be synced automatically to your cloud account.',

  'cloudWentWrong' => 'Something went wrong, verify you\'ve entered your credentials correctly.',

  'cloudWentWrongMoreHelp' => 'Click here for more support.',

  'checkConnection' => 'Check connection',

	// ---------------
	// KiOS settings

	'forceNetwork' => 'Force network mode',

	'forceNetworkInfo' => 'When enabled the OS will reboot if it can\'t connect to the internet. This is necessary if you are using the cloud application, but have an unreliable network.',

	'autoRemoval' => 'Auto removal media',

	'autoRemovalInfo' => 'When enabled images are automatically removed when disk is almost full.'

);
