/************************
*
*   Download images
*
**/

define(["jquery"], function($)
{
    return {
        clean: function()
        {
            // ----------------
            // Download images
            
            var self = this;
            $.get(_baseUrl + "/api/v1/images/clean",function(file)
            {
                location.reload();
            });
        }
    };
});