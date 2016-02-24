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
                refreshRate: 30,
                quality: 100,
                port: 8888
            });
            
            var width = 300;
            var height = 150;
            $("#livestream canvas").attr('width', width);
            $("#livestream canvas").attr('height', height);
            var ctx = $("#livestream canvas")[0].getContext("2d");

            var x = width/2;
            var y = height/2;
            ctx.font = '20px Arial';
            ctx.textAlign = 'center';
            ctx.fillStyle = 'black';
            ctx.fillText('No stream available', x, y);
            
            // Wait 300 ms before executing 
            setTimeout(this_.config.callback, 300);
        }
    };
});