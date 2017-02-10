/**************
*   Releases
**/

define(["jquery", "underscore", "app/controllers/Cache"], function($, _, Cache)
{
    return {

        githubEndpoint: "https://api.github.com/repos/kerberos-io/kios/releases",
        kiosEndpoint: _baseUrl + "/api/v1/system/kios",

        getVersions: function(callback)
        {
            Cache(this.githubEndpoint).then(function (versions)
            {
                if(versions && versions.length)
                {
                    versions = _.sortBy(versions, function(version)
                    {
                        return version.tag_name;
                    }).reverse();
                }

                callback(versions);
            });
        },
        getSystemInfo: function(callback)
        {
            Cache(this.kiosEndpoint).then(function(data)
            {
                callback(data);
            });
        },
        highlightIfNewRelease: function()
        {
            var self = this;

            self.getSystemInfo(function(data)
            {
                var currentVersion = data.version;

                if(data.isKios && data.version)
                {
                    if(window.location.hash)
                    {
                        var hash = window.location.hash.substring(1);
                        if(hash === "develop")
                        {
                            self.githubEndpoint = "https://api.github.com/repos/cedricve/kios/releases";
                        }
                    }

                    self.getVersions(function(versions)
                    {           
                        if(currentVersion != versions[0].tag_name)
                        {
                            $("#new-release").show();
                        }
                    });
                }
            });
        }
    };
});