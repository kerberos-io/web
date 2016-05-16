/************************
*
*   System controller
*
**/

define(["jquery", "progressbar"], function($, ProgressBar)
{
    return {
        currentVersion: undefined,
        currentVersionAsset: undefined,
        versions: undefined,
        board: undefined,
        
        setBoard: function(board)
        {
            this.board = board;
        },
        getBoard: function()
        {
            return this.board;
        },
        setCurrentVersion: function(version)
        {
            this.currentVersion = version;
        },
        getCurrentVersion: function()
        {
            return this.currentVersion;
        },
        timeSince(date)
        {
            var seconds = Math.floor((new Date() - date) / 1000);
            var interval = Math.floor(seconds / 31536000);
            
            if (interval > 1) {
                return interval + " years";
            }
            interval = Math.floor(seconds / 2592000);
            if (interval > 1) {
                return interval + " months";
            }
            interval = Math.floor(seconds / 86400);
            if (interval > 1) {
                return interval + " days";
            }
            interval = Math.floor(seconds / 3600);
            if (interval > 1) {
                return interval + " hours";
            }
            interval = Math.floor(seconds / 60);
            if (interval > 1) {
                return interval + " minutes";
            }
            return Math.floor(seconds) + " seconds";
        },
        intialize: function(callback)
        {            
            // ----------------
            // Show all versions
            
            var versionwrapper = $("#kios-versions");

            // Get versions from API
            var self = this;
            $.get(_baseUrl + "/api/v1/system/versions",function(versions)
            {
                self.versions = [];
                
                var list = $("<ul>");
                versionwrapper.html(list);
                versions.reverse();
                for(var i = 0; i < versions.length; i++)
                {
                    var readableTime = self.timeSince(new Date(versions[i].published_at));
                    
                    if(versions[i].version === self.currentVersion)
                    {
                        list.append($("<li id='" + versions[i].version + "' class='version active'>")
                                .html(versions[i].version)
                                .prepend($("<span class='active'>")));
                    }
                    else
                    {
                        list.append($("<li id='" + versions[i].version + "' class='version'>")
                                .html(versions[i].version)
                                .prepend($("<span>")));
                    }
                    
                    self.versions[versions[i].version] = versions[i];
                }
                
                callback();
            });
        },
        sleep: function (delay)
        {
            var start = new Date().getTime();
            while (new Date().getTime() < start + delay);
        },
        progress: function()
        {
            var self = this;
            var progress = 0;
            $.ajaxSetup({async:false});
            $.post(_baseUrl + "/api/v1/system/upgrade/progress", {'size': this.currentVersionAsset['size']}, function(data)
            {
                progress = data.progress;
                self.circle.animate(progress/100);
            });
            $.ajaxSetup({async:true});
                    
            return progress;
        },
        download: function(version)
        {
            var assets = version['assets'];
            
            // Get download url from board
            for(var i = 0; i < assets.length; i++)
            {
                var name = assets[i].name;
                var board = name.split("-")[1];
                
                if(board === this.board)
                {
                    this.currentVersionAsset = assets[i];
                    var download = this.currentVersionAsset['browser_download_url'];
                    
                    $.ajaxSetup({async:false});
                    $.post(_baseUrl + "/api/v1/system/upgrade/download", {'version': version, 'download': download}, function(){})
                    .fail(function(){});
                    $.ajaxSetup({async:true});
                }
            }
        },
        downloadVersion: function(version, callback)
        {
            if(version.version != this.currentVersion)
            {
                // execute download..
                this.circle = new ProgressBar.Circle('#percentage-downloaded',{
                color: '#943633',
                strokeWidth: 3,
                trailWidth: 1,
                text: {
                    value: '0'
                },
                step: function(state, bar)
                {
                    bar.setText((bar.value() * 100).toFixed(0));
                }
                });
                
                this.download(version);
                
                var progress = 0;
                this.circle.animate(0, function() {});
                
                var interval = undefined;
                var self = this;
                var intervalFunction = function()
                {
                    progress = self.progress();  
                    if(progress == 100)
                    {
                        clearInterval(interval);
                        
                        // Proceed to next upgrade steps..
                        callback();
                    }
                };
                
                var time = 2500;
                if(this.board === "raspberrypi") time *= 3;
                
                interval = setInterval(intervalFunction, time);
            }
        },
        unzip: function(callback)
        {
            $.get(_baseUrl + "/api/v1/system/upgrade/unzip", callback)
            .fail(function(){});
        },
        unpack: function(callback)
        {
            $.get(_baseUrl + "/api/v1/system/upgrade/depack", callback)
            .fail(function(){});
        },
        transfer: function(callback)
        {
            $.get(_baseUrl + "/api/v1/system/upgrade/transfer", callback)
            .fail(function(){});
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