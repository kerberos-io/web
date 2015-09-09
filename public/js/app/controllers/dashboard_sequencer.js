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
            this_ = this;
            this_.config = config;
    
            $.get(config.url, function(images)
            {
                this_.config.images = images;
                this_.attachTo(document.getElementById("latest-activity-sequence"));
                this_.play();
            })
            .always(function()
            {
                // Wait 500 ms before executing 
                setTimeout(this_.config.callback, 500);
            });
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
            if(this.config.images && this.config.images.length > 0)
            {
                $(this.config.element).css({"width":"100%"});
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