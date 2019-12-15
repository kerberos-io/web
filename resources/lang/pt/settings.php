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

  'settings' => 'Configurações',

  'configuration' => 'Configurações',

	'update' => 'Atualizar',

	'general' => 'Configurações gerais',

	'purchase' => 'Acompanhe a atividade de suas cameras de qualquer lugar do mundo com <b>Kerberos Cloud</b>, preço <u>inicial</u> apenas 1,99€/mês!',

	'basic' => 'Básico',

	'advanced' => 'Avançado',

	'name' => 'Nome',

	'nameInfo' => 'Um nome único para sua camera é necessário, caso você possua várias instâncias do Kerberos.io',

	'timezone' => 'Fuso horário',
	
	'timezoneInfo' => 'O fuso horário é usado para converter registros de data e hora em sua hora local. É usado pela interface web e também pela machinery.',

	'camera' => 'Camera',

	'usbcamera' => 'Camera USB',

	'usbcameraInfo' => 'Selecione essa opção para utilizar uma camera USB.',

	'rpicamera' => 'Camera RPi',

	'rpicameraInfo' => 'Se você está rodando Kerberos.io em um Raspberry Pi poderá selecionar essa opção se desejar utilizar o módulo de camera(v1 ou v2).',

	'ipcamera' => 'Camera IP',

	'ipcameraInfo' => 'Selecione esta opção, se você deseja usar uma camera IP com suporte a RTSP ou MJPEG stream.',

	 'surveillanceMode' => 'Monitoramento',

	'motion' => 'Movimento',
	
	'motionInfo' => 'Um detector inteligente de movimentos que salva snapshots ou vídeos e/ou conecta em outros dipositivos por meio de webhook. Configure a detecção de movimento para somente uma região especifica da visualização.',

	'storage' => 'Armazenamento',
	
	'storageInfo' => 'Use Kerbberos.cloud para acompanhar multiplas instâncias de qualquer lugar do mundo.',

	'dontForget' => 'Precione atualizar para confirmar sua configuração.',

	'update' => 'Atualizar',

	'cancel' => 'Cancelar',

	'confirmAndSelect' => 'Confirmar e Selecionar',


	// --------------
	// Camera
	
	'fpsRaspberryInfo' => 'O número de quadros processados por segundo; Observe que esse parâmetro também define o número de quadros por segundo de uma gravação de vídeo.',

	'width' => 'Largura',

	'height' => 'Altura',

	'widthHeightInfo' => 'A resolução das imagens capturadas pela sua câmera. Certifique-se de que esta resolução seja suportada!',

	'delay' => 'atraso em segundos',

	'delayInfo' => 'O tempo de atraso dirá ao Kerberos.io para aguardar x quantidade de segundos, entre duas capturas de quadro. Isso é útil quando você deseja reduzir o número de imagens processadas por segundo (por exemplo, por motivos de desempenho).',

	'livestream' => 'transmissão ao vivo qadros/seg',
	
	'livestreamInfo' => 'Os quadros por segundo da transmissão ao vivo podem ser configurados. Definir essa opção como zero desativará a transmissão ao vivo.',

	'rotate' => 'Clique nesta imagem se a sua câmera for girada. Por exemplo. Se a sua câmera estiver montada de cabeça para baixo, certifique-se de que esta imagem também esteja de cabeça para baixo.',

	'url' => 'Digite a URL do stream RTSP ou MJPEG da sua câmera IP.',

	// ----------------
	// Motion

	'image' => 'Imagem',

	'video' => 'Video',

	'step1' => 'Passo 1. Selecionar a região',

	'step1Info' => 'Mova os pontos para desenhar a região de interesse. Clique duas vezes em um ponto para removê-lo e / ou no ponto branco para adicionar mais pontos.',

	'step2' => 'Etapa 2. Configurar Parâmetros',

	'step2Info' => 'Alterando a configuração abaixo, você pode tornar a detecção de movimento mais ou menos sensível.',

	'step3' => 'Etapa 3. Selecione uma ou mais saídas',

	'step3Info' => 'Uma vez que o movimento é detectado, você pode executar (assíncrono) uma ou mais saídas.',

	'sensitivity' => 'sensitividade',

	'sensitivityInfo' => 'Aumentar esse controle deslizante tornará o Kerberos.io mais sensível para o movimento. Diminuir tornará menos sensível ao movimento.',

	'numberOfDetections' => 'número de detecções antes de válido',

	'numberOfDetectionsInfo' => 'se número representa o número de detecções seguidas antes que o Kerberos.io acione um evento válido. Ao aumentar esse valor, você pode eliminar falsos positivos: por exemplo, relâmpago, nuvens, etc.'

		// ------------------
		// Timestamp - Colors

		'noTimestamp' => 'nenhuma timestamp',

		'white' => 'branco',

		'black' => 'preto',

		'red' => 'vermelho',

		'green' => 'verde',

		'blue' => 'azul',

	'drawTimestamp' => 'Desenhar timestamp',

	'drawTimestampInfo' => 'Quando uma imagem é salva em disco, você pode desenhar a data e a hora atuais na imagem.',

	'drawTimestampInfoVideo' => 'Quando um vídeo é salvo no disco, você pode desenhar a data e a hora atuais no vídeo.',

	'privacy' => 'privacidade',

	'privacyInfo' => 'Ao ativar essa opção, somente a região selecionada da etapa 1 ficará visível. Todos os pixels fora da região são pretos.',

	'fps' => 'Quadros por segundo',

	'fpsInfo' => 'Os quadros por segundo são gravados em arquivo de vídeo; Esteja ciente de que um Raspberry Pi só pode processar um número limitado de FPS (por exemplo, 7 FPS).',

	'secondsRecord' => 'segundos de gravação',

	'secondsRecordInfo' => 'O número de segundos que serão gravados após uma movimento ser detectado.',

	 'webhookUrl' => 'url',

	 'webhookUrlInfo' => 'Url de destino em que o POST será enviado com um JSON.',

	'scriptPath' => 'caminho',

	'scriptPathInfo' => 'O caminho para um script bash que será executado. Um JSON é enviado como parâmetro.',

	'gpioPin' => 'pino',

	'gpioPinInfo' => 'Defina o número do pino que o pulso será enviado.',

	'gpioPeriod' => 'período',

	'gpioPeriodInfo' => 'O número de microsegundos de duração do pulso.',

	'hardwareEncodingEnabled' => 'Seu dispositivo de captura oferece suporte à codificação de hardware integrada, por isso você não pode escolher parâmetros adicionais (por exemplo, registro de data e hora).
                 Além disso, o vídeo gerado terá as mesmas especificações que o dispositivo de captura escolhido (por exemplo, FPS, nitidez, etc).',

 	'secure' => 'seguro',

  	'secureInfo' => 'Habilitar SSL/TLS. O certificado deve estar em /etc/ssl/certs/ directory.',

  	 'verifycn' => 'veriricar',

  	'verifycnInfo' => 'Verificar certificado CN (Common Name)',

  	'mqttServer' => 'server',

  	'mqttServerInfo' =>  'O endereço de ip utilizado pelo serviço MQTT.',

  	'mqttPort' => 'porta',

 	'mqttPortInfo' =>  'O numero da porta utilizada pelo serviço MQTT.',

  	'mqttTopic' => 'tópico',

 	'mqttTopicInfo' =>  'O nome do tópico que as mensagens MQTT serão enviadas.',

	'mqttClientId' =>  'client_id',

 	'mqttClientIdInfo' =>  'O ID de cliente usado para acessar o broker MQTT.',

 	'mqttUsername' => 'Usuário',

	'mqttUsernameInfo' =>  'O usuário para acessar o broker MQTT.',

	'mqttPassword' => 'senha',

	'mqttPasswordInfo' =>  'A chave de acesso para acessar o broker MQTT.',

  	'throttler' => 'frequência',

	'throttlerInfo' =>  'Use para evitar spamming. Ex. executa apenas uma vez a cada 5 segundos.',

	// --------------
	// Cloud

	'whatIsThis' => 'O que é isso',

	'whatIsthisInformation' => 'O Kerberos.io vem com seu próprio aplicativo em nuvem. Ao assinar um plano, você pode sincronizar todas as suas imagens e vídeos s, e revê-lo de qualquer lugar do mundo. Uma vez inscrito, você receberá algumas credenciais que você pode preencher nos campos à esquerda. Depois de confirmar e atualizar Nas configurações, sua atividade será sincronizada automaticamente. Diverta-se!',

	'subscribeNow' => 'Assine agora por apenas €1,99',

	'verifyConnectivity' => 'Virifique sua conexão',

	'cloudHurray' => 'Viva! A conexão foi estabelecida. Sua mídia será sincronizada automaticamente com a sua conta na nuvem.',

	'cloudWentWrong' => 'Algo deu errado, verifique se você inseriu suas credenciais corretamente.',

        'cloudWentWrongMoreHelp' => 'Clique aqui para mais informações.',

        'checkConnection' => 'Verifique sua conexão',

	// ---------------
	// KiOS settings

	'forceNetwork' => 'Forçar modo de rede',

	'forceNetworkInfo' => 'Quando habilitado o SO irá reiniciar caso não estiver conectado há internet. Isso é necessário se você estiver utilizando a aplicação Cloud, mas tem uma rede não confiável.',

	'autoRemoval' => 'Remoção automática de mídia',
	
	'autoRemovalInfo' => 'Quando habilitado as imagens são automaticamente removidas quando o disco está cheio..'

);
