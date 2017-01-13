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
            $('#timezone-picker-basic option[value="'+timezone+'"]').attr('selected', 'selected')
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
        getIoDevices: function()
        {
            this.devices = {
                disk: {
                    enabled: false,
                    colorTimestamp: $("input[name='io__Disk__timestampColor']").val(),
                    markWithTimestamp: $("input[name='io__Disk__markWithTimestamp']").prop('checked')
                },
                video: {
                    enabled: false,
                    recordAfter: $("input[name='io__Video__recordAfter']").val(),
                    fps: $("input[name='io__Video__fps']").val()
                },
                webhook: {
                    enabled: false,
                    url: $("input[name='io__Webhook__url']").val()
                }
            };

            var self = this;
            _.each($("select[name^='config__instance__io']"), function(device)
            {
                var option =  $(device).find("option:selected").text();
                option = option.toLowerCase();
                self.devices[option].enabled = true;
            });

            return this.devices;
        },
        changeIoDevices: function(devices)
        {
            var numberOfSelects = $("select[name^='config__instance__io']").length;
            var activeDevices = _.filter(devices,function(device)
            {
                return device.enabled;
            });

            // Add new selects
            for(var i = numberOfSelects; i < activeDevices.length; i++)
            {
                var section = $("select[name^='config__instance__io']").parent().parent();
                if(section.find(".add-dropdown"))
                {
                    var dropdown = section.find(".add-dropdown i");
                    dropdown.click();
                    console.log(dropdown)
                }
            }

            // Remove number of selects
            for(var i = activeDevices; i < numberOfSelects.length; i++)
            {
                var section = $("select[name^='config__instance__io']").parent().parent();
                if(section.find(".add-dropdown"))
                {
                    var dropdown = section.find(".add-dropdown i");
                    dropdown.click();
                    console.log(dropdown)
                }
            }
            

            // Step 2. Create dropdowns for each device

            // Step 3. Transfer the data

            /*if(element.prop('checked'))
            {
                /*var section = $("select[name^='config__instance__io']").parent().parent();
                if(section.find(".add-dropdown"))
                {
                    var dropdown = section.find(".add-dropdown i");
                    dropdown.click();

                    // Get last device
                    var devices = $("select[name^='config__instance__io']");
                    var lastOne = devices[devices.length - 1];
                }*

                element.parent().parent().find('.content').slideDown();
            }
            else
            {
                // Find list of device that has been disabled.
                /*var devices = $("select[name^='config__instance__io']");

                // You need at least one device enabled.
                if(devices.length > 1)
                {
                    var self = this; var i = 0;
                    _.each(devices, function(device)
                    {
                        var option = $(device).find("option:selected").text();
                        option = option.toLowerCase();

                        if(name == option)
                        {
                            // Check if trashcan exists    
                            if(i == 0)
                            {
                                $(device).next().next('div.delete-dropdown').remove();
                            }
                            else
                            {
                                $(device).next('div.delete-dropdown').remove();
                            }

                            $(device).remove();
                        }

                        i++;
                    });
                    element.parent().parent().find('.content').slideUp();
                }
                else
                {
                    element.prop('checked', true);
                }
                
                element.parent().parent().find('.content').slideUp();
            }*/
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
            }


    });

    return Settings;
});