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

  'settings' => 'Einstellungen',

  'configuration' => 'Konfiguration',

	'update' => 'Aktualisieren',

	'heatmap' => 'Heatmap',

	'general' => 'Allgemeine Einstellungen',

	'purchase' => 'Schau deine Aktivitäten von überall auf der Welt an mit <b>Kerberos.cloud</b>, Leg <u>los</u> für nur 1,49€/Monat!',

	'basic' => 'Grundlagen',

	'advanced' => 'Fortgeschritten',

	'name' => 'Name',

	'nameInfo' => 'Ein eindeutiger Name ist für die Kamera erforderlich, wenn Sie mehrere Kerberos.io Instanzen verwenden.',

	'timezone' => 'Zeitzone',

	'timezoneInfo' => 'Die Zeitzone wird gebraucht um die Zeitstempel in das lokale Zeitformat zu konvertieren. Es wird sowohl in der Weboberfläche als auch in der Maschine genutzt',

	'camera' => 'Kamera',

	'usbcamera' => 'USB Kamera',

	'usbcameraInfo' => 'Diese Option auswählen wenn sie eine USB Kamera verwenden wollen',

	'rpicamera' => 'RPi Kamera',

	'rpicameraInfo' => 'Wenn Kerberos.io auf einem Raspberry Pi läuft können Sie diese Option auswählen, sofern ein Raspberry Pi Kamera-Modul (v1 oder v2) angeschlossen ist.',

	'ipcamera' => 'IP Kamera',

	'ipcameraInfo' => 'Diese Option auswählen, wenn Sie eine IP Kamera verwenden wollen welche RTSP oder MJPEG stream unterstützt.',

	'surveillanceMode' => 'Überwachung',

	'motion' => 'Bewegung',

	'motionInfo' => 'Intelligente Bewegungserkennung welche Schnappschüsse oder Videos speichert, und/oder andere Geräte via webhook auslöst. Bedingungen einrichten um nur einen bestimmten Bereich im Blickfeld zu überwachen.',

	'storage' => 'Speicher',

	'storageInfo' => 'Verwende Kerberos.cloud um mehrere Kerberos.io Instanzen von überall auf der Welt zu überwachen.',

	'dontForget' => 'Aktualisieren auswählen um die Konfiguration zu speichern.',

	'update' => 'Aktualisieren',

	'cancel' => 'Abbrechen',

	'confirmAndSelect' => 'Bestätigen und auswählen',

	// --------------
	// Camera

	/* to translate */ 'fpsRaspberryInfo' => 'The number of frames processed per second; note that this parameter also defines the number of frames per second of a video recording.',

	'width' => 'Breite',

	'height' => 'Höhe',

	'widthHeightInfo' => 'The resolution of the images being captured by your camera. Make sure that this resolution is supported!',
	'widthHeightInfo' => 'Auflösung mit der die Kamera die Bilder aufzeichnet. Auflösung muss von der Kamera unterstützt werden!',

	'delay' => 'Verzögerung in Sekunden',

	'delayInfo' => 'Die Verzögerungszeit sagt Kerberos.io x Sekunden zwischen 2 Bildaufzeichnungen zu warten. Das ist sinnvoll wenn Sie weniger Bilder pro Sekunden verarbeiten wollen (z.B. bessere Performance).',

	'livestream' => 'Livestream frames/sek',

	'livestreamInfo' => 'Frames pro Sekunde des Livestreams konfigurieren. Wenn diese Option auf 0 gesetzt wird, wird der Livestream deaktiviert.',

	'rotate' => 'Aufs Bild klicken wenn die Kamera gedreht ist. z.B. wenn die Kamera über Kopf angebracht ist um sicher zu gehen das das Bild auch auf den Kopf steht.',

	'url' => 'URL des RTSP oder MJPEG stream Ihrer IP camera.',

	// ----------------
	// Motion

	'image' => 'Bild',

	'video' => 'Video',

	'step1' => 'Schritt 1. Region auswählen',

	'step1Info' => 'Punkte bewegen um Region die von Interesse ist auszuwählen. Doppelklick um einen Punkt zu entfernen, und/oder auf den weißen Punkt um mehr hinzuzufügen.',

	'step2' => 'Step 2. Parameter konfigurieren',

	'step2Info' => 'By changing the configuration below you can make the motion detection more or less sensitive.',
	'step2Info' => 'Mit den Parametern kann die Bewegungserkennung mehr oder weniger empfindlich eingestellt werden.',

	'step3' => 'Step 3. Eine oder mehrere Ausgaben auswählen',

	'step3Info' => 'Wenn eine Bewegung erkannt worden können eine oder mehrere Ausgaben (asynchron) ausgeführt werden.',

	'sensitivity' => 'Empfindlichkeit',

	'sensitivityInfo' => 'Kerberos.io ist empfindlicher wenn der Schieberegler erhöht wird. Entsprechend umgekehrt wenn er verringert wird.',

	'numberOfDetections' => 'Anzahl der Erkennungen bevor Aktivität erkannt',

	'numberOfDetectionsInfo' => 'Die Zahl repräsentiert die Anzahl der Erkennungen die hintereinander auftreten müssen bevor Kerberos.io eine gültige Aktivität auslöst. Wenn der Wert erhöht wird werden Falschmeldungen verhindert z.B. Wolken, Blitze, etc.',

		// ------------------
		// Timestamp - Colors

		'noTimestamp' => 'kein Zeitstempel',

		'white' => 'Weiß',

		'black' => 'Schwarz',

		'red' => 'Rot',

		'green' => 'Grün',

		'blue' => 'Blau',

	'drawTimestamp' => 'Zeitstempel aufzeichen',

	'drawTimestampInfo' => 'Wenn ein Bild gespeichert wird Datum und Uhrzeit auf dem Bild hinterlegen.',

	/* to translate */ 'drawTimestampInfoVideo' => 'When a video is saved to disk, you can draw the current date and time on the video.',

	/* to translate */ 'privacy' => 'privacy',

	/* to translate */ 'privacyInfo' => 'By enabling this option, only the selected region of step 1 will be visible. All pixels outside the region are made black.',

	'fps' => 'Frames pro Sekunde',

	'fpsInfo' => 'Frmes pro Sekunde mit der das Video geschrieben wird; bitte beachten das der Raspberry Pi nur eine geringe Anzahl von FPS verarbeiten kann (z.B. 7 FPS).',

	'secondsRecord' => 'Aufzeichnungslänge in Sekunden',

	'secondsRecordInfo' => 'Die Länge in Sekunden die aufgezeichnet werden nachdem eine Bewegung erkannt wurde.',

	'webhookUrl' => 'URL',

	'webhookUrlInfo' => 'Die URL an die ein JSON Objekt via POST gesendet wird.',

	'scriptPath' => 'Pfad',

	'scriptPathInfo' => 'Pfad zum bash Skript das ausgeführt wird. Ein JSON Objekt wird als Parameter übergeben.',

	'gpioPin' => 'PIN',

	'gpioPinInfo' => 'PIN Nummer die ein Signal erhält.',

	'gpioPeriod' => 'Zeitraum',

	'gpioPeriodInfo' => 'Signallänge in Mikrosekunden.',

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

	'whatIsThis' => 'Was ist das',
	'whatIsthisInformation' => 'Kerberos.io kommt mit einer eigenen Cloudanwendung. Mit einem Abonnement werden alle Bilder und Videos synchronisiert und sind dadurch von überall auf der Welt erreichbar. Sobald Sie abonniert sind erhalten Sie Zugangsdaten welche in die Felder zu Ihrer linken eingefügt werden können. Nachdem die Einstellungen gespeichert wurden werden die Aktivitäten automatisch synchronisiert. Viel Spass!',

	'whatIsthisInformation' => '',

	'subscribeNow' => 'Für nur €1,49 abonnieren',

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
