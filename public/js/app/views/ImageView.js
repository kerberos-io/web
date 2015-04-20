/*****************************************************************
*  ImageView: shows all available images.
****/

define(["underscore", "backbone", "fancybox", "app/models/Images", "app/views/BaseView"], 
    function (_, Backbone, fancybox, ImagesCollection, BaseView)
{ 
    var ImageItemView = BaseView.extend(
    {
        el: '<li>',
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

                // -------------------------------
                // add new collection to current.

                self.newViews = imagesCollection.map(self.createView, self);
                var imagesList = $("<ul id='images-"+self.currentPage+"' class='images'>");   
                imagesList.html(_.map(self.newViews, self.getDom, self));
                
                // ---------------
                // Hide tooltip
                
                imagesList.find("i").hide();

                self.$el.find("div#images-wrapper").append($("<div class='new-page'>").html('<i class="fa fa-clock-o"></i> '+imagesCollection.at(0).get('time')));
                self.$el.find("div#images-wrapper").append(imagesList);
                $(".load4").css({'display':'none'});
                $(".scroll-down").css({'display':'block'});

                // --------------------------
                // Start progressive loading

                var wrappers = document.getElementById("images-"+self.currentPage).querySelectorAll('[data-lazy-load]');
                jellyfish.addLoadingIcons(wrappers);
                jellyfish.addLoadContentFunction(this.draw);
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

            this.views = this.collection.map(this.createView, this);

            if(this.views.length>0)
            {
                this.$el.find("ul#images-1").html(_.map(this.views, this.getDom, this));

                this.$el.find("div#images-wrapper")
                    .prepend($("<div class='new-page'>")
                        .html('<i class="fa fa-clock-o"></i> '+this.collection.at(0).get('time')));
            }

            // ---------------
            // Hide tooltip

            this.$el.find("span i").hide();

            return this;
        }
    });

    return ImageView;
});