/*************************
*   Update Profile
**/

define(["underscore", "backbone", "remodal", "app/models/User", "app/views/UpdateProfileView"], 
	function (_, Backbone, remodal, UserCollection, UpdateProfileView)
{ 
    return {
        translation: {},
        modal: undefined,
        userCollection: undefined,
        updateProfileView: undefined,

        initialize: function(translation)
        {
            this.translation = translation;
            this.modal = $('[data-remodal-id=update-profile]').remodal({ hashTracking: false });
            this.userCollection = new UserCollection();
            this.updateProfileView = new UpdateProfileView({
                collection: this.userCollection
            });
        },
        open: function()
        {
            this.updateProfileView.render(this.translation);
        	this.modal.open();
        }
    };
});