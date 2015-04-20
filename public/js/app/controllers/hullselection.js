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
            var hull = new Hull(this.coordinates);

            var image = {
                "src" : this.image,
                "width" : this.width,
                "height" : this.height,
                "fake": (this.image == "")
            }

            var hullView = new HullSelectionView({
                el: this.element,
                name: this.name,
                image: image,
                model: hull,
            });

            hullView.render();

            $(window).resize(function()
            {
                hullView.restore();
            });

            event.on("section.opened", function(changes)
            {
                if(changes.attr("id")=="hull")
                {
                    hullView.restore();
                }
            });
        }
    };
});