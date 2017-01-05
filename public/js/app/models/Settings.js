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

        constructor: function(coordinates)
        {
            this.name = this.getName();
            this.timezone = this.getTimezone();
            this.usbcamera = this.getUSBCamera();
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

        },

            // -------------------
            // USB camera

            getUSBCamera:  function()
            {
                return {
                    width: $("input[name='capture__USBCamera__frameWidth']").val(),
                    height: $("input[name='capture__USBCamera__frameHeight']").val()
                };
            }


    });

    return Settings;
});