/**
*   Dashboard Heatmap:
*               Shows an heatmap which is draw
*               on a canvas
**/

define(["heatmap"], function(heatmap)
{
    return {
        config: {},
        latestImage: {
            width: 0,
            height: 0,
        },
        initialize: function(config)
        {
            self = this;
            self.config = config;
            self.fps = config.fps;
            self.radius = (config.radius) ? config.radius * 100 : 250;

            // create heatmap
            self.heatmapInstance = heatmap.create({
                container: document.querySelector('.heatmap'),
                maxOpacity: 0.5,
                minOpacity: 0
            });

            $(window).resize(function()
            {
                self.resize();
                self.draw();
            });

            // Wait 300 ms before executing
            setTimeout(self.config.callback, 300);
        },
        changeRadius: function(radius)
        {
            this.radius = radius * 100;
            this.draw();
        },
        redraw: function()
        {
            self = this;

            $.get(self.config.url,function(data)
            {
                $.get(self.config.urlSequence,function(images)
                {
                    self.data = data;
                    self.images = images;
                    self.resize();
                    self.draw();
                });
            });
        },
        draw: function()
        {
            if($(".heatmap .load5"))
            {
                $(".heatmap .load5").remove();
            }

            if(this.data && this.data.length > 0)
            {
                var self = this;
                this.drawBackground(function()
                {
                    self.setRegions(self.data);
                    self.heatmapInstance.setData(self.calculate(self.regions));
                });
            }
            else
            {
                var canvas = $(".heatmap canvas").get(0);
                var ctx = canvas.getContext("2d");

                var x = canvas.width / 2;
                var y = canvas.height / 2;
                ctx.font = '20px Arial';
                ctx.textAlign = 'center';
                ctx.fillStyle = 'black';
                ctx.fillText('No data available', x, y);
            }
        },
        drawBackground: function(callback)
        {
            var canvas = $(".heatmap canvas");

            // Check if videos..
            var videos = _.filter(this.images, function(file)
            {
                return file.type === "video";
            });

            if(videos.length)
            {
                context = canvas.get(0).getContext("2d");

                video = document.createElement("video");
                var self = this;
                video.addEventListener('loadeddata', function()
                {
                    self.latestImage.width = video.videoWidth;
                    self.latestImage.height = video.videoHeight;
                    video.play();
                    context.drawImage(video, 0, 0, canvas.width(), canvas.height());
                    var data =  canvas.get(0).toDataURL();
                    canvas.css({
                        "background-image": "url("+data+")",
                        "background-size": "100% 100%",
                        "background-repeat": "no-repeat",
                    });

                    video.pause();
                    callback();
                });

                video.loop = true;
                video.src = videos[videos.length-1].src;
            }
            else if(this.images.length)
            {
                var img = new Image();

                var self = this;
                img.onload = function()
                {
                    self.latestImage.width = this.width;
                    self.latestImage.height = this.height;
                    canvas.css({
                        "background": "url('"+image.src+"')",
                        "background-size": "100% 100%",
                        "background-repeat": "no-repeat",
                    });
                    canvas.attr("height", canvas.width()/2);
                    $(".heatmap").css({"height": canvas.height()});
                    callback();
                };

                var image = this.images[this.images.length-1];
                img.src = image.src;
            }

            this.heatmapInstance._renderer.setDimensions(canvas.width(),canvas.height());
        },
        setRegions: function(data)
        {
            this.regions = [];

            for(var i  =0; i < data.length; i++)
            {
                var regionCoordinates = data[i].regionCoordinates.split("-");

                var region = {
                    'start': {
                      'x': 0,
                      'y': 0,
                    },
                    'end': {
                      'x': 0,
                      'y': 0,
                    },
                    'changes': 0
                }

                if(regionCoordinates.length > 1)
                {
                    region.start.x = parseInt(regionCoordinates[0]);
                    region.start.y = parseInt(regionCoordinates[1]);
                    region.end.x = parseInt(regionCoordinates[2]);
                    region.end.y = parseInt(regionCoordinates[3]);
                    region.changes = parseInt(data[i].numberOfChanges);
                    region.average = parseInt(data[i].numberOfChanges) / ((region.end.x - region.start.x) * (region.end.y - region.start.y));

                    this.regions.push(region);
                }
            }

            return data;
        },
        calculate: function(regions)
        {
            var max = 0;
            var width = 640;
            var height = 360;
            var dataPoints = [];

            var originalWidth = this.latestImage.width;
            var originalHeight = this.latestImage.height;

            var canvas = $(".heatmap canvas");
            var currentWidth = canvas.width();
            var currentHeight = canvas.height();

            // scale x- and y-coordinates
            var dx = currentWidth / originalWidth;
            var dy = currentHeight / originalHeight;

            for(var i = 0; i < regions.length; i++)
            {
                max = Math.max(max, regions[i].average);
                var point = {
                    x: parseInt(regions[i].start.x * dx + (regions[i].end.x - regions[i].start.x) * dx / 2),
                    y: parseInt(regions[i].start.y * dy + (regions[i].end.y - regions[i].start.y) * dy / 2),
                    value: regions[i].average,
                    radius: regions[i].average * this.radius,
                };

                dataPoints.push(point);
            }

            var data = {
              max: max,
              data: dataPoints
            };

            return data;
        },
        resize: function()
        {
            var canvas = $(".heatmap canvas");
            canvas.attr("width", $(".heatmap").width());
            canvas.attr("height", canvas.width()/2);
            $(".heatmap").css({"height": canvas.width()});
            $(".heatmap").css({"height": canvas.height()});
        }
    };
});
