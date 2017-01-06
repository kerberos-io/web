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

            this.capture = this.getCapture();
            this.usbcamera = this.getUSBCamera();
            this.ipcamera = this.getIPCamera();
            this.rpicamera = this.getRPICamera();
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

        // --------------------------
        // Capture devices

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
                    angle: parseInt($("input[name='capture__USBCamera__angle']").val())
                };
            },
            changeUSBCamera: function(usbcamera)
            {
                this.changeCapture("USBCamera");
                this.usbcamera = usbcamera;
                $("input[name='capture__USBCamera__frameWidth']").val(usbcamera.width);
                $("input[name='capture__USBCamera__frameHeight']").val(usbcamera.height);
                $("input[name='capture__USBCamera__angle']").val(usbcamera.angle);
            },


            // -------------------
            // IP camera

            getRPICamera:  function()
            {
                return {
                    width: $("input[name='capture__RaspiCamera__frameWidth']").val(),
                    height: $("input[name='capture__RaspiCamera__frameHeight']").val()
                };
            },
            changeRPICamera: function(rpicamera)
            {
                this.changeCapture("RaspiCamera");
                this.rpicamera = rpicamera;
                $("input[name='capture__RaspiCamera__frameWidth']").val(rpicamera.width);
                $("input[name='capture__RaspiCamera__frameHeight']").val(rpicamera.height);
            },


            // -------------------
            // IP camera

            getIPCamera:  function()
            {
                return {
                    width: $("input[name='capture__IPCamera__frameWidth']").val(),
                    height: $("input[name='capture__IPCamera__frameHeight']").val()
                };
            },
            changeIPCamera: function(ipcamera)
            {
                this.changeCapture("IPCamera");
                this.ipcamera = ipcamera;
                $("input[name='capture__IPCamera__frameWidth']").val(ipcamera.width);
                $("input[name='capture__IPCamera__frameHeight']").val(ipcamera.height);
            }


    });

    return Settings;
});