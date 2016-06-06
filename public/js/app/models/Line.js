/*************
* Hull Model
**/

define(["underscore", "backbone"], function (_, Backbone)
{ 
    var Line = Backbone.Model.extend(
    {
        coordinates: [],

        constructor: function(coordinates)
        {
            var points = [];
            if(coordinates != "")
            {
                coordinates = coordinates.split("|");
                for(var i = 0; i < coordinates.length; i++)
                {
                    var point = coordinates[i].split(",");
                    points[i] = {"x": parseInt(point[0]), "y": parseInt(point[1])};
                }
            }
            this.coordinates = points;
        },
        addCoordinate: function(point)
        {
            if(point.x && point.y)
            {
                var length = this.coordinates.length;
                this.coordinates[length] = point;
            }
        },
        editCoordinate: function(i, point)
        {
            if(i >= 0 && i < this.coordinates.length && point.x && point.y)
            {
                this.coordinates[i] = point;
            }
        },
        removeCoordinate: function(i)
        {
            if(i >= 0 && i < this.coordinates.length)
            {
                // shift coordinates
                for(i++; i < this.coordinates.length; i++)
                {
                    this.coordinates[i-1] = this.coordinates[i];
                }
                // remove last coordinate
                var lastPoint = this.coordinates.length - 1;
                delete this.coordinates[lastPoint];
                this.coordinates.length = lastPoint;
            }
        }
    });

    return Line;
});