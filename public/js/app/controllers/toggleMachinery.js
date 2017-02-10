/****************************************
*
*   Toggle Machinery
*
**/

define(["jquery"], function($)
{
    return {
        status: undefined,

        getStatus: function()
        {
            return this.status;
        },
        setStatus: function(status)
        {
            var self = this;
            $.ajax({
                url: _baseUrl + "/api/v1/condition/enabled",
                type: 'PUT',
                data: {'active':status},
                success: function(data)
                {
                    self.status = data.active;

                    if(self.status)
                    {
                        $(".machinery-switch input[type='checkbox']").attr("checked", "checked");
                    }
                    else
                    {
                        $(".machinery-switch input[type='checkbox']").removeAttr("checked");
                    }
                }
            });
        },
        initialize: function()
        {
            // -----------------------------------
            // Load view and images
            
            var self = this;
            $(".machinery-switch input[type='checkbox']").attr("disabled", true);
            $.get(_baseUrl + "/api/v1/condition/enabled",function(data)
            {
                self.status = (data.active === "true");
                $(".machinery-switch input[type='checkbox']").attr("checked", self.status);
                $(".machinery-switch input[type='checkbox']").attr("disabled", false);
                $(".machinery-switch span.well").css("opacity", 1);
            });
        }
    };
});