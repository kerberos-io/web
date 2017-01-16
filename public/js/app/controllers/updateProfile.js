/*************************
*   Update Profile
**/

define(["underscore", "backbone", "remodal", "app/models/User", "app/views/UpdateProfileView"], 
	function (_, Backbone, remodal, UserCollection, UpdateProfileView)
{ 
    return {
        config: {},
        modal: undefined,

        initialize: function(config)
        {
        	var updateProfileView

        	UserCollection.fetch();

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