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

  'settings' => 'Impostazioni',

  'configuration' => 'Configurazione',

	'update' => 'Aggiorna',

	'heatmap' => 'Mappa del calore',

	'general' => 'Impostazioni generali',

	'purchase' => 'Guarda le tue attività da qualsiasi posto nel mondo con <b>Kerberos.cloud</b>. <u>Inizia</u> per soli 1,49€/mese!',

	'basic' => 'Base',

	'advanced' => 'Avanzato',

	'name' => 'Nome',

	'nameInfo' => 'È richiesto un nome univoco per la tua telecamera, se eseguirai istanze multiple di Kerberos.io.',

	'timezone' => 'Fuso Orario',

	'timezoneInfo' => 'Il fuso orario è usato per convertire i timestamp alla tua ora locale. È usato sia da machinery che da l\'interfaccia web',

	'camera' => 'Telecamera',

	'usbcamera' => 'Telecamera USB',

	'usbcameraInfo' => 'Seleziona questa opzione, se vuoi usare una telecmera USB',

	'rpicamera' => 'Telecamera RPi',

	'rpicameraInfo' => 'Se esegui Kerberos.io su una Raspberry Pi puoi selezionare questa opzione se vuoi usare un modulo telecamera Raspberry Pi (v1 o v2).',

	'ipcamera' => 'Telecamera IP',

	'ipcameraInfo' => 'Seleziona questa opzione se vuoi usare una telecamera IP che supporta i flussi RTSP oppure MJPG.',

	'surveillanceMode' => 'Sorveglianza',

	'motion' => 'Movimento',

	'motionInfo' => 'Un rilevatore di movimento intelligente, che salva snatshot o video, e/o innesca altri dispositivi usando un webhook. Imposta le condizioni per rilevare il movimento solo in una particolare area.',

	'storage' => 'Spazio di archiviazione',

	'storageInfo' => 'Usa Kerberos.cloud per seguire istanze multiple di Kerberos.io da ovunque nel mondo.',

	'dontForget' => 'Premi aggiorna per confermare la configurazione',

	'update' => 'Aggiorna',

	'cancel' => 'Annulla',

	'confirmAndSelect' => 'Conferma e seleziona',


	// --------------
	// Camera

	'fpsRaspberryInfo' => 'Il numero di frames processati per secondo; nota che questo parametro definisce anche il numero di frame per secondo di una registrazione video.',

	'width' => 'Larghezza',

	'height' => 'Altezza',

	'widthHeightInfo' => 'La risoluzione delle immagini catturate dalla tua telecamera. Assicurati che questa risoluzione sia supportata!',

	'delay' => 'ritardo in secondi',

	'delayInfo' => 'Il tempo di ritardo dirà a Kerberos.io di attendere per x secondi tra due catture di frame. Questo è utile quando si vuole ridurre il numero di immagini processate al secondo (p.e. per ragioni di performance)' ,

	'livestream' => 'frames/sec del flusso dal vivo',

	'livestreamInfo' => 'I frame al secondo del flusso dal vivo possone essere configurati. Configurando questa opzione a zero disabiliterà il flusso dal vivo.',

	'rotate' => 'Clicca su questa immagine se la tua telecamera è capovolta. P.e. se la tua telecamera è montata capovolta, assicurati che questa immagine sia anche capovolta.',

	'url' => 'Inserisci la url del flusso RTSP o MJPEG della tua telecamera IP.',

	// ----------------
	// Motion

	'image' => 'Immagine',

	'video' => 'Video',

	'step1' => 'Passo 1. Seleziona una regione',

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

	// --------------
	// Cloud

	'whatIsThis' => 'What is this',

	'whatIsthisInformation' => 'Kerberos.io comes with its own cloud application. By subscribing to a plan, you can sync all your images and videos, and review it from anywhere in the world. Once subscribed, you\'ll receive some credentials which you can fill in the fields on the left. After confirming and updating the settings, you\'re activity will be synced automatically. Have fun!',

	'subscribeNow' => 'Subscribe now for only €1,49',

	// ---------------
	// KiOS settings

	'forceNetwork' => 'Force network mode',

	'forceNetworkInfo' => 'When enabled the OS will reboot if it can\'t connect to the internet. This is necessary if you are using the cloud application, but have an unreliable network.',

	'autoRemoval' => 'Auto removal media',

	'autoRemovalInfo' => 'When enabled images are automatically removed when disk is almost full.'

);
