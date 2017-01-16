/*****************************************************************
*  UpdateProfileView
****/


define(["underscore", "backbone", "fancybox", "app/models/User", "app/views/BaseView"], 
    function (_, Backbone, fancybox, UserCollection, BaseView)
{ 
    var UpdateProfileView = BaseView.extend(
    {
        el : '#update-profile-modal',
        view : 'update-profile',
        events:
        {
            "click #update": "update"
        },
        initialize: function(data)
        {
            this.collection = data.collection;
        },
        update: function()
        {
            var data = {
                username: this.$el.find("#username").val(),
                language: this.$el.find("#language").val(),
                currentPassword: this.$el.find("#current-password").val(),
                newPassword1: this.$el.find("#new-password-1").val(),
                newPassword2: this.$el.find("#new-password-2").val(),
            };

            if(data.newPassword1 === data.newPassword2)
            {
                $.post(_baseUrl + "/api/v1/users/current", data, function(data)
                {
                    location.reload();
                });
                return true;
            }
            else
            {
                this.$el.find("#new-password-1").css({"border-color":"#943633"});
                this.$el.find("#new-password-1").next().css({"color":"#943633"});

                this.$el.find("#new-password-2").css({"border-color":"#943633"});
                this.$el.find("#new-password-2").next().css({"color":"#943633"});
                return false;
            }
        },
        render: function()
        {   
            var self = this;
            this.collection.fetch({async: true, success: function()
            {
                var user = self.collection.models[0];
                self.$el.html(self.template(user.attributes));
            }});

            return this;
        }
    });

    return UpdateProfileView;
});