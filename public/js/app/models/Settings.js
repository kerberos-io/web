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

        name: undefined,
        timezone: undefined,

        constructor: function(coordinates)
        {
            this.name = this.getName();
            this.timezone = this.getTimezone();
        },

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
        }
    });

    return Settings;
});