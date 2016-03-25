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
                    var span = $("<span>");
                    if(versions[i].version === self.currentVersion)
                    {
                        span.addClass('active');
                    }
                    
                    list.append($("<li id='" + versions[i].version + "' class='version'>")
                                .html(versions[i].version)
                                .prepend(span));
                    
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
                interval = setInterval(intervalFunction, 2500);
            }
        },
        unzip: function(callback)
        {
            $.get(_baseUrl + "/api/v1/system/upgrade/unzip", callback)
            .fail(function(){});
        },,
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