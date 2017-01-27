/********************************************
*
*   Web Settings
*
**/

define(["jquery", "app/models/Settings", "app/views/SettingsWebView"], function($, Settings, SettingsWebView)
{
    return {
        initialize: function(radius, translations)
        {
            this.web = new SettingsWebView(translations);
            this.web.setRadius(radius);
            this.web.render();
        }
    };
});