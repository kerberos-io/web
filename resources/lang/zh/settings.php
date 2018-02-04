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

  'settings' => '设置',

  'configuration' => '配置',

	'update' => '更新',

	'heatmap' => '热力图',

	'general' => '通用设置',

	'purchase' => '通过<b>Kerberos.cloud</b>随时随地监控您的活动，<u>获得它</u> 仅需 1,49€/月!',

	'basic' => '基础设置',

	'advanced' => '高级设置',

	'name' => '名字',

	'nameInfo' => '相机需要一个独一无二的名字, 以便运行多个Kerberos.io实例。',

	'timezone' => '时区',

	'timezoneInfo' => '设置时区用以转换时间戳为当地时间。设备和Web界面都会用到。',

	'camera' => '相机',

	'usbcamera' => 'USB摄像头',

	'usbcameraInfo' => '使用USB摄像头时勾选此项。',

	'rpicamera' => '树莓派相机。',

	'rpicameraInfo' => '在树莓派上运行Kerberos.io时, 您可以选择此项, 特别是当您使用树莓派相机(v1 或 v2)时。',

	'ipcamera' => '网络摄像头',

	'ipcameraInfo' => '当您使用网络摄像头且支持 RTSP 或 MJPEG 串流时，选择此项。',

	'surveillanceMode' => '监视模式',

	'motion' => '运动',

	'motionInfo' => '智能运动探测, 可以保存截图或视频, 也可通过钩子（webhook）触发其他设备。 设置条件来监测画面的特定区域的运动。',

	'storage' => '存储',

	'storageInfo' => '通过 Kerberos.cloud 来跟进多个 Kerberos.io 实例， 无论您身在何处。',

	'dontForget' => '点击更新以确认您的配置。',

	'update' => '更新',

	'cancel' => '取消',

	'confirmAndSelect' => '确认选择',


	// --------------
	// Camera

	'fpsRaspberryInfo' => '每秒处理的帧数; 同时也是录像的帧数。',

	'width' => '宽',

	'height' => '高',

	'widthHeightInfo' => '相机拍照的分辨率。 请确保相机支持此分辨率！',

	'delay' => '延迟秒数',

	'delayInfo' => '设定 Kerberos.io 捕捉两帧图像的间隔时间。 此选项对于减少每秒图像处理数很有帮助 (比如出于性能考虑)。',

	'livestream' => '直播时每秒帧数',

	'livestreamInfo' => '可以设置直播时的每秒帧数。 设置为0，直播关闭。',

	'rotate' => '相机旋转了点此图片。 比如相机是倒挂的, 确保图像也是上下颠倒的。',

	'url' => '输入网络摄像头的 RTSP或MJPEG 串流地址。',

	// ----------------
	// Motion

	'image' => '图像',

	'video' => '视频',

	'step1' => '首先，选择一个探测区域',

	'step1Info' => '用锚点勾出探测区域边缘。 双击锚点以移动, 在白点单击以增加锚点。',

	'step2' => '然后，设置参数',

	'step2Info' => '调节下面的选项，升降灵敏度。',

	'step3' => '最后，选择输出方式。',

	'step3Info' => '一旦侦测到运动，可以异步地完成一个或多个输出。',

	'sensitivity' => '灵敏度',

	'sensitivityInfo' => '增大滑块来增加Kerberos.io运动探测的灵敏度。 减小就没那么灵敏。',

	'numberOfDetections' => '探测到多少次才算有效',

	'numberOfDetectionsInfo' => '这个数字表示一行探测到多少个才让Kerberos.io触发一次有效事件。增大这个值,您可消除错误情况，诸如: 光线、云层之类的。',

	// ------------------
	// Timestamp - Colors

	'noTimestamp' => '没有时间戳',

	'white' => '白',

	'black' => '黑',

	'red' => '红',

	'green' => '绿',

	'blue' => '蓝',

	'drawTimestamp' => '绘制时间戳',

	'drawTimestampInfo' => '当图像被保存时，您可在图像上绘制一个时间戳。',

	'drawTimestampInfoVideo' => '当视频被保存时，您可绘制一组日期、时间。',

	'privacy' => '隐私',

	'privacyInfo' => '开启这个选项后, 只有第一步选择的区域可见。 区域外的像素都会是黑的。',

	'fps' => '每秒帧数',

	'fpsInfo' => '存储视频时的每秒帧数; 注意树莓派只能处理有限的帧数 (比如 7 FPS)。',

	'secondsRecord' => '记录多少秒',

	'secondsRecordInfo' => '侦测到运动后会记录的秒数。',

	'webhookUrl' => 'url地址',

	'webhookUrlInfo' => 'POST一个JSON对象到这个地址（webhook用的）。',

	'scriptPath' => '路径',

	'scriptPathInfo' => '脚本执行路径。会传一个json对象作为入参。',

	'gpioPin' => 'pin码',

	'gpioPinInfo' => '定义一个pin码，随pulse发送（心跳验证？）。',

	'gpioPeriod' => '过期时间',

	'gpioPeriodInfo' => '脉冲持续多少毫秒。',

	'hardwareEncodingEnabled' => '你的采集设备支持板载硬编码, 因此您不能设置额外参数 (如 时间戳)。
	即使生成的视频特性和您选择的采集设备一样 (如 FPS, 锐度 等).',

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

	'whatIsThis' => '这是什么？',

	'whatIsthisInformation' => 'Kerberos.io带来了它自己的云应用。 通过订阅套餐， 您可同步视频与图像，并在世界各地回访。 订阅后， 您会收到一个授权信息并可填入左侧。确认并更新设置后即可同步。 尽情享用吧！',

	'subscribeNow' => '现在订阅只需€1,49',

  /* to translate */ 'verifyConnectivity' => 'Verify connectivity',

  /* to translate */ 'cloudHurray' => 'Hurray, connection was succesful. Your media will now be synced automatically to your cloud account.',

  /* to translate */ 'cloudWentWrong' => 'Something went wrong, verify you\'ve entered your credentials correctly.',

  /* to translate */ 'cloudWentWrongMoreHelp' => 'Click here for more support.',

  /* to translate */ 'checkConnection' => 'Check connection',

	// ---------------
	// KiOS settings

	'forceNetwork' => '强制网络模式',

	'forceNetworkInfo' => '开启后会在没网时重启系统。 这在是用了云应用、网络不可靠时才有必要开启。',

	'autoRemoval' => '媒体资源自动删除',

	'autoRemovalInfo' => '开启后会在硬盘空间不足时删除图像。'

);
