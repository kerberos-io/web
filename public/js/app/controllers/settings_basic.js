/********************************************
*
*   Basic Settings
*
**/

define(["jquery", "app/models/Settings", "app/views/SettingsBasicView"], function($, Settings, SettingsBasicView)
{
    return {
        initialize: function()
        {
            var model = new Settings();
            this.basic = new SettingsBasicView(model);
            this.basic.render();
        },
        refresh: function()
        {
        	this.basic.refresh();
        	this.basic.render();
        }
    };
});