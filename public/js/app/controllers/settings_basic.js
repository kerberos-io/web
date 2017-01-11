/********************************************
*
*   Basic Settings
*
**/

define(["jquery", "app/models/Settings", "app/views/SettingsBasicView"], function($, Settings, SettingsBasicView)
{
    return {
    	image: undefined,
        initialize: function()
        {
            var model = new Settings();
            this.basic = new SettingsBasicView(model, this.image);
            this.basic.render();
        },
        setImage(image)
        {
        	this.image = image;
        }
    };
});