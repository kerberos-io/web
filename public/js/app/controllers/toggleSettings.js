/****************************************
*
*   Toggle Settings
*
**/

define(["jquery", "app/controllers/hullselection", "app/controllers/twolines"], function($, hull, twolines)
{
    return {
        type: undefined,

        getType: function()
        {
            return this.type;
        },
        reloadHull: function(callback)
        {
            hull.setElement($(".hullselection .map"));
            twolines.setElement($(".twolines .map"));

            hull.getLatestImage(function(image)
            {
                hull.setImage(image.src);
                hull.setImageSize(image.width, image.height);
                hull.setCoordinates($(".hullselection .coordinates").val());
                hull.setName($(".hullselection .name").val());
                hull.initialize();

                twolines.setImage(image.src);
                twolines.setImageSize(image.width, image.height);
                twolines.setCoordinates($(".twolines .coordinates").val());
                twolines.setName($(".twolines .name").val());
                twolines.initialize();

                callback && callback();
            });
        },
        setType: function(type)
        {
            var self = this;
            $.ajax({
                url: _baseUrl + "/api/v1/configure",
                type: 'PUT',
                data: {'type' : type},
                success: function(data)
                {
                    self.type = data.type;

                    if(self.type === 'advanced')
                    {
                        $(".configuration-switch input[type='checkbox']").attr("checked", "checked");
                        $("#advanced").show();
                        $("#basic").hide();
                    }
                    else
                    {
                        $(".configuration-switch input[type='checkbox']").removeAttr("checked");
                        $("#advanced").hide();
                        $("#basic").show();
                    }

                    self.reloadHull();
                }
            });
        },
        initialize: function(callback)
        {
            // -----------------------------------
            // Load view and images

            var self = this;
            $(".configuration-switch input[type='checkbox']").attr("disabled", true);

            $.get(_baseUrl + "/api/v1/configure",function(data)
            {
                self.type = data.type;
                $(".configuration-switch input[type='checkbox']").attr("checked", (self.type === 'advanced'));
                $(".configuration-switch input[type='checkbox']").attr("disabled", false);
                $(".configuration-switch span.well").css("opacity", 1);
                self.reloadHull(callback);
            });
        }
    };
});
