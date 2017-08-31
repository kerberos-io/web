/********************************************
*
*   Hullselection: a user can select a hull
*   to define a region of interest.
*
**/

define(["jquery", "app/controllers/event", "app/models/Hull", "app/views/HullSelectionView"], function($, event, Hull, HullSelectionView)
{
    return {
        name: "",
        coordinates: [],
        image: undefined,
        element: undefined,

        setElement: function(element)
        {
            this.element = element;
        },
        setImage: function(image)
        {
            this.image = image;
        },
        setImageData: function(imageData)
        {
            this.imageData = imageData;
        },
        setImageSize: function(width, height)
        {
            this.width = width;
            this.height = height;
        },
        setCoordinates: function(coordinates)
        {
            this.coordinates = coordinates;
        },
        getLatestImage: function(callback)
        {
            var image = {};
            var self = this;

            $.get( _baseUrl + "/api/v1/images/latest_sequence", function(sequence)
            {
                // -----------------------
                // Check if image or video

                image.src = "";
                image.width = 600;
                image.height = 480;
                if(sequence.length)
                {
                    var videos = _.filter(sequence, function(file)
                    {
                        return file.type === "video";
                    });

                    if(videos.length)
                    {
                        var canvas = document.createElement("canvas");
                        context = canvas.getContext("2d");

                        video = document.createElement("video");
                        video.src = videos[videos.length-1].src;

                        video.addEventListener('loadeddata', function()
                        {
                            canvas.width = video.videoWidth;
                            canvas.height = video.videoHeight;

                            video.pause();
                            video.play();
                            context.drawImage(video, 0, 0, canvas.width, canvas.height);
                            video.pause();

                            callback({
                                src: canvas.toDataURL(),
                                width: canvas.width,
                                height: canvas.height
                            });

                        });
                    }
                    else
                    {
                        var img = new Image();
                        img.src = sequence[sequence.length-1].src;
                        img.onload = function()
                        {
                            return callback(img);
                        };
                    }
                }
                else
                {
                    return callback(image);
                }

            });
        },
        setName: function(name)
        {
            this.name = name;
        },
        restore: function()
        {
            this.hullView.restore();
        },
        initialize: function(callback)
        {
            var hull = new Hull(this.coordinates);

            var image = {
                "src" : this.image,
                "width" : this.width,
                "height" : this.height,
                "fake": (this.image == "")
            }

            this.hullView = new HullSelectionView({
                el: this.element,
                name: this.name,
                image: image,
                model: hull,
            });

            var self = this;

            $(window).resize(function()
            {
                self.hullView.restore();
            });

            event.on("section.opened", function(changes)
            {
                if(changes.attr("id")=="hull")
                {
                    self.hullView.restore();
                }
            });

            this.hullView.render(callback);
        }
    };
});
