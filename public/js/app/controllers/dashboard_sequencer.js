/**
*   Dashboard Sequencer:  
*               Sends request to API (images per hour for the last x days)
*               Morris.js is used to render the information to a graph. 
*               Raphael is a dependency of Morris
**/


define(["Sequencer"], function(Sequencer)
{
    return {
        config: {},
        initialize: function(config)
        {
            var self = this;
            self.config = config;

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
            {
                //$(this.config.element).css({"width":"100%"});
                Sequencer.init(this.config);
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