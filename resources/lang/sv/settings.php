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

	'image' => 'Bild',

	'video' => 'Video',

	'step1' => 'Steg 1. Välj en region',

	'step1Info' => 'Flytta punkterna för att rita regionen som är intressant. Dubbelklicka på en punkt för att ta bort den, och/eller på den vita punkten för att lägga till fler punkter.',

	'step2' => 'Steg 2. Konfigurera parametrar',

	'step2Info' => 'Genom att ändra konfigurationen nedan kan du göra rörelsedetekteringen mer eller mindre känslig.',

	'step3' => 'Steg 3. Välj en eller flera utmatningar',

	'step3Info' => 'När rörelse upptäcks kan du exekvera (asynkront) en eller flera utmatningar.',

	'sensitivity' => 'känslighet',

	'sensitivityInfo' => 'Genom att öka detta skjutreglage blir Kerberos.io mer känsligt för rörelse. mindska för att minimera känsligheten för rörelse.',

	'numberOfDetections' => 'antal detekteringar innan giltig',

	'numberOfDetectionsInfo' => 'Detta nummer representerar det antal detekteringar i följd som krävs för att Kerberos.io ska aktivera en giltig händelse. Genom att öka detta värde så kan du minimera falska positiva: t.ex. blixtar, moln, mm.',

		// ------------------
		// Timestamp - Colors

		'noTimestamp' => 'ingen tidsstämpel',

		'white' => 'vit',

		'black' => 'svart',

		'red' => 'röd',

		'green' => 'grön',

		'blue' => 'blå',

	'drawTimestamp' => 'rita tidsstämpel',

	'drawTimestampInfo' => 'När en bild sparas till hårddisken så ritas datum och tid på bilden.',

	'drawTimestampInfoVideo' => 'När en video sparas till hårddisken så ritas datum och tid på videon.',

	'privacy' => 'integritet',

	'privacyInfo' => 'Genom att aktivera detta alternativ så blir allt utom den valda regionen från steg 1 svart.',

	'fps' => 'bilder per sekund',

	'fpsInfo' => 'Antal bilder per sekund som skrivs till videofilen; tänk på att Raspberry Pi kan enbart hantera en begränsad mängd av bilder per sekund (t.ex. 7 bilder per sekund).',

	'secondsRecord' => 'antal sekunder att spela in',

	'secondsRecordInfo' => 'Antalet sekunder som kommer spelas in efter att rörelse upptäcktes.',

	'webhookUrl' => 'url',

	'webhookUrlInfo' => 'Addressen som en POST kommer att skickas till med ett JSON objekt.',

	'scriptPath' => 'sökväg',

	'scriptPathInfo' => 'Sökvägen till ett bash-skript som kommer köras. Ett JSON-objekt skickas som parameter.',

	'gpioPin' => 'stift',

	'gpioPinInfo' => 'Ange stiftnummret som en puls kommer att skickas på.',

	'gpioPeriod' => 'period',

	'gpioPeriodInfo' => 'Antalet mikrosekunder som pulsen kommer vara.',

	'hardwareEncodingEnabled' => 'Din fångstenhet stödjer chiffrering på hårdvaran, därför kan du inte välja fler parametrar (t.ex. sätta tidsstämplar).
	Videon som genereras kommer också att ha samma specifikationer som fångstenheten du valt (t.ex. bilder per sekund, skärpa, mm).',

  'secure' => 'säker',

	'secureInfo' => 'Aktivera SSL/TLS. CA certifikat bör placeras i mappen /etc/ssl/certs/ .',

  'verifycn' => 'verifiera',

	'verifycnInfo' => 'Verifiera certifikatets CN (Vanligt Namn)',

  'mqttServer' => 'server',

  'mqttServerInfo' =>  'MQTT-mäklartjänstens IP-adress.',

  'mqttPort' => 'port',

  'mqttPortInfo' =>  'MQTT-mäklartjänstens portnummer.',

  'mqttTopic' => 'ämne',

  'mqttTopicInfo' =>  'Ämnesnamnet som MQTT-meddelanden skickas.',

  'mqttClientId' =>  'klient_id',

  'mqttClientIdInfo' =>  'Klient id:t som används för att ansluta till en MQTT-mäklare.',

  'mqttUsername' => 'användarnamn',

  'mqttUsernameInfo' =>  'Användarnamnet som används för att autentisera med MQTT-mäklaren.',

  'mqttPassword' => 'lösenord',

  'mqttPasswordInfo' =>  'Lösenordet som används för att autentisera med MQTT-mäklaren.',

  'throttler' => 'begränsning',

  'throttlerInfo' =>  'Använd för att begränsa överdrivet många meddelanden. T.ex Kör enbart en gång var femte sekund.',

	// --------------
	// Cloud

	'whatIsThis' => 'Vad är det här',

	'whatIsthisInformation' => 'Kerberos.io har sin egen molntjänst. Genom att prenumerera på en plan så kan du synkronisera alla dina bilder och videos och titta på dem från var som helst i världen. När du prenumererar så kommer du få login-information som du kan ange i fälten till vänster. Efter att du bekräftat och uppdaterat inställningarna så kommer dina aktiviteter att sykroniseras automatiskt. Ha kul!',

	'subscribeNow' => 'Prenumerera nu för endast €1,99',

  'verifyConnectivity' => 'Verifiera anslutning',

  'cloudHurray' => 'Hurra, anslutningen lyckades. Dina medier kommer nu synkroniseras med molnet automatiskt.',

  'cloudWentWrong' => 'Något gick fel, verifiera att du angett dina inloggningsuppgifter korrekt.',

  'cloudWentWrongMoreHelp' => 'Klicka här för mer hjälp.',

  'checkConnection' => 'Kolla uppkopplingen',

	// ---------------
	// KiOS settings

	'forceNetwork' => 'Tvinga nätverksläge',

	'forceNetworkInfo' => 'När detta är aktiverat så kommer operativsystemet att starta om ifall det inte kan ansluta till Internet. Detta krävs om du använder molntjänsten men har ett opålitligt nätverk.',

	'autoRemoval' => 'Ta bort media automatiskt',

	'autoRemovalInfo' => 'När aktiv så tas bilder bort automatiskt om hårddisken nästan är full.'

);
