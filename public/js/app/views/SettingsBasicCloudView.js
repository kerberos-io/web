/**********************
*  Cloud View
****/

define(["underscore", "backbone", "app/views/BaseView"], function (_, Backbone, BaseView)
{ 
    var SettingsBasicCloudCameraView = BaseView.extend(
    {
        el : '<div>',
        view : 'settings/settings-basic-cloud',
        model: undefined,

        initialize: function(model)
        {
            this.model = model;
        },
        update: function()
        {
            this.model.changeKerberosCloud({
                bucket: this.$el.find("#bucket input").val(),
                folder: this.$el.find("#folder input").val(),
                public: this.$el.find("#public input").val(),
                secret: this.$el.find("#secret input").val(),
            });
        },
        render: function()
        {
            this.$el.html(this.template(this.model));
            return this;
        }
    });

    return SettingsBasicCloudCameraView;
});