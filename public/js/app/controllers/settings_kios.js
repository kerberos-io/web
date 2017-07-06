/********************************************
*
*   KiOS Settings
*
**/

define(["jquery", "app/models/Settings", "app/views/SettingsKiOSView"], function($, Settings, SettingsKiOSView)
{
    return {
        initialize: function(autoremoval, forcenetwork, translations)
        {
            this.kios = new SettingsKiOSView(autoremoval, forcenetwork, translations);
            this.kios.render();
        }
    };
});
