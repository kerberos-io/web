/****************************************
*
*   ImageController:  Image handler
*
**/

define(["jquery", "seiyria-bootstrap-slider", "app/models/Images", "app/views/ImageView", "jellyfish"], function($, slider, ImagesCollection, ImageView, jellyfish)
{
    return {
        time: undefined,
        day: undefined,

        setDay: function(day)
        {
            this.day = day;
        },
        setStartTime: function(time)
        {
            this.time = time;
        },
        initialize: function()
        {
            // -----------------------------------
            // Load view and images
            var imagesCollection = new ImagesCollection();
            var imageView = new ImageView({
                el: $("#images-overview"),
                collection: imagesCollection,
            });
            
            imagesCollection.setDay(this.day);
            imagesCollection.setStartTime(this.time);
            imagesCollection.fetch({async: false});
            
            imageView.render();

            jellyfish.addLoadContentFunction(imageView.draw);
            jellyfish.init();

            var typewatch = function()
            {
                var timer = 0;
                return function(callback, ms){
                    clearTimeout (timer);
                    timer = setTimeout(callback, ms);
                }  
            }();

            function appendNextPage()
            {
                $(".load4").css({'display':'block'});
                $(".scroll-down").css({'display':'none'});
                typewatch(function()
                {
                    imageView.appendNextPage(jellyfish);
                },1000);
            }

            function scrollDown()
            {
                var wrappers = document.querySelectorAll('[data-lazy-load]');
                jellyfish.checkViewport(wrappers);

                if($(window).scrollTop() == $(document).height() - $(window).height())
                {
                    appendNextPage();
                }
            }

            // --------------------------------------------------
            // Get images perhour, used to visualize time slider
            //  - highlight the activity on the slider

            var self = this;
            $.get(_baseUrl + "/api/v1/images/"+this.day+"/hours",function(data)
            {
                $('#timer-slider').slider({
                    tooltip: 'always',
                    formatter: function(value)
                    {
                        if(value == -1) // disabled
                        {
                            return "off";
                        }
                        else // enabled
                        {
                            if(value < 10) value = "0" + value;
                            return value + ":00";
                        }
                    }
                }).on('slideStop', function(ev)
                {
                    if(imageView.atEndOfDay)
                    {
                        $(".load4").css({'display':'none'});
                        $(".scroll-down").css({'display':'block'});
                        $(".load4").parent().css({'display':'block'});
                        $(window).scroll(scrollDown); 
                        $(".scroll-down").click(appendNextPage);
                        imageView.atEndOfDay = false;
                    }

                    imageView.currentPage = 1;

                    if(ev.value === undefined) ev.value = 0;

                    if(ev.value >= 0 && ev.value <= 24)
                    {
                        imagesCollection.setStartTime(ev.value);
                    }
                    else
                    {
                        imagesCollection.setStartTime(undefined);
                    }
                    imagesCollection.fetch({async: false});
                    imageView.render();
                    jellyfish.init();
                });
    
                // --------------------------
                // Build styling

                if(self.time > 0)
                {
                    var steps = 100 / self.time;
                    var max = 0;

                    for(var i = 0; i <= self.time; i++)
                    {
                        if(data[i] > max) max = data[i];
                    }

                    var styling = '-webkit-linear-gradient(left,';
                    for(var i = 0; i <= self.time; i++)
                    {   
                        if(data[i] >= max - (max/3))
                        {
                            styling += 'rgb(148, 54, 51) ' + (i*steps) + '%,';   
                        }
                        else if(data[i] > max/3)
                        {
                            styling += 'rgb(132, 132, 132) ' + (i*steps) + '%,';
                        }
                        else if(data[i] > 0)
                        {
                            styling += 'rgb(190, 190, 190) ' + (i*steps) + '%,';   
                        }
                        else
                        {
                            styling += 'rgb(230, 230, 230) ' + (i*steps) + '%,';  
                        }
                    }

                    styling = styling.slice(0, -1) + ')';
                    $(".slider-track").css({'background': styling});
                }
            });

            // -----------------------------------
            // Append new images at bottom of page or clicked on refresh.
            $(function(){
                // At bottom of page
                $(window).scroll(scrollDown); 
                // On click
                $(".scroll-down").click(appendNextPage);
            });
        }
    };
});