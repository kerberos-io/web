/**
*   Dashboard Radar graph:  
*               Sends request to API (images per weekday for the last x days)
*               Chartjs is used to render the information to a radar graph. 
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
                setTimeout(this_.config.callback, 300);
            });
        },
        draw: function(data)
        {
            var isEmpty = function(obj)
            {
                for(var p in obj)
                {
                    return false;
                }
                return true;
            };

            var canvas = $("#radar-chart").get(0);
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
                multiTooltipTemplate: "<%= datasetLabel %> - <%= value %>"
            };

			if(data.legend)
			{
				var statistics =
				{
				    labels: [data.legend.sunday, data.legend.monday, data.legend.tuesday, data.legend.wednesday, data.legend.thursday, data.legend.friday, data.legend.saturday],
				    datasets: []
				};

				var weekdayStyle = [
				{
	       	     	fillColor: "rgba(120,120,120,0)",
	       		    strokeColor: "#943633",
	            	pointColor: "#943633",
	            	pointStrokeColor: "#943633",
	            	pointHighlightFill: "#943633",
	        	},
	        	{
	            	fillColor: "rgba(120,120,120,0)",
	            	strokeColor: "rgba(120,120,120,1)",
	            	pointColor: "rgba(120,120,120,1)",
	            	pointStrokeColor: "rgba(120,120,120,1)",
	            	pointHighlightFill: "rgba(120,120,120,1)",
	        	},
	        	{
	            	fillColor: "rgba(220,220,220,0)",
	            	strokeColor: "rgba(220,220,220,0)",
	            	ointColor: "rgba(220,220,220,0)",
	            	pointStrokeColor: "rgba(220,220,220,0)",
	            	pointHighlightFill: "rgba(220,220,220,0)",
	        	}];
            }
            
            // ------------------------------------
            // Add sum of images for the past days
            

            // Remove loading bar
            if($("#radar-graph .load5").length > 0)
            {
                $("#radar-graph .load5").remove();
            } 

            if(data.instances && !isEmpty(data.instances))
            {
				var weekDays = data.instances;
				var styleNumber = 0;
				for(var key in weekDays)
				{
					var dataset = weekdayStyle[styleNumber % weekdayStyle.length];
					styleNumber++;

					var eventsOnWeekday = [0, 0, 0, 0, 0, 0, 0];
					for(var i = 0; i < weekDays[key]['eventsOnWeekday'].length; i++)
					{
						if(weekDays[key]['daysPerWeekday'][i].length > 0)
						{
							eventsOnWeekday[i] = parseInt(weekDays[key]['eventsOnWeekday'][i] / weekDays[key]['daysPerWeekday'][i].length);
						}
					}

	                dataset['data'] = eventsOnWeekday;
	                dataset['label'] = key;
	                statistics["datasets"].push(dataset);
				}
               
				// ---------------------------------------------------------------
	            // This will get the first returned node in the jQuery collection.

	            var radarChart = new Chart(ctx).Radar(statistics, options);
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
    }
});