/************************
*
*   System controller
*
**/

define(["jquery", "progressbar",
    "app/views/SystemOSView",
    "app/views/SystemKerberosView",
    "app/views/SystemKiOSView",
    "app/views/NewsView"
],
function($, ProgressBar, SystemOSView, SystemKerberosView, SystemKiOSView, NewsView)
{
    return {
        currentVersion: undefined,
        currentVersionAsset: undefined,

        initialize: function(translation)
        {
            var self = this;

            var newsView = new NewsView();

            newsView.initialize(translation, self);
            newsView.fetchData(function(data)
            {
                newsView.render(data);

                var systemOSView = new SystemOSView();

                systemOSView.initialize(translation, self);
                systemOSView.fetchData(function(data)
                {
                    systemOSView.render(data);

                    var systemKerberosView = new SystemKerberosView();

                    systemKerberosView.initialize(translation, self);
                    systemKerberosView.fetchData(function(data)
                    {
                        systemKerberosView.render(data);

                        var systemKiOSView = new SystemKiOSView();

                        systemKiOSView.initialize(translation, self);
                        systemKiOSView.fetchData(function(data)
                        {
                            systemKiOSView.render(data);
                        })
                    })
                })
            })
        },
        reboot: function(callback)
        {
            $.get(_baseUrl + "/api/v1/system/upgrade/reboot", callback)
            .fail(function(){});
        },
        rebooting: function(callback)
        {
            $.get(_baseUrl + "/api/v1/system/reboot", callback)
            .fail(function(){});
        },
        shuttingdown: function(callback)
        {
            $.get(_baseUrl + "/api/v1/system/shutdown", callback)
            .fail(function(){});
        },
        clean: function()
        {
            // ----------------
            // Download images

            var self = this;
            $.get(_baseUrl + "/api/v1/images/clean",function(file)
            {
                location.reload();
            });
        }
    };
});
