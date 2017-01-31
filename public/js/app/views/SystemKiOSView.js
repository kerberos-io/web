/*******************
*  SystemKiOSView
****/

define(["underscore", "backbone", "app/views/BaseView", "remodal", "progressbar", "app/controllers/releases"], 
    function (_, Backbone, BaseView, remodal, ProgressBar, Releases)
{ 
    var SystemKiOSView = BaseView.extend(
    {
        el : '#kios',
        view : 'system-kios',
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
        initialize: function(translation, system)
        {
            this.model = {};
            this.model.translation = translation;
            this.system = system;
        },
        fetchData: function(callback)
        {
            Releases.getSystemInfo(function(data)
            {
                if(data.isKios)
                {
                    callback(data);
                }
            });
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
        initializeSystem: function()
        {
            // Bind events
            var self= this;
            this.$el.find(".version").click(function(e)
            {
                var version = $(this).attr('id');
                if(self.getCurrentVersion() == version) return false;
                
                version = self.versions[version];
                var published_at = new Date(version.published_at);
                
                $("#upgrade-modal .modal-body").html("" +
                "<h1>" + self.model.translation.release + " " + version.tag_name + "</h1>" +                       
                "<span>" + self.model.translation.publishedAt+" " + published_at + "</span>" +                       
                "<p>" + version.body + "</p>" +
                "<a id='install'>" + self.model.translation.install + "</a>");

                self.modal.open();
                
                $("#install").click(function()
                {   
                    $("#upgrade-modal").html(
                    "<h1>" + self.model.translation.downloading + "..</h1>" +
                    "<div id='percentage-downloaded'></div>");
                    
                    self.downloadVersion(version, function()
                    {
                        // Hit when file has been downloaded
                        $("#upgrade-modal").html(
                            "<h1>" + self.model.translation.unzipping + "..</h1>" +
                            "<div class='load5 loadimage'><div class='loader'></div");
                        
                        self.unzip(function()
                        {
                            // Hit when file has been unzipped
                            $("#upgrade-modal").html(
                                "<h1>" + self.model.translation.unpacking + "..</h1>" +
                                "<div class='load5 loadimage'><div class='loader'></div>");

                            self.unpack(function()
                            {
                            
                                // Hit when file has been unpacked
                                $("#upgrade-modal").html(
                                "<h1>" + self.model.translation.transferring + "..</h1>" +
                                "<div class='load5 loadimage'><div class='loader'></div>");

                                self.transfer(function()
                                {
                                    $("#upgrade-modal").html(
                                        "<h1>" + self.model.translation.rebooting + "..</h1>" +
                                        "<div id='count-down'></div>");

                                    var waitingTime = 180000;

                                    var countDown = new ProgressBar.Circle('#count-down', {
                                        color: '#943633',
                                        strokeWidth: 3,
                                        trailWidth: 1,
                                        duration: waitingTime,
                                        text: {
                                            value: '100'
                                        },
                                        step: function(state, bar)
                                        {
                                            bar.setText(100 - (bar.value() * 100).toFixed(0));
                                        }
                                    });

                                    countDown.animate(1);

                                    setInterval(function() { window.location.reload() }, waitingTime);
                                    
                                    self.system.reboot(function(){});
                                });
                            });
                        });
                    });
                });
            });
        },
        downloadVersion: function(version, callback)
        {
            if(version.version != this.currentVersion)
            {
                // execute download..
                this.circle = new ProgressBar.Circle('#percentage-downloaded', {
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

            $.post(_baseUrl + "/api/v1/system/upgrade/progress",
            {
                'size': this.currentVersionAsset['size']
            },
            function(data)
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

                    $.post(_baseUrl + "/api/v1/system/upgrade/download",
                    {
                        'version': version.version,
                        'download': download
                    },
                    function(){})
                    .fail(function(){});

                    $.ajaxSetup({async:true});
                }
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
        render: function(data)
        {
            this.setBoard(data.board);
            this.setCurrentVersion(data.version);

            this.model.kerberos = data;

            this.$el.html(this.template(this.model));

            var options = {
                hashTracking: false,
                closeOnAnyClick: false, 
                closeOnEscape: false
            };

            this.modal = this.$el.find('[data-remodal-id=upgrade]').remodal(options);

            // ----------------
            // Show all versions
            
            var versionwrapper = this.$el.find("#kios-versions");

            // Get versions from Github
            var self = this;
            Releases.getVersions(function(versions)
            {
                self.versions = [];
                
                var list = $("<ul>");
                versionwrapper.html(list);

                for(var i = 0; i < versions.length; i++)
                {
                    var readableTime = self.timeSince(new Date(versions[i].published_at));
                    
                    if(versions[i].tag_name === self.currentVersion)
                    {
                        list.append($("<li id='" + versions[i].tag_name + "' class='version active'>")
                                .html(versions[i].tag_name)
                                .prepend($("<span class='active'>")));
                    }
                    else
                    {
                        list.append($("<li id='" + versions[i].tag_name + "' class='version'>")
                                .html(versions[i].tag_name)
                                .prepend($("<span>")));
                    }
                    
                    self.versions[versions[i].tag_name] = versions[i];
                }

                self.initializeSystem();
            });

            return this;
        }
    });

    return SystemKiOSView;
});