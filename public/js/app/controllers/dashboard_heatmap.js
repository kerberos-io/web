/**
*   Dashboard Heatmap:  
*               Shows an heatmap which is draw
*               on a canvas 
**/

define(["heatmap"], function(heatmap)
{
    return {
        config: {},
        initialize: function(config)
        {
            self = this;
            self.config = config;
            
            $.get(self.config.url,function(data)
            {
                self.draw(data);
                
                $(window).resize(function()
                {
                    self.resize();
                    self.draw(data);
                });
            })
            .always(function()
            {
                // Wait 300 ms before executing 
                setTimeout(self.config.callback, 300);
            });
        },
        redraw: function()
        {
            self = this;
            
            $.get(self.config.url,function(data)
            {
                self.resize();
                self.draw(data);
            });
        },
        draw: function(data)
        {
            this.regions = [];
            
            var regions = this.getRegions(data);
            
            // create heatmap
            this.heatmapInstance = heatmap.create({
                container: document.querySelector('.heatmap'),
                opacity: 0.5,
                minOpacity: 0.2,
                maxOpacity: 0.2
                
            });
            
            this.drawBackground();
            
            // set data points
            this.heatmapInstance.setData(this.calculate(this.regions));
        },
        drawBackground: function()
        {
            var image = $("#latest-image").attr('src');
            var canvas = $(".heatmap canvas");
            canvas.css({
                "background": "url('"+image+"')", 
                "background-size": "100% 100%", 
                "background-repeat": "no-repeat",
            });
            canvas.attr("height", canvas.width()/2);
            $(".heatmap").css({"height": canvas.height()}); 
            
            this.heatmapInstance._renderer.setDimensions(canvas.width(),canvas.height());
        },
        getRegions: function(data)
        {
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
                }

                this.regions.push(region);
            }
            
            return data;
        },
        calculate: function(regions)
        {
            var max = 0;
            var width = 640;
            var height = 360;
            var dataPoints = [];
            
            var latestImage = $("#latest-image");
            var originalWidth = latestImage.width();
            var originalHeight = latestImage.height();
            
            var canvas = $(".heatmap canvas");
            var currentWidth = canvas.width();
            var currentHeight = canvas.height();
            
            for(var i = 0; i < regions.length; i++)
            {
                // scale x- and y-coordinates
                var dx = currentWidth / originalWidth;
                var dy = currentHeight / originalHeight;
                
                max = Math.max(max, regions[i].average);
                var point = {
                    x: parseInt(regions[i].end.x * dx - regions[i].start.x * dx)/2,
                    y: parseInt(regions[i].end.y * dy - regions[i].start.y * dy)/2,
                    value: regions[i].average,
                    radius: regions[i].average * 500,
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