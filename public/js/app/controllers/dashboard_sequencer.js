/**
*   Dashboard Sequencer:  
*               Sends request to API (images per hour for the last x days)
*               Morris.js is used to render the information to a graph. 
*               Raphael is a dependency of Morris
**/


define(["Sequencer", "underscore"], function(Sequencer, _)
{
    return {
        config: {},
        fps: 0,
        playingVideo: false,
        initialize: function(config)
        {
            var self = this;
            self.config = config;
            self.fps = config.fps;

            $(window).resize(function()
            {
                self.resize();
                self.draw();
            })

            // Wait 300 ms before executing 
            setTimeout(self.config.callback, 300);
        },
        redraw: function()
        {
            self = this;
            
            $.get(self.config.url, function(images)
            {
                self.config.images = images;
                self.resize();
                self.draw();
            });
        },
        draw: function()
        {
            this.attachTo(document.getElementById("latest-activity-sequence"));
            this.play();
        },
        resize: function()
        {
            var canvas = $("li.activity canvas");
            canvas.attr("width", $("li.activity").width());
            canvas.attr("height", canvas.width()/2);
            $("li.activity").css({"height": canvas.width()}); 
            $("li.activity").css({"height": canvas.height()});
        },
        attachTo: function(element)
        {
            if(this.config)
            {
                this.config.element = element;
            }
        },
        play: function()
        {
            if($(".activity .load5").length > 0)
            {
                $(".activity .load5").remove();
            }

            if(this.config.images && this.config.images.length > 0)
            {;
                var images = this.config.images;

                // Check if videos..
                var videos = _.filter(images, function(file)
                {
                    return file.type === "video";
                });

                if(videos.length)
                {
                    if(!this.playingVideo)
                    {
                        var canvas, context, video, xStart, yStart, xEnd, yEnd;

                        canvas = document.getElementById("latest-activity-sequence");
                        context = canvas.getContext("2d");

                        video = document.createElement("video");
                        video.src = videos[videos.length-1].src;
                        video.loop = true;
                        video.muted = true;

                        var self = this;
                        video.addEventListener('loadeddata', function()
                        {
                            video.play();
                            setTimeout(videoLoop, 1000 / self.fps);
                        });

                        function videoLoop()
                        {
                            if (video && !video.paused && !video.ended)
                            {
                                context.drawImage(video,0, 0, canvas.width, canvas.height);
                                setTimeout(videoLoop, 1000 / self.fps);
                            }
                        }

                        this.playingVideo = true;
                    }
                }
                else
                {
                    $(this.config.element).css({"width":"100%"})
                    Sequencer.init(this.config);
                }
            }
            else
            {
                var canvas = this.config.element;
                var ctx = canvas.getContext("2d");

                var x = canvas.width / 2;
                var y = canvas.height / 2;
                ctx.font = '20px Arial';
                ctx.textAlign = 'center';
                ctx.fillStyle = 'black';
                ctx.fillText('No data available', x, y);
            }
        }
    };
});