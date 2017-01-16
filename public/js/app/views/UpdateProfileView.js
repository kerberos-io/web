/*****************************************************************
*  UpdateProfileView
****/


define(["underscore", "backbone", "fancybox", "app/models/User", "app/views/BaseView"], 
    function (_, Backbone, fancybox, UserCollection, BaseView)
{ 
    var UpdateProfileView = BaseView.extend(
    {
        view : 'update-profile',
        initialize: function(data)
        {

        },
        render: function()
        {
            //this.$el.html(this.template({time: this.collection.time}));
            return this;
        }
    });

    return UpdateProfileView;
});