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

  'settings' => 'Réglages',

  'configuration' => 'Configuration',

	'update' => 'Sauvegarder',

	'heatmap' => 'Points chauds',

	'general' => 'Préférences',

	'purchase' => 'Accédez à votre video-surveillance depuis n\'importe où dans le monde avec <b>Kerberos.cloud</b> ; <u>démarrez</u> pour seulement 1,49€ par mois!',

	'basic' => 'Simple',

	'advanced' => 'Avancé',

	'name' => 'Nom',

	'nameInfo' => 'Un nom unique est requis pour votre camera si vous lancez plusieurs instances de Kerberos.io.',

	'timezone' => 'Fuseau horaire',

	'timezoneInfo' => 'Le fuseau horaire permet de calculer le décalage horaire avec l`heure locale. Il est utilisé par le moteur et l\'interface web.',

	'camera' => 'Caméra',

	'usbcamera' => 'Caméra USB',

	'usbcameraInfo' => 'Sélectionner cette option pour utiliser une camera USB.',

	'rpicamera' => 'Caméra RPi',

	'rpicameraInfo' => 'Si vous utilisez Kerberos.io sur un Raspberry Pi, vous pouvez sélectionner cette option pour activer le module caméra (v1 ou v2).',

	'ipcamera' => 'Caméra IP',

	'ipcameraInfo' => 'Selectionner cette option pour utiliser une caméra IP compatible avec les flux RTSP ou MJPEG.',

	'surveillanceMode' => 'Surveillance',

	'motion' => 'Mouvement',

	'motionInfo' => 'Détection intelligente de mouvement : prend un photo ou une video et peut déclancher un webhook. Il est possible de configurer une région spécifique de l\'image pour la détection de mouvement.',

	'storage' => 'Stockage',

	'storageInfo' => 'Utiliser Kerberos.cloud to suivre plusieurs instances de Kerberos.io depuis n\'importe où dans le monde.',

	'dontForget' => 'Clickez sur "Valider" pour confirmer la configuration.',

	'update' => 'Valider',

	'cancel' => 'Annuler',

	'confirmAndSelect' => 'Confirmer and sélectionner',

	// --------------
	// Camera

	/* to translate */ 'fpsRaspberryInfo' => 'The number of frames processed per second; note that this parameter also defines the number of frames per second of a video recording.',

	'width' => 'Largeur',

	'height' => 'Hauteur',

	'widthHeightInfo' => 'La résolution des images capturées. Doit-être compatible avec les spécifications de la caméra !',

	'delay' => 'delai en secondes',

	'delayInfo' => 'Le délai indique à Kerberos.io d\'attendre entre deux captures d\'images. Permet de réduire le nombre d\'images traitées par seconde.',

	'livestream' => 'images/sec',

	'livestreamInfo' => 'Le nombre d\'images par secondes du flux live. Mettre à 0 pour désactiver le flux live.',

	'rotate' => 'Click pour effectuer une rotation de l\'image. Par exemple, si la caméra est montée tête en bas, assurez-vous que l\'image l\'est aussi.',

	'url' => 'Entrez l\'URL du flux RTSP ou MJPEG de la caméra IP.',

	// ----------------
	// Motion

	'image' => 'Image',

	'video' => 'Vidéo',

	'step1' => 'Etape 1. Sélectionner une région',

	'step1Info' => 'Déplacer les points pour dessiner la région à surveiller. Double-clicker sur un point pour le supprimer, ou sur le point pour ajouter un nouveau point.',

	'step2' => 'Etape 2. Configurer les paramètres',

	'step2Info' => 'Changer la configuration ci-dessous pour ajuster la sensibilité de la détection.',

	'step3' => 'Etape 3. Sélectionner une ou plusieurs sorties',

	'step3Info' => 'Les sorties sont exécutées quand un mouvement est détecté.',

	'sensitivity' => 'sensibilité',

	'sensitivityInfo' => 'Augmenter le curseur pour augmenter la sensibilité.',

	'numberOfDetections' => 'Nombre de détections avant action',

	'numberOfDetectionsInfo' => 'Le nombre de détections d\'affilée qui sont nécessaires pour que Kerberos.io déclenche un évènement. Augmenter cette valeur permet d\'éliminter les faux-positifs dûs aux changements de luminosité, aux nuages, etc.',

	// ------------------
	// Timestamp - Colors

	'noTimestamp' => 'Pas d\'horodatage',

	'white' => 'blanc',

	'black' => 'noir',

	'red' => 'rouge',

	'green' => 'vert',

	'blue' => 'bleu',

	'drawTimestamp' => 'Activer l\'horodatage',

	'drawTimestampInfo' => 'Activer l\'affichage de la date et de l\'heure sur les images sauvées sur disque.',

	/* to translate */ 'drawTimestampInfoVideo' => 'When a video is saved to disk, you can draw the current date and time on the video.',

	/* to translate */ 'privacy' => 'privacy',

	/* to translate */ 'privacyInfo' => 'By enabling this option, only the selected region of step 1 will be visible. All pixels outside the region are made black.',

	'fps' => 'images par seconde',

	'fpsInfo' => 'Le nombre d\'image par seconde écrites dans le fichier vidéo. Attention, le Raspberry Pi a une limite du nombre de FPS (7 FPS environ)',

	'secondsRecord' => 'durée d\'enregistrement en secondes',

	'secondsRecordInfo' => 'La durée de l\'enregistrement après une détection de mouvement.',

	'webhookUrl' => 'url',

	'webhookUrlInfo' => 'L\'URL de destination de la requête POST.',

	'scriptPath' => 'chemin',

	'scriptPathInfo' => 'Le chemin du script BASH qui sera exécuté. Un objet JSON est passé en paramètre.',

	'gpioPin' => 'pin GPIO',

	'gpioPinInfo' => 'Définit le numéro de pin GPIO qui recevra une impulsion.',

	'gpioPeriod' => 'Durée',

	'gpioPeriodInfo' => 'Durée de l\'impulsion en microseconde.',

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

	'whatIsThis' => 'Qu\'est-ce donc ?',

	'whatIsthisInformation' => 'Kerberos.io possède sa propre application dans le cloud. En souscrivant au service, vous pouvez synchroniser toutes les images et videos capturées, et les consulter de partout dans le monde. Après l\'enregistrement, vous recevrez votre informations de connexion à copier dans les champs à gauche. Après confirmation, toute l\'activité sera synchronisée automatiquement.',

	'subscribeNow' => 'Enregistrez-vous maintenant pour seulement 1,49€',

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
