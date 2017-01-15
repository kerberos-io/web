/*************************
*   Update Profile
**/

define(["underscore", "backbone", "remodal"], function (_, Backbone, remodal)
{ 
    return {
        config: {},
        modal: undefined,
        initialize: function(config)
        {
            this.modal = $('[data-remodal-id=update-profile]').remodal({ hashTracking: false });
            $('[data-remodal-id=update-profile] .remodal-confirm').unbind('click').click(function()
            {
                alert("ok") 
            });
        },
        open: function()
        {
        	this.modal.open();
        }
    };
});