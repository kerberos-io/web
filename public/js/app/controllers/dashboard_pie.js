/**
*   Dashboard Pie:  
*               Sends request to API (images per day for the last x days)
*               Chartjs is used to render the information to a pie graph. 
**/

define(["jquery", "chartjs"], function($, Chart)
{
    return {
        initialize: function(config)
        {
            this_ = this;
            this_.config = config;
            
            $.get(this_.config.url,function(data)
            {
               this_.draw(data);
            })
            .always(function()
            {
                // Wait 500 ms before executing 
                setTimeout(this_.config.callback, 1000);
            });
        },
        draw: function(data)
        {
            var canvas = $("#time-donut").get(0);
            var ctx = canvas.getContext("2d");

            var options = {
                segmentShowStroke : true,
                segmentStrokeColor : "#fff",
                segmentStrokeWidth : 2,
                percentageInnerCutout : 50, // This is 0 for Pie charts
                animationSteps : 100,
                animationEasing : "easeOutBounce",
                responsive: true,
                animateRotate : true,
                animateScale : false,
                legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
            };

            var dayStyle = [
                {
                    color: "rgba(148,54,51,1)",
                    highlight: "rgba(148,54,51,0.8)",
                    label: "Today"
                },
                {
                    color: "rgba(120,120,120,1)",
                    highlight: "rgba(120,120,120,0.8)",
                    label: "Yesterday"
                },
                {
                    color: "rgba(220,220,220,1)",
                    highlight: "rgba(220,220,220,0.8)",
                    label: "Ereyesterday"
                }
            ];

            var averageStyle = {
                color: "rgba(76,156,56,1)",
                highlight: "rgba(76,156,56,0.8)",
                label: "Average"
            };

            // ------------------------------------
            // Add sum of images for the past days

            var statistics = [];
            var days = data["days"];
            for(var i = 0; i < days.length; i++)
            {
                var dataset = dayStyle[i % dayStyle.length];
                dataset['value'] = days[i];
                statistics.push(dataset);
            }

            // ---------------------
            // Add averages images

            var average = data["statistics"]["average"];

            if(average)
            {
                dataset = averageStyle;
                dataset['value'] = average;
                statistics.push(dataset);
            }

            // ---------------------------------------------------------------
            // This will get the first returned node in the jQuery collection.

            if(statistics && statistics.length > 0)
            {
                var timePie = new Chart(ctx).Pie(statistics, options);

                // ----------------
                // Generate legend

                $("#time-donut-legend").html(timePie.generateLegend());
            }
            else
            {
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