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
            self = this;
            self.config = config;

            // Wait 300 ms before executing 
            setTimeout(self.config.callback, 300);
        },
        redraw: function()
        {
            self = this;
            
            $.get(self.config.url, function(images)
            {
                self.config.images = images;
                self.attachTo(document.getElementById("latest-activity-sequence"));
                self.play();
            })
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
                if($(".activity .load5").length > 0)
                {
                    $(".activity .load5").remove();
                }
                
                $(this.config.element).css({"width":"100%"});
                Sequencer.init(this.config);
            }
        }
    };
});