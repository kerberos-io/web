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

	/* to translate */ 'heatmap' => 'Heatmap',

	/* to translate */ 'general' => 'General settings',

	/* to translate */ 'purchase' => 'Watch your activity from anywhere in the world with <b>Kerberos.cloud</b>, Get <u>started</u> for only 1,49€/month!',

	/* to translate */ 'basic' => 'Basic',

	/* to translate */ 'advanced' => 'Advanced',

	/* to translate */ 'name' => 'Name',

	/* to translate */ 'nameInfo' => 'An unique name for your camera is required, if you will run multiple Kerberos.io instances.',

	/* to translate */ 'timezone' => 'Timezone',

	/* to translate */ 'timezoneInfo' => 'The timezone is used to convert timestamps to your local time. It\'s used in both the machinery and web interface.',

	/* to translate */ 'camera' => 'Camera',

	/* to translate */ 'usbcamera' => 'USB camera',

	/* to translate */ 'usbcameraInfo' => 'Select this option, if you want to use an USB camera.',

	/* to translate */ 'rpicamera' => 'RPi camera',

	/* to translate */ 'rpicameraInfo' => 'If you run Kerberos.io on a Raspberry Pi, you can select this option, if you want to use the Raspberry Pi camera module (v1 or v2).',

	/* to translate */ 'ipcamera' => 'IP camera',

	/* to translate */ 'ipcameraInfo' => 'Select this option, if you want to use an IP camera which supports an RTSP or MJPEG stream.',

	/* to translate */ 'surveillanceMode' => 'Surveillance',

	/* to translate */ 'motion' => 'Motion',

	/* to translate */ 'motionInfo' => 'A smart motion detector, that saves snapshots or video, and/or trigger other devices by using a webhook. Setup conditions to only detect motion at a specific region in the view.',

	/* to translate */ 'storage' => 'Storage',

	/* to translate */ 'storageInfo' => 'Use Kerberos.cloud to follow up multiple Kerberos.io instances from anywhere int the world.',

	/* to translate */ 'dontForget' => 'Press update to confirm your configuration.',

	/* to translate */ 'update' => 'Update',

	/* to translate */ 'cancel' => 'Cancel',

	/* to translate */ 'confirmAndSelect' => 'Confirm and select',


	// --------------
	// Camera

	/* to translate */ 'width' => 'Width',

	/* to translate */ 'height' => 'Height',

	/* to translate */ 'widthHeightInfo' => 'The resolution of the images being captured by your camera. Make sure that this resolution is supported!',

	/* to translate */ 'delay' => 'delay in seconds',

	/* to translate */ 'delayInfo' => 'The delay time will tell Kerberos.io to wait for x amount of seconds, between two frame captures. This is helpful when you would like to reduce the number of images being processed per second (e.g. for performance reasons).',

	/* to translate */ 'livestream' => 'live stream frames/sec',

	/* to translate */ 'livestreamInfo' => 'The frames per second of the live stream can be configured. Setting this option to zero, will disable the live stream.',

	/* to translate */ 'rotate' => 'Click on this image if your camera is rotated. E.g. if your camera is mounted upside down, make sure this image is also upside down.',

	/* to translate */ 'url' => 'Enter the url of the RTSP or MJPEG stream of your IP camera.',

	// ----------------
	// Motion
	
	/* to translate */ 'image' => 'Image',

	/* to translate */ 'video' => 'Video',

	/* to translate */ 'step1' => 'Step 1. Select a region',

	/* to translate */ 'step1Info' => 'Move the points to draw the region of interest. Double click on a point to remove it, and/or on the white point to add more points.',

	/* to translate */ 'step2' => 'Step 2. Configure parameters',

	/* to translate */ 'step2Info' => 'By changing the configuration below you can make the motion detection more or less sensitive.',

	/* to translate */ 'step3' => 'Step 3. Select one or more outputs',

	/* to translate */ 'step3Info' => 'Once motion is detected you can execute (asynchronous) one or more outputs.',

	/* to translate */ 'sensitivity' => 'sensitivity',

	/* to translate */ 'sensitivityInfo' => 'Increasing this slider will make Kerberos.io more sensitive for motion. Decreasing will make it less sensitive for motion.',

	/* to translate */ 'numberOfDetections' => 'number of detections before valid',

	/* to translate */ 'numberOfDetectionsInfo' => 'This number represents the number of detections in a row before Kerberos.io will trigger a valid event. By increasing this value you can eliminate false-positives: e.g. lightning, clouds, etc.',

		// ------------------
		// Timestamp - Colors

		/* to translate */ 'noTimestamp' => 'no timestamp',

		/* to translate */ 'white' => 'white',

		/* to translate */ 'black' => 'black',

		/* to translate */ 'red' => 'red',

		/* to translate */ 'green' => 'green',

		/* to translate */ 'blue' => 'blue',

	/* to translate */ 'drawTimestamp' => 'draw timestamp',

	/* to translate */ 'drawTimestampInfo' => 'When an image is saved to disk, you can draw the current date and time on the image.',

	/* to translate */ 'fps' => 'frames per second',

	/* to translate */ 'fpsInfo' => 'The frames per second written to the video file; be aware that a Raspberry Pi can only process a limited number of FPS (e.g. 7 FPS).',

	/* to translate */ 'secondsRecord' => 'seconds to record',

	/* to translate */ 'secondsRecordInfo' => 'The number of seconds that will be recorded after motion was detected.',

	/* to translate */ 'webhookUrl' => 'url',

	/* to translate */ 'webhookUrlInfo' => 'The url to which a POST will be sent with a JSON object.',

	/* to translate */ 'scriptPath' => 'path',

	/* to translate */ 'scriptPathInfo' => 'The path to a bash script that will be executed. A JSON object is send as a parameter.',

	/* to translate */ 'gpioPin' => 'pin',

	/* to translate */ 'gpioPinInfo' => 'Define the pin number on which a pulse will be send.',

	/* to translate */ 'gpioPeriod' => 'period',

	/* to translate */ 'gpioPeriodInfo' => 'The number of microseconds the pulse will last.',

	// --------------
	// Cloud

	/* to translate */ 'whatIsThis' => 'What is this',

	/* to translate */ 'whatIsthisInformation' => 'Kerberos.io comes with its own cloud application. By subscribing to a plan you can sync all your images and videos, and review it from anywhere in the world. Once subscribed, you\'ll receive some credentials which you can fill in the fields on the left. After confirming and updating the settings, you\'re activity will be synced automatically. Have fun!',

	/* to translate */ 'subscribeNow' => 'Subscribe now for only €1,49'

);
