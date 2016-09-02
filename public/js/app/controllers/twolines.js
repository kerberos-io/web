/********************************************
*
*   Hullselection: a user can select a hull
*   to define a region of interest.
*
**/

define(["jquery", "app/controllers/event", "app/models/Line", "app/views/LineSelectionView"], function($, event, Line, LineSelectionView)
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
        setImageSize: function(width, height)
        {
            this.width = width;
            this.height = height;
        },
        setCoordinates: function(coordinates)
        {
            this.coordinates = coordinates;
        },
        setName: function(name)
        {
            this.name = name;
        },
        initialize: function()
        {
            var line = new Line(this.coordinates);

            var image = {
                "src" : this.image,
                "width" : this.width,
                "height" : this.height,
                "fake": (this.image == "")
            }

            var lineView = new LineSelectionView({
                el: this.element,
                name: this.name,
                image: image,
                model: line,
            });

            lineView.render();

            $(window).resize(function()
            {
                lineView.restore();
            });

            event.on("section.opened", function(changes)
            {
                if(changes.attr("id")=="lines")
                {
                    lineView.restore();
                }
            });
        }
    };
});