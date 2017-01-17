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
            /*this.model.changeIPCamera({
                width: this.$el.find("#ipcamera-view .width").val(),
                height: this.$el.find("#ipcamera-view .height").val(),
                angle: this.model.ipcamera.angle, // overkill
                delay: parseFloat(this.$el.find("#ipcamera-view .slider-delay").val()) * 1000,
                fps: parseInt(this.$el.find("#ipcamera-view .slider-fps").val()),
                url: this.$el.find("#ipcamera-view .url").val()
            });*/
        },
        render: function()
        {
            this.$el.html(this.template(this.model));
            return this;
        }
    });

    return SettingsBasicCloudCameraView;
});