/*****************************************************************
*  ImageView: shows all available images.
****/

define(["underscore", "photoswipe", "photoswipe-ui", "backbone", "fancybox", "app/models/Images", "app/views/BaseView"], 
    function (_, PhotoSwipe, PhotoSwipeUI, Backbone, fancybox, ImagesCollection, BaseView)
{ 
    var ImageItemView = BaseView.extend(
    {
        el: '<div>',
        view : 'image-item',
        initialize: function(options)
        {
            this.parent = options.parent;
        },
        render: function()
        {
            var data = {
                'image' : this.model.get('src'),
                'metadata' : JSON.stringify(this.model.get('metadata')),
                'datetime' : this.model.get('datetime'),
                'time' : this.model.get('time'),
            };
            this.$el.html(this.template(data));
            return this;
        }
    });

    var ImageView = BaseView.extend(
    {
        currentPage : 1,
        view : 'image',
        gallery: [],
        initialize: function(data)
        {
            this.views = {};
        },
        createView: function(image)
        {
            return new ImageItemView({model: image, parent: this});
        }, 
        destroyViews: function()
        {
            _.invoke(this.views, 'close');
            this.views.length = 0;
        },
        getDom: function (view)
        {
            return view.render().el;
        },
        appendNextPage: function(jellyfish) // jellyfish does progressive loading
        {
            this.currentPage++;
            var imagesCollection = new ImagesCollection();
            imagesCollection.setPage(this.currentPage);
            imagesCollection.setDay(this.collection.day);
        
            if(this.collection.time != "" && this.collection.time !== undefined)
            {
                imagesCollection.setStartTime(this.collection.time);
            }
            
            imagesCollection.fetch({async: false});

            // ------------------------------
            // We have some images to append

            if(imagesCollection.models.length > 0)
            {
                var self = this;

                // -----------------------------
                // Get first image of collection

                var imagesCollectionFirst = $.extend(true, {}, imagesCollection);
                imagesCollectionFirst.models = [];

                var firstModel = imagesCollection.models[0];
                imagesCollectionFirst.models.push(firstModel);

                if(imagesCollection.models.length > 1)
                {
                    var secondModel = imagesCollection.models[imagesCollection.models.length-1];
                    imagesCollectionFirst.models.push(secondModel);
                }

                // -------------------------------
                // add new collection to current.

                self.newViews = imagesCollectionFirst.map(self.createView, self);
                var imagesList = $("<div id='images-"+self.currentPage+"' class='images'>");   
                imagesList.html(_.map(self.newViews, self.getDom, self));

                // ---------------
                // Hide tooltip
                
                imagesList.find("i").hide();

                var timeBetween = "";
                var timeRange = "";
                if(imagesCollection.models.length > 1)
                {
                    timeBetween = imagesCollection.last().attributes.metadata.timestamp - imagesCollection.at(0).attributes.metadata.timestamp;
                    if(timeBetween > 0 && timeBetween / 60 > 1)
                    {
                        timeBetween = parseInt(timeBetween / 60);
                        timeBetweenText = " during " + timeBetween;
                        timeRange = imagesCollection.at(0).get('time') + ' - ' + imagesCollection.last().get('time');
                        
                        if(timeBetween > 1)
                        {
                            timeBetweenText += " minutes";
                        }
                        else
                        {
                            timeBetweenText += " minute";
                        }
                    }
                    else
                    {
                        timeBetweenText = " during " + timeBetween;
                        
                        if(timeBetween > 1)
                        {
                            timeBetweenText += " seconds";
                            timeRange = imagesCollection.at(0).get('time') + ' - ' + imagesCollection.last().get('time');
                        }
                        else if(timeBetween == 0)
                        {
                            timeBetweenText = "";
                            timeRange = imagesCollection.at(0).get('time');
                        }
                        else
                        {
                            timeBetweenText += " second";
                            timeRange = imagesCollection.at(0).get('time');
                        }
                    }
                }
                else
                {
                    timeBetweenText = "";
                    timeRange = imagesCollection.at(0).get('time');
                }

                self.$el.find("div#images-wrapper").append($("<div class='new-page'>").html(timeRange));

                var numberOfEvents = (imagesCollection.models.length == 1 ) ? imagesCollection.models.length + " event" : imagesCollection.models.length  + " events";
                this.$el.find("div#images-wrapper")
                    .append($("<p class='metadata'>")
                        .html(numberOfEvents + timeBetweenText));

                $(".load4").css({'display':'none'});
                $(".scroll-down").css({'display':'block'});

                // -------------------
                // Append images

                self.$el.find("div#images-wrapper").append(imagesList);

                // --------------------------
                // Start progressive loading

                var wrappers = document.getElementById("images-"+self.currentPage).querySelectorAll('[data-lazy-load]');
                jellyfish.addLoadingIcons(wrappers);
                jellyfish.addLoadContentFunction(this.draw);

                imagesList.find("div.image").click(function()
                {
                    // -------------------------------
                    // Build photoswipe
                
                    var pswpElement = document.querySelectorAll('.pswp')[0];

                    // Build items array
                    var img = new Image();
                    var image = imagesCollection.models[0];
                    img.src = image.attributes.src;
                    img.onload = function()
                    {
                        var items = [];
                        for(var i = 0; i < imagesCollection.models.length; i++)
                        {
                            image = imagesCollection.models[i];
                            items.push({
                                title: image.attributes.time,
                                src:  image.attributes.src,
                                w: this.width,
                                h: this.height
                            });
                        }
            
                        // Initializes and opens PhotoSwipe
                        var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI, items, {});
                        gallery.init();
                    }
                });
            }

            // --------------------------------------------------------------
            // If nothing more to load, hide loading bar and unbind events..

            else
            {
                $(".load4").parent().css({'display':'none'});
                $(window).unbind('scroll');
                $(".scroll-down").unbind('click');
                this.atEndOfDay = true;
            }
        },
        draw: function(wrapper)
        {
            var imageBlock = wrapper.parentNode.parentNode;

            // -----------------------------------
            // Get image information from wrapper

            var src = wrapper.getAttribute('data-lazy-load');
            var metadata = JSON.parse(wrapper.getAttribute('metadata'));
            
            // ------------------
            // Create new image

            var image = new Image();
            image.src = src;

            // --------------
            // Build canvas

            var canvas = document.createElement('canvas');
            var ctx = canvas.getContext("2d");

            // -----------
            // Find tooltip elment

            var tooltip = $(wrapper.parentNode).find("i");

            var drawCanvas = function()
            {
                var width = imageBlock.offsetWidth;
                var ratio =  image.width / image.height;

                canvas.width = width;
                canvas.height = width / ratio;

                ctx.drawImage(image, 0, 0, width, canvas.height); 

                // ---------------------
                // Draw region 

                var tooltipOutput = "";

                if(metadata.regionCoordinates)
                {
                    var coordinates = metadata.regionCoordinates.split("-");

                    var x1 = coordinates[0] * (canvas.width / image.width);
                    var y1 = coordinates[1] * (canvas.height / image.height);
                    var x2 = coordinates[2] * (canvas.width / image.width);
                    var y2 = coordinates[3] * (canvas.height / image.height);

                    var regionWidth = x2 - x1;
                    var regionHeight = y2 - y1;

                    var color = "red";

                    // ---------------------------
                    // e.g. show region in tooltip
                    //tooltipOutput += "Region: " + (coordinates[2]-coordinates[0]) + "x" + (coordinates[3]-coordinates[1]);
                    
                    ctx.rect(x1, y1, regionWidth, regionHeight);
                    ctx.strokeStyle = color;
                    ctx.stroke();
                }

                // --------------------------------------------------
                // Create tooltip with metadata (Currently Disabled)
                // - Could be enabled to show
                // meta data inside a tooltip.

                /*if(tooltip)
                {
                    if(tooltipOutput != "")
                    {
                        tooltip.html(tooltipOutput);
                        tooltip.show();
                    }
                    else
                    {
                        tooltip.hide();
                    }
                }*/
            }

            // ------------------------
            // Attach events to canvas

            image.onload = drawCanvas;
            $(window).resize(drawCanvas);

            return canvas;
        },
        render: function()
        {
            this.$el.html(this.template({}));

            // ------------
            // Add images

            this.destroyViews();

            // -----------------------------
            // Get first image of collection
            
            var imagesCollection = this.collection;
            if(imagesCollection.models.length > 0)
            {
                imagesCollection = $.extend(true, {}, this.collection);
                imagesCollection.models = [];

                var firstModel = this.collection.models[0];
                imagesCollection.models.push(firstModel);

                if(this.collection.models.length > 1)
                {
                    var secondModel = this.collection.models[this.collection.models.length-1];
                    imagesCollection.models.push(secondModel);
                }
            }

            this.views = imagesCollection.map(this.createView, this);

            if(this.views.length>0)
            {
                
                this.$el.find("div#images-1").html(_.map(this.views, this.getDom, this));
                var self = this;
                this.$el.find("div.image").click(function()
                {
                    var collection = self.collection;
                
                    // Build photoswipe
                    var pswpElement = document.querySelectorAll('.pswp')[0];

                    // Build items array
                    var img = new Image();
                    var image = collection.models[0];
                    img.src = image.attributes.src;
                    img.onload = function()
                    {
                        var items = [];
                        for(var i = 0; i < collection.models.length; i++)
                        {
                            image = collection.models[i];
                            items.push({
                                title: image.attributes.time,
                                src:  image.attributes.src,
                                w: this.width,
                                h: this.height
                            });
                        }
        
                        // Initializes and opens PhotoSwipe
                        var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI, items, {});
                        gallery.init();
                    }
                });

                var timeBetween = "";
                var timeRange = "";
                if(this.collection.models.length > 1)
                {
                    timeBetween = this.collection.last().attributes.metadata.timestamp - this.collection.at(0).attributes.metadata.timestamp;
                    if(timeBetween > 0 && timeBetween / 60 > 1)
                    {
                        timeBetween = parseInt(timeBetween / 60);
                        timeBetweenText = " during " + timeBetween;
                        timeRange = this.collection.at(0).get('time') + ' - ' + this.collection.last().get('time');

                        if(timeBetween > 1)
                        {
                            timeBetweenText += " minutes";
                        }
                        else
                        {
                            timeBetweenText += " minute";
                        }
                    }
                    else
                    {
                        timeBetweenText = " during " + timeBetween;
                        
                        if(timeBetween > 1)
                        {
                            timeBetweenText += " seconds";
                            timeRange = this.collection.at(0).get('time') + ' - ' + this.collection.last().get('time');
                        }
                        else if(timeBetween == 0)
                        {
                            timeBetweenText = "";
                            timeRange = this.collection.at(0).get('time');
                        }
                        else
                        {
                            timeBetweenText += " second";
                            timeBetweenText = "";
                            timeRange = this.collection.at(0).get('time');
                        }
                    }
                }
                else
                {
                    timeBetweenText = "";
                    timeRange = this.collection.at(0).get('time');
                }

                var numberOfEvents = (this.collection.models.length == 1 ) ? this.collection.models.length + " event" : this.collection.models.length  + " events";
                this.$el.find("div#images-wrapper")
                    .prepend($("<p class='metadata'>")
                        .html(numberOfEvents + timeBetweenText));

                this.$el.find("div#images-wrapper")
                    .prepend($("<div class='new-page'>")
                        .html(timeRange));

            }

            // ---------------
            // Hide tooltip

            this.$el.find("span i").hide();

            return this;
        }
    });

    return ImageView;
});