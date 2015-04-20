/**
*   Dashboard Radar graph:  
*               Sends request to API (images per weekday for the last x days)
*               Chartjs is used to render the information to a radar graph. 
**/

define(["jquery"], function($)
{
    // Chartjs
    require(["chartjs"], function(Chart)
    {
    	var isEmpty = function(obj)
    	{
        	for(var p in obj)
        	{
        		return false;
        	}
        	return true;
        };

        $.get(_baseUrl + "/api/v1/images/perweekday/3",function(data)
        {
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

			var statistics =
			{
			    labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
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
	            pointColor: "rgba(220,220,220,0)",
	            pointStrokeColor: "rgba(220,220,220,0)",
	            pointHighlightFill: "rgba(220,220,220,0)",
	        }];

            // ------------------------------------
            // Add sum of images for the past days
            if(data && !isEmpty(data))
            {
				var weekDays = data;

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
        });
    });
});