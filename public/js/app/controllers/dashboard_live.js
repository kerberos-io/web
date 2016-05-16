/**
*   Dashboard Streamer:  
*               Get stream from MJPEG endpoint and draw
*               on a canvas 
**/

define(["streamer"], function(streamer)
{
    return {
        config: {},
        initialize: function(config)
        {
            this_ = this;
            this_.config = config;
            
            // Create the main viewer.
            var viewer = new streamer.Viewer({
                divID : this_.config.element,
                host : this_.config.host,
                refreshRate: 300,
                quality: 100,
                port: 8888
            });

            var width = "100%";
            $("#livestream canvas").attr('width', width);

            // Wait 300 ms before executing 
            setTimeout(this_.config.callback, 300);
        }
    };
});