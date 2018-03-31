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

  'settings' => 'Instellingen',

  'configuration' => 'Configuratie',

	'update' => 'Aanpassen',

	'heatmap' => 'Warmtefoto',

	'general' => 'Algemene instellingen',

	'purchase' => 'Bekijk je activeit overal ter wereld met <b>Kerberos.cloud</b>, Start <u>nu</u> voor slechts 1,49€/maand!',

	'basic' => 'Eenvoudig',

	'advanced' => 'Moeilijk',

	'name' => 'Naam',

	'nameInfo' => 'Een unieke naam per camera is verplicht indien je meerdere Kerberos.io installaties zal opzetten. Dit is nodig om onderscheid te kunnen maken tussen de verschillende beelden of videos.',

	'timezone' => 'Tijdzone',

	'timezoneInfo' => 'De tijdzone wordt gebruikt om de correct datum en tijd, die in jouw land van toepassing is, van de verschillende events te kunnen weergeven.',

	'camera' => 'Camera',

	'usbcamera' => 'USB camera',

	'usbcameraInfo' => 'Selecteer deze optie, indien je gebruikmaakt van een USB camera.',

	'rpicamera' => 'RPi camera',

	'rpicameraInfo' => 'Wanneer je Kerberos.io gebruikt op een Raspberry Pi, kan je gebruik maken van de Raspberry Pi camera module (versie 1 of 2).',

	'ipcamera' => 'IP camera',

	'ipcameraInfo' => 'Selecteer deze optie als je gebuik wilt maken van een IP camera doormiddel van een RTSP of MJPEG stream.',

	'surveillanceMode' => 'Beveiliging',

	'motion' => 'Beweging',

	'motionInfo' => 'Een eenvoudige maar slimme bewegings detector, welke snapshots en video zal opslaan van zodra er beweging is gedetecteerd. Er is een mogelijkheid om deze gegevens naar jouw eigen applicatie door te sluizen doormiddel van een webhook.',

	'storage' => 'Opslag',

	'storageInfo' => 'Gebruik Kerberos.cloud om één of meerdere Kerberos.io installaties op te volgen overal ter wereld.',

	'dontForget' => 'Klik op de update knop om jouw configuratie te bevestigen.',

	'update' => 'Pas aan',

	'cancel' => 'Sluiten',

	'confirmAndSelect' => 'Bevestig en slecteer',


	// --------------
	// Camera

	'fpsRaspberryInfo' => 'Het aantal beelden per seconde die worden verwerkt; let op deze parameter bepaalt ook het aantal beelden per seconde van een video opname.',

	'width' => 'Breedte',

	'height' => 'hoogte',

	'widthHeightInfo' => 'De resolutie van de beelden die door de camera kunnen worden opgenomen. Let wel op dat deze resolutie compatibel is met de specificaties van jouw camera!',

	'delay' => 'wachttijd in seconden',

	'delayInfo' => 'De wachttijd zal het aantal seconden bepalen tussen het nemen van twee opeeenvolgende beelden. Het introduceren kan handig zijn als je de performantie of load van je CPU wilt verlagen, of het aantal afbeeldingen die er per seconden genomen worden.',

	'livestream' => 'real-time weergave beelden/sec',

	'livestreamInfo' => '"De beelden per seconde" van de real-time weergave kan geconfigureerd worden. Door deze optie op 0 te zetten, zorg je ervoor dat de real-time weergave wordt gedeactiveerd.',

	'rotate' => 'Klik op deze afbeelding om de camera te roteren. Bijvoorbeeld, stel dat jouw camera ondersteboven is gemonteerd, zorg ervoor dat deze afbeelding ook omgekeerd staat.',

	'url' => 'Geef hier de url van jouw RTSP of MJPEG stream in.',

	// ----------------
	// Motion

	'image' => 'Afbeelding',

	'video' => 'Video',

	'step1' => 'Stap 1. Selecteer een bereik',

	'step1Info' => 'Door het verslepen van de rode punten kan je een bereik bepalen, waarin beweging zal worden gededecteerd. Je kan punten verwijderen door op de rode punten te klikken. Om meer punten toe te voegen kan je dubbel klikken op het witte punt.',

	'step2' => 'Stap 2. Configureer de parameters',

	'step2Info' => 'Door het aanpassen van de onderstaande configuratie, kan je de gevoeligiheid van de bewegingsdetectie beinvloden.',

	'step3' => 'Stap 3. Selecteer een of meerdere outputs',

	'step3Info' => 'Wanneer beweging is gedetecteerd kunnnen één of meerdere acties, (asynchroon) worden uitgevoerd.',

	'sensitivity' => 'gevoeligheid',

	'sensitivityInfo' => 'Door het verhogen van deze meter zal je Kerberos.io gevoeliger maken voor kleine veranderingen. Wanneer je deze optie verlaagt, zullen enkel grotere veranderingen worden waargenomen.',

	'numberOfDetections' => 'aantal detecteringen',

	'numberOfDetectionsInfo' => 'Door het aangeven van het aantal opeenvolgende (positieve) detecties, kunnen valse-positieven uitgeschakeld worden. Zo kan je instellen dat pas na 5 opeenvolgende positieve detecties, er een video wordt opgenomen.',

		// ------------------
		// Timestamp - Colors

		'noTimestamp' => 'geen tijdweergave',

		'white' => 'wit',

		'black' => 'zwart',

		'red' => 'rood',

		'green' => 'groen',

		'blue' => 'blauw',

	'drawTimestamp' => 'geef tijd weer',

	'drawTimestampInfo' => 'Wanneer een afbeelding wordt opgeslagen, kan je er voor kiezen om de huidige tijd af te beelden op de afbeelding.',

	'drawTimestampInfoVideo' => 'Wanneer een video wordt opgeslagen, kan je er voor kiezen om de huidige tijd af te beelden in de video.',

	'privacy' => 'privacy',

	'privacyInfo' => 'Door deze optie te activeren zorg je ervoor dat enkel het gebied, aangeduid in stap 1, zichtbaar is. Alle pixels die buiten deze zone vallen worden zwart gemaakt.',

	'fps' => 'beelden per seconde',

	'fpsInfo' => 'Wanneer men kiest voor het opnemen van video, kan men het aantal beelden per seconden bepalen. Let wel op dat het verhogen van deze parameter het systeem extra belast. Deze parameter is voor de Raspberry Pi, het best tussen de 4 en 7 FPS.',

	'secondsRecord' => 'opname duur',

	'secondsRecordInfo' => 'Het aantal seconden video die wordt opgenomen na een positieve detectie.',

	'webhookUrl' => 'url',

	'webhookUrlInfo' => 'De url naar waar een POST zal gestuurd worden (JSON object).',

	'scriptPath' => 'bestand',

	'scriptPathInfo' => 'Het pad naar een bash script dat wordt uitgevoerd. Een JSON object wordt als parameter meegestuurd.',

	'gpioPin' => 'pin',

	'gpioPinInfo' => 'Definieer de nummer van de pin op welke een puls moet worden verstuurd.',

	'gpioPeriod' => 'periode',

	'gpioPeriodInfo' => 'Het aantal microseconden dat de puls zal duren.',

	'hardwareEncodingEnabled' => 'De camera die je geselecteerd hebt ondersteund hardware encoding, dat is waarom bepaalde parameters niet kunnen geselecteerd worden (e.g. tijdsweergave).
		Alsook heeft de video die wordt opgenomen dezelfde eigenschappen als degene die ingesteld zijn bij jouw camera (e.g. FPS, sharpness, etc).',

  'secure' => 'secure',

	'secureInfo' => 'Activeer SSL/TLS. CA certificaat moet zich bevinden in /etc/ssl/certs/.',

  'verifycn' => 'verify',

	'verifycnInfo' => 'Verifieer certificaet CN (Common Name)',

  'mqttServer' => 'server',

  'mqttServerInfo' =>  'Het IP adres van de host waar de MQTT broker service aanwezig is.',

  'mqttPort' => 'poort',

  'mqttPortInfo' =>  'Poort nummer van de MQTT broker service.',

  'mqttTopic' => 'topic',

  'mqttTopicInfo' =>  'De topic naam waaronder de MQTT berichten verzonden worden.',

  'mqttUsername' => 'gebruikersnaam',

  'mqttUsernameInfo' =>  'De gebruikersnaam nodig om MQTT berichten te versturen.',

  'mqttPassword' => 'wachtwoord',

  'mqttPasswordInfo' =>  'Het wachtwoord nodig om MQTT berichten te versturen.',

  'throttler' => 'smoren',

  'throttlerInfo' =>  'Gebruik om spam te voorkomen. Bv. slechts 1 keer uitvoeren om de 5 seconden.',

	// --------------
	// Cloud

	'whatIsThis' => 'Wat is dit',

	'whatIsthisInformation' => 'Kerberos.io heeft zijn eigen cloud applicatie. Doormiddel van een inschrijving op een plan, kan je al jouw afbeeldingen en videos synchroniseren en overal ter wereld opvolgen. Na het inschrijven zal je enkele gegevens ontvangen welke je in de velden (aan de linkerzijde) kan ingeven. Na het bevestigen van deze gegevens, zal al jouw activiteit automatisch gesynchroniseerd worden met ons platform. Veel plezier!',

	'subscribeNow' => 'Schrijf nu in voor slechts €1,49',

  'verifyConnectivity' => 'Verifieer connectiviteit',

  'cloudHurray' => 'Joepie, de connectie is gelukt. Alle media zal vanaf nu automatisch worden gesynchroniseerd met je cloud account.',

  'cloudWentWrong' => 'Oeps er ging iets fout, verifieer dat je jouw cloud credentials correct hebt ingegeven.',

  'cloudWentWrongMoreHelp' => 'Of klik hier voor meer support.',

  'checkConnection' => 'Controleer connectie',

	// ---------------
	// KiOS settings

	'forceNetwork' => 'Netwerk verplicht',

	'forceNetworkInfo' => 'Deze optie zal er voor zorgen dat het OS steeds internet verbinding heeft, wanneer dit niet het geval is zal KiOS opnieuw opstarten. Dit is nodig bij instabiele netwerken en het gebruik van de cloud applicatie.',

	'autoRemoval' => 'Automatisch verwijderen',

	'autoRemovalInfo' => 'Wanneer de SD kaart bijna vol is worden de oudste beelden automatisch verwijderd.'

);
