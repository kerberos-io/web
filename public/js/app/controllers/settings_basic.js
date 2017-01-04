/********************************************
*
*   Basic Settings
*
**/

define(["jquery", "app/models/Settings", "app/views/SettingsBasic"], function($, Settings, SettingsBasicView)
{
    return {
        initialize: function()
        {
            var model = new Settings();
            var basic = new SettingsBasicView(model);
            basic.render();
        }
    };
});