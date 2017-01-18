/********************************************
*
*   Basic Settings
*
**/

define(["jquery", "app/models/Settings", "app/views/SettingsBasicView"], function($, Settings, SettingsBasicView)
{
    return {
        initialize: function(translations)
        {
            var model = new Settings();
            this.basic = new SettingsBasicView(model, translations);
            this.basic.render();
        }
    };
});