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

	'nameInfo' => 'È richiesto un nome univoco per la tua telecamera, nel caso in cui eseguirai istanze multiple di Kerberos.io.',

	'timezone' => 'Fuso Orario',

	'timezoneInfo' => 'Il fuso orario è usato per convertire i timestamp alla tua ora locale. È usato sia da machinery che dall\'interfaccia web',

	'camera' => 'Telecamera',

	'usbcamera' => 'Telecamera USB',

	'usbcameraInfo' => 'Seleziona questa opzione, se vuoi usare una telecmera USB',

	'rpicamera' => 'Telecamera RPi',

	'rpicameraInfo' => 'Se esegui Kerberos.io su una Raspberry Pi puoi selezionare questa opzione se vuoi usare un modulo telecamera Raspberry Pi (v1 o v2).',

	'ipcamera' => 'Telecamera IP',

	'ipcameraInfo' => 'Seleziona questa opzione se vuoi usare una telecamera IP che supporta i flussi RTSP oppure MJPG.',

	'surveillanceMode' => 'Sorveglianza',

	'motion' => 'Movimento',

	'motionInfo' => 'Un rilevatore di movimento intelligente, che salva snapshot o filmati, e/o innesca altri dispositivi usando un webhook. Imposta le condizioni per rilevare il movimento solo in una particolare area.',

	'storage' => 'Spazio di archiviazione',

	'storageInfo' => 'Usa Kerberos.cloud per seguire istanze multiple di Kerberos.io da ovunque nel mondo.',

	'dontForget' => 'Premi aggiorna per confermare la configurazione',

	'update' => 'Aggiorna',

	'cancel' => 'Annulla',

	'confirmAndSelect' => 'Conferma e seleziona',

	// --------------
	// Camera

	'fpsRaspberryInfo' => 'Il numero di frame processati per secondo; nota che questo parametro definisce anche il numero di frame per secondo di una registrazione video.',

	'width' => 'Larghezza',

	'height' => 'Altezza',

	'widthHeightInfo' => 'La risoluzione delle immagini catturate dalla tua telecamera. Assicurati che questa risoluzione sia supportata!',

	'delay' => 'ritardo in secondi',

	'delayInfo' => 'Il tempo di ritardo dirà a Kerberos.io di attendere  x secondi tra due catture di frame. Questo è utile quando si vuole ridurre il numero di immagini processate al secondo (p.es. per ragioni di performance)' ,

	'livestream' => 'frames/sec del flusso dal vivo',

	'livestreamInfo' => 'I frame al secondo del flusso dal vivo possone essere configurati. Configurando questa opzione a zero disabiliterà il flusso dal vivo.',

	'rotate' => 'Clicca su questa immagine se la tua telecamera è capovolta. P.es. se la tua telecamera è montata capovolta, assicurati che questa immagine sia anche capovolta.',

	'url' => 'Inserisci la url del flusso RTSP o MJPEG della tua telecamera IP.',

	// ----------------
	// Motion

	'image' => 'Immagine',

	'video' => 'Video',

	'step1' => 'Passo 1. Seleziona una regione',

	'step1Info' => 'Sposta i punti per disegnare una regione di interesse. Fai doppio click su un punto per rimuoverlo, e/o sul punto bianco per aggiungere più punti.',

	'step2' => 'Passo 2. Configura i parametri.',

	'step2Info' => 'Cambiando la configurazione qui sotto puoi rendere il rilevamento del movimento più o meno sensibile.',

	'step3' => 'Passo 3. Seleziona una o più uscite.',

	'step3Info' => 'Una volta rilevato il movimento puoi eseguire (in modo asincrono) una o più uscite.',

	'sensitivity' => 'sensibilità',

	'sensitivityInfo' => 'Aumentando questo slider renderà Kerberos.io più sensibile al movimento. Diminuendolo lo renderà meno sensibile al movimento',

	'numberOfDetections' => 'numero di rilevamenti prima di validare',

	'numberOfDetectionsInfo' => 'Questo numero rappresenta il numero di rilevamenti successivi prima che Kerberos.io inneschi un evento valido. Aumentando questo valore puoi eliminare falsi positivi: p.es. lampi, nuvole, etc ...',

		// ------------------
		// Timestamp - Colors

		'noTimestamp' => 'nessun timestamp',

		'white' => 'bianco',

		'black' => 'nero',

		'red' => 'rosso',

		'green' => 'verde',

		'blue' => 'blu',

	'drawTimestamp' => 'stampare timestamp',

	'drawTimestampInfo' => 'Quando un\'immagine viene salvata su disco, puoi stampare la data e ora corrente sull\'immagine.',

	'drawTimestampInfoVideo' => 'Quando un filmato viene salvato su disco, puoi stampare la data e ora corrente sul filmato.',

	'privacy' => 'privacy',

	'privacyInfo' => 'Abilitando questa opzione, solo la regione selezionata al passo 1 sarà visibile. Tutti i pixel fuori dalla regione saranno neri.',

	'fps' => 'frame al secondo',

	'fpsInfo' => 'I frame al secondo registrati nel file del filmato; fai attenzione che Raspberry Pi può processare solo un numero limitato di FPS (p.es. 7 FPS).',

	'secondsRecord' => 'secondi da registrare',

	'secondsRecordInfo' => 'Il numero di secondi che saranno registrati dopo che un movimento viene rilevato.',

	'webhookUrl' => 'url',

	'webhookUrlInfo' => 'L\'URL alla quale verrà inviata una POST con un oggetto JSON.',

	'scriptPath' => 'percorso disco',

	'scriptPathInfo' => 'Il percorso su disco ad uno script bash che verrà eseguito. Un oggetto JSON verrà passato come parametro.',

	'gpioPin' => 'pin',

	'gpioPinInfo' => 'Definisce il numero del pin al quale verrà inviato un impulso.',

	'gpioPeriod' => 'periodo',

	'gpioPeriodInfo' => 'Il numero di microsecondi che l\'impulso durerà.',

	'hardwareEncodingEnabled' => 'Il tuo dispositivo supporta l\'hardware encoding, ecco perchè non puoi scegliere parametri addizionali (p.es. timestamping).
	Inoltre il filmato generato avrà le stesse specifiche del dispositivo di cattura che hai scelto (p.es. FPS, sharpness, etc.)',

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

	'whatIsThis' => 'Cos\'è questo',

	'whatIsthisInformation' => 'Kerberos.io ha una propria applicazione cloud. Sottoscrivendo un piano di abbonamento puoi sincronizzare tutte le immagini e filmati e rivederli da ovunque nel mondo. Una volta abbonato, riceverai delle credenziali che puoi inserire nei campi qui a sinistra. Dopo la conferma ed aver aggiornato la configurazione, le tue attività saranno sincronizzate automaticamente. Divertiti! ',

	'subscribeNow' => 'Abbonati ora a soli €1,49',

  /* to translate */ 'verifyConnectivity' => 'Verify connectivity',

  /* to translate */ 'cloudHurray' => 'Hurray, connection was succesful. Your media will now be synced automatically to your cloud account.',

  /* to translate */ 'cloudWentWrong' => 'Something went wrong, verify you\'ve entered your credentials correctly.',

  /* to translate */ 'cloudWentWrongMoreHelp' => 'Click here for more support.',

  /* to translate */ 'checkConnection' => 'Check connection',

	// ---------------
	// KiOS settings

	'forceNetwork' => 'Forza il network mode',

	'forceNetworkInfo' => 'Quando abilitato il Sistema  si riavvierà se non riesce a connettersi ad internet. Questo è necessario se usi l\'applicazione cloud ma non hai una connessione affidabile',

	'autoRemoval' => 'Rimuovi i media automaticamente',

	'autoRemovalInfo' => 'Quando abilitato, le immagini soo automaticamente rimosse se il disco è pieno.'

);
