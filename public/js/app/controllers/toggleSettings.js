/****************************************
*
*   Toggle Settings
*
**/

define(["jquery"], function($)
{
    return {
        type: undefined,

        getType: function()
        {
            return this.type;
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
                }
            });
        },
        initialize: function()
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
            });
        }
    };
});