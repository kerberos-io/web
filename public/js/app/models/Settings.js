/*************
* Settings Model
**/

define(["underscore", "backbone"], function (_, Backbone)
{
    var Settings = Backbone.Model.extend(
    {
    	options: {
    		name: undefined,
    	},

        // General settings
        name: undefined,
        timezone: undefined,

        // Capture devices
        capture: undefined,
        stream: undefined,
        usbcamera: undefined,
        rpicamera: undefined,
        ipcamera: undefined,

        constructor: function()
        {
            this.refresh();
        },

        refresh: function()
        {
            this.name = this.getName();
            this.timezone = this.getTimezone();
            this.stream = this.getStream();
            this.capture = this.getCapture();
            this.usbcamera = this.getUSBCamera();
            this.ipcamera = this.getIPCamera();
            this.rpicamera = this.getRPICamera();
            this.devices = this.getIoDevices();
            this.motion = this.getMotion();
            this.kerberosCloud = this.getKerberosCloud();
        },

        // ------------------
        // General settings

        changeTimezone: function(timezone)
        {
            $('#timezone-picker option[value="'+timezone+'"]').attr('selected', 'selected');
        },
        setTimezone: function(timezone)
        {
            $("#timezone-picker-basic").append($("#timezone-picker option").clone());
            $('#timezone-picker-basic option[value="'+timezone+'"]').attr('selected', 'selected');
        },
        getTimezone: function()
        {
        	return $("#timezone-picker option:selected").val();
        },

        changeName: function(name)
        {
            this.name = name;
        	$("input[name='config__instance__name']").val(name);
        },
        getName: function()
        {
        	return $("input[name='config__instance__name']").val();
        },

        getMotion: function()
        {
            return {
                sensitivity: 30 - $("input[name='algorithm__DifferentialCollins__threshold']").val(),
                detections: $("input[name='heuristic__Sequence__minimumDuration']").val()
            };
        },
        changeMotion: function(motion)
        {
            $("input[name='algorithm__DifferentialCollins__threshold']").val(30 - motion.sensitivity);
            $("input[name='heuristic__Sequence__minimumDuration']").val(motion.detections);
        },

        getIoDevices: function()
        {
            this.devices = {
                disk: {
                    enabled: false,
                    colorTimestamp: $("input[name='io__Disk__timestampColor']").val(),
                    markWithTimestamp: $("input[name='io__Disk__markWithTimestamp']").val(),
                    privacy: ($("input[name='io__Disk__privacy']").val() === "true")
                },
                video: {
                    enabled: false,
                    hardwareEncodingEnabled: (this.getCapture() === 'RaspiCamera'),
                    recordAfter: $("input[name='io__Video__recordAfter']").val(),
                    fps: $("input[name='io__Video__fps']").val(),
                    colorTimestamp: $("input[name='io__Video__timestampColor']").val(),
                    markWithTimestamp: $("input[name='io__Video__markWithTimestamp']").val(),
                    privacy: ($("input[name='io__Video__privacy']").val() === "true")
                },
                webhook: {
                    enabled: false,
                    url: $("input[name='io__Webhook__url']").val(),
                    throttler:  $("input[name='io__Webhook__throttler']").val(),
                },
                script: {
                    enabled: false,
                    path: $("input[name='io__Script__path']").val(),
                    throttler:  $("input[name='io__Script__throttler']").val(),
                },
                gpio: {
                    enabled: false,
                    pin: $("input[name='io__GPIO__pin']").val(),
                    period: $("input[name='io__GPIO__periodTime']").val(),
                    throttler:  $("input[name='io__GPIO__throttler']").val(),
                },
                mqtt: {
                    enabled: false,
                    secure: ($("input[name='io__MQTT__secure']").val() === "true"),
                    verifycn: ($("input[name='io__MQTT__verifycn']").val() === "true"),
                    server:  $("input[name='io__MQTT__server']").val(),
                    port:  $("input[name='io__MQTT__port']").val(),
                    topic:  $("input[name='io__MQTT__topic']").val(),
                    username:  $("input[name='io__MQTT__username']").val(),
                    password:  $("input[name='io__MQTT__password']").val(),
                    throttler:  $("input[name='io__MQTT__throttler']").val(),
                }
            };

            var self = this;
            _.each($("select[name^='config__instance__io']"), function(device)
            {
                var option =  $(device).find("option:selected").text();
                option = option.toLowerCase();
                if(self.devices[option])
                {
                    self.devices[option].enabled = true;
                }
            });

            return this.devices;
        },
        changeIoDevices: function(devices)
        {
            // --------------------------------------
            // Step 1. Create or remove select boxes

            var el = "select[name^='config__instance__io']";
            var existingDevices = $(el);
            var activeDevices = _.filter(devices,function(device)
            {
                return device.enabled;
            });

            // Add new devices
            for(var i = existingDevices.length; i < activeDevices.length; i++)
            {
                var section = $(el).parent().parent();
                if(section.find(".add-dropdown"))
                {
                    var dropdown = section.find(".add-dropdown i");
                    dropdown.click();
                }
            }

            // Remove number of existing
            for(var i = activeDevices.length; i < existingDevices.length; i++)
            {
                var lastInRow = $(el).last();
                lastInRow.next('div.delete-dropdown').remove();
                lastInRow.remove();
            }


            // --------------------------------------
            // Step 2. Select correct values in boxes

            function capitalizeFirstLetter(str)
            {
                return str.substr(0, 1).toUpperCase() + str.substr(1);
            }

            var i = 0;
            _.each(devices, function(device, key)
            {
                if(device.enabled)
                {
                    var select = $($(el)[i++]);
                    select.val(capitalizeFirstLetter(key));
                    if(key === "gpio" || key === "mqtt")
                    {
                        select.val(key.toUpperCase());
                    }
                }
            });

            // -------------------------
            // Step 3. Transfer the data

            $("input[name='io__Disk__timestampColor']").val(devices.disk.colorTimestamp);
            $("input[name='io__Disk__markWithTimestamp']").val(devices.disk.markWithTimestamp);
            $("input[name='io__Disk__privacy']").val(devices.disk.privacy);

            if(!devices.video.hardwareEncodingEnabled)
            {
                $("input[name='io__Video__recordAfter']").val(devices.video.recordAfter);
                $("input[name='io__Video__fps']").val(devices.video.fps);
                $("input[name='io__Video__timestampColor']").val(devices.video.colorTimestamp);
                $("input[name='io__Video__markWithTimestamp']").val(devices.video.markWithTimestamp);
                $("input[name='io__Video__privacy']").val(devices.video.privacy);
            }

            $("input[name='io__Webhook__url']").val(devices.webhook.url);
            $("input[name='io__Webhook__throttler']").val(devices.webhook.throttler);

            $("input[name='io__Script__path']").val(devices.script.path);
            $("input[name='io__Script__throttler']").val(devices.script.throttler);

            $("input[name='io__GPIO__pin']").val(devices.gpio.pin);
            $("input[name='io__GPIO__periodTime']").val(devices.gpio.period);
            $("input[name='io__GPIO__throttler']").val(devices.gpio.throttler);

            $("input[name='io__MQTT__secure']").val(devices.mqtt.secure);
            $("input[name='io__MQTT__verifycn']").val(devices.mqtt.verifycn);
            $("input[name='io__MQTT__server']").val(devices.mqtt.server);
            $("input[name='io__MQTT__port']").val(devices.mqtt.port);
            $("input[name='io__MQTT__topic']").val(devices.mqtt.topic);
            $("input[name='io__MQTT__username']").val(devices.mqtt.username);
            $("input[name='io__MQTT__password']").val(devices.mqtt.password);
            $("input[name='io__MQTT__throttler']").val(devices.mqtt.throttler);
        },

        // --------------------------
        // Capture devices

        getStream: function()
        {
            return {
                fps: $("input[name='stream__Mjpg__fps']").val(),
                enabled: ($("#stream__Mjpg__enabled").attr('checked') !== undefined)
            }
        },
        changeStream: function(fps)
        {
            $("input[name='stream__Mjpg__fps']").val(fps);
            if(fps === 0)
            {
                $("#stream__Mjpg__enabled").removeAttr('checked');
                $("input[name='stream__Mjpg__enabled']").val("false");
            }
            else
            {
                $("#stream__Mjpg__enabled").prop('checked', true);
                $("input[name='stream__Mjpg__enabled']").val("true");
            }
        },
        getCapture: function()
        {
            return $("select[name='config__instance__capture:0'] option:selected").val();
        },
        changeCapture:function(capture)
        {
            this.capture = capture;
            $("select[name='config__instance__capture:0']").val(capture);
        },

            // -------------------
            // USB camera

            getUSBCamera:  function()
            {
                return {
                    width: $("input[name='capture__USBCamera__frameWidth']").val(),
                    height: $("input[name='capture__USBCamera__frameHeight']").val(),
                    angle: parseInt($("input[name='capture__USBCamera__angle']").val()),
                    delay: parseInt($("input[name='capture__USBCamera__delay']").val())/1000.
                };
            },
            changeUSBCamera: function(usbcamera)
            {
                this.changeCapture("USBCamera");
                this.usbcamera = usbcamera;
                $("input[name='capture__USBCamera__frameWidth']").val(usbcamera.width);
                $("input[name='capture__USBCamera__frameHeight']").val(usbcamera.height);
                $("input[name='capture__USBCamera__angle']").val(usbcamera.angle);
                $("input[name='capture__USBCamera__delay']").val(usbcamera.delay);
                this.changeStream(usbcamera.fps);
            },


            // -------------------
            // IP camera

            getRPICamera:  function()
            {
                return {
                    fps: $("input[name='capture__RaspiCamera__framerate']").val(),
                    width: $("input[name='capture__RaspiCamera__frameWidth']").val(),
                    height: $("input[name='capture__RaspiCamera__frameHeight']").val(),
                    angle: parseInt($("input[name='capture__RaspiCamera__angle']").val()),
                    delay: parseInt($("input[name='capture__RaspiCamera__delay']").val())/1000.
                };
            },
            changeRPICamera: function(rpicamera)
            {
                this.changeCapture("RaspiCamera");
                this.rpicamera = rpicamera;
                $("input[name='capture__RaspiCamera__framerate']").val(rpicamera.fps);
                $("input[name='capture__RaspiCamera__frameWidth']").val(rpicamera.width);
                $("input[name='capture__RaspiCamera__frameHeight']").val(rpicamera.height);
                $("input[name='capture__RaspiCamera__angle']").val(rpicamera.angle);
                $("input[name='capture__RaspiCamera__delay']").val(rpicamera.delay);
                this.changeStream(rpicamera.fps);
            },


            // -------------------
            // IP camera

            getIPCamera:  function()
            {
                return {
                    width: $("input[name='capture__IPCamera__frameWidth']").val(),
                    height: $("input[name='capture__IPCamera__frameHeight']").val(),
                    angle: parseInt($("input[name='capture__IPCamera__angle']").val()),
                    delay: parseInt($("input[name='capture__IPCamera__delay']").val())/1000.,
                    url: $("input[name='capture__IPCamera__url']").val()
                };
            },
            changeIPCamera: function(ipcamera)
            {
                this.changeCapture("IPCamera");
                this.ipcamera = ipcamera;
                $("input[name='capture__IPCamera__frameWidth']").val(ipcamera.width);
                $("input[name='capture__IPCamera__frameHeight']").val(ipcamera.height);
                $("input[name='capture__IPCamera__angle']").val(ipcamera.angle);
                $("input[name='capture__IPCamera__delay']").val(ipcamera.delay);
                $("input[name='capture__IPCamera__url']").val(ipcamera.url);
                this.changeStream(ipcamera.fps);
            },

        // ------------------
        // Kerberos Cloud

        getKerberosCloud: function()
        {
            return {
                bucket: $("input[name='cloud__S3__bucket']").val(),
                folder: $("input[name='cloud__S3__folder']").val(),
                public: $("input[name='cloud__S3__publicKey']").val(),
                secret: $("input[name='cloud__S3__privateKey']").val(),
            };
        },
        changeKerberosCloud: function(cloud)
        {
            this.kerberosCloud = cloud;
            $("input[name='cloud__S3__bucket']").val(cloud.bucket);
            $("input[name='cloud__S3__folder']").val(cloud.folder);
            $("input[name='cloud__S3__publicKey']").val(cloud.public);
            $("input[name='cloud__S3__privateKey']").val(cloud.secret);
        }

    });

    return Settings;
});
