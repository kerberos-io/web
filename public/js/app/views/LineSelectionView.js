/********************************************************************
*  LineSelectionView: show an image, on which a region (hull) 
*                     can be selected.
****/

define(["underscore", "backbone", "app/views/BaseView"], function (_, Backbone, BaseView)
{ 
    var $document = $(document), mouse = { update: function(e) {this.x = e.pageX; this.y = e.pageY;}};

    var LineSelectionView = BaseView.extend(
    {
        name: "",
        image: undefined,
        view : 'twolines',

        events:
        {
            "mousedown.drag .point" : "movePoint",
            "change img" : "drawCoordinates"
        },
        initialize: function(data)
        {
            this.name = data.name;
            this.image = data.image;
            this.model = data.model;
        },
        renderPoint: function(point, delta)
        {
    
            var point_id = this.$el.find('.point').length;
            this.$el.append('<div class="point" id="point_' + point_id + '"></div>');

            this.$el.find('#point_' + point_id).css('left', point.x + 'px');
            this.$el.find('#point_' + point_id).css('top', point.y + 'px');

            // Add coordinate info, relative to map
            this.$el.append('<div class="info" id="info_' + point_id + '">('+(point.x - delta.x)+','+(point.y - delta.y)+')</div>');
            this.$el.find('#info_' + point_id).css('left', point.x - 40 + 'px');
            this.$el.find('#info_' + point_id).css('top', point.y - 35 + 'px');

            // Draw a line between new and previous point 
            if(point_id % 2 == 1)
            {
                var x1 = this.$el.find('#point_' + (point_id - 1)).position().left;
                var y1 = this.$el.find('#point_' + (point_id - 1)).position().top;
                var line = this.createLine(point_id, x1, y1, point.x, point.y);
                this.$el.append(line);
            }

            return true;
        },
        movePoint: function(e)
        {
            var $elem = this.$el.find(e.target);
            var self = this;
            mouse.update(e);

            if(!/^(relative|absolute)$/.test($elem.css('position')))
            {
                $elem.css('position', 'relative');
            }

            $document.bind('mousemove.drag', function(e)
            {
                var left = (parseInt($elem.css('left'))||0) + (e.pageX - mouse.x);
                var top = (parseInt($elem.css('top'))||0) +  (e.pageY - mouse.y);

                // move text info (point location)
                var mapPosition = self.$el.find("img").position();
                var mapWidth = self.$el.find("img").width();
                var mapHeight = self.$el.find("img").height();

                // point can't be moved outside image window
                if(left - mapPosition.left < 0)
                    left = mapPosition.left;
                if(top - mapPosition.top < 0)
                    top = mapPosition.top;

                if(left > mapPosition.left + mapWidth)
                    left = mapPosition.left + mapWidth;
                if(top > mapPosition.top + mapHeight)
                    top = mapPosition.top + mapHeight;

                $elem.css({
                    left: left + "px",
                    top: top + "px"
                });

                var line_sm = parseInt($elem.attr('id').split('point_')[1],10);

                // Edit point in Hull model (relative to ratio)
                var mapPosition = self.$el.find("img").position();
                var widthRatio = self.image.width / self.$el.find("img").width() ;
                var heightRatio = self.image.height / self.$el.find("img").height();
                var point = {
                    "x" : Math.round((left - mapPosition.left) * widthRatio),
                    "y" : Math.round((top - mapPosition.top) * heightRatio)
                };
                self.model.editCoordinate(line_sm, point);
                self.writeCoordinates();
        
                x2 = left;
                y2 = top;
                
                var $info = self.$el.find("#info_"+line_sm);

                $info.css({
                    left: left - 40 + "px",
                    top: top - 35 + "px"
                });

                $info.html('('+(left - mapPosition.left)+','+(top - mapPosition.top)+')');

                var x1 = undefined, y1 = undefined;
                if (line_sm == 0 && self.closed)
                {
                    var previousLine = self.$el.find(".point").length;
                    x1 = self.$el.find('#point_' + (previousLine - 1)).position().left;
                    y1 = self.$el.find('#point_' + (previousLine - 1)).position().top;
                }
                else if (line_sm > 0)
                {
                    var previousLine = line_sm;
                    x1 = self.$el.find('#point_' + (previousLine - 1)).position().left;
                    y1 = self.$el.find('#point_' + (previousLine - 1)).position().top;
                }

                if(x1 != undefined && y1 != undefined)
                {
                    var length = Math.sqrt((x1-x2)*(x1-x2) + (y1-y2)*(y1-y2));
                    var angle  = Math.atan2(y2 - y1, x2 - x1) * 180 / Math.PI;
                    var transform = 'rotate('+angle+'deg)';

                    self.$el.find('.line[rel=' + previousLine + ']').css(
                    {
                        'position': 'absolute',
                        '-webkit-transform':  transform,
                        '-moz-transform':     transform,
                        'transform':          transform
                    }).width(length);
                }
                
                self.$el.find('.line[rel=' + (line_sm + 1) + ']').css('top', top);
                self.$el.find('.line[rel=' + (line_sm + 1) + ']').css('left', left);
            
                if (self.$el.find('.point').length-1 == line_sm)
                {
                    var x1 = self.$el.find('#point_0').position().left;
                    var y1 = self.$el.find('#point_0').position().top;
                }
                else
                {
                    var x1 = self.$el.find('#point_' + (line_sm + 1)).position().left;
                    var y1 = self.$el.find('#point_' + (line_sm + 1)).position().top;
                }

                var length = Math.sqrt((x1-x2)*(x1-x2) + (y1-y2)*(y1-y2));
                var angle  = Math.atan2(y1 - y2, x1 - x2) * 180 / Math.PI;
                var transform = 'rotate('+angle+'deg)';
        
                self.$el.find('.line[rel=' + (line_sm + 1) + ']').css(
                {
                    'position': 'absolute',
                    '-webkit-transform':  transform,
                    '-moz-transform':     transform,
                    'transform':          transform
                })
                .width(length);
            
                mouse.update(e);
                e.preventDefault();
            });

            $document.one('mouseup.drag', function(e)
            {
                $document.unbind('mousemove.drag');
            });
        },
        createLine: function(point_id, x1, y1, x2, y2)
        {
            var length = Math.sqrt((x1 - x2) * (x1 - x2) + (y1 - y2) * (y1 - y2));
            var angle  = Math.atan2(y2 - y1, x2 - x1) * 180 / Math.PI;
            var transform = 'rotate('+angle+'deg)';

            var line = $('<div>')
                .addClass('line')
                .css({
                  'position': 'absolute',
                  '-webkit-transform':  transform,
                  '-moz-transform':     transform,
                  'transform':          transform
                })
                .attr('rel', point_id)
                .width(length)
                .offset({left: x1, top: y1});

            if(point_id == 1)
            {
                this.$el.find("#point_0").css({'background': '#943633'});
                this.$el.find("#point_1").css({'background': '#943633'});
                line.css({'background': '#943633'});
            }
            else if(point_id == 3)
            {
                this.$el.find("#point_2").css({'background': '#21912C'});
                this.$el.find("#point_3").css({'background': '#21912C'});
                line.css({'background': '#21912C'});
            }

            return line;
        },
        writeCoordinates: function()
        {
            var coordinateString = "";
            var coordinates = this.model.coordinates;
            for(var i = 0; i < coordinates.length; i++)
            {
                coordinateString += coordinates[i].x + "," + coordinates[i].y + "|";
            }
            coordinateString = coordinateString.substring(coordinateString.length-1,0);

            this.$el.find("input").val(coordinateString);
        },
        drawCoordinates: function()
        {
            var mapPosition = this.$el.find("img");
            var delta = {
                "x": mapPosition.position().left,
                "y": mapPosition.position().top
            };

            // Add point to Hull model (relative to ratio)
            var widthRatio = this.image.width / mapPosition.width() ;
            var heightRatio = this.image.height / mapPosition.height();

            var coordinates = this.model.coordinates;
            for(var i = 0; i < coordinates.length; i++)
            {
                var point = {
                    "x": Math.round((coordinates[i].x/widthRatio)+delta.x), 
                    "y": Math.round((coordinates[i].y/heightRatio)+delta.y)
                };
                this.renderPoint(point, delta);
            }
        },
        restore: function()
        {
            this.$el.find(".point").remove();
            this.$el.find(".info").remove();
            this.$el.find(".line").remove();
            this.closed = false;
            this.drawCoordinates();
        },
        render: function()
        {
            this.$el.html(this.template({
                "name": this.name,
                "image": this.image,
                "coordinates": this.model.coordinates,
            }));
            this.writeCoordinates();
            return this;
        }
    });

    return LineSelectionView;
});